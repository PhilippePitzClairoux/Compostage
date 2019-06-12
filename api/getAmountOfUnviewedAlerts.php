<?php


    include_once($_SERVER["DOCUMENT_ROOT"] . "/controller/ConnectionManager.php");
    try {
        $conn = getConnection();
        $value = 0;
        $statement = $conn->prepare("SELECT COUNT(*) as val FROM ta_alert_event WHERE has_been_viewed = 0");

        if (!$statement->execute()) {
            $conn->close();
            throw new Exception($statement->error);
        }

        $result = $statement->get_result();

        while ($row = $result->fetch_assoc()) {

            $value = $row["val"];
        }

        mysqli_free_result($result);
        mysqli_close($conn);

    } catch(Exception $e) {
        $value = -1;
    }

    echo "{ \"data\" : " . $value . " }";