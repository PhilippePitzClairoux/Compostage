<?php

    include_once($_SERVER["DOCUMENT_ROOT"] . "/controller/config.php");
    //include_once($_SERVER["DOCUMENT_ROOT"] . "/Compostage/controller/config.php");

    //https://www.php.net/manual/en/mysqli.quickstart.connections.php
    function getConnection() {

        $connection = mysqli_connect("localhost", username, password)
            or die("Cannot connect to the db");

        mysqli_select_db($connection, database_name)
            or die("Cannot select the database properly");

        return $connection;
    }
