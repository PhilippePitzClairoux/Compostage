<?php


    include_once($_SERVER["DOCUMENT_ROOT"] . "/controller/data_management/user.php");
    include_once($_SERVER["DOCUMENT_ROOT"] . "/controller/SecurityUtils.php");

    if (!empty($_GET["username"])) {

        try {

            $user = user::loadWithId(sanitize_input($_GET["username"]));
            echo json_encode($user);

        } catch (Exception $e) {

            echo "{ \"error\":\"{$e->getMessage()}\"}";

        }

    } else {

        echo "{ \"error\":\"Pass a username\"}";

    }