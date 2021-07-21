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
<html>

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Admin control panel </title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" type="text/css" href="./css/bootstrap.min.css" />
  <link rel="stylesheet" href="./css/admin.css">
  <link rel="icon" type="text/icon" href="./images/logo.png">
  <link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300' rel='stylesheet' type='text/css'>

</head>

<body>


  <!--navigation menu-->
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="index.php">
      <img src="./images/pic1.png" height="80px" />
    </a>
    <button class="navbar-toggler" type="button" class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto ">
        <li <?php if (@$_GET['q'] == 0) echo 'class="active"'; ?> class="nav-item active">
          <a class="nav-link" href="admin.php?q=0">Home </a>
        </li>
        <li <?php if (@$_GET['q'] == 1) echo 'class="active"'; ?> class="nav-item">
          <a class="nav-link" href="admin.php?q=1">student grade</a>
        </li>
        <li class="nav-item dropdown <?php if (@$_GET['q'] == 4 || @$_GET['q'] == 5) echo 'active"'; ?>">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            quiz
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="admin.php?q=4">add quiz</a></li>
            <li><a class="dropdown-item" href="admin.php?q=3">edit quiz</a></li>
            <li><a class="dropdown-item" href="admin.php?q=5">delete quiz</a></li>
          </ul>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="logout.php">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-right" viewBox="0 0 16 16">
              <path fill-rule="evenodd" d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0v2z" />
              <path fill-rule="evenodd" d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z" />
            </svg>
            logout</a>
        </li>
      </ul>

    </div>
  </nav>
  <!--navigation menu closed-->
  <?php
  // display all new quiz in admin control panel
  if (@$_GET['q'] == 0) {
    // get data from database
    $result = mysqli_query($conn, "SELECT * FROM quizs ORDER BY date DESC") or die('Error0');
    echo  '<div class="panel">
     <div class="table-responsive">
     <table class="table table-striped title1">
      <tr>
      <td><b>N.</b></td>
      <td><b>Topic</b></td>
      <td><b>Total question</b></td>
      <td><b>Marks</b></td>
      <td><b>Time limit</b></td>
 
      </tr>';
    $c = 1;
    // fetch data from database
    while ($row = mysqli_fetch_array($result)) {
      $title = $row['title'];
      $total = $row['total'];
      $right = $row['right'];
      $quiz_id = $row['quiz_id'];

      echo '<tr>
  <td>' . $c++ . '</td>
  <td>' . $title . '</td>
  <td>' . $total . '</td>
  <td>' . $right * $total . '</td>
  <td> 20 &nbsp;min</td>
 
  </tr>';
    }
    $c = 0;
    echo '</table>
          </div>
          </div>';
  }
  // display student infrmation

  if (@$_GET['q'] == 1) {


    // select all data from history table
    $history = mysqli_query($conn, "SELECT * FROM history  ORDER BY score DESC ") or die('Error15');
    echo  '<div class="panel title">
         <div class="table-responsive">
          <table class="table table-striped title1" >
          <tr style="color:red">
          <td><b>No.</b></td>
          <td><b>Student Name</b></td>
          <td><b>Subject Name</b></td>
          <td><b>Score</b></td>
          </tr>';
    $c = 0;
    // fetch data from history table
    while ($row = mysqli_fetch_array($history)) {

      $email = $row['email'];
      $score = $row['score'];
      $quiz_id = $row['quiz_id'];
      // select all user infromation to display it in informain table
      $user = mysqli_query($conn, "SELECT * FROM users WHERE email='$email' ") or die('Error16');
      while ($row = mysqli_fetch_array($user)) {
        $fname = $row['fname'];
        $lname = $row['lname'];
        $email = $row['email'];
      }
      // select data from quiz table to get the name of the quiz
      $quiz = mysqli_query($conn, "SELECT * FROM quizs WHERE quiz_id='$quiz_id' ") or die('Error16');
      while ($row = mysqli_fetch_array($quiz)) {
        $title = $row['title'];
      }
      $c++;
      echo '<tr>
<td style="color:#99cc32"><b>' . $c . '</b></td>
<td>' . $fname . '  ' . $lname . '</td>
<td>' . $title . '</td>
<td>' . $score . '</td>';
    }
    echo '</table>
          </div>
          </div>';
  }
  // add Quiz

  if (@$_GET['q'] == 4 && !(@$_GET['step'])) {

    echo ' 
  <div class="container">
  <div class="row ">
  <center>
  <span class="title1" style="font-size:30px;margin-top:10%;">
  <b>Enter Quiz Details</b>
  </span>
  </center>
  <br /><br />
   <div class="col-md-3"></div>
   <div class="col-md-6">  
    <form class=" title1" name="form" action="addQuiz.php?q=addquiz"  method="POST">
  <fieldset>
  
  
  <!-- Text input to add name of the quiz-->
  <div class="form-group">
    <label class="col-md-12 control-label" for="name"></label>  
    <div class="col-md-12">
    <input id="name" name="name" required placeholder="Enter Quiz title" class="form-control input-md" type="text">
      
    </div>
  </div>
  
  
  
  <!-- Text input to add number of questions of the quiz-->
  <div class="form-group">
    <label class="col-md-12 control-label" for="total"></label>  
    <div class="col-md-12">
    <input id="total" required name="total" placeholder="Enter total number of questions" class="form-control input-md" type="number">
      
    </div>
  </div>
  
  <!-- Text input to add point that will give to the right answer -->
  <div class="form-group">
    <label class="col-md-12 control-label" for="right"></label>  
    <div class="col-md-12">
    <input id="right" required name="right" placeholder="Enter marks on right answer" class="form-control input-md" min="0" type="number">
      
    </div>
  </div>
  
  <!-- Text input to add point that will take off from the right answer-->
  <div class="form-group">
    <label class="col-md-12 control-label" for="wrong"></label>  
    <div class="col-md-12">
    <input id="wrong" required name="wrong" placeholder="Enter minus marks on wrong answer without sign" class="form-control input-md" min="0" type="number">
      
    </div>
  </div>
  
  
  <div class="form-group">
    <label class="col-md-12 control-label" for=""></label>
    <div class="col-md-12"> 
     <center> <input  type="submit" style="" class="btn btn-addQES   btn-primary" value="Add Questions" /></center>
    </div>
  </div>
  
  </fieldset>
  </form></div>
  <div class="col-md-3"></div>
  </div>
  </div>';
  }



  //add quiz step2 where will add questions and options and write answer 
  if (@$_GET['q'] == 4 && (@$_GET['step']) == 2) {
    echo ' 
<div class="container">
<div class="row">
<center>
<span class="title1" style="font-size:30px;">
<b>Enter Question Details</b>
</span>
</enter><br /><br />
  <div class="col-md-3"></div>
  <div class="col-md-6">
 <form class="form-horizontal title1" name="form" action="addQuiz.php?q=addqns&n=' . @$_GET['n'] . '&quiz_id=' . @$_GET['quiz_id'] . '&ch=4 "  method="POST">
<fieldset>
';
    for ($i = 1; $i <= @$_GET['n']; $i++) {
      echo '<b>Question number' . $i . ':</><br />
<!-- Text input to add the question-->
<div class="form-group">
  <label class="col-md-12 control-label" for="qns' . $i . ' "></label>  
  <div class="col-md-12">
  <textarea rows="3" cols="5" name="qns' . $i . '" 
  class="form-control" required placeholder="Write question  ' . $i . ' here..."></textarea>  
  </div>
</div>
<!-- Text input to add to option-->
<div class="form-group">
  <label class="col-md-12 control-label" for="' . $i . '1"></label>  
  <div class="col-md-12">
  <input id="' . $i . '1" name="' . $i . '1"  required
  placeholder="Enter option a" class="form-control input-md" type="text">
  </div>
</div>
<!-- Text input-->
<div class="form-group">
  <label class="col-md-12 control-label" for="' . $i . '2"></label>  
  <div class="col-md-12">
  <input id="' . $i . '2" required name="' . $i . '2" placeholder="Enter option b"
   class="form-control input-md" type="text">
  </div>
</div>
<!-- Text input-->
<div class="form-group">
  <label class="col-md-12 control-label" for="' . $i . '3"></label>  
  <div class="col-md-12">
  <input id="' . $i . '3"   name="' . $i . '3" placeholder="Enter option c"
   class="form-control input-md" type="text">   
  </div>
</div>
<!-- Text input-->
<div class="form-group">
  <label class="col-md-12 control-label" for="' . $i . '4"></label>  
  <div class="col-md-12">
  <input id="' . $i . '4"  name="' . $i . '4" placeholder="Enter option d" 
  class="form-control input-md" type="text">   
  </div>
</div>
<br />
<!-- select the correct answer -->
<b>Correct answer</b>:<br />
<select id="ans' . $i . '" required name="ans' . $i . '" placeholder="Choose correct answer " class="form-control input-md" >
   <option value="a">Select answer for question ' . $i . '</option>
  <option value="a">option a</option>
  <option value="b">option b</option>
  <option value="c">option c</option>
  <option value="d">option d</option> </select><br /><br />';
    }

    echo '<div class="form-group">
  <label class="col-md-12 control-label" for=""></label>
  <div class="col-md-12"> 
    <input  type="submit"  class="btn btn-addQES btn-primary" value="Add Quiz" class="btn btn-primary"/>
  </div>
</div>

</fieldset>
</form>
</div>
<div class="col-md-3"></div>
</div>
</div>';
  }


  //remove quiz
  if (@$_GET['q'] == 5) {
    // select data from database
    $result = mysqli_query($conn, "SELECT * FROM quizs ORDER BY date DESC") or die('Error2');
    echo  '<div class="panel">
<div class="table-responsive">
<table class="table table-striped title1">
<tr>
<td><b>N.</b></td>
<td><b>Topic</b></td>
<td><b>Total question</b></td>
<td><b>Marks</b></td>
<td><b>Time limit</b></td>
<td></td>
</tr>';
    $c = 1;
    while ($row = mysqli_fetch_array($result)) {
      $title = $row['title'];
      $total = $row['total'];
      $right = $row['right'];
      $quiz_id = $row['quiz_id'];
      echo '<tr>
  <td>' . $c++ . '</td>
  <td>' . $title . '</td>
  <td>' . $total . '</td>
  <td>' . $right * $total . '</td>
  <td> 20 &nbsp;min</td>
  <td><b><a href="deleteQuiz.php?q=rmquiz&quiz_id=' . $quiz_id . '" class="pull-right btn " style="margin:0px;background:red">
  <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
  &nbsp;<span class="title1"><b>Remove</b></span>
  </a></b></td></tr>';
    }
    $c = 0;
    echo '</table></div></div>';
  }
  //edit quiz
  if (@$_GET['q'] == 3 && !@$_GET['step']) {
    // select data from database
    $result = mysqli_query($conn, "SELECT * FROM quizs ORDER BY date DESC") or die('Error3');
    echo  '<div class="panel">
<div class="table-responsive">
<table class="table table-striped title1">
<tr>
<td><b>N.</b></td>
<td><b>Topic</b></td>
<td><b>Total question</b></td>
<td><b>Marks</b></td>
<td><b>Time limit</b></td>
<td></td>
</tr>';
    $c = 1;
    while ($row = mysqli_fetch_array($result)) {
      $title = $row['title'];
      $total = $row['total'];
      $right = $row['right'];
      $quiz_id = $row['quiz_id'];
      echo '<tr>
  <td>' . $c++ . '</td>
  <td>' . $title . '</td>
  <td>' . $total . '</td>
  <td>' . $right * $total . '</td>
  <td> 20 &nbsp;min</td>
  <td>
  <b><a href="admin.php?q=3&quiz_id=' . $quiz_id . '&step=3" class="pull-right btn" style="margin:0px;background:#04D4F0">
  <span class="title1">
  <b>edit</b>
  </span>
  </a>
  </b>
  </td>
  </tr>';
    }
    $c = 0;
    echo '</table>
            </div>
            </div>';
  }

  //edit quiz step2 start

  if (@$_GET['q'] == 3 && @$_GET['step'] == 3) {
    $quiz_id = @$_GET['quiz_id'];
    $total = @$_GET['t'];
    // get data to display them in fileds for edit
    $quiz = mysqli_query($conn, "SELECT * FROM quizs WHERE quiz_id='$quiz_id' ") or die('Error4');
    $num = mysqli_fetch_array($quiz);
    $title = $num['title'];
    echo ' 
<div class="container">
<div class="row">
<center>
<span class="title1" style="font-size:30px;">
<b>Edit Question Details</b>
</span>
<br /><br />
<span class="title1" style="font-size:30px;">
<b>' . $title . '</b>
</span>
</center>
<br /><br />
 <div class="col-md-3"></div>
 <div class="col-md-6">
 <form class="form-horizontal title1" name="form" action="editQuiz.php?q=upquiz&quiz_id=' . $quiz_id . '" method="POST">
<fieldset>
';
    // get the questions and options and write answer from the database
    $questions = mysqli_query($conn, "SELECT *  FROM questions WHERE quiz_id ='$quiz_id' ") or die('Error5');

    while ($data = mysqli_fetch_array($questions)) {
      $question  = $data['question'];
      $question_id = $data['question_id'];
      $question_number = $data['question_number'];

      $optionA = $data['optionA'];
      $optionB = $data['optionB'];
      $optionC = $data['optionC'];
      $optionD = $data['optionD'];
      $C = 0;

  ?>


      <div class="form-group">
        <label class="col-md-12 control-label"></label>
        <div class="col-md-12">
          <h5>Question <?php echo $question_number; ?> </h5></br>
          <input class="form-control height" name="qns<?php echo  $question_number; ?>" value="<?php echo  $question; ?>"><br>
          <h5>Options</h5></br>
        </div>
      </div>

      <input class="form-control" name="op1<?php echo $question_number; ?>" value="<?php echo  $optionA; ?>"><br>
      <input class="form-control" name="op2<?php echo $question_number; ?>" value="<?php echo  $optionB; ?>"><br>

      <input class="form-control" name="op3<?php echo $question_number; ?>" value="<?php echo  $optionC; ?>"><br>
      <input class="form-control" name="op4<?php echo $question_number; ?>" value="<?php echo  $optionD; ?>"><br>

  <?php

    }
    echo '<div class="form-group">
  <label class="col-md-12 control-label" for=""></label>
  <div class="col-md-12"> 
    <input  type="submit" style="margin-left:35%" class="btn btn-info"  value="Update Questions" class="btn btn-primary"/>
  </div>
</div>

</fieldset>
</form>
</div>
<div class="col-md-3"></div>
</div>
</div>';
  }

  ?>


  <script src="./js/bootstrap.min.js"></script>
</body>

</html>