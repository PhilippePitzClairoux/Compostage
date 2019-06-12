<?php

    include_once($_SERVER["DOCUMENT_ROOT"] . "/controller/ConnectionManager.php");
    include_once($_SERVER["DOCUMENT_ROOT"] . "/controller/data_management/sensor.php");

    function getAllRaspberryPiIds() {

        $conn = getConnection();
        $ids = Array();

        $statement = $conn->prepare("SELECT raspberry_pi_id FROM raspberry_pi");

        if (!$statement->execute()){
            $conn->close();
            throw new Exception($statement->error);
        }

        $result = $statement->get_result();

        while( $row = $result->fetch_assoc()) {

            array_push($ids, $row["raspberry_pi_id"]);
        }

        $conn->close();
        $result->free();

        return $ids;
    }

    function getAllBedIds() {
        $conn = getConnection();
        $ids = Array();

        $statement = $conn->prepare('SELECT * FROM bed WHERE bed_name LIKE "b%" ');

        if (!$statement->execute()){
            $conn->close();
            throw new Exception($statement->error);
        }

        $result = $statement->get_result();

        while( $row = $result->fetch_assoc()) {

            array_push($ids, $row["bed_name"]);
        }

        $conn->close();
        $result->free();

        return $ids;
    }

    function getRaspberryFromBedId($bed_id) {
        $conn = getConnection();
        $ids = Array();

        $statement = $conn->prepare("SELECT raspberry_pi_id FROM raspberry_pi INNER JOIN zone ON raspberry_pi.zone_id = zone.zone_id INNER JOIN bed b on zone.bed_id = b.bed_name WHERE bed_name = ?");
        $statement->bind_param("s", $bed_id);

        if (!$statement->execute()){
            $conn->close();
            throw new Exception($statement->error);
        }

        $result = $statement->get_result();

        while( $row = $result->fetch_assoc()) {

            array_push($ids, $row["raspberry_pi_id"]);
        }

        $conn->close();
        $result->free();

        return $ids;
    }

    //the argument must be an object
    function getAllSensors($raspberry_pi) {

        $conn = getConnection();
        $sensors = Array();

        $statement = $conn->prepare("SELECT sensor_id FROM sensor WHERE raspberry_pi_id=?");
        $statement->bind_param("i", $raspberry_pi->getRaspberryPiId());

        if (!$statement->execute()) {
            $conn->close();
            throw new Exception($statement->error);
        }


        $result = $statement->get_result();

        while ($row = $result->fetch_assoc()) {
            $value = sensor::loadWithId($row["sensor_id"]);
            array_push($sensors , $value);
        }

        $conn->close();
        $result->free();

        return $sensors;
    }


    function getAverage($timestamp, $sensor_type) {

        $conn = getConnection();

        $statement = $conn->prepare("SELECT AVG(measure_value) as val FROM ta_measure_type INNER JOIN sensor s on ta_measure_type.sensor_id = s.sensor_id WHERE measure_timestamp = ? AND sensor_type = ?");
        $statement->bind_param("ss", $timestamp, $sensor_type);
        $average = 0;

        if (!$statement->execute()) {
            $conn->close();
            throw new Exception($statement->error);
        }

        $result = $statement->get_result();

        while ($row = $result->fetch_assoc()) {
            $average = $row["val"];
        }

        mysqli_free_result($result);
        mysqli_close($conn);

        return $average;
    }