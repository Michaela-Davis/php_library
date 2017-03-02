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
        $author = Author::find($new_book->getId());
        $author->addBook($new_book);
        return $app['twig']->render('books.html.twig', array('books'=>Book::getall(), "authors"=>Author::getAll()));
    });

    $app->delete("/delete-book/{id}", function($id) use ($app) {
        $book = Book::find($id);
        $book->delete();
        return $app->redirect("/books");
    });

    $app->get("/authors", function() use ($app) {
        return $app['twig']->render('authors.html.twig', array('authors'=>Author::getall()));
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


    return $app;
?>

///Applications/MAMP/Library/bin/mysql --host=localhost -uroot -proot
//don't look
