<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Patron.php";
    require_once "src/Copy.php";
    require_once "src/Book.php";

    $server = 'mysql:host=localhost;dbname=library_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class PatronTest extends PHPUnit_Framework_TestCase {

        protected function teardown() {
            Patron::deleteAll();
            Copy::deleteAll();
        }

        function testGetFirstName() {
            //Arrange;
            $first_name = 'Daniel';
            $last_name = 'Quinn';
            $test_patron = new Patron($first_name, $last_name);

            //Act;
            $result = $test_patron->getFirstName();

            //Assert;
            $this->assertEquals($first_name, $result);
        }

        function testGetLastName() {
            //Arrange;
            $first_name = 'Daniel';
            $last_name = 'Quinn';
            $test_patron = new Patron($first_name, $last_name);

            //Act;
            $result = $test_patron->getLastName();

            //Assert;
            $this->assertEquals($last_name, $result);
        }

        function testGetId() {
            //Arrange;
            $first_name = 'Daniel';
            $last_name = 'Quinn';
            $id = 1;
            $test_patron = new Patron($first_name, $last_name, $id);

            //Act;
            $result = $test_patron->getId();

            //Assert;
            $this->assertEquals($id, $result);
        }

        function testSave() {
            //Arrange;
            $first_name = 'Daniel';
            $last_name = 'Quinn';
            $id = 1;
            $test_patron = new Patron($first_name, $last_name, $id);

            //Act;
            $test_patron->save();
            $result = Patron::getAll();

            //Assert;
            $this->assertEquals($test_patron, $result[0]);
        }

        function testGetAll() {
            //Arrange;
            $first_name = 'Daniel';
            $last_name = 'Quinn';
            $id = 1;
            $test_patron = new Patron($first_name, $last_name, $id);
            $test_patron->save();

            $first_name2 = 'Ernest';
            $last_name2 = 'Hemingway';
            $id2 = 2;
            $test_patron2 = new Patron($first_name2, $last_name2, $id2);
            $test_patron2->save();

            //Act;
            $result = Patron::getAll();

            //Assert;
            $this->assertEquals([$test_patron, $test_patron2], $result);

        }

        function testDeleteAll() {
            //Arrange;
            $first_name = 'Daniel';
            $last_name = 'Quinn';
            $id = 1;
            $test_patron = new Patron($first_name, $last_name, $id);
            $test_patron->save();

            $first_name2 = 'Ernest';
            $last_name2 = 'Hemingway';
            $id2 = 2;
            $test_patron2 = new Patron($first_name2, $last_name2, $id2);
            $test_patron2->save();

            //Act;
            Patron::deleteAll();
            $result = Patron::getAll();

            //Assert;
            $this->assertEquals([], $result);
        }

        function testFind() {
            //Arrange;
            $first_name = 'Daniel';
            $last_name = 'Quinn';
            $id = 1;
            $test_patron = new Patron($first_name, $last_name, $id);
            $test_patron->save();

            $first_name2 = 'Ernest';
            $last_name2 = 'Hemingway';
            $id2 = 2;
            $test_patron2 = new Patron($first_name2, $last_name2, $id2);
            $test_patron2->save();

            //Act;
            $result = Patron::find($test_patron2->getId());

            //Assert;
            $this->assertEquals($test_patron2, $result);
        }

        function testSearchByLastName() {
            //Arrange;
            $first_name = 'Daniel';
            $last_name = 'Quinn';
            $id = 1;
            $test_patron = new Patron($first_name, $last_name, $id);
            $test_patron->save();

            $first_name2 = 'Ernest';
            $last_name2 = 'Hemingway';
            $id2 = 2;
            $test_patron2 = new Patron($first_name2, $last_name2, $id2);
            $test_patron2->save();

            $first_name3 = 'Ernest';
            $last_name3 = 'Hemingwayyy';
            $id3 = 2;
            $test_patron3 = new Patron($first_name3, $last_name3, $id3);
            $test_patron3->save();

            //Act;
            $search_term = 'Hemingway2';
            $result = Patron::searchByLastName($search_term);

            //Assert;
            $this->assertEquals([$test_patron2, $test_patron3], $result);
        }

        function testAddCopy() {
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
            $test_patron->addCopy($test_copy);
            $result = $test_patron->getCopies();
            //Assert;
            $this->assertEquals([$test_copy], $result);
        }

        function testgetCopies() {
            //Arrange;
            $first_name = 'Daniel';
            $last_name = 'Quinn';
            $test_patron = new Patron($first_name, $last_name);
            $test_patron->save();

            $title = 'Ishmael';
            $genre = 'Sci-Fi';
            $test_book = new Book($title, $genre);
            $test_book->save();

            $book_id = $test_book->getId();
            $available = 1;
            $due_date = '2016-01-01';
            $test_copy = new Copy($book_id, $available, $due_date);
            $test_copy->save();

            $book_id2 = $test_book->getId();
            $available2 = 1;
            $due_date2 = '2016-01-01';
            $test_copy2 = new Copy($book_id2, $available2, $due_date2);
            $test_copy2->save();

            //Act;
            $test_patron->addcopy($test_copy);
            $test_patron->addcopy($test_copy2);
            $result = $test_patron->getcopies();

            //Assert;
            $this->assertEquals([$test_copy, $test_copy2], $result);
        }

        function testUpdate() {
            //Arrange;
            $first_name = 'Daniel';
            $last_name = 'Quinn';
            $id = 1;
            $test_patron = new Patron($first_name, $last_name, $id);
            $test_patron->save();

            //Act;
            $new_first_name = 'Dan';
            $new_last_name = ' ';
            $test_patron->update($new_first_name, $new_last_name);
            $result = [$test_patron->getFirstName(), $test_patron->getLastName()];

            //Assert;
            $this->assertEquals([$new_first_name, 'Quinn'], $result);
        }

        function testDelete() {
            //Arrange;
            $first_name = 'Daniel';
            $last_name = 'Quinn';
            $id = 1;
            $test_patron = new Patron($first_name, $last_name, $id);
            $test_patron->save();

            $first_name2 = 'Ernest';
            $last_name2 = 'Hemingway';
            $id2 = 2;
            $test_patron2 = new Patron($first_name2, $last_name2, $id2);
            $test_patron2->save();

            //Act;
            $test_patron->delete();
            $result = Patron::getAll();

            //Assert;
            $this->assertEquals([$test_patron2], $result);
        }

        function SearchByName() {
            //Arrange;
            $first_name = 'Daniel';
            $last_name = 'Quinn';
            $id = 1;
            $test_patron = new Patron($first_name, $last_name, $id);
            $test_patron->save();

            $first_name2 = 'Ernest';
            $last_name2 = 'Hemingway';
            $id2 = 2;
            $test_patron2 = new Patron($first_name2, $last_name2, $id2);
            $test_patron2->save();

            //Act;
            $search_term = 'Ernest';
            $result = Patron::searchByName($search_term);

            //Assert;
            $this->assertEquals([$test_patron2], $result);
        }
    }


 ?>
