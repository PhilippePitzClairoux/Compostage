<?php

    include_once($_SERVER["DOCUMENT_ROOT"] . "/controller/SessionUtils.php");

    create_session();

    if (check_if_valid_session_exists()) {
        echo "Session found";
        close_session();
        header("Location:../index.html");
        exit();
    }

    header("Location:../index.html");
    exit();