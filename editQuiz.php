<?php
include_once 'dbConnection.php';


session_start();
$email = $_SESSION['email'];



if (@$_GET['q'] == 'upquiz') {
   $quiz_id = @$_GET['quiz_id'];

   //  select data from database the questons
   $selectQsn = mysqli_query($conn, "SELECT * FROM questions WHERE quiz_id='$quiz_id'  ") or die('Error42');
   while ($row = mysqli_fetch_array($selectQsn)) {

      $question_id = $row['question_id'];
      $question_number = $row['question_number'];

      $question = $_POST['qns' . $question_number];
      $optionA = $_POST['op1' . $question_number];
      $optionB = $_POST['op2' . $question_number];
      $optionC = $_POST['op3' . $question_number];
      $optionD = $_POST['op4' . $question_number];
      $updateQuestion = mysqli_query($conn, "UPDATE  questions SET  question='$question' 
       WHERE question_id = '$question_id' ") or die('Error1');
      $updateOptionA = mysqli_query($conn, "UPDATE  questions SET  optionA='$optionA' 
       WHERE question_id = '$question_id' ") or die('Error2');
      $updateOptionB = mysqli_query($conn, "UPDATE  questions SET  optionB='$optionB' 
       WHERE question_id = '$question_id' ") or die('Error3');
      $updateOptionC = mysqli_query($conn, "UPDATE  questions SET  optionC='$optionC' 
        WHERE question_id = '$question_id' ") or die('Error4');
      $updateOptionD = mysqli_query($conn, "UPDATE  questions SET  optionD='$optionD' 
         WHERE question_id = '$question_id' ") or die('Error5');
   }

   header("location:admin.php?q=3");
}
