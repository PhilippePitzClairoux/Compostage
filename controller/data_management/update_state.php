
<?php

    include_once($_SERVER["DOCUMENT_ROOT"] . "/controller/ConnectionManager.php");

    class update_state implements JsonSerializable {

        private $update_state_id;
        private $update_state;
        private $update_state_description;

        private function __construct() {}

        public static function loadWithId($update_state_id) {
            $instance = new self();

            $instance->setUpdateStateId($update_state_id);
            $instance->fetch_data();

            return $instance;
        }

        public function getUpdateStateId() {
            return $this->update_state_id;
        }

        public function setUpdateStateId($update_state_id): void {
            $this->update_state_id = $update_state_id;
        }

        public function getUpdateState() {
            return $this->update_state;
        }

        public function setUpdateState($update_state): void {
            $this->update_state = $update_state;
        }

        public function getUpdateStateDescription() {
            return $this->update_state_description;
        }

        public function setUpdateStateDescription($update_state_description): void {
            $this->update_state_description = $update_state_description;
        }

        public function fetch_data() {

            $conn = getConnection();
            $statement = $conn->prepare("SELECT * FROM update_state WHERE update_state_id = ?");
            $statement->bind_param("i", $this->update_state_id);

            if (!$statement->execute()) {
                mysqli_close($conn);
                throw new Exception($statement->error);
            }

            $result = $statement->get_result();

            if ($result->num_rows === 0) {
                mysqli_free_result($result);
                mysqli_close($conn);
                throw new Exception("Update state does not exist.");
            }

            while ($row = $result->fetch_assoc()) {

                $this->setUpdateState($row["update_state"]);
                $this->setUpdateStateDescription($row["update_state_description"]);
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