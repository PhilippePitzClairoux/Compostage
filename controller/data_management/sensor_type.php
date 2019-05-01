<?php

    include_once("../ConnectionManager.php");

    class sensor_type {

        private $sensor_type_id;
        private $sensor_type_name;

        private function __construct() {}

        public static function loadWithId($sensor_type) {

            $instance = new self();

            $instance->setSensorTypeId($sensor_type);
            $instance->fetch_data();

            return $instance;
        }

        public function getSensorTypeId() {
            return $this->sensor_type_id;
        }

        public function setSensorTypeId($sensor_type_id): void {
            $this->sensor_type_id = $sensor_type_id;
        }

        public function getSensorTypeName() {
            return $this->sensor_type_name;
        }

        public function setSensorTypeName($sensor_type_name): void {
            $this->sensor_type_name = $sensor_type_name;
        }

        function fetch_data() {

            $conn = getConnection();

            $statement = $conn->prepare("SELECT * FROM sensor_type WHERE sensor_type_id = ?");
            $statement->bind_param("i", $this->sensor_type_id);

            if (!$statement->execute()) {
                mysqli_close($conn);
                throw new Exception($statement->error);
            }

            $result = $statement->get_result();

            if ($result->num_rows === 0) {
                mysqli_free_result($result);
                mysqli_close($conn);
                throw new Exception("Sensor Type does not exist");
            }

            while ($row = $result->fetch_assoc()) {
                $this->setSensorTypeName($row["sensor_type_name"]);
            }


            mysqli_free_result($result);
            mysqli_close($conn);
        }

    }