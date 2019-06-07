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

    //the argument must be an object
    function getAllSensors($raspberry_pi) {

        $conn = getConnection();
        $sensors = Array();

        $statement = $conn->prepare("SELECT sensor_id FROM sensor WHERE raspberry_pi_id=?");
        $statement->bind_param("s", $raspberry_pi->getRaspberryPiId());

        if (!$statement->execute()) {
            $conn->close();
            throw new Exception($statement->error);
        }


        $result = $statement->get_result();

        while ($row = $result->fetch_assoc()) {

            array_push($sensors , sensor::loadWithId($row["sensor_id"]) );
        }

        $conn->close();
        $result->free();

        return $sensors;
    }