<?php
    Class Copy {
        private $book_id;
        private $available;
        private $due_date;
        private $id;

        public function __construct($book_id, $available = 1, $due_date = '3000-01-01', $id = null) { //1 is true;
            $this->id = $id;
            $this->available = $available;
            $this->due_date = $due_date;
            $this->book_id = $book_id;
        }

        //setters;
        public function setcopyId($book_id) {
            $this->book_id = $book_id;
        }

        public function setAvailable($available) {
            $this->available = $available;
        }

        public function setDueDate($due_date) {
            $this->due_date = $due_date;
        }

        //Getters;

        public function getId() {
            return $this->id;
        }

        public function getAvailable() {
            return $this->available;
        }

        public function getDueDate() {
            return $this->due_date;
        }

        public function getBookId() {
          return $this->book_id;
        }

        public function save() {
            $GLOBALS['DB']->exec("INSERT INTO copies (Book_id, available, due_date) VALUES ({$this->getBookId()}, {$this->getAvailable()}, '{$this->getDueDate()}');");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        static function getAll() {
            $returned_copies = $GLOBALS['DB']->query("SELECT * FROM copies");
            $copies = array();

            foreach ($returned_copies as $copy) {
                $book_id = $copy['book_id'];
                $id = $copy['id'];
                $due_date = $copy['due_date'];
                $available = $copy['available'];
                $new_copy = new Copy($book_id, $available, $due_date, $id);
                array_push($copies, $new_copy);
            }
            return $copies;
        }

        static function deleteAll() {
            $GLOBALS['DB']->exec("DELETE FROM copies");
        }

        public function checkoutBook() {
            $GLOBALS['DB']->exec("UPDATE copies SET available = 0 WHERE id = {$this->getId()};");
            $this->setAvailable(0);
        }

        public function returnBook() {
            $GLOBALS['DB']->exec("UPDATE copies SET available = 1 WHERE id = {$this->getId()};");
            $this->setAvailable(1);
        }

        public function addPatron($patron) {
            $GLOBALS['DB']->exec("INSERT INTO copies_patrons (copy_id, patron_id) VALUES ({$this->getId()}, {$patron->getId()});");
        }

        public function getPatrons() {
            $returned_patrons = $GLOBALS['DB']->query("SELECT patrons.* FROM copies
                 JOIN copies_patrons ON (copies.id = copies_patrons.copy_id)
                 JOIN patrons ON (copies_patrons.patron_id = patrons.id)
                 WHERE copies.id = {$this->getId()};");

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

        static function find($search_id) {
            $copies = Copy::getAll();
            $found_copy = null;
            foreach ($copies as $copy) {
                $id = $copy->getId();
                if ($search_id == $id) {
                    $found_copy = $copy;
                }
            }
            return $found_copy;
        }

        public function delete() {
            $GLOBALS['DB']->exec("DELETE FROM copies WHERE id = {$this->getId()};");
            $GLOBALS['DB']->exec("DELETE FROM copies_patrons WHERE copy_id = {$this->getId()};");
        }


        public function returnAvailabile() {
            if ($this->getAvailable() == 1) {
                return 'Yes';
            }
            else {
                return 'No';
            }
        }




    }

?>
