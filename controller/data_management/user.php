<?php

    include("user_type.php");

    class user
    {

        private $username;
        private $user_type;
        private $user_password;
        private $user_email;
        private $user_auth_question;
        private $user_auth_answer;

        private function __construct() {}

        public static function loadWithId($username) {
            $instance = new self();

            $instance->setUsername($username);
            $instance->fetch_data();

            return $instance;
        }

        public static function createNewUser($username,
                                             $user_type_id,
                                             $encrypted_password,
                                             $email,
                                             $auth_question,
                                             $auth_answer) {

            $instance = new self();

            $instance->setUsername($username);
            $instance->setUserType(user_type::loadWithId($user_type_id));
            $instance->setUserPassword($encrypted_password);
            $instance->setUserEmail($email);
            $instance->setUserAuthQuestion($auth_question);
            $instance->setUserAuthAnswer($auth_answer);

            $instance->insert_data();

            return $instance;
        }

        public function getUserAuthQuestion() {
            return $this->user_auth_question;
        }

        public function setUserAuthQuestion($user_auth_question): void {
            $this->user_auth_question = $user_auth_question;
        }

        public function getUserAuthAnswer() {
            return $this->user_auth_answer;
        }

        public function setUserAuthAnswer($user_auth_answer): void {
            $this->user_auth_answer = $user_auth_answer;
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
                $this->setUserAuthQuestion($row["auth_question"]);
                $this->setUserAuthAnswer($row["auth_answer"]);

                ($this->user_type)->fetch_data();
            }

            mysqli_free_result($result);
            mysqli_close($conn);
        }

        function validate_new_username($username) {

        }

        function validate_new_username_and_update_it($new_username) {

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

            $statement = $conn->prepare("UPDATE users SET password = ?, email = ?, auth_answer = ?, auth_question = ? WHERE username = ?");
            $statement->bind_param("sssss", $this->user_password, $this->user_email,
                $this->user_auth_answer, $this->user_auth_question, $this->username);

            if (!$statement->execute()) {
                mysqli_close($conn);
                throw new Exception($statement->error);
            }

            mysqli_close($conn);
        }

        function insert_data() {

            $this->validate_new_username_and_update_it($this->getUsername());


        }

    }