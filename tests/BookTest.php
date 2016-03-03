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
            Copy::deleteAll();
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

        function testGetCopyId() {
            //Arrange;
            $number = 2;
            $id = 1;
            $test_copy = new Copy($number, $id);

            $title = 'Ishmael';
            $genre = 'Sci-Fi';
            $copy_id = $test_copy->getId();
            $test_book = new Book($title, $genre, $copy_id);

            //Act;
            $result = $test_book->getCopyId();

            //Assert;
            $this->assertEquals($copy_id, $result);
        }

        function testGetId() {
            //Arrange;
            $title = 'Ishmael';
            $genre = 'Sci-Fi';
            $copy_id = 1;
            $id = 1;
            $test_book = new Book($title, $genre, $copy_id, $id);

            //Act;
            $result = $test_book->getId();

            //Assert;
            $this->assertEquals($id, $result);
        }

        function testSave() {
            //Arrange;
            $copy_id = null;
            $copy = new Copy($copy_id);
            $title = 'Ishmael';
            $genre = 'Sci-Fi';
            $copy_id = 2;
            $id = 1;
            $test_book = new Book($title, $genre, $copy_id, $id);

            //Act;
            $test_book->save();
            $result = Book::getAll();

            //Assert;
            $this->assertEquals($test_book, $result[0]);
        }

        function testGetAll() {
            //Arrange;
            $copy = new Copy();
            $title = 'Ishmael';
            $genre = 'Sci-Fi';
            $copy_id = 2;
            $test_book = new Book($title, $genre, $copy_id);
            $test_book->save();

            $title2 = 'The Chrysalids';
            $genre2 = 'Sci-Fi';
            $copy_id2
            $test_book2 = new Book($title2, $genre2, $copy_id2);
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
            $copy_id = 1;
            $id = 1;
            $test_book = new Book($title, $genre, $copy_id, $id);
            $test_book->save();

            $title2 = 'The Chrysalids';
            $genre2 = 'Sci-Fi';
            $copy_id2 = 2;
            $id2 = 3;
            $test_book2 = new Book($title2, $genre2, $copy_id2, $id2);
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
            $copy_id = 1;
            $id = 1;
            $test_book = new Book($title, $genre, $copy_id, $id);
            $test_book->save();

            $title2 = 'The Chrysalids';
            $genre2 = 'Sci-Fi';
            $copy_id2 = 2;
            $id2 = 3;
            $test_book2 = new Book($title2, $genre2, $copy_id2, $id2);
            $test_book2->save();

            //Act;
            $result = Book::find($test_book2->getId());

            //Assert;
            $this->assertEquals($test_book2, $result);
        }

        function testSearchByTitle() {
            //Arrange;
            $id = null;
            $copy = new Copy($id);
            $title = 'Ishmael2';
            $genre = 'Sci-Fi';
            $copy_id = $copy->getId();
            $test_book = new Book($title, $genre, $copy_id, $id);
            $test_book->save();

            $title2 = 'The Chrysalids';
            $genre2 = 'Sci-Fi';
            $test_book2 = new Book($title, $genre, $copy_id, $id);
            $test_book2->save();

            $title3 = 'Chrysalids';
            $genre3 = 'Sci-Fi';
            $test_book3 = new Book($title, $genre, $copy_id, $id);
            $test_book3->save();

            //Act;
            $search_term = 'Chrysalids';
            $result = Book::searchByTitle($search_term);

            //Assert;
            $this->assertEquals([$test_book2, $test_book3], $result);
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
            $result = $test_book->getAuthors();

            //Assert;
            $this->assertEquals([$test_author], $result);
        }

        function testUpdate() {
            //Arrange;

            $number = 3;
            $copy = new Copy($number);
            $title = 'Ishmael';
            $genre = 'Sci-Fi';
            $copy_id = $copy->getId();
            $id = 1;
            $test_book = new Book($title, $genre, $copy_id, $id);
            $test_book->save();

            //Act;
            $new_title = '';
            $new_genre =' ';
            $test_book->update($new_title, $new_genre);
            $result = [$test_book->getTitle(), $test_book->getGenre()];

            //Assert;
            $this->assertEquals(['Ishmael', 'Sci-Fi'], $result);
        }

        function testDelete() {
            //Arrange;
            $title = 'Ishmael';
            $genre = 'Sci-Fi';
            $copy_id = 1;
            $id = 1;
            $test_book = new Book($title, $genre, $copy_id, $id);
            $test_book->save();

            $title2 = 'The Chrysalids';
            $genre2 = 'Sci-Fi';
            $copy_id2 = 2;
            $id2 = 3;
            $test_book2 = new Book($title2, $genre2, $copy_id2, $id2);
            $test_book2->save();

            //Act;
            $test_book->delete();
            $result = Book::getAll();

            //Assert;
            $this->assertEquals([$test_book2], $result);

        }
    }


?>
