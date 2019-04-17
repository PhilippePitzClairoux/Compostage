<?php

    include_once("../ConnectionManager.php");
    include_once("measurement_type.php");

    class measurement {

        private $measurement_id;
        private $measurement_type;
        private $measurement_value;
        private $measurement_date;

        function __construct($measurement_id) {

            $this->measurement_id = $measurement_id;
        }

        public function getMeasurementId() {
            return $this->measurement_id;
        }

        public function setMeasurementId($measurement_id) {
            if (!is_null($measurement_id))
                $this->measurement_id = $measurement_id;
        }

        public function getMeasurementType() {
            return $this->measurement_type;
        }

        public function setMeasurementType($measurement_type) {
            if (!is_null($measurement_type))
                $this->measurement_type = $measurement_type;
        }

        public function getMeasurementValue() {
            return $this->measurement_value;
        }

        public function setMeasurementValue($measurement_value) {
            if (!is_null($measurement_value))
            $this->measurement_value = $measurement_value;
        }


        public function getMeasurementDate() {
            return $this->measurement_date;
        }


        public function setMeasurementDate($measurement_date) {
            if (!is_null($measurement_date))
                $this->measurement_date = $measurement_date;
        }
        
    }