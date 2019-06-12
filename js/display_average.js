

window.onload = async function() {


        let zone_and_measures = await getData("AVG_Bed");
        zone_and_measures = zone_and_measures["data"][0][1];

        let card = createBigCard("Average Stats");

        for (let i = 0; i < zone_and_measures[1].length; i++) {



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
            appendCardToBody(entry, card);

            console.log(card);
            console.log(entry);
        }

        document.getElementById("data").append(card);

};