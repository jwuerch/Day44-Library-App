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
        return $app['twig']->render('books.html.twig', array('books' => Book::getAll()));
    });

    $app->get("/book/{id}", function($id) use ($app) {
        $book = Book::find($id);
        return $app['twig']->render('book.html.twig', array('books' => Book::getAll(), 'book' => $book));
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
