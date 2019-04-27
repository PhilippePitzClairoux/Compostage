<?php

    include_once("../ConnectionManager.php");
    include_once("sensor_state.php");
    include_once("sensor_type.php");

    class sensor {

        private $sensor_id;
        private $sensor_state;
        private $sensor_type;
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

        //TODO
        public static function createNewSensor($sensor_state_id, $sensor_type_id, $aquisition_date, $serial_number) {

            $instance = new self();

            $instance->setSensorState(sensor_state::loadWithId($sensor_state_id));
            $instance->setSensorType(sensor_type::loadWithId($sensor_type_id));
            $instance->setSensorAquisitionDate($aquisition_date);
            $instance->setSensorSerialNumber($serial_number);

            $instance->insert_data();

            return $instance;
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

        public function fetch_data() {

            $con = getConnection();

            $statement = $con->prepare("SELECT * FROM sensor WHERE sensor_id = ?");
            $statement->bind_param("i", $this->sensor_id);

            if (!$statement->execute()) {
                mysqli_close($con);
                throw new Exception($statement->error);
            }

            $result = $statement->get_result();

            if ($result->num_rows === 0) {
                mysqli_free_result($result);
                mysqli_close($con);
                throw new Exception("Sensor does not exist");
            }

            while ($row = $result->fetch_assoc()) {

                $this->sensor_type = sensor_type::loadWithId($row["sensor_type_id"]);
                $this->sensor_state = sensor_state::loadWithId($row["sensor_state_id"]);

                $this->setSensorAquisitionDate($row["sensor_aquisition_date"]);
                $this->setSensorSerialNumber($row["sensor_serial_number"]);
            }

        }

        public function insert_data() {

            $con = getConnection();

            $statement = $con->prepare("INSERT INTO sensor(sensor_state_id, raspberry_pi_id,
                                                sensor_aquisition_date, sensor_serial_number) VALUES (?, ?, ?, ?) ");

            $statement->bind_param("iiss", ($this->sensor_state)->getSensorStateId(),
                ($this->sensor_type)->getSensorTypeId(), $this->sensor_aquisition_date,
                $this->sensor_serial_number);

            if (!$statement->execute()) {
                mysqli_close($con);
                throw new Exception($statement->error);
            }

            mysqli_close($con);
        }

    }

