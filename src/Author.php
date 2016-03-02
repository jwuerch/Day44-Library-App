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

        public function save() {
            $GLOBALS['DB']->exec("INSERT INTO authors (first_name, last_name) VALUES ('{$this->getFirstName()}', '{$this->getLastName()}');");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        static function getAll() {
            $returned_authors = $GLOBALS['DB']->query("SELECT * FROM authors");
            $authors = array();
            foreach ($returned_authors as $author) {
                $first_name = $author['first_name'];
                $last_name = $author['last_name'];
                $id = $author['id'];
                $new_author = new Author($first_name, $last_name, $id);
                array_push($authors, $new_author);
            }
            return $authors;
        }

        static function deleteAll() {
            $GLOBALS['DB']->exec("DELETE FROM authors");
        }

        static function find($search_id) {
            $authors = Author::getAll();
            $found_author = null;
            foreach ($authors as $author) {
                $id = $author->getId();
                if ($search_id = $id) {
                    $found_author = $author;
                }
            }
            return $found_author;
        }
    }


 ?>
