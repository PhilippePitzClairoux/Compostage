<?php

    include_once("data_management/user.php");
    include_once("SessionUtils.php");

    if (!empty($_POST["username"]) AND !empty($_POST["password"])) {

        try {

            $user = user::loadWithId($_POST["username"]);

            if (password_verify($_POST["password"], $user->getUserPassword())) {

                create_session();

                //store the user in the session (will be useful later)
                $_SESSION["user"] = $user;
                header("Location:../inventory/dashboard.php");

            } else {
                throw new Exception("Invalid password >:[");
            }

        } catch (Exception $e) {

            echo "There was an error : <br>" . $e->getMessage() . "<br>";
            close_session();
        }
    }
