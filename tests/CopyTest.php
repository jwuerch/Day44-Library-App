<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Copy.php";
    require_once "src/Book.php";

    $server = 'mysql:host=localhost;dbname=library_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class AuthorTest extends PHPUnit_Framework_TestCase {

        protected function teardown() {
            Book::deleteAll();
            Copy::deleteAll();
        }

        function testGetNumber() {
            //Arrange;
            $id = null;
            $number = 1;
            $test_book = new Copy($number, $id);

            //Act;
            $result = $test_book->getNumberOfCopies();
            //Assert;
            $this->assertEquals($number, $result);
        }

        function testGetId() {
            //Arrange;
            $id = null;
            $number = 1;
            $test_book = new Copy($number, $id);

            //Act;
            $result = $test_book->getId();

            //Assert;
            $this->assertEquals($id, $result);
        }

        function testGetAll() {
            //Arrange;
            $id = null;
            $number = 1;
            $test_book = new Copy($number, $id);
            $test_book->save();

            $id2 = null;
            $number2 = 2;
            $test_book2 = new Copy($number2, $id2);
            $test_book2->save();

            //Act;
            $result = Copy::getAll();

            //Assert;
            $this->assertEquals([$test_book, $test_book2], $result);
        }

        function testSave() {
            //Arrange;
            $id = null;
            $number = 1;
            $test_book = new Copy($number, $id);

            //Act;
            $test_book->save();
            $result = Copy::getAll();

            //Assert;
            $this->assertEquals($test_book, $result[0]);
        }

    }
