<?php
include_once 'dbConnection.php';

session_start();
$email = $_SESSION['email'];


//add quiz

if (@$_GET['q'] == 'addquiz') {
     $name = $_POST['name'];
     $name = ucwords(strtolower($name));
     $total = $_POST['total'];
     $right = $_POST['right'];
     $wrong = $_POST['wrong'];
     $id = uniqid();
     //     insert data in quiz table
     $quiz = mysqli_query($conn, "INSERT INTO quizs VALUES  ('$id','$name' , '$right' , '$wrong','$total', NOW())") or die('Error11');
     //     redrict to add questions page
     header("location:admin.php?q=4&step=2&quiz_id=$id&n=$total");
     exit();
}


//add question

if (@$_GET['q'] == 'addqns') {
     $n = @$_GET['n'];
     $quiz_id = @$_GET['quiz_id'];
     $ch = @$_GET['ch'];

     for ($i = 1; $i <= $n; $i++) {
          $question_id = uniqid();
          $question = $_POST['qns' . $i];
          $optionA = $_POST[$i . '1'];
          $optionB = $_POST[$i . '2'];
          $optionC = $_POST[$i . '3'];
          $optionD = $_POST[$i . '4'];
          $answers = $_POST['ans' . $i];

          //     get the correct answer equl to which option
          switch ($answers) {
               case 'a':
                    $ans = $optionA;
                    break;
               case 'b':
                    $ans = $optionB;
                    break;
               case 'c':
                    $ans = $optionC;
                    break;
               case 'd':
                    $ans = $optionD;
                    break;
          }

          //     insert data into question table
          $questions = mysqli_query($conn, "INSERT INTO questions VALUES  
    ('$quiz_id','$question_id ','$question' , '$optionA ','$optionB ',
    '$optionC' ,'$optionD', '$ans','$i')") or die('Error12');
     }
     // redirct to home page
     header("location:admin.php?q=0");
     exit();
}
