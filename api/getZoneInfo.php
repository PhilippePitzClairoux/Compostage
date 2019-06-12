<?php

    include_once($_SERVER["DOCUMENT_ROOT"] . "/controller/RaspberryPiUtils.php");
    include_once($_SERVER["DOCUMENT_ROOT"] . "/controller/data_management/raspberry_pi.php");

    if (!empty($_GET["raspberry_pi_id"])) {

        try {

            $data = zone::loadWithRaspberryPiId($_GET["raspberry_pi_id"]);

            echo "{ \"data\" : " . json_encode($data) . " }";


        } catch(Exception $e) {

            echo "{ \"data\" : " . json_encode($e->getMessage()) . " }";
        }
    } else {

        echo "{ \"data\" : \"Not enough arguments passed\" }";

    }