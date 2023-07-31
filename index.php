<?php
session_start();
require_once ('include/dbController.php');
$db_handle = new DBController();
date_default_timezone_set("Asia/Hong_Kong");
if(isset($_POST['login'])){
    $email = $db_handle->checkValue($_POST['email']);
    $password = $db_handle->checkValue($_POST['password']);
    $log_in = $db_handle->runQuery("select * from customer where email = '$email' and password = '$password'");
    $log_in_no = $db_handle->numRows("select * from customer where email = '$email' and password = '$password'");
    if($log_in_no == 1){
        $_SESSION['userid'] = $log_in[0]["id"];
        echo "<script>
                document.cookie = 'alert = 1;';
                window.location.href='home.php';
                </script>";
    } else{
        echo "<script>
                document.cookie = 'alert = 5;';
                window.location.href='index.php';
                </script>";
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="assets/css/bootstrap/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    <title>Ichi-Catch</title>
    <link href="assets/js/toastr/css/toastr.min.css" rel="stylesheet" type="text/css"/>
    <script src="assets/js/custom.js"></script>
</head>
<body class="login-body">
<section class="login-logo">
    <div class="container">
        <div class="row flex align-items-center justify-content-center">
            <div class="col-6">
                <img src="assets/images/login/logo.webp" class="img-fluid" alt="logo">
            </div>
        </div>
        <div class="row text-center mb-3">
            <h1 class="login-heading mt-3">ICHI - CATCHER</h1>
        </div>

        <form class="login-form" action="#" method="post">
            <div class="mb-3">
                <input type="text" class="form-control" aria-describedby="emailHelp" placeholder="Email or Usename" name="email">
            </div>
            <div class="mb-3">
                <input type="password" class="form-control" aria-describedby="emailHelp" name="password">
            </div>
            <div class="row">
                <button type="submit" class="btn" name="login"><img src="assets/images/login/login-button.webp" class="img-fluid">
                </button>
            </div>
            <div class="row text-center mt-3">
                <p class="forget-pass">Forget Password</p>
            </div>
            <div class="row text-center mt-3">
                <div class="horizontal-lines">
                    <span class="line"></span>
                    <span class="or-text">OR</span>
                    <span class="line"></span>
                </div>
            </div>
            <div class="row mt-3">
                <button type="submit" class="btn"><img src="assets/images/login/create-account.webp" class="img-fluid">
                </button>
            </div>
        </form>
    </div>

</section>

<script src="assets/js/jQuery/jquery-3.6.4.min.js"></script>
<script src="assets/js/toastr/js/toastr.min.js" type="text/javascript"></script>
<script src="assets/js/toastr-init.js" type="text/javascript"></script>
<script src="assets/js/bootstrap.bundle.min.js"></script>



</body>
</html>