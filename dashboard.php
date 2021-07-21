<?php
include_once 'dbConnection.php';


session_start();
$email = $_SESSION['email'];
// check if the user logged in
if (!(isset($_SESSION['email']))) {
  header("location:index.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

  <link rel="stylesheet" href="./css/bootstrap.min.css">
  <link rel="stylesheet" href="./css/dashStudent.css">
  <link rel="icon" type="text/icon" href="./images/logo.png">
  <title>Dashboard</title>
</head>

<body>
  <!-- sidebar -->
  <nav class="menu" tabindex="0">
    <div class="smartphone-menu-trigger"></div>
    <header class="avatar">
      <?php
      // get user from dashboard to daisplay the name of user in dashboard
      $user = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'") or die('Error0');
      while ($row = mysqli_fetch_array($user)) {
        $fname = $row['fname'];
        $lname = $row['lname'];
      }
      ?>
      <img src="https://s3.amazonaws.com/uifaces/faces/twitter/kolage/128.jpg" />
      <h2><?php echo $fname . ' ' . $lname; ?></h2>
    </header>
    <ul>
      <li tabindex="0" <?php if (@$_GET['q'] == 1) echo 'class="active"'; ?>>
        <a href="dashboard.php?q=1">
          <i class="fa fa-home fa-2x"></i><span> courses</span>
        </a>
      </li>
      <li tabindex="0" <?php if (@$_GET['q'] == 2) echo 'class="active"'; ?>>
        <a href="dashboard.php?q=2">

          <i class="fa fa-list-ul fa-2x"></i><span> grade</span>
        </a>
      </li>
      <li tabindex="0">
        <a href="logout.php">
          <!-- <i class="fa fa-outdent fa-2x"></i> -->
          <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-box-arrow-right" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0v2z" />
            <path fill-rule="evenodd" d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z" />
          </svg>
          <span> logout</span>
        </a>
      </li>
    </ul>
  </nav>
  <!-- end sidebar -->
  <!-- start main content -->
  <main>

    <img class="logo" src="./images/pic1.png">
    <div class="helper">
      DASHBOARD
      <!--home start-->
      <!-- display all quizez -->
      <?php if (@$_GET['q'] == 1) {
        // get data from database
        $result = mysqli_query($conn, "SELECT * FROM quizs ORDER BY date DESC") or die('Error0');
        echo  '
<div class="panel">
<div class="table-responsive">
<table class="table table-striped title1">
<tr>
<td><b>S.N.</b></td>
<td><b>Topic</b></td>
<td><b>Total question</b></td>
<td><b>Marks</b></td>
<td><b>Time limit</b></td>
<td>Action</td>
</tr>';
        $c = 1;
        while ($row = mysqli_fetch_array($result)) {
          $title = $row['title'];
          $total = $row['total'];
          $right = $row['right'];
          $time = $row['time'];
          $quiz_id = $row['quiz_id'];
          $getAllEaxm = mysqli_query($conn, "SELECT score FROM history WHERE quiz_id='$quiz_id'  AND email='$email'") or die('Error 1');
          $count = mysqli_num_rows($getAllEaxm);
          // get the new quizes
          if ($count == 0) {
            echo '<tr>
   <td>' . $c++ . '</td>
   <td>' . $title . '</td>
   <td>' . $total . '</td>
   <td>' . $right * $total . '</td>
   <td> 20 min</td>
	<td>
   <a  href="dashboard.php?q=quiz&step=2&quiz_id=' . $quiz_id . '&t=' . $total . '" class="start btn sub1" style="margin:0px;background:#99cc32">
   <b class="title1">Start </b>
   </a>
   </td>
   </tr>';
          } else {
            // if the quiz already taken
            echo '
<tr style="color:#99cc32">
<td>' . $c++ . '</td>
<td>' . $title . '</td>
<td>' . $total . '</td>
<td>' . $right * $total . '</td>
<td>20 ' . $time . 'min</td>
<td>
<button  disabled class="pull-right btn sub1" style="margin:0px;background:red;color:white;">
<b class="title1">taken</b>
</button>
</td>
</tr>';
          }
        }
        $c = 0;
        echo '</table></div></div>';
      }


      //quiz start

      if (@$_GET['q'] == 'quiz' && @$_GET['step'] == 2) {

        $quiz_id = @$_GET['quiz_id'];
        $question_number = @$_GET['n'];
        $total = @$_GET['t'];

        // select all questions and options and write answer from  database
        $questions = mysqli_query($conn, "SELECT * FROM questions WHERE quiz_id='$quiz_id'  ") or die('Error2');

        echo '<div class="panel" style="margin:1%;float:left; text-align:left;">';

        $c = 1;
        $i = 1;
        // fetch all questions
        while ($row = mysqli_fetch_array($questions)) {
          $question = $row['question'];
          $question_id = $row['question_id'];
          $optionA = $row['optionA'];
          $optionB = $row['optionB'];
          $optionC = $row['optionC'];
          $optionD = $row['optionD'];
          echo '<br><b>Q/' . $c++ . ' </b> <br />
          <b> ' . $question . '</b> <br /><br />';

          echo '<form id="startForm"    action="update.php?q=quiz&step=2&quiz_id=' . $quiz_id . '&t=' . $total . '" 
         method="POST"  class="form-horizontal">
         <br />';



          // fetch all options

          echo '<input type="radio" name="ans' . $question_id . '[]" value="' . $optionA . '">    ' . $optionA . '<br /><br />';
          echo '<input type="radio" name="ans' . $question_id . '[]" value="' . $optionB . '">    ' . $optionB . '<br /><br />';
          echo '<input type="radio" class="hide" name="ans' . $question_id . '[]" value="' . $optionC . '">    ' . $optionC . '<br /><br />';
          echo '<input type="radio" class="hide" name="ans' . $question_id . '[]" value="' . $optionD . '">    ' . $optionD . '<br /><br />';
        }
        // timer of the quiz
        echo '<br>  <span id="countdown" class="timer" style="font-size:30px;  "></span>';
        //  submit button 
        echo '<button type="submit"   class="btn btn-primary">
             Submit
             </button>
             </form>
            
             </div>';
      }
      //result display
      if (@$_GET['q'] == 'result' && @$_GET['quiz_id']) {
        $quiz_id = @$_GET['quiz_id'];
        // get the data from database
        $history = mysqli_query($conn, "SELECT * FROM history WHERE  quiz_id='$quiz_id' AND email='$email' ") or die('Error4');
        echo  '<div class="panel">
      <center>
      <b style="color:red;" id="finish"></p>
      <h1 class="title" style="color:#660033">Result</h1>
      </center><br />
       <table class="table table-striped title1" style="font-size:20px;font-weight:1000;">';
        // fetch the result from database in history table
        while ($row = mysqli_fetch_array($history)) {
          $score = $row['score'];
          $wrong = $row['wrong'];
          $right = $row['right'];
          $noOfQsn = $row['noOfQsn'];
          echo '<tr style="color:#66CCFF">
               <td>Total Questions</td> 
               <td>' . $noOfQsn . '</td>
               </tr>
             <tr style="color:#99cc32">
             <td>right Answer</td>
              <td>' . $right . '</td>
                </tr> 
	         <tr style="color:red">
            <td>Wrong Answer</td>
            <td>' . $wrong . '</td>
            </tr>
	           <tr style="color:#66CCFF">
              <td>Score</td>
              <td>' . $score . '</td>
              </tr>';
        }
        // show the correct answers

        echo '<tr style="color:#990000">
        <td colspan="2">
        <center>
        <a href="dashboard.php?q=correct&quiz_id=' . $quiz_id . '" class="btn btn-warning" style="width:100%;">show correct answers</a>
        </center>
        </td>
       
        </tr>';

        echo '</table></div>';
      }

      //display grade of the student

      if (@$_GET['q'] == 2) {
        // select data from history table
        $history = mysqli_query($conn, "SELECT * FROM history WHERE email='$email' ORDER BY date DESC ") or die('Error6');
        echo  '<div class="panel title">
<table class="table table-striped title1" >
<tr style="color:red">
<td><b>S.N.</b></td>
<td><b>Quiz</b></td>
<td><b>Right</b></td>
<td><b>Wrong<b></td>
<td><b>Score</b></td>
<td></td>';
        $c = 0;
        // fetch data from history table
        while ($row = mysqli_fetch_array($history)) {
          $quiz_id = $row['quiz_id'];
          $score = $row['score'];
          $wrong = $row['wrong'];
          $right = $row['right'];
          $noOfQsn = $row['noOfQsn'];
          // select title of quiz from quiz table 
          $quiz = mysqli_query($conn, "SELECT * FROM quizs WHERE  quiz_id='$quiz_id' ") or die('Error7');
          while ($row = mysqli_fetch_array($quiz)) {
            $title = $row['title'];
            $rightQuizTbl = $row['right'];
            $total = $row['total'];
          }
          $c++;
          echo '<tr>
<td>' . $c . '</td>
<td>' . $title . '</td>
<td>' . $right . '</td>
<td>' . $wrong . '</td>
<td >' . $score . '/' . $total * $rightQuizTbl . ' </td>
<td><a href="dashboard.php?q=certification&quiz_id=' . $quiz_id . '">certification</a>
<a href="dashboard.php?q=correct&quiz_id=' . $quiz_id . '">Rview </a></td>
</tr>';
        }

        echo '</table>
</div>';
      }
      //  certification

      if (@$_GET['q'] == 'certification') {
        $quiz_id = @$_GET['quiz_id'];
        // select data from history table
        $history = mysqli_query($conn, "SELECT * FROM history WHERE email='$email' AND quiz_id='$quiz_id' ") or die('Error6');
        echo  '<div style="padding:5%;margin-top:30px;border:1px solid black; border-radius:20px ;width:400px;font-family:time new roman">
<h1 >certificate</h1>
';
        // fetch data from history table
        $row = mysqli_fetch_array($history);

        $score = $row['score'];


        // select title of quiz from quiz table 
        $quiz = mysqli_query($conn, "SELECT * FROM quizs WHERE  quiz_id='$quiz_id' ") or die('Error7');
        $row1 = mysqli_fetch_array($quiz);

        $title = $row1['title'];
        $rightQuizTbl = $row1['right'];
        $total = $row1['total'];
        $user = mysqli_query($conn, "SELECT * FROM users WHERE email='$email' ") or die('Error16');
        $row2 = mysqli_fetch_array($user);
        $fname = $row2['fname'];
        $lname = $row2['lname'];

        $all = $total * $rightQuizTbl / 2;
        echo '<div>
<h3>' . $fname . '  ' . $lname . '</h3>
<h3>' . $title . '</h3>
<h3>' . $score . '/' . $total * $rightQuizTbl . ' </h3>';
        if ($score >= $all) {
          echo '<b> Congratulations you passed  this exam</b>';
        } else {
          echo '<b>  you failed in this exam </b>
';
        }



        echo '</div></div>';
      }
      //  show correct answers
      if (@$_GET['q'] == 'correct') {
        $quiz_id = @$_GET['quiz_id'];
        $question_number = @$_GET['n'];
        $total = @$_GET['t'];

        // select all questions and options and answer from database
        $questions = mysqli_query($conn, "SELECT * FROM questions WHERE quiz_id='$quiz_id' ") or die('Error8');

        echo '<div class="panel" style="margin:1%;float:left; text-align:left;">';
        // fetch all questions
        $c = 1;
        while ($row = mysqli_fetch_array($questions)) {

          $question = $row['question'];
          $question_id = $row['question_id'];
          $right_answer  = $row['right_answer'];
          $qur = mysqli_query($conn, "SELECT * FROM student_answers WHERE email='$email' AND quiz_id='$question_id'") or die('Error80');
          while ($row = mysqli_fetch_array($qur)) {

            $studentAnswer = $row['answer'];
          }
          echo '<b>Q/  ' . $c++ . '   ' . $question_number . ' </b> <br />

         <b> ' . $question . '</b> <br /><br />';



          echo '<b style="color: gray;"> ans: ' . $right_answer . ' </b> <br /><br />';
      ?>
          <b style="color:<?php if ($studentAnswer == $right_answer) {
                            echo 'green';
                          } else {
                            echo 'red';
                          }
                          ?>"> your answer: <?php echo $studentAnswer; ?> </b> <br /><br />

      <?php
        }
        echo ' </div>';
      }

      ?>
    </div>
  </main>
  <script src="./js/jquery-3.4.1.min.js"></script>
  <script src="./js/main.js"></script>
  <script src="./js/bootstrap.min.js"></script>
</body>

</html>