<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Copy.php";

    $server = 'mysql:host=localhost;dbname=library_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class CopyTest extends PHPUnit_Framework_TestCase {

        // protected function teardown() {
        //     Copy::deleteAll();
        // }

        function testGetId() {
            //Arrange;
            $id = 1;
            $name ='hi';
            $test_copy = new Copy($name, $id);

            //Act;
            $result = $test_copy->getId();

            //Assert;
            $this->assertEquals($id, $result);
        }

        function testGetName() {
            $name = 'hi';
            $id = 1;
            $test_copy = new Copy($name, $id);

            //Act;
            $result = $test_copy->getName();


            //Assert;
            $this->assertEquals($name, $result);
        }

        function testSave() {
            //Arrange;
            $name ='Name';
            $id = 1;
            $test_copy = new Copy($name, $id);

            //Act;
            $test_copy->save();
            $result = Copy::getAll();

            //Assert;
            $this->assertEquals($test_copy, $result[0]);
        }



    }
