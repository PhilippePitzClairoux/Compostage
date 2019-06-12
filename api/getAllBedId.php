<?php


    include_once($_SERVER["DOCUMENT_ROOT"] . "/controller/RaspberryPiUtils.php");
    include_once($_SERVER["DOCUMENT_ROOT"] . "/controller/data_management/raspberry_pi.php");

    try {

        $raspberry_ids = getAllBedIds();

        echo "{ \"data\" : " . json_encode($raspberry_ids) . " }";

    } catch (Exception $e) {

        echo "{ \"error\" : \"" . $e->getMessage() . "\" }";

    }