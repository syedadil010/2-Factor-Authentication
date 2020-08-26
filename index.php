<?php

// Start Session
session_start();

// Load PHP files for Database connection
require 'db_connection.php';
$db = DB();

// Load the operation implementations ( i.e., Operation class )
require 'operation.php';
$app = new Operation($db);

$login_error_message = '';

// check Login request
if (!empty($_POST['btnLogin'])) {

    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if ($username == "") {
        $login_error_message = 'Username field is required!';
    } else if ($password == "") {
        $login_error_message = 'Password field is required!';
    } else {
        $user_id = $app->Login($username, $password); // check user login
        if($user_id > 0)
        {
            $_SESSION['user_id'] = $user_id; // Set Session
            $login_otp = rand(100000,999999); //generate random OTP
            $_SESSION['otp'] = $login_otp;
            
            //Send OTP in mail using PHPMailer library
            require_once("mail_function.php");
            $mail_status = sendOTP($username,$login_otp);

            header("Location: validate_login.php"); // Redirect user to validate auth code
        }
        else
        {
            $login_error_message = 'Invalid login details!';
        }
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" 
href=https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css >
</head>
<body>

    <div class="container">
     <div class="col-md-12">
      <h2> Login Two factor authentication </h2>
     </div>
     <div class="row">
      <div class="col-md-5 col-md-offset-3 well">
       <h4>Login</h4>
        <?php
        if ($login_error_message != "") {
            echo '<div class="alert alert-danger"><strong>Error: </strong> ' . $login_error_message . '</div>';
        }
        ?>
        <form action="index.php" method="post">
            <div class="form-group">
                <label for="">Username/Email</label>
                <input type="text" name="username" class="form-control"/>
            </div>
            <div class="form-group">
                <label for="">Password</label>
                <input type="password" name="password" class="form-control"/>
            </div>
            <div class="form-group">
                <input type="submit" name="btnLogin" class="btn btn-primary" value="Login"/>
            </div>
        </form>
        <div class="form-group">
            Not Registered Yet? <a href="registration.php">Register Here</a>
        </div>
       </div>
      </div>
    </div>

</body>
</html>

