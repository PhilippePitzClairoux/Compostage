<!--********************************
    Fichier : alert_type.php
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

    class alert_type {

        private $alert_type_id;
        private $alert_type_name;

        private function __construct(){}

        public static function loadWithId($alert_type_id) {

            $instance = new self();

            $instance->setAlertTypeId($alert_type_id);
            $instance->fetch_data();

            return $instance;
        }

        public function getAlertTypeId() {
            return $this->alert_type_id;
        }

        public function setAlertTypeId($alert_type_id): void {
            $this->alert_type_id = $alert_type_id;
        }

        public function getAlertTypeName() {
            return $this->alert_type_name;
        }

        public function setAlertTypeName($alert_type_name): void {
            $this->alert_type_name = $alert_type_name;
        }

        public function fetch_data() {

            $conn = getConnection();

            $statement = $conn->prepare("SELECT * FROM alert_type WHERE alert_type_id = ?");
            $statement->bind_param("i", $this->alert_type_id);

            if (!$statement->execute()) {
                mysqli_close($conn);
                throw new Exception($statement->error);
            }

            $result = $statement->get_result();

            if ($result->num_rows === 0) {
                mysqli_free_result($result);
                mysqli_close($conn);
                throw new Exception("Alert type does not exist.");
            }
            while ($row = $result->fetch_assoc()) {

                $this->setAlertTypeName($row["alert_type_name"]);
            }

            mysqli_free_result($result);
            mysqli_close($conn);
        }

    }