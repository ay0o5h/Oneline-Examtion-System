<?php
include_once 'dbConnection.php';

session_start();


$ref = @$_GET['q'];
$errors = array();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // inilize the variabiles
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password = md5($password);

    //    get the data from database
    $sql = mysqli_query($conn, "SELECT * FROM users WHERE email='$email' AND password ='$password'");
    $num = mysqli_num_rows($sql);
    if ($num > 0) {
        $row = mysqli_fetch_array($sql);
        $_SESSION['email'] = $email;
        $_SESSION['user_id'] = $id;
        $_SESSION['role'] = $row['role'];

        $_SESSION["fname"] = $fname;
        //  $verify=password_verify($password ,$row['password']);
        //  if ( $verify ){
        //  check the premsion of the user
        if ($row['role'] == 'student') {

            header("Location:dashboard.php?q=1");
        } else {
            header("Location:admin.php");
        }

        //  }



    }
    //    check if the password incccroct
    else {
        array_push($errors, "Incorrect Password!");
    }
    // elseif($password !== $row['password']) {
    //     array_push($errors,"email or password is incorect");
    //     header('Refresh: 10;url=login.php');
    // }
    //    check if the account exist
    // elseif($email !== $row['email']) {
    //     array_push($errors,"this account not register");
    //     header('Refresh: 3;url=signup.php');
    // }

}
