<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    // require_once "src/Student.php";
    // require_once "src/Course.php";
    //
    // $server = 'mysql:host=localhost:8889;dbname=registrar_test';
    // $username = 'root';
    // $password = 'root';
    // $DB = new PDO($server, $username, $password);
    //
    //
    // class StudentTest extends PHPUnit_Framework_TestCase
    // {
    //
    //     protected function tearDown()
    //     {
    //       Student::deleteAll();
    //       Course::deleteAll();
    //     }
    //
    //     function testGetFirstName()
    //     {
    //         //Arrange
    //         $first_name = "Mark";
    //         $last_name = "Johnson";
    //         $enroll_date = "2017-12-12";
    //
    //         $testGetFirstName = new Student($first_name, $last_name, $enroll_date);
    //
    //         //Act
    //         $result = $testGetFirstName->getFirstName();
    //
    //         //Assert
    //         $this->assertEquals($first_name, $result);
    //
    //     }
    //
    //     function testSetFirstName()
    //     {
    //         //Arrange
    //         $first_name = "Mark";
    //         $last_name = "Johnson";
    //         $enroll_date = "2017-12-12";
    //
    //         $testGetFirstName = new Student($first_name, $last_name, $enroll_date);
    //
    //         //Act
    //         $testGetFirstName->setFirstName("Mike");
    //         $result = $testGetFirstName->getFirstName();
    //
    //         //Assert
    //         $this->assertEquals("Mike", $result);
    //     }
    //
    //     function testGetId()
    //     {
    //         //Arrange
    //         $first_name = "Mark";
    //         $last_name = "Johnson";
    //         $enroll_date = "2017-12-12";
    //         $id = 1;
    //
    //         $testGetFirstName = new Student($first_name, $last_name, $enroll_date, $id);
    //
    //         //Act
    //         $result = $testGetFirstName->getId();
    //
    //         //Assert
    //         $this->assertEquals($id, $result);
    //     }
    //
    //     function testSave()
    //     {
    //         //Arrange
    //         $first_name = "Mark";
    //         $last_name = "Johnson";
    //         $enroll_date = "2017-12-12";
    //
    //         $testGetFirstName = new Student($first_name, $last_name, $enroll_date);
    //         $testGetFirstName->save();
    //
    //         //Act
    //         $result = Student::getAll();
    //
    //         //Assert
    //         $this->assertEquals($testGetFirstName, $result[0]);
    //     }
    //
    //     function testUpdate()
    //     {
    //         //Arrange
    //         $first_name = "Mark";
    //         $last_name = "Johnson";
    //         $enroll_date = "2017-12-12";
    //
    //         $testGetFirstName = new Student($first_name, $last_name, $enroll_date);
    //         $testGetFirstName->save();
    //
    //         $new_first_name = "Mike";
    //         $new_last_name = "Smith";
    //
    //         //Act
    //         $testGetFirstName->update($new_first_name, $new_last_name);
    //
    //         //Assert
    //         $this->assertEquals($new_first_name, $testGetFirstName->getFirstName());
    //     }
    //
    //     function testDeleteCourse()
    //     {
    //         //Arrange
    //         $first_name = "Mark";
    //         $last_name = "Johnson";
    //         $enroll_date = "2017-12-12";
    //
    //         $testGetFirstName = new Student($first_name, $last_name, $enroll_date);
    //         $testGetFirstName->save();
    //
    //         $first_name2 = "John";
    //         $last_name2 = "Johnson";
    //         $enroll_date2 = "2017-12-12";
    //
    //         $testGetFirstName2 = new Student($first_name2, $last_name2, $enroll_date2);
    //         $testGetFirstName2->save();
    //
    //         //Act
    //         $testGetFirstName->delete();
    //
    //         //Assert
    //         $this->assertEquals([$testGetFirstName2], Student::getAll());
    //     }
    //
    //     function testGetAll()
    //     {
    //         //Arrange
    //         $first_name = "Mark";
    //         $last_name = "Johnson";
    //         $enroll_date = "2017-12-12";
    //
    //         $testGetFirstName = new Student($first_name, $last_name, $enroll_date);
    //         $testGetFirstName->save();
    //
    //         $first_name2 = "John";
    //         $last_name2 = "Johnson";
    //         $enroll_date2 = "2017-12-12";
    //
    //         $testGetFirstName2 = new Student($first_name2, $last_name2, $enroll_date2);
    //         $testGetFirstName2->save();
    //
    //         //Act
    //         $result = Student::getAll();
    //
    //         //Assert
    //         $this->assertEquals([$testGetFirstName, $testGetFirstName2], $result);
    //     }
    //
    //     function testDeleteAll()
    //     {
    //         //Arrange
    //         $first_name = "Mark";
    //         $last_name = "Johnson";
    //         $enroll_date = "2017-12-12";
    //
    //         $testGetFirstName = new Student($first_name, $last_name, $enroll_date);
    //         $testGetFirstName->save();
    //
    //         $first_name2 = "John";
    //         $last_name2 = "Johnson";
    //         $enroll_date2 = "2017-12-12";
    //
    //         $testGetFirstName2 = new Student($first_name2, $last_name2, $enroll_date2);
    //         $testGetFirstName2->save();
    //
    //         //Act
    //         Student::deleteAll();
    //
    //         //Assert
    //         $result = Student::getAll();
    //         $this->assertEquals([], $result);
    //     }
    //
    //     function testFind()
    //     {
    //         //Arrange
    //         $first_name = "Mark";
    //         $last_name = "Johnson";
    //         $enroll_date = "2017-12-12";
    //
    //         $testGetFirstName = new Student($first_name, $last_name, $enroll_date);
    //         $testGetFirstName->save();
    //
    //         $first_name2 = "John";
    //         $last_name2 = "Johnson";
    //         $enroll_date2 = "2017-12-12";
    //
    //         $testGetFirstName2 = new Student($first_name2, $last_name2, $enroll_date2);
    //         $testGetFirstName2->save();
    //
    //         //Act
    //         $result = Student::find($testGetFirstName->getId());
    //
    //         //Assert
    //         $this->assertEquals($testGetFirstName, $result);
    //     }
    //
    //     function testAddCourse()
    //     {
    //         //Arrange
    //         $title = "War on Terror Revisited";
    //         $course_number = "POL-411";
    //         $test_course = new Course($title, $course_number);
    //         $test_course->save();
    //
    //         $first_name = "Mark";
    //         $last_name = "Johnson";
    //         $enroll_date = "2017-12-12";
    //
    //         $test_student = new Student($first_name, $last_name, $enroll_date);
    //         $test_student->save();
    //
    //         //Act
    //         $test_student->addCourse($test_course);
    //
    //         //Assert
    //         $this->assertEquals($test_student->getCourses(), [$test_course]);
    //     }
    //
    //     function testGetCourses()
    //     {
    //         //Arrange
    //         $title = "War on Terror Revisited";
    //         $course_number = "POL-411";
    //         $test_course = new Course($title, $course_number);
    //         $test_course->save();
    //
    //         $title2 = "Underwater Basket Weaving";
    //         $course_number2 = "BASK-123";
    //         $test_course2 = new Course($title2, $course_number2);
    //         $test_course2->save();
    //
    //         $first_name = "Mark";
    //         $last_name = "Johnson";
    //         $enroll_date = "2017-12-12";
    //
    //         $test_student = new Student($first_name, $last_name, $enroll_date);
    //         $test_student->save();
    //
    //         //Act
    //         $test_student->addCourse($test_course);
    //         $test_student->addCourse($test_course2);
    //
    //         //Assert
    //         $this->assertEquals($test_student->getCourses(), [$test_course, $test_course2]);
    //     }
    //
    //     function testEnrollStatus()
    //     {
    //         $title = "War on Terror Revisited";
    //         $course_number = "POL-411";
    //         $test_course = new Course($title, $course_number);
    //         $test_course->save();
    //
    //         $first_name = "Mark";
    //         $last_name = "Johnson";
    //         $enroll_date = "2017-12-12";
    //
    //         $test_student = new Student($first_name, $last_name, $enroll_date);
    //         $test_student->save();
    //
    //         $test_student->addCourse($test_course);
    //         $result = $test_student->getCourseStatus($test_course->getId());
    //
    //         $this->assertEquals("enrolled", $result);
    //
    //     }
    //
    //     function testUpdateStatus()
    //     {
    //         $title = "War on Terror Revisited";
    //         $course_number = "POL-411";
    //         $test_course = new Course($title, $course_number);
    //         $test_course->save();
    //
    //         $first_name = "Mark";
    //         $last_name = "Johnson";
    //         $enroll_date = "2017-12-12";
    //
    //         $test_student = new Student($first_name, $last_name, $enroll_date);
    //         $test_student->save();
    //
    //         $test_student->addCourse($test_course);
    //         $test_student->updateStatus($test_student->getId(), $test_course->getId(), "Dropped");
    //         $result = $test_student->getCourseStatus($test_course->getId());
    //
    //
    //         $this->assertEquals("Dropped", $result);
    //
    //     }

    // }

?>
