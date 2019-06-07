<?php


    function genSerialNumber() {

        $num = str_split(mt_rand(111111111, 999999999), 3);

        return $num[0] . "-" . $num[1] . "-" . $num[2];
    }

    function genPourcentage() {
        return round(mt_rand(0, mt_getrandmax() - 1) / mt_getrandmax(), 2);
    }