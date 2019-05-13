<?php



    if (!empty($_GET["to_test"]) AND !empty($_GET["encrypted_password"])) {

        echo json_encode(array("isValid" => password_verify(sanitize_input($_GET["to_test"]), sanitize_input($_GET["encrypted_password"]))));
    } else {

        echo "{ \"isValid\" : \"false\" }";
    }