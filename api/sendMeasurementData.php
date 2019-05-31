<?php


    include_once($_SERVER["DOCUMENT_ROOT"] . "/controller/data_management/measurement.php");
    include_once($_SERVER["DOCUMENT_ROOT"] . "/controller/SecurityUtils.php");


    if (!empty($_GET["sensor_id"]) AND !empty($_GET["value"]) AND !empty($_GET["type_id"])
        AND !empty($_GET["timestamp"])) {

        try {
            $measurement = measurement::newMeasurement($_GET["sensor_id"], $_GET["value"],
                $_GET["type_id"], $_GET["timestamp"]);

            echo "{ \"status\" : \"ok\" }";

        } catch (Exception $e) {

            $message = $e->getMessage();
            echo "{ \"status\" : \"$message\" }";
        }
    } else {

        echo "{ \"status\" : \"Some fields are empty\" }";
    }