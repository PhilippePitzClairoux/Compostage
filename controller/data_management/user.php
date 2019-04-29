<?php

    include("user_type.php");

    class user
    {

        private $username;
        private $user_type;
        private $user_password;
        private $user_email;

        private function __construct() {}

        public static function loadWithId($username) {
            $instance = new self();

            $instance->setUsername($username);
            $instance->fetch_data();

            return $instance;
        }

        public function getUsername() {
            return $this->username;
        }

        public function setUsername($username) {
            if (!is_null($username))
                $this->username = $username;
        }

        public function getUserType() {
            return $this->user_type;
        }

        public function setUserType($user_type) {
            if (!is_null($user_type))
                $this->user_type = $user_type;
        }

        public function getUserPassword() {
            return $this->user_password;
        }

        public function setUserPassword($user_password) {
            if (!is_null($user_password))
                $this->user_password = $user_password;
        }

        public function getUserEmail() {
            return $this->user_email;
        }


        public function setUserEmail($user_email) {
            if (!is_null($user_email))
                $this->user_email = $user_email;
        }

        function fetch_data() {

            $conn = getConnection();

            $statement = $conn->prepare("SELECT * FROM users WHERE username = ?");
            $statement->bind_param("s", $this->username);

            if (!$statement->execute()) {
                mysqli_close($conn);
                throw new Exception($statement->error);
            }

            $result = $statement->get_result();

            if ($result->num_rows === 0) {
                mysqli_free_result($result);
                mysqli_close($conn);
                throw new Exception("User does not exist");
            }

            while ($row = $result->fetch_assoc()) {

                $this->setUserEmail($row["email"]);
                $this->setUserPassword($row["password"]);
                $this->setUserType(user_type::loadWithId($row["user_type_id"]));

                ($this->user_type)->fetch_data();
            }

            mysqli_free_result($result);
            mysqli_close($conn);
        }


        function validate_new_username($new_username) {

            $conn = getConnection();

            $statement = $conn->prepare("SELECT * FROM users WHERE username = ?");
            $statement->bind_param("s", $new_username);

            $statement->execute();

            if ($statement->get_result()["num_rows"] !== 0) {
                mysqli_close($conn);
                die("Name is already taken.");
            }

            $statement->close();
            $statement = $conn->prepare("UPDATE users SET username = ? WHERE username = ?");
            $statement->bind_param("ss", $new_usernamem, $this->username);

            if (!$statement->execute()) {
                mysqli_close($conn);
                throw new Exception($statement->error);
            }

            mysqli_close($conn);
        }

        function update_data() {

            $conn = getConnection();

            $statement = $conn->prepare("UPDATE users SET password = ?, email = ? WHERE username = ?");
            $statement->bind_param("sss", $this->user_password, $this->user_email, $this->username);

            if (!$statement->execute()) {
                mysqli_close($conn);
                throw new Exception($statement->error);
            }

            mysqli_close($conn);

            ($this->user_type)->update_data();

        }

        function insert_data() {

        }

    }