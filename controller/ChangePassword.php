<?php

    include_once($_SERVER["DOCUMENT_ROOT"] . "/controller/SessionUtils.php");
    include_once($_SERVER["DOCUMENT_ROOT"] . "/controller/SecurityUtils.php");

    create_session();

    print_r($_POST);

    if (!empty($_SESSION["user"]) AND !empty($_POST["inputPasswordOne"]) AND !empty($_POST["inputPasswordTwo"])) {

        if (strcmp(sanitize_input($_POST["inputPasswordOne"]), sanitize_input($_POST["inputPasswordTwo"])) === 0) {

            echo "we good!";

            $_SESSION["user"]->setUserPassword(password_hash(sanitize_input($_POST["inputPasswordOne"]), PASSWORD_DEFAULT));
            $_SESSION["user"]->update_data();

            if (isset($_SESSION["error"]))
                unset($_SESSION["error"]);

            header("Location: ../index.php");
            exit();

        } else {

            echo "oh ohhhh";

            header("Location: ../index.html");
            exit();

        }

    }