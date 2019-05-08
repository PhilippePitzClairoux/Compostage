<!--********************************
    Fichier : measurement.php
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

    include_once("measurement_value.php");

    class measurement implements JsonSerializable {

        private $measurement_id;
        private $sensor_id;
        private $measurement_value;
        private $measurement_date;
        private $measurement_types;


        function __construct() {}

        static function loadWithId($measurement_id) {

            $instance = new self();
            $instance->setMeasurementId($measurement_id);

            $instance->fetch_data();
            return $instance;
        }

        static function newMeasurement($sensor_id, $value, $type_id) {

            $instance = new self();

            $instance->setMeasurementValue($value);
            $instance->setSensorId($sensor_id);
            $instance->setMeasurementTypes($type_id);

            return $instance;
        }

        public function getSensorId() {
            return $this->sensor_id;
        }

        public function setSensorId($sensor_id): void {
            if (!is_null($sensor_id))
                $this->sensor_id = $sensor_id;
        }


        public function getMeasurementTypes() {
            return $this->measurement_types;
        }

        public function setMeasurementTypes($measurement_types): void {
            if (!is_null($measurement_types))
                $this->measurement_types = $measurement_types;
        }

        public function getMeasurementId() {
            return $this->measurement_id;
        }

        public function setMeasurementId($measurement_id) : void {
            if (!is_null($measurement_id))
                $this->measurement_id = $measurement_id;
        }

        public function getMeasurementValue() {
            return $this->measurement_value;
        }

        public function setMeasurementValue($measurement_value) : void {
            if (!is_null($measurement_value))
            $this->measurement_value = $measurement_value;
        }


        public function getMeasurementDate() {
            return $this->measurement_date;
        }


        public function setMeasurementDate($measurement_date) : void {
            if (!is_null($measurement_date))
                $this->measurement_date = $measurement_date;
        }

        function fetch_id($sensor_id, $date) : void {

            $conn = getConnection();
            $statement = $conn->prepare("SELECT * FROM measures WHERE sensor_id = ? AND measure_timestamp = ?");

            $statement->bind_param("is",  $sensor_id, $date);

            if (!$statement->execute()) {
                mysqli_close($conn);
                throw new Exception($statement->error);
            }

            $result = $statement->get_result();

            while($row = $result->fetch_assoc()) {

                $this->measurement_id = $row["measure_id"];
            }

            mysqli_free_result($result);
            mysqli_close($conn);
        }

        function fetch_data() {

            $conn = getConnection();
            $statement = $conn->prepare("SELECT * FROM measures WHERE measure_id = ?");
            $statement->bind_param("i", $this->measurement_id);

            if (!$statement->execute()) {
                mysqli_close($conn);
                throw new Exception($statement->error);
            }

            $result = $statement->get_result();

            while($row = $result->fetch_assoc()) {

                $this->measurement_date = $row["measure_timestamp"];
                $this->sensor_id = $row["sensor_id"];
            }

            mysqli_free_result($result);
            $statement->close();

            $statement = $conn->prepare("SELECT * FROM ta_measure_type WHERE measure_id = ?");
            $statement->bind_param("i", $this->measurement_id);

            if (!$statement->execute()) {
                mysqli_close($conn);
                throw new Exception($statement->error);
            }

            $this->measurement_types = array();
            $this->measurement_value = array();

            $result = $statement->get_result();

            if($result->num_rows === 0 ) {
                mysqli_free_result($result);
                mysqli_close($conn);
                throw new Exception("Measurement does not exist");
            }

            while($row = $result->fetch_assoc()) {

                array_push($this->measurement_types, $row["measure_type_id"]);
            }


            mysqli_free_result($result);

            foreach($this->measurement_types as $type_id) {

                array_push($this->measurement_value,measurement_value::loadWithId($this->measurement_id, $type_id));
            }

        }


        function insert_data() {

            $conn = getConnection();
            $statement = $conn->prepare("INSERT INTO measures(sensor_id, measure_timestamp) VALUES (?, ?) ");

            date_default_timezone_set('America/New_York');
            $current_date = date("Y-m-d H:i:s", time());

            echo $current_date."\n";

            $statement->bind_param("is", $this->sensor_id, $current_date);

            if (!$statement->execute()) {
                mysqli_close($conn);
                throw new Exception($statement->error);
            }

            $this->fetch_id($this->sensor_id, $current_date);

            $statement->close();
            $statement = $conn->prepare("INSERT INTO ta_measure_type(measure_id, measure_type_id, measure_value) VALUES (?, ?, ?)");

            $statement->bind_param("iid", $this->measurement_id,
                $this->measurement_types, $this->measurement_value);

            if (!$statement->execute()) {
                mysqli_close($conn);
                throw new Exception($statement->error);
            }

            mysqli_close($conn);

        }

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

//    $tmp = measurement::newMeasurement(1, 10, 1);
//    $tmp->insert_data();

//    $tmp = measurement::loadWithId(2);
//    print_r($tmp->getMeasurementValue());