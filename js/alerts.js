
function add_data_to_table(alert_id, timestamp, zone, value, reason) {

    let data = "             <th>" + alert_id + "</th>\n" +
        "                    <th>" + timestamp + "</th>\n" +
        "                    <th>" + zone + "</th>\n" +
        "                    <th>" + value + "</th>\n" +
        "                    <th>" + reason + "</th>\n";

    let htmlObject = document.createElement('tr');
    htmlObject.innerHTML = data;

    document.getElementById("add_alerts").append(htmlObject);

}

function get_alert_ids() {
    return fetch("http://localhost:8080/api/getUnviewdAlertIds.php")
        .then(function(response) {
            return response.json();
        });
}

function get_alert_data(alert_id) {

    return fetch("http://localhost:8080/api/getAlertData.php?alert_id=" + alert_id)
        .then(function(response) {
            return response.json();
        });

}

window.onload = async function() {

    let ids = await get_alert_ids();
    console.log(ids);
    ids = ids["data"];

    for (let i = 0; i < ids.length; i++) {

        let currentAlert = await get_alert_data(ids[i]);
        currentAlert = currentAlert["data"];

        add_data_to_table(currentAlert[0]["alert_id"], currentAlert[0]["measure"]["measurement_timestamp"],
            currentAlert[1]["bed"]["bed_name"] + " : " + currentAlert[1]["zone_name"],
            currentAlert[0]["measure"]["measurement_value"],
            currentAlert[0]["alert_type"]["alert_type_name"]);
    }

    $('#dataTable').DataTable();


};