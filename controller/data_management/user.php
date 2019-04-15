<?php

    include("user_type.php");

    class user {

        private $username;
        private $user_type;
        private $user_password;
        private $user_email;

        function __construct($user) {

            $this->setUsername($user);
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
                die("Cannot get info from that user...");
            }

            $result = $statement->get_result();

            while($row = $result->fetch_assoc()) {

                $this->setUserEmail($row["email"]);
                $this->setUserPassword($row["password"]);
                $this->setUserType(new user_type($row["user_type_id"]));

                ($this->user_type)->fetch_data();
            }

            mysqli_free_result($result);
            mysqli_close($conn);
        }


    }

    function send_data() {



    }