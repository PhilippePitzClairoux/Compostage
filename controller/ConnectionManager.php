<?php

    include_once("config.php");


    function getConnection() {

        $connection = mysqli_connect("localhost", username, password)
            or die("Cannot connect to the db");

        mysqli_select_db($connection, database_name)
            or die("Cannot select the database properly");

        return $connection;
    }