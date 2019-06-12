<?php


    include_once($_SERVER["DOCUMENT_ROOT"] . "/controller/ConnectionManager.php");

    class measurements implements JsonSerializable {

        private $sensor_id;
        private $measurement_id;
        private $measurement_value;
        private $measurement_timestamp;

        public static function loadWithId($measurement_id) {

            $instance = new self();

            $instance->setMeasurementId($measurement_id);
            $instance->fetch_data();

            return $instance;
        }

        public static function createNewMeasurement($sensor_id, $timestamp, $value) {
            $instance = new self();

            $instance->setSensorId($sensor_id);
            $instance->setMeasurementTimestamp($timestamp);
            $instance->setMeasurementValue($value);
            $instance->insert_data();

            return $instance;
        }

        public function getMeasurementId() {
            return $this->measurement_id;
        }

        public function setMeasurementId($measurement_id): void {
            $this->measurement_id = $measurement_id;
        }


        public function getSensorId() {
            return $this->sensor_id;
        }

        public function setSensorId($sensor_id): void {
            $this->sensor_id = $sensor_id;
        }

        public function getMeasurementValue() {
            return $this->measurement_value;
        }

        public function setMeasurementValue($measurement_value): void {
            $this->measurement_value = $measurement_value;
        }

        public function getMeasurementTimestamp() {
            return $this->measurement_timestamp;
        }

        public function setMeasurementTimestamp($measurement_timestamp): void {
            $this->measurement_timestamp = $measurement_timestamp;
        }


        public function fetch_data() {

            $con = getConnection();

            $statemenet = $con->prepare("SELECT * FROM ta_measure_type WHERE ta_measure_type_id=?");
            $statemenet->bind_param("i", $this->measurement_id);

            if (!$statemenet->execute()) {
                $con->close();
                throw new Exception($statemenet->error);
            }

            $result = $statemenet->get_result();

            while ($row = $result->fetch_assoc()) {

                $this->setMeasurementValue($row["measure_value"]);
                $this->setSensorId($row["sensor_id"]);
                $this->setMeasurementTimestamp($row["measure_timestamp"]);
            }

            $result->free();
            $con->close();
        }

        public function insert_data() {

            $con = getConnection();

            $statement = $con->prepare("INSERT INTO ta_measure_type(sensor_id, measure_value, measure_timestamp) VALUES (?, ?, ?)");
            $statement->bind_param("ids", $this->getSensorId(),
                $this->getMeasurementValue(), $this->getMeasurementTimestamp());

            if (!$statement->execute()) {
                $con->close();
                throw new Exception($statement->error);
            }

            $this->setMeasurementId(mysqli_insert_id($con));
            $con->close();
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