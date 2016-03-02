<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Book.php";

    $server = 'mysql:host=localhost;dbname=library_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class BookTest extends PHPUnit_Framework_TestCase {

        protected function teardown() {
            Book::deleteAll();
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

        function testGetNumOfCopies() {
            //Arrange;
            $title = 'Ishmael';
            $genre = 'Sci-Fi';
            $num_of_copies = 2;
            $test_book = new Book($title, $genre, $num_of_copies);

            //Act;
            $result = $test_book->getNumOfCopies();

            //Assert;
            $this->assertEquals($num_of_copies, $result);
        }

        function testGetId() {
            //Arrange;
            $title = 'Ishmael';
            $genre = 'Sci-Fi';
            $num_of_copies = 1;
            $id = 1;
            $test_book = new Book($title, $genre, $num_of_copies, $id);

            //Act;
            $result = $test_book->getId();

            //Assert;
            $this->assertEquals($id, $result);
        }

        function testSave() {
            //Arrange;
            $title = 'Ishmael';
            $genre = 'Sci-Fi';
            $num_of_copies = 1;
            $id = 1;
            $test_book = new Book($title, $genre, $num_of_copies, $id);

            //Act;
            $test_book->save();
            $result = Book::getAll();

            //Assert;
            $this->assertEquals([$test_book], $result);
        }
    }


?>
