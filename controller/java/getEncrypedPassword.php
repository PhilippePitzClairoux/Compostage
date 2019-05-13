<?php


    if (!empty($_GET["password"])) {

        echo json_encode(array("password" => password_hash($_GET["password"], PASSWORD_DEFAULT)));

    } else {

        echo "{ \"password\" : \"error\" }";

    }