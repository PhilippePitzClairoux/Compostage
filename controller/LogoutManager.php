<?php

    include_once("SessionUtils.php");

    create_session();

    if (check_if_valid_session_exists()) {
        close_session();
        header("Location:../inventory/login_page.html");
    }
