<?php

    include_once($_SERVER["DOCUMENT_ROOT"] . "/controller/SessionUtils.php");

    create_session();

    if (!empty($_SESSION["user"]) AND !empty($_POST["pass1"]) AND !empty($_POST["pass2"])) {

        if (strcmp($_POST["pass1"], $_POST["pass2"]) === 0) {

            $_SESSION["user"]->setUserPassword(password_hash($_POST["pass1"], PASSWORD_DEFAULT));
            $_SESSION["user"]->update_data();

            unset($_SESSION["error"]);

            header("Location: ../inventory/dashboard.php");
            exit();

        } else {

            $_SESSION["error"] = "passwords do not match.";
            header("Location: ../inventory/change_password.php");
            exit();

        }

    }