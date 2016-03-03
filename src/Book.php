<?php

    class Book {
        private $title;
        private $genre;
        private $copy_id;
        private $id;

        public function __construct($title, $genre, $copy_id = 1, $id = null) {
            $this->title = $title;
            $this->genre = $genre;
            $this->copy_id = $copy_id;
            $this->id = $id;
        }

        //Setters;
        public function setTitle($new_title) {
            $this->title = $new_title;
        }
        public function setGenre($new_genre) {
            $this->genre = $new_genre;
        }

        public function setCopyId($id) {
            $this->copy_id = $id;
        }
        //Getters;
        public function getTitle() {
            return $this->title;
        }
        public function getGenre() {
            return $this->genre;
        }
        public function getCopyId() {
            return $this->copy_id;
        }
        public function getId() {
            return $this->id;
        }

        public function save() {
            $GLOBALS['DB']->exec("INSERT INTO books (title, genre, copy_id) VALUES ('{$this->getTitle()}', '{$this->getGenre()}', {$this->getCopyId()});");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        static function deleteAll() {
            $GLOBALS['DB']->exec("DELETE FROM books");
        }

        static function getAll() {
            $returned_books = $GLOBALS['DB']->query("SELECT * FROM books ORDER BY title");
            $books = array();

            foreach ($returned_books as $book) {
                $title = $book['title'];
                $genre = $book['genre'];
                $copy_id = $book['copy_id'];
                $id = $book['id'];
                $new_book = new Book($title, $genre, $copy_id, $id);
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

        static function searchByTitle($search_term) {
            $books = Book::getAll();
            $found_books = array();
            foreach ($books as $book) {
                similar_text($search_term, $book->getTitle(), $percentage);
                if ($percentage > 35) {
                    array_push($found_books, $book);
                }
            }
            return $found_books;
        }

        public function addAuthor($author) {
            $GLOBALS['DB']->exec("INSERT INTO books_authors (book_id, author_id) VALUES ({$this->getId()}, {$author->getId()});");
        }

        public function getAuthors() {
            $returned_authors = $GLOBALS['DB']->query("SELECT authors.* FROM books
                 JOIN books_authors ON (books.id = books_authors.book_id)
                 JOIN authors ON (books_authors.author_id = authors.id)
                 WHERE books.id = {$this->getId()};");

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

        public function update($new_title, $new_genre) {
            if ($new_title == '' OR $new_genre == ' ') {
                $new_title = $this->getTitle();
            }
            if ($new_genre == '' OR $new_genre == ' ') {
                $new_genre = $this->getGenre();
            }
            $GLOBALS['DB']->exec("UPDATE books SET title = {$new_title}, genre = {$new_genre} WHERE id = {$this->getId()}");
            $this->setTitle($new_title);
            $this->setGenre($new_genre);
        }

        public function delete() {
            $GLOBALS['DB']->exec("DELETE FROM books WHERE id = {$this->getId()};");
            $GLOBALS['DB']->exec("DELETE FROM books_authors WHERE book_id = {$this->getId()};");
        }

    }

?>
