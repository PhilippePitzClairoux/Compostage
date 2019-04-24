<?php

    include("measurement_type.php");


    class measurement_value {

        private $measurement_id;
        private $measurement_type_id;
        private $measurement_type;
        private $measurement_value;

        function __construct($measurement_id, $measurement_type_id) {

            $this->measurement_id = $measurement_id;
            $this->measurement_type_id = $measurement_type_id;
        }

        static function createNewMeasurement() {

        }

        public function getMeasurementTypeId() {
            return $this->measurement_type_id;
        }

        public function setMeasurementTypeId($measurement_type_id): void {
            if (!is_null($measurement_type_id))
                $this->measurement_type_id = $measurement_type_id;
        }


        public function getMeasurementId() {
            return $this->measurement_id;
        }

        public function setMeasurementId($measurement_id): void {
            if (!is_null($measurement_id))
                $this->measurement_id = $measurement_id;
        }



        public function getMeasurementType() {
            return $this->measurement_type;
        }

        public function setMeasurementType($measurement_type): void {
            if (!is_null($measurement_type))
                $this->measurement_type = $measurement_type;
        }

        public function getMeasurementValue() {
            return $this->measurement_value;
        }

        public function setMeasurementValue($measurement_value): void {
            if (!is_null($measurement_value))
                $this->measurement_value = $measurement_value;
        }

        function fetch_data() {

            if (is_null($this->measurement_type_id) AND is_null($this->measurement_id))
                die("Cannot fetch data without a measurement_type_id and measurement_id");

            $conn = getConnection();
            $statement = $conn->prepare("SELECT * FROM ta_measure_type WHERE measure_id = ? AND measure_type_id = ?");
            $statement->bind_param("ii", $this->measurement_id, $this->measurement_type_id);

            if (!$statement->execute()) {
                mysqli_close($conn);
                die("Cannot fetch the data for value...");
            }

            $result = $statement->get_result();

            print_r($result);
            while($row = $result->fetch_assoc()) {

                $this->measurement_type = new measurement_type($row["measure_type_id"]);
                ($this->measurement_type)->fetch_data();

                $this->measurement_value = $row["measure_value"];
            }

            mysqli_free_result($result);
            mysqli_close($conn);
        }

        function insert_data() {

            if (is_null($this->measurement_type_id) AND is_null($this->measurement_id))
                die("Cannot insert data without a measurement_type_id and a measurement_id");

            if (empty($this->measurement_value))
                die("Cannot insert data without a value...");

            $conn = getConnection();
            $statement = $conn->prepare("INSERT INTO ta_measure_type(measure_id, measure_type_id, measure_value) VALUES (?, ?, ?)");

            $statement->bind_param("iif", $this->measurement_id, $this->measurement_type_id, $this->measurement_value);

            if (!$statement->execute()) {
                mysqli_close($conn);
                die("Cannot insert measure");
            }

            mysqli_close($conn);
        }

    }