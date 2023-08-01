<?php
session_start();
require_once ('include/dbController.php');
$db_handle = new DBController();
date_default_timezone_set("Asia/Hong_Kong");
if(isset($_SESSION['userid'])){
    $userid = $_SESSION['userid'];
}
if(isset($_POST['update_pass'])){
    $password = $db_handle->checkValue($_POST['password']);
    $update_pass = $db_handle->insertQuery("UPDATE `customer` SET `password` = '$password' WHERE id = '$userid'");
    if($update_pass){
        echo "<script>
                alert('Password updated successfully!');
                window.location.href='home.php';
                </script>";
    } else{
        session_destroy();
        session_unset();
        echo "<script>
                alert('Something went wrong!');
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
                <input type="password" class="form-control" aria-describedby="emailHelp" name="password">
            </div>
            <div class="row">
                <button type="submit" class="btn" name="update_pass"><img src="assets/images/up-button.png" class="img-fluid">
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