<?php


    include_once($_SERVER["DOCUMENT_ROOT"] . "/controller/data_management/user.php");
    include_once($_SERVER["DOCUMENT_ROOT"] . "/controller/SecurityUtils.php");

    if (!empty($_GET["username"]) AND (!empty($_GET["user_password"]) OR !empty($_GET["user_email"]) OR !empty($_GET["user_auth_question"]) OR !empty($_GET["user_auth_answer"]))) {
        $status = array();

        try {

            $user = user::loadWithId(sanitize_input(["username"]));

        } catch (Exception $e) {

            $message = $e->getMessage();
            echo "{ \"error\" : \"$message\" }";

        }


        if (!empty($_GET["user_password"])) {

            $user->setUserPassword(sanitize_input($_GET["user_password"]));
            array_push($status, "password");
        }

        if (!empty($_GET["user_email"])) {

            $user->setUserPassword(sanitize_input($_GET["user_email"]));
            array_push($status, "email");
        }

        if (!empty($_GET["user_auth_question"])) {

            $user->setUserPassword(sanitize_input($_GET["user_auth_question"]));
            array_push($status, "auth_question");
        }

        if (!empty($_GET["user_auth_answer"])) {

            $user->setUserPassword(password_hash(sanitize_input($_GET["user_auth_answer"]), PASSWORD_DEFAULT));
            array_push($status, "auth_answer");
        }

        $status_message = "";

        foreach ($status as $value) {

            $status_message = $status_message . $value . " ";
        }

        try {
            $user->update_data();
            echo "{ \"status\" : \"Update completed on " . $status_message .  "\" }";

        } catch (Exception $e) {
            echo "{ \"error\" : \"could not complete update\" }";
        }

    } else {

        echo "{ \"error\" : \"no fields sent as parameter\" }";

    }
