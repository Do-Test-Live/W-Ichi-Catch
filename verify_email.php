<?php
session_start();
require_once ('include/dbController.php');
$db_handle = new DBController();
date_default_timezone_set("Asia/Hong_Kong");
if(isset($_POST['verify_email'])){
    $vcode = $db_handle->checkValue(strtolower($_POST['vcode']));
    $email = $_GET['email'];
    $verification = $_SESSION['vcode'];

    if($vcode == $verification){
        session_destroy();
        session_unset();
        $fetch_customer = $db_handle -> runQuery("select * from customer where email = '$email'");
        session_start();
        $_SESSION['userid'] = $fetch_customer [0]["id"];
        echo "<script>
                alert('Please set a new password to continue your session!');
                window.location.href='setpass.php';
                </script>";
    } else{
        echo "<script>
                alert('Sorry! Can not verify your email.);
                window.location.href='forgetpass.php';
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
                <input type="text" class="form-control" aria-describedby="emailHelp" placeholder="6 digit code" name="vcode">
            </div>
            <div class="row">
                <button type="submit" class="btn" name="verify_email"><img src="assets/images/ve-button.png" class="img-fluid">
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