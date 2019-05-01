<?php

    include_once($_SERVER["DOCUMENT_ROOT"] . "/controller/ConnectionManager.php");

    class user_permissions
    {


        private $permission_name;
        private $permission_description;

        private function __construct(){}

        public static function loadWithId($permission_name) {
            $instance = new self();

            $instance->setPermissionName($permission_name);
            $instance->fetch_data();

            return $instance;
        }


        public function getPermissionName() {
            return $this->permission_name;
        }

        public function setPermissionName($permission_name) {
            if (!is_null($permission_name))
                $this->permission_name = $permission_name;
        }

        public function getPermissionDescription() {
            return $this->permission_description;
        }

        public function setPermissionDescription($permission_description) {
            if (!is_null($permission_description))
                $this->permission_description = $permission_description;
        }


        function fetch_data() {

            $conn = getConnection();

            $statement = $conn->prepare("SELECT permission_description FROM permissions WHERE permission_name = ?");
            $statement->bind_param("i", $this->permission_name);

            if (!$statement->execute()) {
                mysqli_close($conn);
                throw new Exception($statement->error);
            }

            $result = $statement->get_result();

            if ($result->num_rows === 0) {
                mysqli_free_result($result);
                mysqli_close($conn);
                throw new Exception("User permission does not exist");
            }

            while ($row = $result->fetch_assoc()) {

                $this->setPermissionDescription($row["permission_description"]);
            }

            mysqli_free_result($result);
            mysqli_close($conn);
        }

        function send_data() {

            $conn = getConnection();

            $statement = $conn->prepare("INSERT INTO permissions(permission_name, permission_description) VALUES (?, ?)");
            $statement->bind_param("ss", $this->getPermissionName(), $this->getPermissionDescription());

            if (!$statement->execute()) {
                mysqli_close($conn);
                throw new Exception($statement->error);
            }

            mysqli_close($conn);
        }

        function update_data() {

            $conn = getConnection();
            $statement = $conn->prepare("UPDATE permissions SET permission_description = ? WHERE permission_name = ?");
            $statement->bind_param("ss", $this->permission_description, $this->permission_name);

            if (!$statement->execute()) {
                mysqli_close($conn);
                throw new Exception($statement->error);
            }

            mysqli_close($conn);
        }

    }