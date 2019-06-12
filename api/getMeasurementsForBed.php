<?php

    include_once($_SERVER["DOCUMENT_ROOT"] . "/controller/SecurityUtils.php");
    include_once($_SERVER["DOCUMENT_ROOT"] . "/controller/data_management/raspberry_pi.php");
    include_once($_SERVER["DOCUMENT_ROOT"] . "/controller/RaspberryPiUtils.php");


    if (!empty($_GET["bed_id"])) {

        try {

            $raspberry_array = getRaspberryFromBedId(sanitize_input($_GET["bed_id"]));
            $data = Array();

            foreach ($raspberry_array as $rasperry) {

                $raspberry_pi = raspberry_pi::loadWithId($rasperry);
                $zone = zone::loadWithRaspberryPiId($rasperry);
                $measurements = getAllSensors($raspberry_pi);

                array_push($data, Array($zone, $measurements));
            }



            echo "{ \"data\" : " . json_encode($data) . " }";


        } catch (Exception $e) {
            echo "{ \"error\" :\"" . $e->getMessage() . "\" }";
        }

    } else
        echo "{ \"error\" : \"no id passed\" }";
