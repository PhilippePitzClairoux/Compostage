<?php

    include_once($_SERVER["DOCUMENT_ROOT"] . "/controller/data_management/sensor.php");
    include_once($_SERVER["DOCUMENT_ROOT"] . "/controller/data_management/alert.php");


    function validate_inserted_values($measurement_id, $value) {

            $measurement = measurements::loadWithId($measurement_id);
            $type = $sensor->getSensorType()->getSensorType();

            if ($type === "PH_SENSOR") {

                if ($value < 5.0 || $value > 6.0) {
                    alert::createNewAlert();
                }

            } else if ($type === "TEMPATURE_SENSOR") {



            } else if ($type === "HUMIDITY_SENSOR") {



            }
    }