<?php
    date_default_timezone_set('America/Los_Angeles');

    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Student.php";
    require_once __DIR__."/../src/Course.php";

    $app = new Silex\Application();

    $app['debug']=true;

    $server = 'mysql:host=localhost:8889;dbname=registrar';
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
        return $app['twig']->render('index.html.twig', array('confirm'=>'false','courses'=>Course::getAll(), 'students'=>Student::getAll()));
    });

    $app->get("/courses", function() use ($app) {
        return $app['twig']->render('courses.html.twig', array('courses'=>Course::getAll()));
    });

    $app->get("/students", function() use ($app) {
        return $app['twig']->render('students.html.twig', array('students'=>Student::getAll()));
    });

    $app->get("/search", function() use ($app) {
        $result = Student::searchFor($_GET['search_term']);
        return $app['twig']->render('students.html.twig', array('students'=>$result));
    });

    $app->post("/add_course", function() use ($app) {
        $new_course = new Course(filter_var($_POST['inputCourseName'], FILTER_SANITIZE_MAGIC_QUOTES), filter_var($_POST['inputCourseNumber'], FILTER_SANITIZE_MAGIC_QUOTES));
        $new_course->save();
        return $app->redirect("/courses");
    });

    $app->post("/add_student", function() use ($app) {
        $new_student = Student::findStudent($_POST['inputFirst'], $_POST['inputLast']);
        $course = Course::findCourse($_POST['courseName']);
        $new_student->addCourse($course);
        return $app['twig']->render('student.html.twig', array("all_courses"=>Course::getAll(), 'student'=>$new_student, 'courses'=>$new_student->getCourses()));
    });

    $app->post("/enroll_student", function() use ($app) {
        $enroll_date = date("Y-m-d");
        $new_course = new Student(filter_var($_POST['inputFirstName'], FILTER_SANITIZE_MAGIC_QUOTES), filter_var($_POST['inputLastName'], FILTER_SANITIZE_MAGIC_QUOTES), $enroll_date);
        $new_course->save();
        return $app->redirect("/students");
    });

    $app->post("/", function() use ($app) {
        $student = Student::findStudent(filter_var($_POST['inputFirst'], FILTER_SANITIZE_MAGIC_QUOTES), filter_var($_POST['inputLast'], FILTER_SANITIZE_MAGIC_QUOTES));
        $course = Course::findCourse($_POST['courseName']);
        $student->addCourse($course);
        return $app['twig']->render('index.html.twig', array('confirm'=>'true','courses'=>Course::getAll(), 'students'=>Student::getAll()));
    });

    $app->get("/courses/{id}", function($id) use ($app) {
        $course = Course::find($id);
        return $app['twig']->render('course.html.twig', array('course'=>$course, 'students'=>$course->getStudents()));
    });

    $app->get("/students/{id}", function($id) use ($app) {
        $student = Student::find($id);
        return $app['twig']->render('student.html.twig', array('student'=>$student, 'courses'=>$student->getCourses(), "all_courses"=>Course::getAll()));
    });

    $app->patch("/edit-student/{id}", function($id) use ($app) {
        $student = Student::find($id);
        $student->update(filter_var($_POST['student_first_name'], FILTER_SANITIZE_MAGIC_QUOTES), filter_var($_POST['student_last_name'], FILTER_SANITIZE_MAGIC_QUOTES));
        return $app['twig']->render('student.html.twig', array("all_courses"=>Course::getAll(), 'student'=>$student, 'courses'=>$student->getCourses()));
    });

    $app->patch("/edit-course/{id}", function($id) use ($app) {
        $course = Course::find($id);
        Student::updateStatus($_POST['student_id'], $id, $_POST['courseStatus']);
        return $app['twig']->render('course.html.twig', array('course'=>$course, 'students'=>$course->getStudents()));
    });

    $app->delete("/remove-course/{id}", function($id) use ($app) {
        $course = Course::find($id);
        $student = Student::find($_POST['student_id']);
        $student->removeCourse($course);
        return $app['twig']->render('student.html.twig', array('student'=>$student, 'courses'=>$student->getCourses(), "all_courses"=>Course::getAll()));
    });

    $app->delete("/delete-student/{id}", function($id) use ($app) {
        $student = Student::find($id);
        $student->delete();
        return $app['twig']->render('students.html.twig', array('students'=>Student::getAll()));
    });

    $app->delete("/delete-course/{id}", function($id) use ($app) {
        $course = Course::find($id);
        $course->delete();
        return $app['twig']->render('courses.html.twig', array('courses'=>Course::getAll()));
    });


    return $app;
?>

///Applications/MAMP/Library/bin/mysql --host=localhost -uroot -proot
//don't look
