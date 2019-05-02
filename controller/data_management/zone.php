<?php


    include_once($_SERVER["DOCUMENT_ROOT"] . "/controller/ConnectionManager.php");


    class zone {

        private $zone_id;
        private $zone_name;
        private $bed;

        private function __construct() {}

        public static function loadWithId($zone_id) {
            $instance = new self();

            $instance->setZoneId($zone_id);
            $instance->fetch_data();

            return $instance;
        }

        public function getZoneId() {
            return $this->zone_id;
        }

        public function setZoneId($zone_id): void {
            $this->zone_id = $zone_id;
        }

        public function getZoneName() {
            return $this->zone_name;
        }

        public function setZoneName($zone_name): void {
            $this->zone_name = $zone_name;
        }

        public function getBed() {
            return $this->bed;
        }

        public function setBed($bed): void {
            $this->bed = $bed;
        }

        public function fetch_data() {

            $conn = getConnection();
            $statement = $conn->prepare("SELECT * FROM zone WHERE zone_id = ?");
            $statement->bind_param("i", $this->zone_id);

            if (!$statement->execute()) {
                mysqli_close($conn);
                throw new Exception($statement->error);
            }

            $result = $statement->get_result();

            if ($result->num_rows === 0) {
                mysqli_free_result($result);
                mysqli_close($conn);
                throw new Exception("Zone does not exist");
            }

            while ($row = $result->fetch_assoc()) {

                $this->setZoneName($row["zone_name"]);
                $this->setBed(bed::loadWithId($row["bed_id"]));
            }

            mysqli_free_result($result);
            mysqli_close($conn);
        }

    }