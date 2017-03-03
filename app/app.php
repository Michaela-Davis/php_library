<?php
    date_default_timezone_set('America/Los_Angeles');

    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Author.php";
    require_once __DIR__."/../src/Book.php";
    require_once __DIR__."/../src/Patron.php";

    $app = new Silex\Application();

    $app['debug']=true;

    $server = 'mysql:host=localhost:8889;dbname=library';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    // for postgres
    // $dbopts = parse_url(getenv('DATABASE_URL'));
    // $app->register(new Herrera\Pdo\PdoServiceProvider(),
    // array(
    //   'pdo.dsn' => 'pgsql:dbname='.ltrim($dbopts["path"],'/').';host='.$dbopts["host"] . ';port=' . $dbopts["port"],
    //   'pdo.username' => $dbopts["user"],
    //   'pdo.password' => $dbopts["pass"]
    //   )
    // );
    // $DB = $app['pdo'];

    use Symfony\Component\HttpFoundation\Request;
    Request::enableHttpMethodParameterOverride();

    $app->register(new Silex\Provider\TwigServiceProvider(), array(
        'twig.path' => __DIR__.'/../web/views'
    ));

    $app->get("/", function() use ($app) {
        return $app['twig']->render('homeView.html.twig');
    });

    $app->get("/books", function() use ($app) {
        return $app['twig']->render('books.html.twig', array('books'=>Book::getall(), "authors"=>Author::getAll()));
    });

    $app->post("/books", function() use ($app) {
        $new_book = new Book($_POST['inputTitle'], $_POST['inputGenre'], $_POST['inputISBN'], $_POST['inputTotal'], $_POST['inputAvailable'], $_POST['inputCheckedOut']);
        $new_book->save();
        $author = Author::find($_POST['inputAuthor']);
        $author->addBook($new_book);
        return $app['twig']->render('books.html.twig', array('books'=>Book::getall(), "authors"=>Author::getAll()));
    });

    $app->get("/books/{id}", function($id) use ($app) {
        $new_book = Book::find($id);
        return $app['twig']->render('book.html.twig', array('book'=>$new_book));
    });

    $app->delete("/delete-book/{id}", function($id) use ($app) {
        $book = Book::find($id);
        $book->delete();
        return $app->redirect("/books");
    });

    $app->patch("/add-copies/{id}", function($id) use ($app) {
        $book = Book::find($id);
        $book->update($_POST['inputTotal']);
        return $app->redirect("/books/$id");
    });

    $app->get("/authors", function() use ($app) {
        return $app['twig']->render('authors.html.twig', array('authors'=>Author::getall()));
    });

    $app->get("/authors/{id}", function($id) use ($app) {
        $new_author = Author::find($id);
        return $app['twig']->render('author.html.twig', array('author'=>$new_author));
    });

    $app->post("/authors", function() use ($app) {
        $new_book = new Author($_POST['inputFirstName'], $_POST['inputLastName']);
        $new_book->save();
        return $app->redirect("/authors");
    });

    $app->delete("/delete-author/{id}", function($id) use ($app) {
        $author = Author::find($id);
        $author->delete();
        return $app->redirect("/authors");
    });

    $app->get("/patrons", function() use ($app) {
        return $app['twig']->render('patrons.html.twig', array('patrons'=>Patron::getall()));
    });

    $app->post("/patrons", function() use ($app) {
        $new_book = new Patron($_POST['inputFirstName'], $_POST['inputLastName']);
        $new_book->save();
        return $app->redirect("/patrons");
    });

    $app->delete("/delete-patron/{id}", function($id) use ($app) {
        $patron = Patron::find($id);
        $patron->delete();
        return $app->redirect("/patrons");
    });

    $app->get("/patrons/{id}", function($id) use ($app) {
        $new_patron = Patron::find($id);
        $found_books = $new_patron->findBooks();
        return $app['twig']->render('patron.html.twig', array('patron'=>$new_patron, 'all_books'=>Book::getAll(), 'found_books'=>$found_books));
    });

    $app->post("/patrons/{id}", function($id) use ($app) {
        $new_patron = Patron::find($id);
        $book = Book::find($_POST['bookDrop']);
        $new_patron->addBook($book);
        return $app->redirect("/patrons/$id");
    });

    $app->delete("/turn-in/{id}/{join_id}", function($id, $join_id) use ($app) {
        $book = Book::find($id);
        $book->turnIn();
        $book->removeBook($join_id);
        return $app->redirect("/patrons");
    });

    return $app;
?>

///Applications/MAMP/Library/bin/mysql --host=localhost -uroot -proot
//don't look
