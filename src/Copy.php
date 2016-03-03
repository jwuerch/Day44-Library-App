<?php
    Class Copy {
        private $name;
        private $id;

        public function __construct($name, $id = null) {
            $this->id = $id;
            $this->name = $name;
        }

        //setters;
        public function setName($name) {
            $this->name = $name;
        }

        //Getters;

        public function getName() {
            return $this->name;
        }

        public function getId() {
            return $this->id;
        }

        public function save() {
            $GLOBALS['DB']->exec("INSERT INTO copies (name) VALUES ('{$this->getName()}');");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        static function getAll() {
            $returned_copies = $GLOBALS['DB']->query("SELECT * FROM copies;");
            $copies = array();
            foreach ($copies as $copy) {
                $id = $copy['id'];
                $name = $copy['name'];
                $new_copy = new Copy($name, $id);
                array_push($copies, $new_copy);
            }
            return $copies;
        }

        static function deleteAll() {
            $GLOBALS['DB']->exec("DELETE FROM copies");
        }

    }

?>
