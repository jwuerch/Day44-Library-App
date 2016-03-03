<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Book.php";
    require_once "src/Author.php";
    require_once "src/Copy.php";

    $server = 'mysql:host=localhost;dbname=library_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class BookTest extends PHPUnit_Framework_TestCase {

        protected function teardown() {
            Book::deleteAll();
            Author::deleteAll();
        }

        function testGetTitle() {
            //Arrange;
            $title = 'Ishmael';
            $genre = 'Sci-Fi';
            $test_book = new Book($title, $genre);

            //Act;
            $result = $test_book->getTitle();

            //Assert;
            $this->assertEquals($title, $result);
        }

        function testGetGenre() {
            //Arrange;
            $title = 'Ishmael';
            $genre = 'Sci-Fi';
            $test_book = new Book($title, $genre);

            //Act;
            $result = $test_book->getGenre();

            //Assert;
            $this->assertEquals($genre, $result);
        }

        function testGetId() {
            //Arrange;
            $title = 'Ishmael';
            $genre = 'Sci-Fi';
            $id = 1;
            $test_book = new Book($title, $genre, $id);

            //Act;
            $result = $test_book->getId();

            //Assert;
            $this->assertEquals($id, $result);
        }

        function testSave() {
            //Arrange;
            $title = 'Ishmael';
            $genre = 'Sci-Fi';
            $id = 1;
            $test_book = new Book($title, $genre, $id);

            //Act;
            $test_book->save();
            $result = Book::getAll();

            //Assert;
            $this->assertEquals($test_book, $result[0]);
        }

        function testGetAll() {
            //Arrange;
            $title = 'Ishmael';
            $genre = 'Sci-Fi';
            $test_book = new Book($title, $genre);
            $test_book->save();

            $title2 = 'The Chrysalids';
            $genre2 = 'Sci-Fi';
            $test_book2 = new Book($title2, $genre2);
            $test_book2->save();

            //Act;
            $result = Book::getAll();

            //Assert;
            $this->assertEquals([$test_book, $test_book2], $result);
        }

        function testDeleteAll() {
            //Arrange;
            $title = 'Ishmael';
            $genre = 'Sci-Fi';
            $id = 1;
            $test_book = new Book($title, $genre, $id);
            $test_book->save();

            $title2 = 'The Chrysalids';
            $genre2 = 'Sci-Fi';
            $id2 = 3;
            $test_book2 = new Book($title2, $genre2, $id2);
            $test_book2->save();

            //Act;
            Book::deleteAll();
            $result = Book::getAll();

            //Assert;
            $this->assertEquals([], $result);
        }

        function testFind() {
            //Arrange;
            $title = 'Ishmael';
            $genre = 'Sci-Fi';
            $id = 1;
            $test_book = new Book($title, $genre, $id);
            $test_book->save();

            $title2 = 'The Chrysalids';
            $genre2 = 'Sci-Fi';
            $id2 = 3;
            $test_book2 = new Book($title2, $genre2, $id2);
            $test_book2->save();

            //Act;
            $result = Book::find($test_book2->getId());

            //Assert;
            $this->assertEquals($test_book2, $result);
        }

        function testAddAuthor() {
            //Arrange;
            $title = 'Ishmael';
            $genre = 'Sci-Fi';
            $copy_id = 1;
            $id = 1;
            $test_book = new Book($title, $genre, $copy_id, $id);
            $test_book->save();

            $first_name = 'Daniel';
            $last_name = 'Quinn';
            $id = 2;
            $test_author = new Author($first_name, $last_name, $id);
            $test_author->save();

            $first_name2 = 'John';
            $last_name2 = 'Doe';
            $id2 = 3;
            $test_author2 = new Author($first_name2, $last_name2, $id2);
            $test_author2->save();

            //Act;
            $test_book->addAuthor($test_author);
            $test_book->addAuthor($test_author2);
            $result = $test_book->getAuthors();

            //Assert;
            $this->assertEquals([$test_author, $test_author2], $result);
        }

        function testGetAuthors() {
            //Arrange;
            $title = 'Ishmael';
            $genre = 'Sci-Fi';
            $id = 1;
            $test_book = new Book($title, $genre, $id);
            $test_book->save();

            $first_name = 'Daniel';
            $last_name = 'Quinn';
            $id = 2;
            $test_author = new Author($first_name, $last_name, $id);
            $test_author->save();

            $first_name2 = 'John';
            $last_name2 = 'Doe';
            $id2 = 3;
            $test_author2 = new Author($first_name2, $last_name2, $id2);
            $test_author2->save();

            //Act;
            $test_book->addAuthor($test_author);
            $result = $test_book->getAuthors();

            //Assert;
            $this->assertEquals([$test_author], $result);
        }

        function testUpdate() {
            //Arrange;

            $title = 'Ishmael';
            $genre = 'Sci-Fi';
            $id = 1;
            $test_book = new Book($title, $genre, $id);
            $test_book->save();

            //Act;
            $new_title = 'Donny';
            $new_genre =' ';
            $test_book->update($new_title, $new_genre);
            $result = [$test_book->getTitle(), $test_book->getGenre()];

            //Assert;
            $this->assertEquals(['Donny', ' '], $result);
        }

        function testDelete() {
            //Arrange;
            $title = 'Ishmael';
            $genre = 'Sci-Fi';
            $id = 1;
            $test_book = new Book($title, $genre, $id);
            $test_book->save();

            $title2 = 'The Chrysalids';
            $genre2 = 'Sci-Fi';
            $copy_id2 = 2;
            $id2 = 3;
            $test_book2 = new Book($title2, $genre2, $id2);
            $test_book2->save();

            //Act;
            $test_book->delete();
            $result = Book::getAll();

            //Assert;
            $this->assertEquals([$test_book2], $result);

        }

        function testGetNumOfCopies() {
            //Arrange;
            $title = 'Ishmael';
            $genre = 'Sci-Fi';
            $test_book = new Book($title, $genre);
            $test_book->save();

            $book_id = $test_book->getId();
            $available = 1;
            $due_date = '2016-03-03';
            $test_copy = new Copy($book_id, $available, $due_date);
            $test_copy->save();

            $book_id2 = $test_book->getId();
            $available2 = 1;
            $due_date2 = '2016-03-03';
            $test_copy2 = new Copy($book_id2, $available2, $due_date2);
            $test_copy2->save();

            //Act;
            $result = $test_book->getNumOfCopies();

            //Assert;
            $this->assertEquals(2, $result);
        }

        function testGetCopies() {
            //Arrange;
            $title = 'Ishmael';
            $genre = 'Sci-Fi';
            $test_book = new Book($title, $genre);
            $test_book->save();

            $book_id = $test_book->getId();
            $available = 1;
            $due_date = '2016-03-03';
            $test_copy = new Copy($book_id, $available, $due_date);
            $test_copy->save();

            $book_id2 = $test_book->getId();
            $available2 = 1;
            $due_date2 = '2016-03-03';
            $test_copy2 = new Copy($book_id2, $available2, $due_date2);
            $test_copy2->save();

            //Act;
            $result = $test_book->getCopies();

            //Assert;
            $this->assertEquals([$test_copy, $test_copy2], $result);
        }

    }


?>
