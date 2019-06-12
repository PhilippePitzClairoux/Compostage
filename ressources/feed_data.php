<?php


    //generate fake entries!

    include_once($_SERVER["DOCUMENT_ROOT"] . "/controller/data_management/raspberry_pi.php");
    include_once($_SERVER["DOCUMENT_ROOT"] . "/controller/data_management/zone.php");
    include_once($_SERVER["DOCUMENT_ROOT"] . "/controller/data_management/bed.php");
    include_once($_SERVER["DOCUMENT_ROOT"] . "/controller/data_management/sensor.php");
    include_once($_SERVER["DOCUMENT_ROOT"] . "/controller/RaspberryPiUtils.php");
    include_once($_SERVER["DOCUMENT_ROOT"] . "/ressources/gen_utils.php");


    $dates = array("2019-04-24 00:06:23", "2019-04-24 1:06:23",
                    "2019-04-24 2:06:23", "2019-04-24 3:06:23",
                    "2019-04-24 4:06:23", "2019-04-24 5:06:23",
                    "2019-04-24 6:06:23", "2019-04-24 7:06:23",
                    "2019-04-24 8:06:23", "2019-04-24 9:06:23",
                    "2019-04-24 10:06:23", "2019-04-24 11:06:23",
                    "2019-04-24 12:06:23", "2019-04-24 13:06:23",
                    "2019-04-24 14:06:23", "2019-04-24 15:06:23",
                    "2019-04-24 16:06:23", "2019-04-24 17:06:23",
                    "2019-04-24 18:06:23", "2019-04-24 19:06:23",
                    "2019-04-24 20:06:23", "2019-04-24 21:06:23",
                    "2019-04-24 22:06:23","2019-04-24 23:06:23");


    for ($i = 0; $i < 30; $i++) {

        $bed = bed::createNewBed("B" . $i);

        for ($j = 0; $j < 3; $j++) {


            $zone = zone::createNewZone("Z" . $j, $bed->getBedName());

            $rasp = raspberry_pi::createNewRaspberryPi("MODEL_3", "raspberry_pi",
                $zone->getZoneId() , "2019-04-24", 32);


            $ph = sensor::createNewSensor( "WORKING", "PH_SENOSR", $rasp->getRaspberryPiId(), "2019-04-24", genSerialNumber());
            $humidity = sensor::createNewSensor( "WORKING", "HUMIDITY_SENSOR", $rasp->getRaspberryPiId(), "2019-04-24", genSerialNumber());
            $tempature = sensor::createNewSensor( "WORKING", "TEMPATURE_SENSOR", $rasp->getRaspberryPiId(), "2019-04-24", genSerialNumber());

            foreach ($dates as $date) {
                measurements::createNewMeasurement($ph->getSensorId(), $date, mt_rand(0, 14));
            }

            foreach ($dates as $date) {
                measurements::createNewMeasurement($humidity->getSensorId(), $date, genPourcentage());
            }

            foreach ($dates as $date) {
                measurements::createNewMeasurement($tempature->getSensorId(), $date, mt_rand(-50, 50));
            }
        }

    }

    $bed = bed::createNewBed("AVG_Bed");
    $zone = zone::createNewZone("AVG_Zone", $bed->getBedName());
    $rasp = raspberry_pi::createNewRaspberryPi("MODEL_3", "raspberry_pi",
    $zone->getZoneId() , "2019-04-24", 32);

    $ph = sensor::createNewSensor( "WORKING", "PH_SENOSR", $rasp->getRaspberryPiId(), "2019-04-24", genSerialNumber());
    $humidity = sensor::createNewSensor( "WORKING", "HUMIDITY_SENSOR", $rasp->getRaspberryPiId(), "2019-04-24", genSerialNumber());
    $tempature = sensor::createNewSensor( "WORKING", "TEMPATURE_SENSOR", $rasp->getRaspberryPiId(), "2019-04-24", genSerialNumber());

    foreach ($dates as $date) {
        measurements::createNewMeasurement($ph->getSensorId(), $date, getAverage($date, $ph->getSensorType()->getSensorType()));
    }

    foreach ($dates as $date) {
        measurements::createNewMeasurement($humidity->getSensorId(), $date, getAverage($date, $humidity->getSensorType()->getSensorType()));
    }

    foreach ($dates as $date) {
        measurements::createNewMeasurement($tempature->getSensorId(), $date, getAverage($date, $tempature->getSensorType()->getSensorType()));
    }
