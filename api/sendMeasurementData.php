<?php


    include_once($_SERVER["DOCUMENT_ROOT"] . "/controller/data_management/measurements.php");
    include_once($_SERVER["DOCUMENT_ROOT"] . "/controller/SecurityUtils.php");
    include_once($_SERVER["DOCUMENT_ROOT"] . "/controller/DataValidation.php");


    if (!empty($_GET["sensor_id"]) AND !empty($_GET["value"]) AND !empty($_GET["timestamp"])) {

        try {

            $measurement = measurements::createNewMeasurement(sanitize_input($_GET["sensor_id"]), sanitize_input($_GET["timestamp"]), sanitize_input($_GET["value"]));
            validate_inserted_values($measurement);

            echo "{ \"status\" : \"ok\" }";

        } catch (Exception $e) {

            $message = $e->getMessage();
            echo "{ \"status\" : \"$message\" }";
        }
    } else {

        echo "{ \"status\" : \"Some fields are empty\" }";
    }