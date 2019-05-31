<?php


    function genSerialNumber() {

        $num = str_split(mt_rand(111111111, 999999999), 3);

        return $num[0] . "-" . $num[1] . "-" . $num[2];
    }
