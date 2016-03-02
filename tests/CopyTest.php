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

        // protected function teardown() {
        //     Author::deleteAll();
        //     Book::deleteAll();
        //     Copy::deleteAll();
        // }

        public function testGetNumber() {
            //Arrange;
            $number = 1;
            $id = 1;
            $test_book = new Copy($number, $id);

            //Act;
            $result = $test_book->getNumber();
            //Assert;
            $this->assertEquals($number, $result);
        }

    }
