<?php

    include_once($_SERVER["DOCUMENT_ROOT"] . "/controller/SessionUtils.php");
    include_once($_SERVER["DOCUMENT_ROOT"] . "/controller/data_management/user.php");
    include_once($_SERVER["DOCUMENT_ROOT"] . "/controller/SecurityUtils.php");

    if (!empty($_POST["username"]) AND !empty($_POST["answer"])) {

        $user = user::loadWithId(sanitize_input($_POST["username"]));
        if (password_verify(sanitize_input($_POST["answer"]), $user->getUserAuthAnswer())) {

            create_session();

            $_SESSION["user"] = $user;

            header("Location: " . "../inventory/change_password.php");
            exit();

        } else {

            echo "Wrong answer has been guessed! Please try again.";
        }

    } else {

        header("Location: " . "../inventory/forgot_password.html");
        exit();
    }