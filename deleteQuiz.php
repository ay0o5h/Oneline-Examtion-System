<?php
include_once 'dbConnection.php';

session_start();
$email = $_SESSION['email'];
//remove quiz

if (@$_GET['q'] == 'rmquiz') {
  $quiz_id = @$_GET['quiz_id'];
  $result = mysqli_query($conn, "SELECT * FROM questions WHERE quiz_id='$quiz_id' ") or die('Error18');

  $r1 = mysqli_query($conn, "DELETE FROM questions WHERE quiz_id='$quiz_id' ") or die('Error21');
  $r2 = mysqli_query($conn, "DELETE FROM quizs WHERE quiz_id='$quiz_id' ") or die('Error22');
  $r3 = mysqli_query($conn, "DELETE FROM history WHERE quiz_id='$quiz_id' ") or die('Error23');


  header("location:admin.php?q=5");
}
