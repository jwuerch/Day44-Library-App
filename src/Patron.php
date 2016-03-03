<?php

    class Patron {
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
            $GLOBALS['DB']->exec("INSERT INTO patrons (first_name, last_name) VALUES ('{$this->getFirstName()}', '{$this->getLastName()}');");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        static function getAll() {
            $returned_patrons = $GLOBALS['DB']->query("SELECT * FROM patrons");
            $patrons = array();
            foreach ($returned_patrons as $patron) {
                $first_name = $patron['first_name'];
                $last_name = $patron['last_name'];
                $id = $patron['id'];
                $new_patron = new Patron($first_name, $last_name, $id);
                array_push($patrons, $new_patron);
            }
            return $patrons;
        }

        static function deleteAll() {
            $GLOBALS['DB']->exec("DELETE FROM patrons");
        }

        static function find($search_id) {
            $patrons = Patron::getAll();
            $found_patron = null;
            foreach ($patrons as $patron) {
                $id = $patron->getId();
                if ($search_id = $id) {
                    $found_patron = $patron;
                }
            }
            return $found_patron;
        }

        static function searchByLastName($search_term) {
            $patrons = Patron::getAll();
            $found_patrons = array();
            foreach ($patrons as $patron) {
                similar_text($patron->getLastName(), $search_term, $percentage);
                if ($percentage > 35) {
                    array_push($found_patrons, $patron);
                }
            }
            return $found_patrons;
        }

        public function addCopy($copy) {
            $GLOBALS['DB']->exec("INSERT INTO copies_patrons (copy_id, patron_id) VALUES ({$copy->getId()}, {$this->getId()});");
        }

        public function getCopies() {
            $returned_copies = $GLOBALS['DB']->query("SELECT copies.* FROM patrons
            JOIN copies_patrons ON (patrons.id = copies_patrons.patron_id)
            JOIN copies ON (copies_patrons.copy_id = copies.id)
            WHERE patron_id = {$this->getId()};");
            $copies = array();
            foreach ($returned_copies as $copy) {
                $book_id = $copy['book_id'];
                $available = $copy['available'];
                $id = $copy['id'];
                $due_date = $copy['due_date'];
                $new_copy = new Copy($book_id, $available, $due_date, $id);
                array_push($copies, $new_copy);
            }
            return $copies;
        }

        public function update($new_first_name, $new_last_name) {
            if ($new_first_name == '' OR $new_first_name == ' ') {
                $new_first_name = $this->getFirstName();
            }
            if ($new_last_name == '' OR $new_last_name == ' ') {
                $new_last_name = $this->getLastName();
            }
            $GLOBALS['DB']->exec("UPDATE patrons SET first_name = '{$new_first_name}', last_name = '{$new_last_name}' WHERE id = {$this->getId()}");
            $this->setFirstName($new_first_name);
            $this->setLastName($new_last_name);
        }

        public function delete() {
            $GLOBALS['DB']->exec("DELETE FROM patrons WHERE id = {$this->getId()};");
            $GLOBALS['DB']->exec("DELETE FROM copies_patrons WHERE patron_id = {$this->getId()};");
        }

        static function searchByName($search_term) {
            $returned_patrons = Patron::getAll();
            $patrons = array();
            foreach ($returned_patrons as $patron) {
                similar_text($search_term, $patron, $percentage);
                if ($percentage > 35) {
                    array_push($patrons, $patron);
                }
            }
            return $patrons;
        }
    }


 ?>
