<?php


    include_once($_SERVER["DOCUMENT_ROOT"] . "/controller/data_management/measurements.php");
    include_once($_SERVER["DOCUMENT_ROOT"] . "/controller/SecurityUtils.php");


    if (!empty($_GET["sensor_id"]) AND !empty($_GET["value"]) AND !empty($_GET["timestamp"])) {

        try {

            $measurement = measurements::createNewMeasurement($_GET["sensor_id"], $_GET["timestamp"], $_GET["value"]);
            echo "{ \"status\" : \"ok\" }";

        } catch (Exception $e) {

            $message = $e->getMessage();
            echo "{ \"status\" : \"$message\" }";
        }
    } else {

        echo "{ \"status\" : \"Some fields are empty\" }";
    }