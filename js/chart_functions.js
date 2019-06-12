
function getAllIds() {

    return fetch("http://localhost:8080/api/getAllBedId.php")
        .then(function(response) {
            return response.json();
        });
}


function getData(id) {

        return fetch("http://localhost:8080/api/getMeasurementsForBed.php?bed_id=" + id.toString())
            .then(function(response) {
                return response.json();
            });
}

function createBigCardNoBorder(title) {

    let new_entry = "<div class=\"card-header\">\n" +
        "                    <p id=\"title\">" + title + "</p>" +
        "              </div>" +
        "              <div class=\"row card-body\">" +
        "              </div>" +
        "             </div>";

    let htmlObject = document.createElement('div');
    htmlObject.className = "card mb-12";
    htmlObject.innerHTML = new_entry;

    return htmlObject;
}

function createBigCard(title) {

    let new_entry = "<div class=\"card-header\">\n" +
        "                    <p id=\"title\">" + title + "</p>" +
        "              </div>" +
        "              <div class=\"row card-body\">" +
        "              </div>" +
        "             </div>";

    let htmlObject = document.createElement('div');
    htmlObject.className = "card mb-12";
    htmlObject.style.marginTop = "100px";
    htmlObject.style.border = "1px solid black";
    htmlObject.innerHTML = new_entry;

    return htmlObject;
}

function createCard(title) {

    let new_entry = "<div class=\"card-header\">\n" +
        "                    <p id=\"title\">" + title + "</p>" +
        "              </div>" +
        "              <div class=\"row card-body\">" +
        "              </div>" +
        "             </div>";

    let htmlObject = document.createElement('div');
    htmlObject.className = "card";
    htmlObject.style.width = "100%";
    htmlObject.style.border = "100px";
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