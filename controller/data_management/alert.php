
<?php


    include_once("alert_type.php");
    include_once("measurements.php");

    class alert implements JsonSerializable {

        private $alert_id;
        private $alert_type;
        private $measure;
        private $has_been_viewed;

        private function __construct() {}

        public static function createNewAlert($alert_type_id, $measure_id) {
            $instance = new self();

            $instance->setAlertType(alert_type::loadWithId($alert_type_id));
            $instance->setMeasure(measurements::loadWithId($measure_id));
            $instance->setHasBeenViewed(false);
            $instance->insert_data();

            return $instance;
        }


        public static function loadWithId($alert_id) {

            $instance = new self();

            $instance->setAlertId($alert_id);
            $instance->fetch_data();

            return $instance;
        }

        public function getHasBeenViewed() {
            return $this->has_been_viewed;
        }

        public function setHasBeenViewed($has_been_viewed): void {
            $this->has_been_viewed = $has_been_viewed;
        }

        public function getAlertId() {
            return $this->alert_id;
        }

        public function setAlertId($alert_id): void {
            $this->alert_id = $alert_id;
        }


        public function getAlertType() {
            return $this->alert_type;
        }

        public function setAlertType($alert_type): void {
            $this->alert_type = $alert_type;
        }

        public function getMeasure() {
            return $this->measure;
        }

        public function setMeasure($measure): void {
            $this->measure = $measure;
        }


        public function insert_data() {

            $conn = getConnection();

            $statement = $conn->prepare("INSERT INTO ta_alert_event(alert_type_id, measure_id, has_been_viewed) VALUES (?, ?, ?)");
            $statement->bind_param("sii", $this->alert_type->getAlertTypeName(),
                $this->measure->getMeasurementId(), boolval($this->getHasBeenViewed()));

            if (!$statement->execute()) {
                $conn->close();
                throw new Exception($statement->error);
            }

            $this->setAlertId(mysqli_insert_id($conn));
            $conn->close();

        }

        public function fetch_data() {

            $conn = getConnection();

            $statement = $conn->prepare("SELECT * FROM ta_alert_event INNER JOIN ta_measure_type tmt on ta_alert_event.measure_id = tmt.ta_measure_type_id WHERE alert_event_id = ?");
            $statement->bind_param("i", $this->getAlertId());


            if (!$statement->execute()) {
                mysqli_close($conn);
                throw new Exception($statement->error);
            }

            $result = $statement->get_result();

            if ($result->num_rows === 0) {
                mysqli_free_result($result);
                mysqli_close($conn);
                throw new Exception("There is no alert.");
            }

            while ($row = $result->fetch_assoc()) {

                $this->measure = measurements::loadWithId($row["measure_id"]);
                $this->alert_type = alert_type::loadWithId($row["alert_type_id"]);
                $this->setHasBeenViewed($row["has_been_viewed"]);

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