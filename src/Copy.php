<?php
    Class Copy {
        private $number;
        private $id;

        public function __construct($number, $id) {
            $this->number = $number;
            $this->id = $id;
        }

        //Setters;
        public function setNumber($new_number, $id = null) {
            $this->number = $new_number;
            $this->id = $id;

        }

        //Getters;
        public function getNumber() {
            return $this->number;
        }

        public function getId() {
            return $this->id;
        }
    }

?>
