<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Author.php";
    require_once "src/Book.php";

    $server = 'mysql:host=localhost;dbname=library_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class AuthorTest extends PHPUnit_Framework_TestCase {

        protected function teardown() {
            Author::deleteAll();
            Book::deleteAll();
        }

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

        function testSave() {
            //Arrange;
            $first_name = 'Daniel';
            $last_name = 'Quinn';
            $id = 1;
            $test_author = new Author($first_name, $last_name, $id);

            //Act;
            $test_author->save();
            $result = Author::getAll();

            //Assert;
            $this->assertEquals($test_author, $result[0]);
        }

        function testGetAll() {
            //Arrange;
            $first_name = 'Daniel';
            $last_name = 'Quinn';
            $id = 1;
            $test_author = new Author($first_name, $last_name, $id);
            $test_author->save();

            $first_name2 = 'Ernest';
            $last_name2 = 'Hemingway';
            $id2 = 2;
            $test_author2 = new Author($first_name2, $last_name2, $id2);
            $test_author2->save();

            //Act;
            $result = Author::getAll();

            //Assert;
            $this->assertEquals([$test_author, $test_author2], $result);

        }

        function testDeleteAll() {
            //Arrange;
            $first_name = 'Daniel';
            $last_name = 'Quinn';
            $id = 1;
            $test_author = new Author($first_name, $last_name, $id);
            $test_author->save();

            $first_name2 = 'Ernest';
            $last_name2 = 'Hemingway';
            $id2 = 2;
            $test_author2 = new Author($first_name2, $last_name2, $id2);
            $test_author2->save();

            //Act;
            Author::deleteAll();
            $result = Author::getAll();

            //Assert;
            $this->assertEquals([], $result);
        }

        function testFind() {
            //Arrange;
            $first_name = 'Daniel';
            $last_name = 'Quinn';
            $id = 1;
            $test_author = new Author($first_name, $last_name, $id);
            $test_author->save();

            $first_name2 = 'Ernest';
            $last_name2 = 'Hemingway';
            $id2 = 2;
            $test_author2 = new Author($first_name2, $last_name2, $id2);
            $test_author2->save();

            //Act;
            $result = Author::find($test_author2->getId());

            //Assert;
            $this->assertEquals($test_author2, $result);
        }

        function testSearchByLastName() {
            //Arrange;
            $first_name = 'Daniel';
            $last_name = 'Quinn';
            $id = 1;
            $test_author = new Author($first_name, $last_name, $id);
            $test_author->save();

            $first_name2 = 'Ernest';
            $last_name2 = 'Hemingway';
            $id2 = 2;
            $test_author2 = new Author($first_name2, $last_name2, $id2);
            $test_author2->save();

            $first_name3 = 'Ernest';
            $last_name3 = 'Hemingwayyy';
            $id3 = 2;
            $test_author3 = new Author($first_name3, $last_name3, $id3);
            $test_author3->save();

            //Act;
            $search_term = 'Hemingway2';
            $result = Author::searchByLastName($search_term);

            //Assert;
            $this->assertEquals([$test_author2, $test_author3], $result);
        }

        function testGetBooks() {
            //Arrange;
            $first_name = 'Daniel';
            $last_name = 'Quinn';
            $id = 1;
            $test_author = new Author($first_name, $last_name, $id);
            $test_author->save();

            $title = 'Ishmael';
            $genre = 'Sci-Fi';
            $test_book = new Book($title, $genre);
            $test_book->save();

            $title2 = 'Day of the Triffods';
            $genre2 = 'Sci-Fi';
            $test_book2 = new Book($title2, $genre2);
            $test_book2->save();

            //Act;
            $test_author->addBook($test_book);
            $test_author->addBook($test_book2);
            $result = $test_author->getBooks();

            //Assert;
            $this->assertEquals([$test_book, $test_book2], $result);
        }

        function testUpdate() {
            //Arrange;
            $first_name = 'Daniel';
            $last_name = 'Quinn';
            $id = 1;
            $test_author = new Author($first_name, $last_name, $id);
            $test_author->save();

            //Act;
            $new_first_name = 'Dan';
            $new_last_name = ' ';
            $test_author->update($new_first_name, $new_last_name);
            $result = [$test_author->getFirstName(), $test_author->getLastName()];

            //Assert;
            $this->assertEquals([$new_first_name, 'Quinn'], $result);
        }

        function testDelete() {
            //Arrange;
            $first_name = 'Daniel';
            $last_name = 'Quinn';
            $id = 1;
            $test_author = new Author($first_name, $last_name, $id);
            $test_author->save();

            $first_name2 = 'Ernest';
            $last_name2 = 'Hemingway';
            $id2 = 2;
            $test_author2 = new Author($first_name2, $last_name2, $id2);
            $test_author2->save();

            //Act;
            $test_author->delete();
            $result = Author::getAll();

            //Assert;
            $this->assertEquals([$test_author2], $result);
        }
    }


 ?>
