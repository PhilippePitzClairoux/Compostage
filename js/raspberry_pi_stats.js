
function getAllIds() {

    return fetch("http://localhost:8080/api/getAllRaspberryPiId.php")
        .then(function(response) {
            return response.json();
        });
}


function getData(id) {

        return fetch("http://localhost:8080/api/getMeasurementsForRaspberryPi.php?raspberry_pi_id=" + id.toString())
            .then(function(response) {
                return response.json();
            });
}

function createCard(title) {

    let new_entry = "<div class=\"card-header\">\n" +
        "                    <p id=\"title\">" + title + "</p>" +
        "              </div>" +
        "              <div class=\"row card-body\">" +
        "              </div>" +
        "             </div>";

    let htmlObject = document.createElement('div');
    htmlObject.className = "card mb-3";
    htmlObject.innerHTML = new_entry;

    return htmlObject;
}

function createEntry(entry_name) {

    let new_entry = `<div class="card mb-3">
                             <div class="card-header">
                                <i class="fas fa-chart-area"></i>
                                 ` + entry_name + `
                             </div>
                             <div class="card-body">
                                    <canvas id="chart" width="100%" height="50"></canvas>
                             </div>
                     </div>`;

    let htmlObject = document.createElement('div');
    htmlObject.className = "col-lg-4";
    htmlObject.innerHTML = new_entry;

    return htmlObject;
}

function appendCardToBody(card, data) {

    card.getElementsByClassName("card-body")[0].append(data);
}


//dataset must be a json and canvas needs to be a
function createLineChart(dataEntry, dataSet, labels, type) {

    let min, max, color, color_bg;

    console.log(type);

    if (type === "PH_SENOSR") {
        min = 0;
        max = 14;

        color = "rgba(255,25,0,1)";
        color_bg = "rgba(255,25,0,0.2)";
    } else if (type === "TEMPATURE_SENSOR") {
        min = -50;
        max = 50;

        color="rgba(255,153,0,1)";
        color_bg="rgba(255,153,0,0.2)";
    } else if (type === "HUMIDITY_SENSOR") {
        min = 0;
        max = 1;

        color="rgba(2,117,216,1)";
        color_bg="rgba(2,117,216,0.2)";
    }


    new Chart(dataEntry.getElementsByTagName("canvas")[0], {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: "Sessions",
                lineTension: 0.3,
                backgroundColor: color_bg,
                borderColor: color,
                pointRadius: 5,
                pointBackgroundColor: color_bg,
                pointBorderColor: "rgba(255,255,255,0.8)",
                pointHoverRadius: 5,
                pointHoverBackgroundColor: color_bg,
                pointHitRadius: 50,
                pointBorderWidth: 2,
                data: dataSet,
            }],
        },
        options: {
            scales: {
                xAxes: [{
                    time: {
                        unit: 'date'
                    },
                    gridLines: {
                        display: false
                    },
                    ticks: {
                        maxTicksLimit: 7
                    }
                }],
                yAxes: [{
                    ticks: {
                        min: min,
                        max: max,
                        maxTicksLimit: 5
                    },
                    gridLines: {
                        color: "rgba(0, 0, 0, .125)",
                    }
                }],
            },
            legend: {
                display: false
            }
        }
    });

}

window.onload = async function() {

    let ids = await getAllIds();
    ids = ids["data"];

    for (let k = 0; k < ids.length; k++) {

        let sensors = await getData(ids[k]);
        sensors = sensors["data"];

        let card = createCard("Raspberry Pi #" + sensors[0]["sensor_raspberry_pi_id"]);

        for (let i = 0; i < sensors.length; i++) {

            let current_sensor = sensors[i];
            let dataSet = [];
            let labels = [];
            let sensor_type = current_sensor["sensor_type"];
            let measures = current_sensor["measures"];
            let entry = createEntry(sensor_type.split("_")[0]);


            for (let j = 0; j < measures.length; j++) {
                dataSet.push(measures[j]["measurement_value"]);
                labels.push(measures[j]["measurement_timestamp"]);
            }


            createLineChart(entry, dataSet, labels, sensor_type);
            appendCardToBody(card, entry);
        }

        document.getElementById("data").append(card);


    }

};