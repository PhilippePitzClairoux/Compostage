<?php

include_once("../ConnectionManager.php");

class measurement_type {

    private $measurement_type_id;
    private $measurement_type_name;

    function __construct($measurement_type_id) {

        $this->measurement_type_id = $measurement_type_id;
    }


    function setMeasurementTypeName($name) {
        if (!is_null($name))
            $this->measurement_type_name = $name;
    }

    function setMeasurementTypeId($id) {
        if (!is_null($id))
            $this->measurement_type_id = $id;
    }

    function getMeasurementTypeId() {
        return $this->measurement_type_id;
    }

    function  getMeasurementTypeName() {
        return $this->measurement_type_name;
    }

    function fetch_data() {

        $conn = getConnection();

        $statement = $conn->prepare("SELECT measure_type_name FROM measure_type WHERE measure_type_id = ?");
        $statement->bind_param("i", $this->measurement_type_id);

        if (!$statement->execute()) {

            $conn->close();
            $statement->close();
            die("Error getting the measurement_type");
        }

        $result = $statement->get_result();

        if ($result->num_rows === 0) {
            mysqli_free_result($result);
            mysqli_close($conn);
            throw new Exception("Measurement type does not exist");
        }

        while( $row = $result->fetch_assoc()) {

            $this->measurement_type_name = $row["measure_type_name"];
        }

        $statement->close();
        mysqli_free_result($result);
        mysqli_close($conn);
    }

    function insert_data() {

        $conn = getConnection();

        $statement = $conn->prepare("INSERT INTO measure_type(measure_type_name) VALUES (?)");
        $statement->bind_param("s", $this->measurement_type_name);

        if (!$statement->execute()) {
            mysqli_close($conn);
            die("Cannot insert new measure_type");
        }

        mysqli_close($conn);
    }

}