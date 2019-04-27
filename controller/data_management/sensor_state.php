<?php

    include_once("../ConnectionManager.php");

    class sensor_state {

        private $sensor_id;
        private $sensor_state;

        private function __construct(){}

        public static function loadWithId($sensor_id) {

            $instance = new self();

            $instance->setSensorId($sensor_id);
            $instance->fetch_data();

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

        public function fetch_data() {

            $conn = getConnection();

            $statement = $conn->prepare("SELECT * FROM sensor_state WHERE sensor_state_id = ?");
            $statement->bind_param("i", $this->sensor_id);

            if (!$statement->execute()) {
                mysqli_close($conn);
                throw new Exception($statement->error);
            }

            $result = $statement->get_result();

            if ($result->num_rows === 0)
                throw new Exception("Sensor State does not exist");

            while ($row = $result->fetch_assoc()) {

                $this->setSensorState($row["sensor_state"]);
            }

            mysqli_free_result($result);
            mysqli_close($conn);
        }


    }