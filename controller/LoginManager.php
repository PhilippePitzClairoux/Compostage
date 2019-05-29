<?php

    include_once($_SERVER["DOCUMENT_ROOT"] . "/controller/data_management/user.php");
    include_once($_SERVER["DOCUMENT_ROOT"] . "/controller/SessionUtils.php");
    include_once($_SERVER["DOCUMENT_ROOT"] . "/controller/SecurityUtils.php");


    if (!empty($_POST["username"]) AND !empty($_POST["password"])) {

        try {

            $user = user::loadWithId(sanitize_input($_POST["username"]));

            if (password_verify(sanitize_input($_POST["password"]), $user->getUserPassword())) {

                create_session();

                //store the user in the session (will be useful later)
                $_SESSION["user"] = $user;
                header("Location:../index.php");
                exit();

            } else {

                throw new Exception("Invalid password >:[");
            }

        } catch (Exception $e) {

            echo "There was an error : <br>" . $e->getMessage() . "<br>";
            close_session();

            header("Location:../login.html");
            exit();

        }
    } else {

        echo "Not enough args!";
        header("Location:../login.html");
        exit();
    }
