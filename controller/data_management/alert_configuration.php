<!--********************************
    Fichier : alert_configuration.php
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

    include_once($_SERVER["DOCUMENT_ROOT"] . "/controller/ConnectionManager.php");

    class alert_configuration implements JsonSerializable {

        private $alert_configuration_id;
        private $alert_configuration_message;
        private $alert_configuration_min;
        private $alert_configuration_max;

        private function __construct() {}

        public static function loadWithAlertConfigurationId($alert_configuration_id) {
            $instance = new self();

            $instance->setAlertConfigurationId($alert_configuration_id);
            $instance->fetch_data();

            return $instance;
        }

        public static function createNewAlertConfiguration($alert_message, $alert_min, $alert_max) {
            $instance = new self();

            $instance->setAlertConfigurationMessage($alert_message);
            $instance->setAlertConfigurationMin($alert_min);
            $instance->setAlertConfigurationMax($alert_max);

            $instance->insert_data();

            return $instance;
        }

        public function getSensorId() {
            return $this->sensor_id;
        }

        public function setSensorId($sensor_id): void {
            $this->sensor_id = $sensor_id;
        }


        public function getAlertConfigurationId() {
            return $this->alert_configuration_id;
        }

        public function setAlertConfigurationId($alert_configuration_id): void {
            $this->alert_configuration_id = $alert_configuration_id;
        }

        public function getAlertConfigurationMessage() {
            return $this->alert_configuration_message;
        }

        public function setAlertConfigurationMessage($alert_configuration_message): void {
            $this->alert_configuration_message = $alert_configuration_message;
        }

        public function getAlertConfigurationMin() {
            return $this->alert_configuration_min;
        }

        public function setAlertConfigurationMin($alert_configuration_min): void {
            $this->alert_configuration_min = $alert_configuration_min;
        }

        public function getAlertConfigurationMax() {
            return $this->alert_configuration_max;
        }

        public function setAlertConfigurationMax($alert_configuration_max): void {
            $this->alert_configuration_max = $alert_configuration_max;
        }

        public function fetch_data() {

            $conn = getConnection();

            $statement = $conn->prepare("SELECT * FROM alert_configuration WHERE alert_configuration_id = ?");
            $statement->bind_param("i", $this->getAlertConfigurationId());

            if (!$statement->execute()) {
                mysqli_close($conn);
                throw new Exception($statement->error);
            }

            $result = $statement->get_result();

            if ($result->num_rows === 0) {
                mysqli_free_result($result);
                mysqli_close($conn);
                throw new Exception("Alert configuration does not exist");
            }

            while ($row = $result->fetch_assoc()) {

                $this->setAlertConfigurationMax($row["alert_configuration_max_value"]);
                $this->setAlertConfigurationMin($row["alert_configuration_min_value"]);
                $this->setAlertConfigurationMessage($row["alert_configuration_message"]);

            }

            mysqli_free_result($result);
            mysqli_close($conn);
        }

        public function insert_data() {

            $conn = getConnection();

            $statement = $conn->prepare("INSERT INTO alert_configuration(alert_configuration_message,
                                alert_configuration_min_value, alert_configuration_max_value) VALUES (?, ?, ?)");

            $statement->prepare("sii", $this->getAlertConfigurationMessage(), $this->getAlertConfigurationMin(),
                $this->getAlertConfigurationMax());

            if (!$statement->execute()) {
                mysqli_close($conn);
                throw new Exception($statement->error);
            }

            $statement->close();
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