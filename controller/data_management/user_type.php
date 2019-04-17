<?php

    include("user_permissions.php");


    class user_type {

        private $user_type_name;
        private $user_type_description;
        private $user_permissions;

        function __construct($user_type) {

            $this->setUserTypeName($user_type);
        }

        public function getUserTypeName() {
            return $this->user_type_name;
        }

        public function setUserTypeName($user_type_name) {
            if (!is_null($user_type_name))
                $this->user_type_name = $user_type_name;
        }

        public function getUserTypeDescription() {
            return $this->user_type_description;
        }

        public function setUserTypeDescription($user_type_description) {
            if (!is_null($user_type_description))
                $this->user_type_description = $user_type_description;
        }

        public function getPermissions() {
            return $this->user_permissions;
        }

        function fetch_data() {

            $conn = getConnection();

            $statement = $conn->prepare("SELECT user_type_description FROM user_type WHERE user_type_name = ?");
            $statement->bind_param("s", $this->user_type_name);

            if (!$statement->execute()) {
                mysqli_close($conn);
                die("Cannot fetch user_type_description...");
            }

            $result = $statement->get_result();

            while ($row = $result->fetch_assoc()) {

                $this->setUserTypeDescription($row["user_type_description"]);
            }

            mysqli_free_result($result);
            $statement->close();

            $statement = $conn->prepare("SELECT permission FROM ta_users_permissions WHERE user_type = ?");
            $statement->bind_param("s", $this->user_type_name);

            if (!$statement->execute()) {
                mysqli_close($conn);
                die("Cannot fetch permissions for specefic user_type...");
            }

            $result = $statement->get_result();
            $this->user_permissions = array();

            while ($row = $result->fetch_assoc()) {

                $index = array_push($this->user_permissions, new user_permissions($row["permission"])) - 1;
                $this->user_permissions[$index]->fetch_data();
            }

            mysqli_free_result($result);
            mysqli_close($conn);
        }

        function update_data() {

            $conn = getConnection();
            $statement = $conn->prepare("UPDATE user_type SET user_type_description = ? WHERE user_type_name = ?");
            $statement->bind_param("ss", $this->user_type_description, $this->user_type_name);

            if (!$statement->execute()) {
                mysqli_close($conn);
                die("Cannot update user_type");
            }

            mysqli_close($conn);

            for($i = 0; $i < count($this->user_permissions); $i++) {

                ($this->user_permissions[$i])->update_data();
            }

        }

    }