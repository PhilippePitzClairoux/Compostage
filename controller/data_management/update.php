<!--********************************
    Fichier : update.php
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
    include_once("update_state.php");
    include_once("raspberry_pi.php");

    class update {

        private $update_id;
        private $update_state;
        private $update_name;
        private $update_date;

        private function __construct() {}

        public static function loadWithId($update_id) {
            $instance = new self();

            $instance->setUpdateId($update_id);
            $instance->fetch_data();

            return $instance;
        }

        public function getUpdateId() {
            return $this->update_id;
        }

        public function setUpdateId($update_id): void {
            $this->update_id = $update_id;
        }

        public function getUpdateState() {
            return $this->update_state;
        }

        public function setUpdateState($update_state): void {
            $this->update_state = $update_state;
        }

        public function getUpdateName() {
            return $this->update_name;
        }

        public function setUpdateName($update_name): void {
            $this->update_name = $update_name;
        }

        public function getUpdateDate() {
            return $this->update_date;
        }

        public function setUpdateDate($update_date): void {
            $this->update_date = $update_date;
        }

        public function fetch_data() {

            $conn = getConnection();
            $statement = $conn->prepare("SELECT * FROM `update` WHERE update_id = ?");
            $statement->bind_param("i", $this->update_id);

            if (!$statement->execute()) {
                mysqli_close($conn);
                throw new Exception($statement->error);
            }

            $result = $statement->get_result();

            if ($result->num_rows === 0) {
                mysqli_free_result($result);
                mysqli_close($conn);
                throw new Exception("Update does not exist");
            }

            while ($row = $result->fetch_assoc()) {

                $this->setUpdateDate($row["update_date"]);
                $this->setUpdateState(update_state::loadWithId($row["update_state_id"]));
                $this->setUpdateName($row["update_name"]);
            }

            mysqli_free_result($result);
            mysqli_close($conn);
        }
    }

    function hasCompletedUpdate($update_id, $raspberry_pi_id) {

        $conn = getConnection();

        $raspberry_pi = raspberry_pi::loadWithId($raspberry_pi_id);
        $update = update::loadWithId($update_id);

        $statement = $conn->prepare("SELECT * FROM update_completed WHERE update_id = ? AND raspberry_pi_id = ?");
        $statement->bind_param("ii", $update->getUpdateId(), $raspberry_pi->getRaspberryPiId());

        if (!$statement->execute()) {
            mysqli_close($conn);
            throw new Exception($statement->error);
        }

        $result = $statement->get_result();

        if ($result->num_rows === 0) {
            mysqli_free_result($result);
            mysqli_close($conn);
            return false;
        } else {
            return true;
        }
    }

    function completeUpdate($raspberry_pi_id, $update_id) {

        $raspberry_pi = raspberry_pi::loadWithId($raspberry_pi_id);
        $update = update::loadWithId($update_id);

        $conn = getConnection();
        $statement = $conn->prepare("INSERT INTO update_completed WHERE update_id = ? AND raspberry_pi_id = ?");
        $statement->bind_param("ii", $update->getUpdateId(), $raspberry_pi->getRaspberryPiId());

        if (!$statement->execute()) {
            mysqli_close($conn);
            throw new Exception($statement->error);
        }

        $statement->close();
        mysqli_close($conn);
    }