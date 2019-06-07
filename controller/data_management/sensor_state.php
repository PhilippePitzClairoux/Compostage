
<?php

    include_once($_SERVER["DOCUMENT_ROOT"] . "/controller/ConnectionManager.php");

    class sensor_state implements JsonSerializable {

        private $sensor_state;

        private function __construct(){}

        public static function loadWithId($sensor_id) {

            $instance = new self();

            $instance->setSensorState($sensor_id);
            $instance->fetch_data();

            return $instance;
        }

        public function getSensorState() {
            return $this->sensor_state;
        }

        public function setSensorState($sensor_state): void {
            $this->sensor_state = $sensor_state;
        }

        public function fetch_data() {

            $conn = getConnection();

            $statement = $conn->prepare("SELECT * FROM sensor_state WHERE sensor_state = ?");
            $statement->bind_param("s", $this->sensor_state);

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