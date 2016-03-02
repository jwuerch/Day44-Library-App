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

        public function save() {
            $GLOBALS['DB']->exec("INSERT INTO books (title, genre, num_of_copies) VALUES ('{$this->getTitle()}', '{$this->getGenre()}', {$this->getNumOfCopies()});");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        static function deleteAll() {
            $GLOBALS['DB']->exec("DELETE FROM books");
        }

        static function getAll() {
            $returned_books = $GLOBALS['DB']->query("SELECT * FROM books");
            $books = array();

            foreach ($returned_books as $book) {
                $title = $book['title'];
                $genre = $book['genre'];
                $num_of_copies = $book['num_of_copies'];
                $id = $book['id'];
                $new_book = new Book($title, $genre, $num_of_copies, $id);
                array_push($books, $new_book);
            }
            return $books;
        }

        static function find($search_id) {
            $books = Book::getAll();
            $found_book = null;
            foreach ($books as $book) {
                $id = $book->getId();
                if ($search_id == $id) {
                    $found_book = $book;
                }
            }
            return $found_book;
        }

    }

?>
