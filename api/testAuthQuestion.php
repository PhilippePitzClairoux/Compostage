<?php

include_once($_SERVER["DOCUMENT_ROOT"] . "/controller/SessionUtils.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/controller/data_management/user.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/controller/SecurityUtils.php");

if (!empty($_GET["username"]) AND !empty($_GET["answer"])) {

    $user = user::loadWithId(sanitize_input($_GET["username"]));
    if (password_verify(sanitize_input($_GET["answer"]), $user->getUserAuthAnswer())) {

        create_session();

        $_SESSION["user"] = $user;

        echo "{ \"status\" : \"completed\" }";

    } else {

        echo "{ \"status\" : \"wrong answer\" }";
    }

} else {

    echo "{ \"error\" : \"not enough info\" }";
}