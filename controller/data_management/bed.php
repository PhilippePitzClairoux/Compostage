<?php

    include_once($_SERVER["DOCUMENT_ROOT"] . "/controller/ConnectionManager.php");
    //include_once($_SERVER["DOCUMENT_ROOT"] . "/Compostage/controller/ConnectionManager.php");

    class bed {

        private $bed_id;
        private $bed_name;

        private function __construct() {}

        public static function loadWithId($bed_id) {
            $instance = new self();

            $instance->setBedId($bed_id);
            $instance->fetch_data();

            return $instance;
        }

        public static function createNewBed($bed_name) {
            $instance = new self();

            $instance->setBedName($bed_name);
            $instance->insert_data();

            return $instance;
        }


        public function getBedId() {
            return $this->bed_id;
        }

        public function setBedId($bed_id): void {
            $this->bed_id = $bed_id;
        }

        public function getBedName() {
            return $this->bed_name;
        }

        public function setBedName($bed_name): void {
            $this->bed_name = $bed_name;
        }

        public function fetch_data() {

            $conn = getConnection();
            $statement = $conn->prepare("SELECT * FROM bed WHERE bed_id = ?");
            $statement->bind_param("i", $this->bed_id);

            if (!$statement->execute()) {
                mysqli_close($conn);
                throw new Exception($statement->error);
            }

            $result = $statement->get_result();

            if ($result->num_rows === 0) {
                mysqli_free_result($result);
                mysqli_close($conn);
                throw new Exception("Bed does not exist");
            }

            while ($row = $result->fetch_assoc()) {

                $this->setBedName($row["bed_name"]);
            }

            mysqli_free_result($result);
            mysqli_close($conn);
        }

        public function insert_data() {

            $conn = getConnection();
            $statement = $conn->prepare("INSERT INTO bed(bed_name) VALUES (?)");
            $statement->bind_param("s", $this->bed_name);

            if (!$statement->execute()) {
                mysqli_close($conn);
                throw new Exception($statement->error);
            }

            $statement->close();
            mysqli_close($conn);
        }


    }
