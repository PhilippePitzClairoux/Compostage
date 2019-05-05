<?php

    include_once($_SERVER["DOCUMENT_ROOT"] . "/controller/SessionUtils.php");
    include_once($_SERVER["DOCUMENT_ROOT"] . "/controller/SecurityUtils.php");

    create_session();

    if (!empty($_SESSION["user"]) AND !empty($_POST["pass1"]) AND !empty($_POST["pass2"])) {

        if (strcmp(sanitize_input($_POST["pass1"]), sanitize_input($_POST["pass2"])) === 0) {

            $_SESSION["user"]->setUserPassword(password_hash(sanitize_input($_POST["pass1"]), PASSWORD_DEFAULT));
            $_SESSION["user"]->update_data();

            if (isset($_SESSION["error"]))
                unset($_SESSION["error"]);

            header("Location: ../inventory/dashboard.php");
            exit();

        } else {

            $_SESSION["error"] = "passwords do not match.";
            header("Location: ../inventory/change_password.php");
            exit();

        }

    }