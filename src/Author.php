<?php

    class Author {
        private $first_name;
        private $last_name;
        private $id;

        public function __construct($first_name, $last_name, $id = null) {
            $this->first_name = $first_name;
            $this->last_name = $last_name;
            $this->id = $id;
        }

        //Setters;
        public function setFirstName($new_first_name) {
            $this->first_name = $new_first_name;
        }
        public function setLastName($new_last_name) {
            $this->last_name = $new_last_name;
        }

        //Getters;
        public function getFirstName() {
            return $this->first_name;
        }
        public function getLastName() {
            return $this->last_name;
        }
        public function getId() {
            return $this->id;
        }
    }


 ?>
