<?php

    include_once("../ConnectionManager.php");

    class user_permissions
    {


        private $permission_name;
        private $permission_description;

        function __construct($name) {

            $this->setPermissionName($name);
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

            $statement = $conn->prepare("SELECT permission_name, permission_description FROM permissions WHERE permission_name = ?");
            $statement->bind_param("i", $this->getPermissionId());

            if (!$statement->execute()) {
                $conn->close();
                $statement->close();
                die("Cannot fetch permission...");
            }

            $result = $statement->get_result();

            while ($row = $result->fetch_assoc()) {

                $this->setPermissionName($row["permission_name"]);
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
                die("Cannot create new permission");
            }

            mysqli_close($conn);
        }

    }