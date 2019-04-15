<?php

include_once("../ConnectionManager.php");

class mesurement_type {

    private $mesurement_type_id;
    private $mesurement_type_name;

    function __construct($mesurement_type_id) {

        $this->mesurement_type_id = $mesurement_type_id;
    }


    function setMesurementTypeName($name) {
        if (!is_null($name))
            $this->mesurement_type_name = $name;
    }

    function setMesurementTypeId($id) {
        if (!is_null($id))
            $this->mesurement_type_id = $id;
    }

    function getMesurementTypeId() {
        return $this->mesurement_type_id;
    }

    function  getMesurementTypeName() {
        return $this->mesurement_type_name;
    }

    function fetch_data() {

        $conn = getConnection();

        $statement = $conn->prepare("SELECT mesure_type_name FROM mesure_type WHERE mesure_type_id = ?");
        $statement->bind_param("i", $this->mesurement_type_id);

        if (!$statement->execute()) {

            $conn->close();
            $statement->close();
            die("Error getting the mesurement_type");
        }

        $result = $statement->get_result();

        while( $row = $result->fetch_assoc()) {

            $this->mesurement_type_name = $row["mesure_type_name"];
        }

        $statement->close();
        mysqli_free_result($result);
        mysqli_close($conn);
    }

    function send_data() {

        $conn = getConnection();

        $statement = $conn->prepare("INSERT INTO mesure_type(mesure_type_name) VALUES (?)");
        $statement->bind_param("s", $this->mesurement_type_name);

        if (!$statement->execute()) {
            mysqli_close($conn);
            die("Cannot insert new mesure_type");
        }

        mysqli_close($conn);
    }

}