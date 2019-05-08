<!--********************************
    Fichier : alert.php
    Auteur : Philippe Pitz Clairoux
    Fonctionnalité :
    Date : 2019-05-04

    Vérification :
    Date                Nom                 Approuvé
    ====================================================

    Historique de modifications :
    Date                Nom                 Description
    ======================================================

 ********************************/-->
<?php


    include_once("alert_type.php");
    include_once("measurement.php");

    class alert implements JsonSerializable {

        private $alert_type;
        private $measure;

        private function __construct() {}

        public static function loadWithAlertTypeId($alert_type_id) {

            $instance = new self();

            $instance->setAlertType(alert_type::loadWithId($alert_type_id));
            $instance->fetch_data();

            return $instance;
        }

        public static function loadWithMeasureId($measure_id) {

            $instance = new self();

            $instance->setMeasure(measurement::loadWithId($measure_id));
            $instance->fetch_data();

            return $instance;
        }

        public static function loadWithMeasureIdAndTypeId($measure_id, $alert_type_id) {

            $instance = new self();

            $instance->setMeasure(measurement::loadWithId($measure_id));
            $instance->setAlertType(alert_type::loadWithId($alert_type_id));
            $instance->fetch_data();

            return $instance;
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


        public function fetch_data() {

            $conn = getConnection();
            $statement = "";

            if (!empty($this->alert_type) AND !empty($this->measure)) {

                $statement = $conn->prepare("SELECT * FROM ta_alert_event WHERE alert_type_id = ? AND measure_id = ?");
                $statement->bind_param("ii",($this->alert_type)->getAlertTypeId(),
                    ($this->measure)->getMeasurementId());

            } else if (!empty($this->measure)) {

                $statement = $conn->prepare("SELECT * FROM ta_alert_event WHERE measure_id = ?");
                $statement->bind_param("i", ($this->measure)->getMeasurementId());

            } else if (!empty($this->alert_type)) {

                $statement = $conn->prepare("SELECT * FROM ta_alert_event WHERE alert_type_id = ?");
                $statement->bind_param("i", ($this->alert_type)->getAlertTypeId());

            }

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

                $this->measure = measurement::loadWithId($row["measure_id"]);
                $this->alert_type = alert_type::loadWithId($row["alert_type_id"]);

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