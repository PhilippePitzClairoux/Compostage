<?php

    include_once($_SERVER["DOCUMENT_ROOT"] . "/controller/ConnectionManager.php");

    class sensor_state {

        private $sensor_state_id;
        private $sensor_state;

        private function __construct(){}

        public static function loadWithId($sensor_id) {

            $instance = new self();

            $instance->setSensorStateId($sensor_id);
            $instance->fetch_data();

            return $instance;
        }


        public function getSensorStateId() {
            return $this->sensor_state_id;
        }

        public function setSensorStateId($sensor_state_id): void {
            $this->sensor_state_id = $sensor_state_id;
        }

        public function getSensorState() {
            return $this->sensor_state;
        }

        public function setSensorState($sensor_state): void {
            $this->sensor_state = $sensor_state;
        }

        public function fetch_data() {

            $conn = getConnection();

            $statement = $conn->prepare("SELECT * FROM sensor_state WHERE sensor_state_id = ?");
            $statement->bind_param("i", $this->sensor_state_id);

            if (!$statement->execute()) {
                mysqli_close($conn);
                throw new Exception($statement->error);
            }

            $result = $statement->get_result();

            if ($result->num_rows === 0) {
                mysqli_free_result($result);
                mysqli_close($conn);
                throw new Exception("Sensor State does not exist");
            }
            while ($row = $result->fetch_assoc()) {

                $this->setSensorState($row["sensor_state"]);
            }

            mysqli_free_result($result);
            mysqli_close($conn);
        }


    }