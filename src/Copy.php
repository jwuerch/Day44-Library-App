<?php
    Class Copy {
        private $number;
        private $id;

        public function __construct($number_of_copies, $id) {
            $this->number_of_copies = $number_of_copies;
            $this->id = $id;
        }

        //Setters;
        public function setNumber($new_number, $id = null) {
            $this->number = $new_number;
            $this->id = $id;

        }

        //Getters;
        public function getNumberOfCopies() {
            return $this->number_of_copies;
        }

        public function getId() {
            return $this->id;
        }

        static function getAll() {
            $returned_copies = $GLOBALS['DB']->query("SELECT * FROM copies");
            $copies = array();

            foreach ($returned_copies as $copy) {
                $number_of_copies = $copy['number_of_copies'];
                $id = $copy['id'];
                $new_copy = new Copy($number_of_copies, $id);
                array_push($copies, $new_copy);
            }
            return $copies;
        }

        public function save() {
            $GLOBALS['DB']->exec("INSERT INTO copies (number_of_copies) VALUES ({$this->getNumberOfCopies()});");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        static function deleteAll() {
            $GLOBALS['DB']->exec("DELETE FROM copies");
        }
    }

?>
