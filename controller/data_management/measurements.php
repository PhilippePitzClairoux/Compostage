<?php


    include_once($_SERVER["DOCUMENT_ROOT"] . "/controller/ConnectionManager.php");

    class measurements implements JsonSerializable {

        private $sensor_id;
        private $measurement_value;
        private $measurement_timestamp;

        public static function loadWithId($sensor_id, $timestamp) {

            $instance = new self();

            $instance->setSensorId($sensor_id);
            $instance->setMeasurementTimestamp($timestamp);
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
            $statemenet = $con->prepare("SELECT measure_value FROM ta_measure_type WHERE sensor_id=? AND measure_timestamp=?");

            $statemenet->bind_param("is", $this->sensor_id, $this->measurement_timestamp);

            if (!$statemenet->execute()) {
                $con->close();
                throw new Exception($statemenet->error);
            }

            $result = $statemenet->get_result();

            while ($row = $result->fetch_assoc()) {

                $this->setMeasurementValue($row["measure_value"]);
            }

            $result->free();
            $con->close();
        }

        public function insert_data() {

            $con = getConnection();

            $statement = $con->prepare("INSERT INTO ta_measure_type(sensor_id, measure_value, measure_timestamp) VALUES (?, ?, ?)");
            $statement->bind_param("iis", $this->getSensorId(),
                $this->getMeasurementValue(), $this->getMeasurementTimestamp());

            if (!$statement->execute()) {
                $con->close();
                throw new Exception($statement->error);
            }

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