<!--********************************
    Fichier : measurement_value.php
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

    include("measurement_type.php");

    class measurement_value implements JsonSerializable {

        private $measurement_id;
        private $measurement_type;
        private $measurement_value;

        private function __construct() {}

        public static function loadWithId($measurement_id, $measurement_type_id) {
            $instance = new self();

            $instance->setMeasurementId($measurement_id);
            $instance->setMeasurementType(measurement_type::loadWithId($measurement_type_id));

            $instance->fetch_data();

            return $instance;
        }

        static function createNewMeasurement($measurement_value, $measurement_type_id) {
            $instance = new self();

            $instance->setMeasurementValue($measurement_value);
            $instance->setMeasurementType(measurement_type::loadWithId($measurement_type_id));

            $instance->insert_data();

            return $instance;
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

            if (is_null($this->measurement_type) AND is_null($this->measurement_id))
                die("Cannot fetch data without a measurement_type_id and measurement_id");

            $conn = getConnection();
            $statement = $conn->prepare("SELECT * FROM ta_measure_type WHERE measure_id = ? AND measure_type_id = ?");
            $statement->bind_param("ii", $this->measurement_id,
                ($this->measurement_type)->getMeasurementTypeId());

            if (!$statement->execute()) {
                mysqli_close($conn);
                throw new Exception($statement->error);
            }

            $result = $statement->get_result();

            if ($result->num_rows === 0) {
                mysqli_free_result($result);
                mysqli_close($conn);
                throw new Exception("Measurement does not exist");
            }

            while($row = $result->fetch_assoc()) {

                $this->measurement_value = $row["measure_value"];
            }

            mysqli_free_result($result);
            mysqli_close($conn);
        }

        function insert_data() {

            if (is_null($this->measurement_type) AND is_null($this->measurement_id))
                die("Cannot insert data without a measurement_type_id and a measurement_id");

            if (empty($this->measurement_value))
                die("Cannot insert data without a value...");

            $conn = getConnection();
            $statement = $conn->prepare("INSERT INTO ta_measure_type(measure_id, measure_type_id, measure_value) VALUES (?, ?, ?)");

            $statement->bind_param("iif", $this->measurement_id,
                ($this->measurement_type)->getMeasurementTypeId(), $this->measurement_value);

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