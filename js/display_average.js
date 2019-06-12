
function get_number_of_alerts() {

    return fetch("http://localhost:8080/api/getAmountOfUnviewedAlerts.php")
        .then(function(response) {
            return response.json();
        });
}


async function set_number_of_alerts() {

    let alerts = await get_number_of_alerts();

    document.getElementById("num_alerts").innerText = alerts["data"] + " new alerts"
}

window.onload = async function() {


        let zone_and_measures = await getData("AVG_Bed");
        zone_and_measures = zone_and_measures["data"][0][1];

        let card = createBigCardNoBorder("Average Stats");

        for (let i = 0; i < zone_and_measures.length; i++) {

            let current_sensor = zone_and_measures[i];
            console.log(current_sensor);

            let dataSet = [];
            let labels = [];
            let sensor_type = current_sensor["sensor_type"]["sensor_type"];
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
        set_number_of_alerts();
};