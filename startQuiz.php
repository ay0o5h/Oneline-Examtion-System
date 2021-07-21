<?php
   include_once 'dbConnection.php';
   session_start();
   $email=$_SESSION['email'];
   //quiz start
if(@$_GET['q']== 'quiz' && @$_GET['step']== 2) {
    // declare variable
   
 
    
    $quiz_id =@$_GET['quiz_id'];
    $question_number=@$_GET['n'];
    $total=@$_GET['t'];
    $ans=$_POST['ans'];
    $question_id=$_GET['question_id'];
    // select the right answer
    $questions=mysqli_query($conn,"SELECT * FROM questions WHERE question_id='$question_id' " )or die('Error24');
    $qur=mysqli_query($conn,"INSERT INTO student_answers VALUES ('$email','$question_id','$ans',NOW())");
   
    // fetch the right answer
    while($row=mysqli_fetch_array($questions) )
    {
        $right_answer=$row['right_answer'];
        $question_id=$row['question_id'];
    }

    // check if the answer == right answer

    if( $ans == $right_answer )
    {
       
      // if true will calcute the right answers 
      // select the right answer score
    $quizs=mysqli_query($conn,"SELECT * FROM quizs WHERE quiz_id='$quiz_id' " )or die('Error25');
    // fetch the right answer score
    while($row=mysqli_fetch_array($quizs) )
    {
    $rightQuizTbl=$row['right'];
    }
    // inser student information in history table
    if($question_number == 1)
    {
        // if the  student is new
    $history=mysqli_query($conn,"INSERT INTO history VALUES('$email','$quiz_id' ,'0','0','0','0',NOW())")or die('Error26');
    }
    // if the  student is already exist
    $history=mysqli_query($conn,"SELECT * FROM history WHERE quiz_id='$quiz_id' AND email='$email' ")or die('Error27');
      
    while($row=mysqli_fetch_array($history) )
    {
    $score=$row['score'];
    $right=$row['right'];
    }
    $right++;
    $score=$score + $rightQuizTbl;
    $history=mysqli_query($conn,"UPDATE `history` SET `score`=$score,`noOfQsn`=$question_number,`right`=$right, date= NOW()  WHERE  email = '$email' AND quiz_id='$quiz_id'")or die('Error28');
    
    } 
    // check if the answer == wrong answer
    else
    {
       // select the wrong answer score
    $quizs=mysqli_query($conn,"SELECT * FROM quizs WHERE quiz_id='$quiz_id' " )or die('Error29');
       // fetch the right answer score
    while($row=mysqli_fetch_array($quizs) )
    {
    $wrongQuizTbl=$row['wrong'];
    $total = $row['total'];
    $rightQuizTbl=$row['right'];
    }
     // inser student information in history table
    if($question_number == 1)
    {
      // if the  student is new
    $history=mysqli_query($conn,"INSERT INTO history VALUES('$email','$quiz_id' ,'0','0','0','0',NOW() )")or die('Error30');
    }
    // if the  student is already exist
    $history=mysqli_query($conn,"SELECT * FROM history WHERE quiz_id='$quiz_id' AND email='$email' " )or die('Error31');
    while($row=mysqli_fetch_array($history) )
    {
    $score=$row['score'];
    $wrong=$row['wrong'];
    }
    $wrong++;
    // $score=$score-$wrongQuizTbl;
    // $score=$score-($rightQuizTbl*$total-$wrongQuizTbl);
    $q=mysqli_query($conn,"UPDATE `history` SET `score`=$score,`noOfQsn`=$question_number,`wrong`=$wrong, date=NOW() WHERE  email = '$email' AND quiz_id = '$quiz_id'")or die('Error32');
    }
   
    if($question_number != $total)
    {
    $question_number++;
     header("location:dashboard.php?q=quiz&step=2&question_id=$question_id&quiz_id=$quiz_id&n=$question_number&t=$total")or die('Error33');
    }
    else if( $_SESSION['email']!='admin99@mail.ru')
    {
    $q1=mysqli_query($conn,"SELECT score FROM history WHERE quiz_id='$quiz_id' AND email='$email'" )or die('Error34');
    while($row=mysqli_fetch_array($q1) )
    {
    $score=$row['score'];
    }
    $q2=mysqli_query($conn,"SELECT * FROM rank WHERE email='$email'" )or die('Error35');
    $rowcount=mysqli_num_rows($q2);
    if($rowcount == 0)
    {
    $q3=mysqli_query($conn,"INSERT INTO rank VALUES('$email','$score',NOW())")or die('Error36');
    }
    else
    {
    while($row=mysqli_fetch_array($q2) )
    {
    $sun=$row['score'];
    }
    $sun=$score+$sun;
    $q5=mysqli_query($conn,"UPDATE `rank` SET `score`=$sun ,time=NOW() WHERE email= '$email'")or die('Error37');
    }
    header("location:dashboard.php?q=result&quiz_id=$quiz_id");
    }
    else
    {
    header("location:dashboard.php?q=result&quiz_id=$quiz_id");
    }
    }
    