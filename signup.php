<?php include('server.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet"  href="./css/bootstrap.min.css" >
    <link rel="stylesheet"  href="./css/style.css" >
    <title>onlineExam</title>
    <link rel="icon" type="text/icon" href="./images/logo.png">
</head>
<body>
    <!-- navbar -->
    <nav class="navbar navbar-light ">
        <div class="container-fluid">
          <a class="navbar-brand" href="index.php">
              <img src="./images/pic1.png" height="80px"/>
          </a>
          <form class="d-flex">
            <a href="login.php" class="btn btn-outline-info" >login</a>
          </form>
        </div>
      </nav>
   <!-- main -->
   <div class="main">
       <div class="container">
           <div class="row">
               <div class="col-sm-6">
               <form action="signup.php" method="post">
                   <?php include('errors.php'); ?>
            <label for="fname">first name</label>
            <input type="text" id="name" name="fname"
            required placeholder="enter your first name" />
           <i class="fa fa-user"></i>
          
            <label for="lname">last name</label>
            <input type="text" id="lname" name="lname" <?php echo $_SESSION['lname'];?>
             required   placeholder="enter your last name" />
            <i class="fa fa-user"></i>
            <label for="email">E-mail</label>
            <input type="email" id="email" name="email" <?php echo $_POST['email'];?>
             required  placeholder="enter your e-mail" />
            <i class="fa fa-envelope"></i>
            <label for="password">password</label>
            <input type="password" id="password" name="password" <?php echo $_POST['password'];?>
             required  placeholder="enter your password" />
            <i class="fa fa-lock"></i>
            <label for="rpassword">confirm your password</label>
            <input type="password" id="rpassword" name="rpassword" <?php echo $_POST['rpassword'];?>
              required  placeholder="confirm your password" />
            <i class="fa fa-lock"></i>
            <br>
         
            <button class="signup" name="signup"  >signup</button>
               </form>
                 </div>
               <div class="col-sm-6">
                   <img src="./images/pic2.png" width="100%">
               </div>
           </div>
       </div>
   </div>
   <script src="./js/main.js" ></script>
  <script src="./js/bootstrap.min.js"></script>
</body>
</html>