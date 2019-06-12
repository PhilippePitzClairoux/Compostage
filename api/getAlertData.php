<?php

    include_once($_SERVER["DOCUMENT_ROOT"] . "/controller/data_management/alert.php");
    include_once($_SERVER["DOCUMENT_ROOT"] . "/controller/data_management/zone.php");
    include_once($_SERVER["DOCUMENT_ROOT"] . "/controller/RaspberryPiUtils.php");
    include_once($_SERVER["DOCUMENT_ROOT"] . "/controller/SecurityUtils.php");

    if (!empty($_GET["alert_id"])) {

        try {

            $alert = alert::loadWithId(sanitize_input($_GET["alert_id"]));
            $zone = zone::loadWithRaspberryPiId(getRaspberryFromSensorId($alert->getMeasure()->getSensorId()));

            echo "{ \"data\" : " . json_encode(Array($alert, $zone)) . " }";
        } catch (Exception $e) {

            echo "{ \"error\" : " . $e->getMessage() ." }";

        }
    } else {

        echo "{ \"error\" : \"Not enough arguments passed\" }";
    }