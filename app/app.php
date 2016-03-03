<?php
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Author.php";
    require_once __DIR__."/../src/Patron.php";
    require_once __DIR__."/../src/Copy.php";
    require_once __DIR__."/../src/Book.php";

    $app = new Silex\Application();
    $server = 'mysql:host=localhost;dbname=library';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);
    use Symfony\Component\HttpFoundation\Request;
    Request::enableHttpMethodParameterOverride();

    $app->register(new Silex\Provider\TwigServiceProvider(), array('twig.path'=>__DIR__."/../views"));

    $app->get("/", function() use ($app) {
        return $app['twig']->render('index.html.twig');
    });

    $app->get("/books", function() use ($app) {
        $copies = Copy::getAll();
        $copies_count = count($copies);
        return $app['twig']->render('books.html.twig', array('all_books' => Book::getAll(), 'copies' => $copies_count));
    });

    $app->get("/search_books", function() use ($app) {
        $result = Book::searchByTitle($_GET['search_term']);
        return $app['twig']->render('books.html.twig', array('all_books' => Book::getAll(), 'results' => $result));
    });

    $app->get("/book/{id}", function($id) use ($app) {
        $book = Book::find($id);
        $copies = $book->getCopies();
        return $app['twig']->render('book.html.twig', array('book' => $book, 'copies' => $copies));
    });

    $app->post("/add_book", function() use ($app) {
        $title = $_POST['title'];
        $genre = $_POST['genre'];
        $new_book = new Book($title, $genre);
        $new_book->save();
        return $app['twig']->render('books.html.twig', array('all_books' => Book::getAll()));
    });

    $app->post("/add_copy", function() use ($app) {
        $book = Book::find($_POST['book_id']);
        $book_id = $book->getId();
        $new_copy = new Copy($book_id);
        $new_copy->save();
        $copies = $book->getCopies();
        return $app['twig']->render('book.html.twig', array('book' => $book, 'copies' => $copies));
    });

    $app->post("/add_book", function() use ($app) {
        $title = $_POST['title'];
        $genre = $_POST['genre'];
        $copies = $_POST['copies'];
        $new_book = new Book($title, $genre, $copies);
        $new_book->save();
        return $app['twig']->render('books.html.twig', array('books' => Book::getAll()));
    });

    $app->post("/delete_all_books", function() use ($app) {
        Book::deleteAll();
        return $app['twig']->render('books.html.twig', array('books' => Book::getAll()));
    });

    $app->post("/add_copy", function() use ($app) {
        $book = Book::find($_POST['book_id']);
        return $app['twig']->render('book.html.twig', array('book' => $book));
    });

    $app->post("/delete_copy", function() use ($app) {
        $book = Book::find($_POST['book_id']);
        return $app['twig']->render('book.html.twig', array('book' => $book));
    });

    $app->patch("/update_book/{id}", function($id) use ($app) {
        $book = Book::find($id);
        $new_title = $_POST['new_title'];
        $new_genre = $_POST['new_genre'];
        $new_number_of_copies = $_POST['new_number_of_copies'];
        $book->update($new_title, $new_genre, $new_number_of_copies);
        return $app['twig']->render('book.html.twig', array('book' => $book));
    });

    $app->delete("/delete_book", function() use ($app) {
        $book = Book::find($_POST['book_id']);
        $book->delete();
        return $app['twig']->render('books.html.twig', array('books' => Book::getAll()));
    });


    return $app;
 ?>
