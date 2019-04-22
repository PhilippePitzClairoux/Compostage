<?php

    include_once("measurement_value.php");

    class measurement {

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

        public function setMeasurementId($measurement_id) {
            if (!is_null($measurement_id))
                $this->measurement_id = $measurement_id;
        }

        public function getMeasurementValue() {
            return $this->measurement_value;
        }

        public function setMeasurementValue($measurement_value) {
            if (!is_null($measurement_value))
            $this->measurement_value = $measurement_value;
        }


        public function getMeasurementDate() {
            return $this->measurement_date;
        }


        public function setMeasurementDate($measurement_date) {
            if (!is_null($measurement_date))
                $this->measurement_date = $measurement_date;
        }

        function fetch_data() {

            $conn = getConnection();
            $statement = $conn->prepare("SELECT * FROM measures WHERE measure_id = ?");

            $statement->bind_param("i", $this->measurement_id);

            if (!$statement->execute()) {
                mysqli_close($conn);
                die("Cannot fetch measure data");
            }

            $result = $statement->get_result();

            while($row = $result->fetch_assoc()) {

                $this->measurement_date = $row["measure_timestamp"];
                $this->sensor_id = $row["sensor_id"];
            }

            mysqli_free_result($result);


            $statement = $conn->prepare("SELECT * FROM ta_measure_type WHERE measure_id = ?");
            $statement->bind_param("i", $this->measurement_id);

            if (!$statement->execute()) {
                mysqli_close($conn);
                die("Cannot fetch types...");
            }

            $this->measurement_types = array();
            $this->measurement_value = array();

            $result = $statement->get_result();

            while($row = $result->fetch_assoc()) {

                array_push($this->measurement_types, $row["measure_type_id"]);
            }

            mysqli_free_result($result);

            foreach($this->measurement_types as $type_id) {

                $index = array_push($this->measurement_value,new measurement_value($this->measurement_id, $type_id)) -1;
                ($this->measurement_value[$index])->fetch_data();
            }

        }

        //TODO : insert the new data in the database
        function insert_data() {

            $conn = getConnection();
            $statement = $conn->prepare("INSERT INTO measures(sensor_id, measure_timestamp) VALUES (?, ?) ");

            date_default_timezone_set('America/New_York');
            $date = date("r");

            $statement->bind_param("is", $this->sensor_id, $date);

            if (!$statement->execute()) {
                mysqli_close($conn);
                die("Cannot insert data inside measures...");
            }

        }

    }

    $tmp = measurement::newMeasurement(1, 10, 1);
    $tmp->insert_data();