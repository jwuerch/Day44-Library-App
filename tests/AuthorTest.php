<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Author.php";

    $server = 'mysql:host=localhost;dbname=library_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class AuthorTest extends PHPUnit_Framework_TestCase {

        // protected function teardown() {
        //
        // }

        function testGetFirstName() {
            //Arrange;
            $first_name = 'Daniel';
            $last_name = 'Quinn';
            $test_author = new Author($first_name, $last_name);

            //Act;
            $result = $test_author->getFirstName();

            //Assert;
            $this->assertEquals($first_name, $result);
        }

        function testGetLastName() {
            //Arrange;
            $first_name = 'Daniel';
            $last_name = 'Quinn';
            $test_author = new Author($first_name, $last_name);

            //Act;
            $result = $test_author->getLastName();

            //Assert;
            $this->assertEquals($last_name, $result);
        }

        function testGetId() {
            //Arrange;
            $first_name = 'Daniel';
            $last_name = 'Quinn';
            $id = 1;
            $test_author = new Author($first_name, $last_name, $id);

            //Act;
            $result = $test_author->getId();

            //Assert;
            $this->assertEquals($id, $result);
        }
    }


 ?>
