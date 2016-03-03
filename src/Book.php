<?php

    class Book {
        private $title;
        private $genre;
        private $id;

        public function __construct($title, $genre, $id = null) {
            $this->title = $title;
            $this->genre = $genre;
            $this->id = $id;
        }

        //Setters;
        public function setTitle($new_title) {
            $this->title = $new_title;
        }
        public function setGenre($new_genre) {
            $this->genre = $new_genre;
        }

        //Getters;
        public function getTitle() {
            return $this->title;
        }
        public function getGenre() {
            return $this->genre;
        }
        public function getId() {
            return $this->id;
        }

        public function save() {
            $GLOBALS['DB']->exec("INSERT INTO books (title, genre) VALUES ('{$this->getTitle()}', '{$this->getGenre()}');");
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
                $id = $book['id'];
                $new_book = new Book($title, $genre, $id);
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
            // if ($new_title == '' || $new_genre == ' ') {
            //     $new_title = $this->getTitle();
            // }
            // if ($new_genre == '' || $new_genre == ' ') {
            //     $new_genre = $this->getGenre();
            // }
            $GLOBALS['DB']->exec("UPDATE books SET title = {$new_title}, genre = {$new_genre} WHERE id = {$this->getId()}");
            $this->setTitle($new_title);
            $this->setGenre($new_genre);
        }

        public function delete() {
            $GLOBALS['DB']->exec("DELETE FROM books WHERE id = {$this->getId()};");
            $GLOBALS['DB']->exec("DELETE FROM books_authors WHERE book_id = {$this->getId()};");
        }

        public function getNumOfCopies() {
            $returned_copies = $GLOBALS['DB']->query("SELECT * FROM copies WHERE book_id = {$this->getId()}");
            $copies = array();
            foreach ($returned_copies as $copy) {
                $id = $copy['id'];
                $book_id = $copy['book_id'];
                $available = $copy['available'];
                $due_date = $copy['due_date'];
                $new_copy = new Copy($book_id, $available, $due_date, $id);
                array_push($copies, $new_copy);
            }
            return count($copies);
        }

        public function getCopies() {
            $returned_copies = $GLOBALS['DB']->query("SELECT * FROM copies WHERE book_id = {$this->getId()};");
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

        static function searchByTitle($search_term) {
            $all_books = Book::getAll();
            $found_books = array();
            foreach ($all_books as $book) {
                similar_text($search_term, $book->getTitle(), $percentage);
                if ($percentage > 35) {
                    array_push($found_books, $book);
                }
            }
            return $found_books;
        }


    }

?>
