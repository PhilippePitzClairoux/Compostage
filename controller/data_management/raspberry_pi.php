<!--********************************
    Fichier : raspberri_pi.php
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

    include_once("raspberry_pi_type.php");
    include_once("user.php");


    class raspberry_pi implements JsonSerializable {

        private $raspberry_pi_id;
        private $zone_id;
        private $raspberry_pi_type;
        private $raspberry_pi_aquisition_date;
        private $raspberry_pi_capacity;
        private $raspberry_pi_user;

        private function __construct() {}

        public static function loadWithId($raspberry_pi_id) {
            $instance = new self();

            $instance->setRaspberryPiId($raspberry_pi_id);
            $instance->fetch_data();

            return $instance;
        }

        public static function createNewRaspberryPi($raspberry_pi_type_id,
                                                    $raspberry_pi_user,
                                                    $raspberry_pi_zone_id,
                                                    $raspberry_pi_aquisition_date,
                                                    $raspberry_pi_capcity) {

            $instance = new self();

            $instance->setRaspberryPiType(raspberry_pi_type::loadWithId($raspberry_pi_type_id));
            $instance->setRaspberryPiUser(user::loadWithId($raspberry_pi_user));
            $instance->setZoneId($raspberry_pi_zone_id);
            $instance->setRaspberryPiAquisitionDate($raspberry_pi_aquisition_date);
            $instance->setRaspberryPiCapacity($raspberry_pi_capcity);

            $instance->insert_data();

            return $instance;
        }

        public function getRaspberryPiUser() {
            return $this->raspberry_pi_user;
        }

        public function setRaspberryPiUser($raspberry_pi_user): void {
            $this->raspberry_pi_user = $raspberry_pi_user;
        }

        public function getRaspberryPiId() {
            return $this->raspberry_pi_id;
        }

        public function setRaspberryPiId($raspberry_pi_id): void {
            $this->raspberry_pi_id = $raspberry_pi_id;
        }

        public function getZoneId() {
            return $this->zone_id;
        }

        public function setZoneId($zone_id): void {
            $this->zone_id = $zone_id;
        }

        public function getRaspberryPiType() {
            return $this->raspberry_pi_type;
        }

        public function setRaspberryPiType($raspberry_pi_type): void {
            $this->raspberry_pi_type = $raspberry_pi_type;
        }

        public function getRaspberryPiAquisitionDate() {
            return $this->raspberry_pi_aquisition_date;
        }

        public function setRaspberryPiAquisitionDate($raspberry_pi_aquisition_date): void {
            $this->raspberry_pi_aquisition_date = $raspberry_pi_aquisition_date;
        }

        public function getRaspberryPiCapacity() {
            return $this->raspberry_pi_capacity;
        }

        public function setRaspberryPiCapacity($raspberry_pi_capacity): void {
            $this->raspberry_pi_capacity = $raspberry_pi_capacity;
        }

        public function fetch_data() {

            $conn = getConnection();
            $statement = $conn->prepare("SELECT * FROM raspberry_pi WHERE raspberry_pi_id = ?");
            $statement->bind_param("i", $this->raspberry_pi_id);

            if (!$statement->execute()) {
                mysqli_close($conn);
                throw new Exception($statement->error);
            }

            $result = $statement->get_result();

            if ($result->num_rows === 0) {
                mysqli_free_result($result);
                mysqli_close($conn);
                throw new Exception("Raspberry pi does not exist.");
            }

            while ($row = $result->fetch_assoc()) {

                $this->raspberry_pi_type = raspberry_pi_type::loadWithId($row["raspberry_pi_type"]);
                $this->raspberry_pi_user = user::loadWithId($row["user_id"]);
                $this->setRaspberryPiAquisitionDate($row["raspberry_pi_aquisition_date"]);
                $this->setRaspberryPiCapacity($row["raspberry_pi_capacity"]);
                $this->setZoneId($row["zone_id"]);

            }

            mysqli_free_result($result);
            mysqli_close($conn);
        }

        public function insert_data() {

            $conn = getConnection();
            $statement = $conn->prepare("INSERT INTO raspberry_pi(zone_id, user_id,
                                                raspberry_pi_type, raspberry_pi_aquisition_date,
                                                raspberry_pi_capacity) VALUES (?, ?, ?, ?, ?) ");

            $statement->bind_param("isssi", $this->zone_id,
                ($this->raspberry_pi_user)->getUsername(), ($this->raspberry_pi_type)->getRaspberryPiType(),
                     $this->raspberry_pi_aquisition_date, $this->raspberry_pi_capacity);

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

