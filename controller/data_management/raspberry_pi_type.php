<?php

    include_once("../ConnectionManager.php");

    class raspberry_pi_type {

        private $raspberry_pi_type;
        private $raspberry_pi_description;

        private function __construct() {}

        public static function loadWithId($raspberry_pi_type) {

            $instance = new self();

            $instance->setRaspberryPiType($raspberry_pi_type);
            $instance->fetch_data();

            return $instance;
        }

        public function getRaspberryPiType() {
            return $this->raspberry_pi_type;
        }

        public function setRaspberryPiType($raspberry_pi_type): void {
            $this->raspberry_pi_type = $raspberry_pi_type;
        }

        public function getRaspberryPiDescription() {
            return $this->raspberry_pi_description;
        }

        public function setRaspberryPiDescription($raspberry_pi_description): void {
            $this->raspberry_pi_description = $raspberry_pi_description;
        }

        public function fetch_data() {

            $conn = getConnection();
            $statement = $conn->prepare("SELECT * FROM raspberry_pi_type WHERE raspberry_pi_type = ?");
            $statement->bind_param("i", $this->raspberry_pi_type);

            if (!$statement->execute()) {
                mysqli_close($conn);
                throw new Exception($statement->error);
            }

            $result = $statement->get_result();

            if ($result->num_rows === 0)
                throw new Exception("Raspberry_pi_type does not exist.");

            while ($row = $result->fetch_assoc()) {

                $this->setRaspberryPiDescription($row["raspberry_pi_description"]);
            }

            mysqli_free_result($result);
            mysqli_close($conn);
        }
    }