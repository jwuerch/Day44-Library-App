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

        static function searchByLastName($search_term) {
            $authors = Author::getAll();
            $found_authors = array();
            foreach ($authors as $author) {
                similar_text($author->getLastName(), $search_term, $percentage);
                if ($percentage > 35) {
                    array_push($found_authors, $author);
                }
            }
            return $found_authors;
        }

        public function addBook($book) {
            $GLOBALS['DB']->exec("INSERT INTO books_authors (book_id, author_id) VALUES ({$book->getId()}, {$this->getId()});");
        }

        public function getBooks() {
            $returned_books = $GLOBALS['DB']->query("SELECT books.* FROM authors
            JOIN books_authors ON (authors.id = books_authors.author_id)
            JOIN books ON (books_authors.book_id = books.id)
            WHERE author_id = {$this->getId()};");
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
    }


 ?>
