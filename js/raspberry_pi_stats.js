

window.onload = async function() {

    let bed_ids = await getAllIds();
    bed_ids = bed_ids["data"];


    for (let k = 0; k < bed_ids.length; k++) {

        let zone_and_measures = await getData(bed_ids[k]);
        zone_and_measures = zone_and_measures["data"];

        let card = createBigCard("Bed " + zone_and_measures[0][0]["bed"]["bed_name"]);

        console.log(zone_and_measures);

        for (let n = 0; n < zone_and_measures.length; n++) {

            let second_card = createCard("Zone " + zone_and_measures[n][0]["zone_name"])
            console.log("Inserting card");

            for (let i = 0; i < zone_and_measures.length; i++) {



                let current_sensor = zone_and_measures[i][1][i];
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
                appendCardToBody(second_card, entry);
            }

            appendCardToBody(card, second_card);
        }

        document.getElementById("data").append(card);


    }

};