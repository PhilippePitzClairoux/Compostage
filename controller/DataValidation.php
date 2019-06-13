<?php

    include_once($_SERVER["DOCUMENT_ROOT"] . "/controller/data_management/sensor.php");
    include_once($_SERVER["DOCUMENT_ROOT"] . "/controller/data_management/alert.php");


    function validate_inserted_values($measurement) {

            $type = sensor::loadWithId($measurement->getSensorId())->getSensorType()->getSensorType();
            $value = $measurement->getMeasurementValue();


            if ($type === "PH_SENSOR") {

                if ($value < 5.0 ) {
                    alert::createNewAlert("LOW", $measurement->getMeasurementId());
                } else if ($value > 6.0) {
                    alert::createNewAlert("HIGH", $measurement->getMeasurementId());
                }


            } else if ($type === "TEMPATURE_SENSOR") {

                if ($value < 30 ) {
                    alert::createNewAlert("LOW", $measurement->getMeasurementId());
                } else if ($value > 60) {
                    alert::createNewAlert("HIGH", $measurement->getMeasurementId());
                }

            } else if ($type === "HUMIDITY_SENSOR") {

                if ($value < 0.40 ) {
                    alert::createNewAlert("LOW", $measurement->getMeasurementId());
                } else if ($value > 0.60) {
                    alert::createNewAlert("HIGH", $measurement->getMeasurementId());
                }

            }
    }