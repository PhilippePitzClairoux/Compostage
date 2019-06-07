
<?php


    include_once($_SERVER["DOCUMENT_ROOT"] . "/controller/ConnectionManager.php");
    include_once($_SERVER["DOCUMENT_ROOT"] . "/controller/data_management/bed.php");



    class zone implements JsonSerializable {

        private $zone_id;
        private $zone_name;
        private $bed;

        private function __construct() {}


        public static function loadWithZoneAndBed($zone_name, $bed_name) {
            $instance = new self();

            $instance->setZoneName($zone_name);
            $instance->setBed(bed::loadWithId($bed_name));
            $instance->fetch_data_with_bed();

            return $instance;
        }

        public static function loadWithId($zone_id) {
            $instance = new self();

            $instance->setZoneId($zone_id);
            $instance->fetch_data();

            return $instance;
        }

        public static function createNewZone($zone_name, $bed_id) {
            $instance = new self();

            $instance->setBed(bed::loadWithId($bed_id));
            $instance->setZoneName($zone_name);
            $instance->insert_data();

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

        public function fetch_data_with_bed() {

            $conn = getConnection();
            $statement = $conn->prepare("SELECT zone_id FROM zone WHERE zone_name = ? AND bed_id =?");
            $statement->bind_param("ss", $this->zone_name, ($this->bed)->getBedName());

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

                $this->setZoneId($row["zone_id"]);
            }

            mysqli_free_result($result);
            mysqli_close($conn);
        }

        public function insert_data() {

            $conn = getConnection();
            $statement = $conn->prepare("INSERT INTO zone(bed_id, zone_name) VALUES (?, ?)");
            $statement->bind_param("ss", ($this->getBed())->getBedName(), $this->zone_name);

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
