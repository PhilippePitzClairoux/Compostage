<?php

    include_once("ConnectionManager.php");
    include_once("sensor_state.php");
    include_once("sensor_type.php");
    include_once("measurement.php");

    class sensor {

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

            $statement = $conn->prepare("SELECT * FROM measures WHERE sensor_id = ?");
            $statement->bind_param("i", $this->sensor_id);

            if (!$statement->execute()) {
                mysqli_close($conn);
                throw new Exception($statement->error);
            }


            $result = $statement->get_result();
            $this->measures = array();

            while ($row = $result->fetch_assoc()) {

                array_push($this->measures, measurement::loadWithId($row["measure_id"]));
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

                $this->sensor_type = sensor_type::loadWithId($row["sensor_type_id"]);
                $this->sensor_state = sensor_state::loadWithId($row["sensor_state_id"]);
                $this->loadMeasurements();

                $this->setSensorAquisitionDate($row["sensor_aquisition_date"]);
                $this->setSensorSerialNumber($row["sensor_serial_number"]);
                $this->setSensorRaspberryPiId($row["raspberry_pi_id"]);
            }
        }

        public function insert_data() {

            $conn = getConnection();

            $statement = $conn->prepare("INSERT INTO sensor(sensor_state_id, sensor_type_id, raspberry_pi_id,
                                                sensor_aquisition_date, sensor_serial_number) VALUES (?, ?, ?, ?, ?) ");

            $statement->bind_param("iiiss", ($this->sensor_state)->getSensorStateId(),
                ($this->sensor_type)->getSensorTypeId(), $this->sensor_raspberry_pi_id,
                $this->sensor_aquisition_date, $this->sensor_serial_number);

            if (!$statement->execute()) {
                mysqli_close($conn);
                throw new Exception($statement->error);
            }

            mysqli_close($conn);
        }
    }

//    $tmp = sensor::createNewSensor(1, 1, 1, "2019-04-24", "666-696969-999");
//    print_r($tmp);

//    $tmp = sensor::loadWithId(1);
//    print_r($tmp);