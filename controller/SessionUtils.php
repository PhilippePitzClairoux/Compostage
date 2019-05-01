<?php

    //when someone logs in
    function create_session() {
        if (empty(session_id()) AND empty($_SESSION)) {

            include_once("data_management/user.php");

            //session isnt started, so we start it
            session_start();
        } else {
            throw new Exception("Cannot create session");
        }
    }

    //when someone logs out
    function close_session() {
        if (!empty(session_id()) || !empty($_SESSION)) {
            //destroy the session
            session_unset();
            session_destroy();
        }
    }

    //return true if a valid session exists and returns false if the session doesnt exist.
    function check_if_valid_session_exists() {
        return session_id() !== '' AND !empty($_SESSION["user"]);
    }