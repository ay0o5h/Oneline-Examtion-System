<?php
include_once 'dbConnection.php';
session_start();
$email = $_SESSION['email'];
//quiz start
if (@$_GET['q'] == 'quiz' && @$_GET['step'] == 2) {
  // declare variable
  $quiz_id = @$_GET['quiz_id'];
  $total = @$_GET['t'];

  $quizs = mysqli_query($conn, "SELECT * FROM quizs WHERE quiz_id='$quiz_id' ") or die('Error25');
  // fetch the right answer score
  while ($row = mysqli_fetch_array($quizs)) {
    $wrongQuizTbl = $row['wrong'];
    $total = $row['total'];
    $rightQuizTbl = $row['right'];
  }

  $history = mysqli_query($conn, "SELECT * FROM history WHERE quiz_id='$quiz_id' AND email='$email' ") or die('Error31');
  while ($row = mysqli_fetch_array($history)) {
    $score = $row['score'];
    $wrong = $row['wrong'];
    $right = $row['right'];
  }

  $tot = 0;
  foreach ($_POST as $key => $value) {
    $id = substr($key, 3);
    $tot++;
    $newId = str_replace("_", "", $id);
    $answer = implode(",", $value);
    $qur = mysqli_query($conn, "INSERT INTO student_answers VALUES ('$email','$newId','$answer',NOW())");
    if ($score_sql = mysqli_query($conn, "SELECT * FROM questions WHERE   question_id='$newId'")) {
    }

    $row = mysqli_fetch_array($score_sql);
    $right_answer = $row['right_answer'];
    $question_number = $row['question_number'];

    if ($answer == $right_answer) {
      $right++;
    } else {
      $wrong++;
    }
  }

  $score = $right * $rightQuizTbl;


  $historyInsert = mysqli_query($conn, "INSERT INTO history VALUES('$email','$quiz_id' ,'$score','$question_number','$right','$wrong',NOW())") or die('Error26');
  //  redirct to result page
  header("location:dashboard.php?q=result&quiz_id=$quiz_id");
}
