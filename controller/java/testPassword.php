<?php



    if (!empty($_GET["to_test"]) AND !empty($_GET["encrypted_password"])) {

        echo json_encode(array("isValid", password_verify($_GET["to_test"], $_GET["encrypted_password"])));
    }