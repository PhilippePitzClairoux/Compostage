
<?php

    include_once($_SERVER["DOCUMENT_ROOT"] . "/controller/ConnectionManager.php");

    class bed implements JsonSerializable {


        private $bed_name;

        private function __construct() {}

        public static function loadWithId($bed_id) {
            $instance = new self();

            $instance->setBedName($bed_id);
            $instance->fetch_data();

            return $instance;
        }

        public static function createNewBed($bed_name) {
            $instance = new self();

            $instance->setBedName($bed_name);
            $instance->insert_data();

            return $instance;
        }

        public function getBedName() {
            return $this->bed_name;
        }

        public function setBedName($bed_name): void {
            $this->bed_name = $bed_name;
        }

        public function fetch_data() {

            $conn = getConnection();
            $statement = $conn->prepare("SELECT * FROM bed WHERE bed_name = ?");
            $statement->bind_param("i", $this->bed_name);

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
