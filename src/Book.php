<?php

    class Book {
        private $title;
        private $genre;
        private $num_of_copies;
        private $id;

        public function __construct($title, $genre, $num_of_copies = 1, $id = null) {
            $this->title = $title;
            $this->genre = $genre;
            $this->num_of_copies = $num_of_copies;
            $this->id = $id;
        }

        //Setters;
        public function setTitle($new_title) {
            $this->title = $new_title;
        }
        public function setGenre($new_genre) {
            $this->genre = $new_genre;
        }
        public function setNumOfCopies($new_num_of_copies) {
            $this->num_of_copies = $new_num_of_copies;
        }
        //Getters;
        public function getTitle() {
            return $this->title;
        }
        public function getGenre() {
            return $this->genre;
        }
        public function getNumOfCopies() {
            return $this->num_of_copies;
        }
        public function getId() {
            return $this->id;
        }
    }

?>
