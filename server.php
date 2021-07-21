<?php
include_once 'dbConnection.php';


session_start();

$pattern = "^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^";
$errors = array();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // inilize the variabiles
  $fname = $_POST['fname'];
  $lname = $_POST['lname'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $rpassword = $_POST['rpassword'];


  // validation of fildes
  if (!preg_match("/^[a-zA-z]*$/", $fname)) {
    array_push($errors, "Only alphabets and whitespace are allowed.");
  } elseif (!preg_match("/^[a-zA-z]*$/", $lname)) {
    array_push($errors, "Only alphabets and whitespace are allowed.");
  } elseif (!preg_match($pattern, $email)) {
    array_push($errors, "Email is not valid.");
  } elseif (!preg_match("/^.*(?=.{8,12})(?=.*\d)(?=.*[a-zA-Z]).*$/", $password)) {
    array_push($errors, "Password must have at least one number and oneone upper or lower case and be at least 8 characters");
  } elseif ($password != $rpassword) {
    array_push($errors, "password not match");
  }

  //  check if there is no error to send information to database
  if (count($errors) == 0) {
    $password = md5($password);
    // $password=password_hash($password, PASSWORD_DEFAULT);
    //  check if the account already exist
    $sqlCheck = mysqli_query($conn, "SELECT * FROM users WHERE email='$email' ");
    $num = mysqli_num_rows($sqlCheck);
    if ($num > 0) {
      array_push($errors, "account already exist");;
      header('Refresh: 3;url=login.php');
    } else {
      // insert the information of the new account
      $sqlInsert = mysqli_query($conn, "INSERT INTO users ( fname,lname, email, password,role) VALUES ('$fname','$lname','$email','$password','student')");
      $_SESSION['email'] = $email;
      header("location:dashboard.php?q=1");
    }
  }
}
