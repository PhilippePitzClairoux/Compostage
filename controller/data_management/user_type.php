<!--********************************
    Fichier : user_type.php
    Auteur : Philippe Pitz Clairoux
    Fonctionnalité :
    Date : 2019-05-04

    Vérification :
    Date                Nom                 Approuvé
    ====================================================

    Historique de modifications :
    Date                Nom                 Description
    ======================================================

 ********************************/-->
<?php

    include("user_permissions.php");


    class user_type implements JsonSerializable {

        private $user_type_name;
        private $user_type_description;
        private $user_permissions;

        private function __construct() {}

        public static function loadWithId($user_type_name) {
            $instance = new self();

            $instance->setUserTypeName($user_type_name);
            $instance->fetch_data();

            return $instance;
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
                throw new Exception($statement->error);
            }

            $result = $statement->get_result();

            if ($result->num_rows === 0) {
                mysqli_free_result($result);
                mysqli_close($conn);
                throw new Exception("User type does not exist");
            }

            while ($row = $result->fetch_assoc()) {

                $this->setUserTypeDescription($row["user_type_description"]);
            }

            mysqli_free_result($result);
            $statement->close();

            $statement = $conn->prepare("SELECT permission FROM ta_users_permissions WHERE user_type = ?");
            $statement->bind_param("s", $this->user_type_name);

            if (!$statement->execute()) {
                mysqli_close($conn);
                throw new Exception($statement->error);
            }

            $result = $statement->get_result();
            $this->user_permissions = array();

            while ($row = $result->fetch_assoc()) {

                array_push($this->user_permissions, user_permissions::loadWithId($row["permission"]));
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
                throw new Exception($statement->error);
            }

            mysqli_close($conn);

            for($i = 0; $i < count($this->user_permissions); $i++) {

                ($this->user_permissions[$i])->update_data();
            }

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