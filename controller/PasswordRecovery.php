<!--********************************
    Fichier : ChangePassword.php
    Auteur : Philippe Pitz Clairoux
    Fonctionnalité :
    Date : 2019-05-04

    Vérification :
    Date                Nom                 Approuvé
    ====================================================

    Historique de modifications :
    Date                Nom                 Description
    ======================================================

 ********************************/-->
<?php

    include_once($_SERVER["DOCUMENT_ROOT"] . "/controller/SessionUtils.php");
    include_once($_SERVER["DOCUMENT_ROOT"] . "/controller/data_management/user.php");
    include_once($_SERVER["DOCUMENT_ROOT"] . "/controller/SecurityUtils.php");

    if (!empty($_POST["username"]) AND !empty($_POST["answer"])) {

        $user = user::loadWithId(sanitize_input($_POST["username"]));
        if (password_verify(sanitize_input($_POST["answer"]), $user->getUserAuthAnswer())) {

            create_session();

            $_SESSION["user"] = $user;

            header("Location: " . "../change_password.php");
            exit();

        } else {

            echo "Wrong answer has been guessed! Please try again.";
        }

    } else {

        header("Location: " . "../forgot_password.html");
        exit();
    }