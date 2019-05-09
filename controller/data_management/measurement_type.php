<!--********************************
    Fichier : measurement_type.php
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

    include_once($_SERVER["DOCUMENT_ROOT"] . "/controller/ConnectionManager.php");

class measurement_type implements JsonSerializable {

    private $measurement_type_id;
    private $measurement_type_name;

    private function __construct() {}

    public static function loadWithId($measurement_type_id) {
        $instance = new self();

        $instance->setMeasurementTypeId($measurement_type_id);
        $instance->fetch_data();

        return $instance;
    }

//    public static function createNewMeasurementType($measurement_type_name) {
//        $instance = new self();
//
//        $instance->setMeasurementTypeName($measurement_type_name);
//        $instance->insert_data();
//
//        return $instance;
//    }

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
            throw new Exception($statement->error);
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

//    function insert_data() {
//
//        $conn = getConnection();
//
//        $statement = $conn->prepare("INSERT INTO measure_type(measure_type_name) VALUES (?)");
//        $statement->bind_param("s", $this->measurement_type_name);
//
//        if (!$statement->execute()) {
//            mysqli_close($conn);
//            throw new Exception($statement->error);
//        }
//
//        mysqli_close($conn);
//    }

    /**
     * Specify data which should be serialized to JSON
     * @link https://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    public function jsonSerialize() {
        return get_object_vars($this);
    }
}