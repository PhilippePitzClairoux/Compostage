<?php

    include_once($_SERVER["DOCUMENT_ROOT"] . "/controller/SecurityUtils.php");
    include_once($_SERVER["DOCUMENT_ROOT"] . "/controller/data_management/raspberry_pi.php");
    include_once($_SERVER["DOCUMENT_ROOT"] . "/controller/RaspberryPiUtils.php");


    if (!empty($_GET["raspberry_pi_id"])) {

        try {

            $raspberry_pi = raspberry_pi::loadWithId($_GET["raspberry_pi_id"]);
            $measurements = getAllSensors($raspberry_pi);

            echo "{ \"data\" : " . json_encode($measurements) . " }";


        } catch (Exception $e) {
            echo "{ \"error\" :\"" . $e->getMessage() . "\" }";
        }

    } else
        echo "{ \"error\" : \"no id passed\" }";
