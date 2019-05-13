<?php


    if (!empty($_GET["password"])) {

        echo json_encode(array("password" => password_hash(sanitize_input($_GET["password"]), PASSWORD_DEFAULT)));

    } else {

        echo "{ \"password\" : \"error\" }";

    }