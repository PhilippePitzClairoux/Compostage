
<?php

    include_once($_SERVER["DOCUMENT_ROOT"] . "/controller/ConnectionManager.php");
    include_once($_SERVER["DOCUMENT_ROOT"] . "/controller/data_management/sensor_state.php");
    include_once($_SERVER["DOCUMENT_ROOT"] . "/controller/data_management/sensor_type.php");
    include_once($_SERVER["DOCUMENT_ROOT"] . "/controller/data_management/measurements.php");


    class sensor implements JsonSerializable {

        private $sensor_id;
        private $sensor_state;
        private $sensor_type;
        private $sensor_raspberry_pi_id;
        private $sensor_aquisition_date;
        private $sensor_serial_number;
        private $measures;

        private function __construct() {}

        public static function loadWithId($sensor_id) {

            $instance = new self();

            $instance->setSensorId($sensor_id);
            $instance->fetch_data();

            return $instance;
        }

        public static function createNewSensor($sensor_state_id, $sensor_type_id, $raspberry_pi_id, $aquisition_date, $serial_number) {

            $instance = new self();

            $instance->setSensorState(sensor_state::loadWithId($sensor_state_id));
            $instance->setSensorType(sensor_type::loadWithId($sensor_type_id));
            $instance->setSensorRaspberryPiId($raspberry_pi_id);
            $instance->setSensorAquisitionDate($aquisition_date);
            $instance->setSensorSerialNumber($serial_number);

            $instance->insert_data();

            return $instance;
        }

        public function getSensorRaspberryPiId() {
            return $this->sensor_raspberry_pi_id;
        }

        public function setSensorRaspberryPiId($sensor_raspberry_pi_id): void {
            $this->sensor_raspberry_pi_id = $sensor_raspberry_pi_id;
        }

        public function getSensorId() {
            return $this->sensor_id;
        }

        public function setSensorId($sensor_id): void {
            $this->sensor_id = $sensor_id;
        }

        public function getSensorState() {
            return $this->sensor_state;
        }

        public function setSensorState($sensor_state): void {
            $this->sensor_state = $sensor_state;
        }

        public function getSensorType() {
            return $this->sensor_type;
        }

        public function setSensorType($sensor_type): void {
            $this->sensor_type = $sensor_type;
        }

        public function getSensorAquisitionDate() {
            return $this->sensor_aquisition_date;
        }

        public function setSensorAquisitionDate($sensor_aquisition_date): void {
            $this->sensor_aquisition_date = $sensor_aquisition_date;
        }

        public function getSensorSerialNumber() {
            return $this->sensor_serial_number;
        }

        public function setSensorSerialNumber($sensor_serial_number): void {
            $this->sensor_serial_number = $sensor_serial_number;
        }

        public function getMeasures() {
            return $this->measures;
        }

        private function loadMeasurements() {

            $conn = getConnection();

            $statement = $conn->prepare("SELECT ta_measure_type_id FROM ta_measure_type WHERE sensor_id = ?");
            $statement->bind_param("i", $this->sensor_id);

            if (!$statement->execute()) {
                mysqli_close($conn);
                throw new Exception($statement->error);
            }

            $result = $statement->get_result();
            $this->measures = array();

            while ($row = $result->fetch_assoc()) {

                array_push($this->measures, measurements::loadWithId($row["ta_measure_type_id"]));
            }

            mysqli_free_result($result);
            mysqli_close($conn);
        }

        public function fetch_data() {

            $conn = getConnection();

            $statement = $conn->prepare("SELECT * FROM sensor WHERE sensor_id = ?");
            $statement->bind_param("i", $this->sensor_id);

            if (!$statement->execute()) {
                mysqli_close($conn);
                throw new Exception($statement->error);
            }

            $result = $statement->get_result();

            if ($result->num_rows === 0) {
                mysqli_free_result($result);
                mysqli_close($conn);
                throw new Exception("Sensor does not exist");
            }

            while ($row = $result->fetch_assoc()) {

                $this->sensor_type = sensor_type::loadWithId($row["sensor_type"]);
                $this->sensor_state = sensor_state::loadWithId($row["sensor_state"]);

                $this->setSensorAquisitionDate($row["sensor_aquisition_date"]);
                $this->setSensorSerialNumber($row["sensor_serial_number"]);
                $this->setSensorRaspberryPiId($row["raspberry_pi_id"]);
            }

            $this->loadMeasurements();

            mysqli_free_result($result);
            mysqli_close($conn);
        }

        public function insert_data() {

            $conn = getConnection();

            $statement = $conn->prepare("INSERT INTO sensor(sensor_state, sensor_type, raspberry_pi_id,
                                                sensor_aquisition_date, sensor_serial_number) VALUES (?, ?, ?, ?, ?) ");

            $statement->bind_param("ssiss", ($this->sensor_state)->getSensorState(),
                ($this->sensor_type)->getSensorType(), $this->sensor_raspberry_pi_id,
                $this->sensor_aquisition_date, $this->sensor_serial_number);

            if (!$statement->execute()) {
                mysqli_close($conn);
                throw new Exception($statement->error);
            }

            $this->setSensorId(mysqli_insert_id($conn));

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

//    $tmp = sensor::createNewSensor("WORKING", "PH_SENOSR", 1, "2019-04-24", "666-696969-999");
//    print_r($tmp);

//    $tmp = sensor::loadWithId(1);
//    print_r($tmp);
