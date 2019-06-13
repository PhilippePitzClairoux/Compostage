<?php


    include_once($_SERVER["DOCUMENT_ROOT"] . "/controller/ConnectionManager.php");

    try {
        $conn = getConnection();
        $value = Array();
        $statement = $conn->prepare("SELECT alert_event_id FROM ta_alert_event WHERE has_been_viewed = 0");

        if (!$statement->execute()) {
            $conn->close();
            throw new Exception($statement->error);
        }

        $result = $statement->get_result();

        while ($row = $result->fetch_assoc()) {

            array_push($value, $row["alert_event_id"]);

        }

        mysqli_free_result($result);
        mysqli_close($conn);

    } catch(Exception $e) {
        $value = -1;
    }

    echo "{ \"data\" : " . json_encode($value) . " }";