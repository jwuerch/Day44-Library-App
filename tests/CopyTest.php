<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Copy.php";
    require_once "src/Book.php";
    require_once "src/Patron.php";

    $server = 'mysql:host=localhost;dbname=library_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class CopyTest extends PHPUnit_Framework_TestCase {

        protected function teardown() {
            Copy::deleteAll();
            Patron::deleteAll();
            Book::deleteAll();
        }

        function testGetBookId() {
            //Arrange;
            $book_id = 1;
            $available = 1;
            $due_date = '2016-01-01';
            $test_copy = new Copy($book_id, $available, $due_date);

            //Act;
            $result = $test_copy->getBookId();

            //Assert;
            $this->assertEquals($book_id, $result);
        }
        function testGetId() {
          //Arrange;
          $title = 'Ishamel';
          $genre = 'Sci-Fi';
          $test_book = new Book($title, $genre);
          $book_id = $test_book->getId();
          $available = 1;
          $id = 1;
          $due_date = '2016-01-01';
          $test_copy = new Copy($book_id, $available, $due_date, $id);

          //Act;
          $result = $test_copy->getId();

          //Assert;
          $this->assertEquals($id, $result);
        }

        function testGetAvailable() {
            //Arrange;
            $title = 'Ishamel';
            $genre = 'Sci-Fi';
            $test_book = new Book($title, $genre);
            $book_id = $test_book->getId();
            $available = 1;
            $due_date = '2016-01-01';
            $test_copy = new Copy($book_id, $available, $due_date);

            //Act;
            $result = $test_copy->getAvailable();

            //Assert;
            $this->assertEquals(1, $result);
        }

        function testGetDueDate() {
            //Arrange;
            $title = 'Ishamel';
            $genre = 'Sci-Fi';
            $test_book = new Book($title, $genre);
            $test_book->save();
            $book_id = $test_book->getId();
            $available = 1;
            $due_date = '2016-01-01';
            $test_copy = new Copy($book_id, $available, $due_date);

            //Act;
            $result = $test_copy->getDueDate();

            //Assert;
            $this->assertEquals($due_date, $result);
        }


        function testSave() {
            //Arrange;
            $title = 'Ishamel';
            $genre = 'Sci-Fi';
            $test_book = new Book($title, $genre);
            $test_book->save();

            $book_id = $test_book->getId();
            $available = 1;
            $id = 1;
            $due_date = '2016-01-01';
            $test_copy = new Copy($book_id, $available, $due_date, $id);


            //Act;
            $test_copy->save();
            $result = Copy::getAll();

            //Assert;
            $this->assertEquals($test_copy, $result[0]);
        }

        function testGetAll() {
            //Arrange;
            $title = 'Ishamel';
            $genre = 'Sci-Fi';
            $test_book = new Book($title, $genre);
            $test_book->save();
            $book_id = $test_book->getId();
            $available = 1;
            $due_date = '2016-01-01';
            $test_copy = new Copy($book_id, $available, $due_date);
            $test_copy->save();

            $title2 = 'Ishamel';
            $genre2 = 'Sci-Fi';
            $test_book2 = new Book($title, $genre);
            $test_book2->save();
            $book_id2 = $test_book2->getId();
            $available2 = 2;
            $due_date2 = '2016-01-02';
            $test_copy2 = new Copy($book_id, $available, $due_date);
            $test_copy2->save();

            //Act;
            $result = Copy::getAll();

            //Assert;
            $this->assertEquals([$test_copy, $test_copy2], $result);
        }

        function testDeleteAll() {
            //Arrange;
            $book_id = 1;
            $available = 1;
            $id = 1;
            $due_date = '2016-01-01';
            $test_copy = new Copy($book_id, $available, $due_date, $id);


            $book_id2 = 2;
            $id2 = 2;
            $test_copy2 = new Copy($book_id2, $available, $due_date, $id2);
            $test_copy2->save();

            //Act;
            Copy::deleteAll();
            $result = Copy::getAll();

            //Act;
            $this->assertEquals([], $result);
        }

        function testCheckOutBook() {
            //Arrange;
            $title = 'Ishamel';
            $genre = 'Sci-Fi';
            $test_book = new Book($title, $genre);
            $test_book->save();

            $book_id = $test_book->getId();
            $available = 1;
            $due_date = '2016-01-01';
            $test_copy = new Copy($book_id, $available, $due_date);
            $test_copy->save();

            //Act;
            $result = $test_copy->checkoutBook();

            //Assert;
            $this->assertEquals(0, $result);
        }

        function testReturnBook() {
            //Arrange;
            $title = 'Ishamel';
            $genre = 'Sci-Fi';
            $test_book = new Book($title, $genre);
            $test_book->save();

            $book_id = $test_book->getId();
            $available = 1;
            $due_date = '2016-01-01';
            $test_copy = new Copy($book_id, $available, $due_date);
            $test_copy->save();

            //Act;
            $result = $test_copy->ReturnBook();

            //Assert;
            $this->assertEquals(0, $result);
        }

        function testAddPatron() {
            //Arrange;
            $title = 'Ishamel';
            $genre = 'Sci-Fi';
            $test_book = new Book($title, $genre);
            $test_book->save();

            $book_id = $test_book->getId();
            $available = 1;
            $due_date = '2016-01-01';
            $test_copy = new Copy($book_id, $available, $due_date);
            $test_copy->save();

            $title2 = 'Ishamel';
            $genre2 = 'Sci-Fi';
            $test_book2 = new Book($title2, $genre2);
            $test_book2->save();

            $book_id2 = $test_book2->getId();
            $available2 = 1;
            $due_date2 = '2016-01-01';
            $test_copy2 = new Copy($book_id2, $available2, $due_date2);
            $test_copy2->save();

            $first_name = 'John';
            $last_name = 'Doe';
            $test_patron = new Patron($first_name, $last_name);
            $test_patron->save();

            $first_name2 = 'Jason';
            $last_name2 = 'Wuerch';
            $test_patron2 = new Patron($first_name2, $last_name2);
            $test_patron2->save();


            //Act;
            $test_copy->addPatron($test_patron);
            $test_copy->addPatron($test_patron2);
            $result = $test_copy->getPatrons();
            //Assert;
            $this->assertEquals([$test_patron, $test_patron2], $result);
        }

        function testGetPatrons() {
            //Arrange;
            $title = 'Ishamel';
            $genre = 'Sci-Fi';
            $test_book = new Book($title, $genre);
            $test_book->save();

            $book_id = $test_book->getId();
            $available = 1;
            $due_date = '2016-01-01';
            $test_copy = new Copy($book_id, $available, $due_date);
            $test_copy->save();

            $first_name = 'Jason';
            $last_name = 'Wuerch';
            $test_patron = new Patron($first_name, $last_name);
            $test_patron->save();

            //Act;
            $test_copy->addPatron($test_patron);
            $result = $test_copy->getPatrons();

            //Assert;
            $this->assertEquals([$test_patron], $result);
        }

        function testFind() {
            //Arrange;
            $title = 'Ishamel';
            $genre = 'Sci-Fi';
            $test_book = new Book($title, $genre);
            $test_book->save();

            $book_id = $test_book->getId();
            $available = 1;
            $due_date = '2016-01-01';
            $test_copy = new Copy($book_id, $available, $due_date);
            $test_copy->save();

            $title2 = 'Ishamel';
            $genre2 = 'Sci-Fi';
            $test_book2 = new Book($title2, $genre2);
            $test_book2->save();

            $book_id2 = $test_book2->getId();
            $available2 = 1;
            $due_date2 = '2016-01-01';
            $test_copy2 = new Copy($book_id2, $available2, $due_date2);
            $test_copy2->save();

            //Act;
            $result = Copy::find($test_copy2->getId());

            //Assert;
            $this->assertEquals($test_copy2, $result);
        }

        function testDelete() {
            //Arrange;
            $book_id = 1;
            $test_book = new Copy($book_id);
            $test_book->save();

            //Arrange;
            $book_id2 = 2;
            $test_book2 = new Copy($book_id2);
            $test_book2->save();

            //Act;
            $test_book->delete();
            $result = Copy::getAll();

            //Assert;
            $this->assertEquals([$test_book2], $result);
        }





    }
