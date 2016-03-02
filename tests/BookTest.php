<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Book.php";
    require_once "src/Author.php";

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
            $this->assertEquals($test_book, $result[0]);
        }

        function testGetAll() {
            //Arrange;
            $title = 'Ishmael';
            $genre = 'Sci-Fi';
            $num_of_copies = 1;
            $id = 1;
            $test_book = new Book($title, $genre, $num_of_copies, $id);
            $test_book->save();

            $title2 = 'The Chrysalids';
            $genre2 = 'Sci-Fi';
            $num_of_copies2 = 2;
            $id2 = 3;
            $test_book2 = new Book($title2, $genre2, $num_of_copies2, $id2);
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
            $num_of_copies = 1;
            $id = 1;
            $test_book = new Book($title, $genre, $num_of_copies, $id);
            $test_book->save();

            $title2 = 'The Chrysalids';
            $genre2 = 'Sci-Fi';
            $num_of_copies2 = 2;
            $id2 = 3;
            $test_book2 = new Book($title2, $genre2, $num_of_copies2, $id2);
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
            $num_of_copies = 1;
            $id = 1;
            $test_book = new Book($title, $genre, $num_of_copies, $id);
            $test_book->save();

            $title2 = 'The Chrysalids';
            $genre2 = 'Sci-Fi';
            $num_of_copies2 = 2;
            $id2 = 3;
            $test_book2 = new Book($title2, $genre2, $num_of_copies2, $id2);
            $test_book2->save();

            //Act;
            $result = Book::find($test_book2->getId());

            //Assert;
            $this->assertEquals($test_book2, $result);
        }

        function testSearchByTitle() {
            //Arrange;
            $title = 'Ishmael2';
            $genre = 'Sci-Fi';
            $num_of_copies = 1;
            $id = 1;
            $test_book = new Book($title, $genre, $num_of_copies, $id);
            $test_book->save();

            $title2 = 'The Chrysalids';
            $genre2 = 'Sci-Fi';
            $num_of_copies2 = 2;
            $id2 = 3;
            $test_book2 = new Book($title2, $genre2, $num_of_copies2, $id2);
            $test_book2->save();

            $title3 = 'Chrysalids';
            $genre3 = 'Sci-Fi';
            $num_of_copies3 = 3;
            $id3 = 3;
            $test_book3 = new Book($title3, $genre3, $num_of_copies3, $id3);
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
            $num_of_copies = 1;
            $id = 1;
            $test_book = new Book($title, $genre, $num_of_copies, $id);
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
            $num_of_copies = 1;
            $id = 1;
            $test_book = new Book($title, $genre, $num_of_copies, $id);
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
            $num_of_copies = 1;
            $id = 1;
            $test_book = new Book($title, $genre, $num_of_copies, $id);
            $test_book->save();

            //Act;
            $new_title = '';
            $new_genre =' ';
            $new_num_of_copies = 2;
            $test_book->update($new_title, $new_genre, $new_num_of_copies);
            $result = [$test_book->getTitle(), $test_book->getGenre(), $test_book->getNumOfCopies()];

            //Assert;
            $this->assertEquals(['Ishmael', 'Sci-Fi', $new_num_of_copies], $result);
        }

        function testDelete() {
            //Arrange;
            $title = 'Ishmael';
            $genre = 'Sci-Fi';
            $num_of_copies = 1;
            $id = 1;
            $test_book = new Book($title, $genre, $num_of_copies, $id);
            $test_book->save();

            $title2 = 'The Chrysalids';
            $genre2 = 'Sci-Fi';
            $num_of_copies2 = 2;
            $id2 = 3;
            $test_book2 = new Book($title2, $genre2, $num_of_copies2, $id2);
            $test_book2->save();

            //Act;
            $test_book->delete();
            $result = Book::getAll();

            //Assert;
            $this->assertEquals([$test_book2], $result);

        }



?>
