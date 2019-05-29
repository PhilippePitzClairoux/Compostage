<?php

    include_once($_SERVER["DOCUMENT_ROOT"] . "/controller/SessionUtils.php");

    create_session();

    if (check_if_valid_session_exists()) {
        echo "Session found";
        close_session();
        header("Location:../login.html");
        exit();
    }

    header("Location:../login.html");
    exit();