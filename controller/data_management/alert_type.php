
<?php

    include_once($_SERVER["DOCUMENT_ROOT"] . "/controller/ConnectionManager.php");

    class alert_type implements JsonSerializable {


        private $alert_type_name;

        private function __construct(){}

        public static function loadWithId($alert_type_id) {

            $instance = new self();

            $instance->setAlertTypeName($alert_type_id);
            $instance->fetch_data();

            return $instance;
        }

        public function getAlertTypeName() {
            return $this->alert_type_name;
        }

        public function setAlertTypeName($alert_type_name): void {
            $this->alert_type_name = $alert_type_name;
        }

        public function fetch_data() {

            $conn = getConnection();

            $statement = $conn->prepare("SELECT * FROM alert_type WHERE alert_type = ?");
            $statement->bind_param("s", $this->alert_type_name);

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

                $this->setAlertTypeName($row["alert_type"]);
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