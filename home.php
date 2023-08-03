<?php
session_start();
require_once('include/dbController.php');
$db_handle = new DBController();
date_default_timezone_set("Asia/Hong_Kong");
if (!isset($_SESSION['userid'])) {
    header("Location: index.php");
}
$userId = $_SESSION['userid'];

$fetch_user = $db_handle->runQuery("select * from customer where id = '$userId'");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="assets/css/bootstrap/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    <title>Ichi-Catch - Home</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
          integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <link href="assets/js/toastr/css/toastr.min.css" rel="stylesheet" type="text/css"/>
    <script src="assets/js/custom.js"></script>
</head>
<body class="home-body">
<div class="navbar">
    <a href="home.html" class="icon"><i class="fa-solid fa-house"></i></a>
    <a href="intro.html" class="icon"><i class="fa-solid fa-magnifying-glass"></i></a>
    <a href="steps.html" class="center-icon"><img src="assets/images/homepage/add-button.png" alt="Icon 3"></a>
    <a href="membership.html" class="icon"><i class="fa-solid fa-gamepad"></i></a>
    <a href="index.html" class="icon"><i class="fa-solid fa-user"></i></a>
</div>

<div class="container-fluid">
    <div class="row mt-3 mb-3 head-banner p-2 flex align-items-center justify-content-center">
        <div class="col-2">
            <img src="assets/images/homepage/Logo.webp" class="img-fluid">
        </div>
        <div class="col-8 ps-3 pe-3">
            <img src="assets/images/homepage/ichi-chatcher.webp" class="img-fluid">
        </div>
        <div class="col-1">
            <img src="assets/images/homepage/imformation.webp" style="width: 20px">
        </div>
        <div class="col-1">
            <img src="assets/images/homepage/bell.webp" style="width: 20px">
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <img src="assets/images/homepage/img01.png" class="img-fluid">
        </div>
    </div>
    <div class="row flex align-items-center justify-content-center" style="margin-top: -90px;">
        <button class="btn grab-btn"></button>
    </div>
    <div class="container home-text-section mt-3 pt-5 pb-5">
        <div class="col-12">
            <h2>Lorem ipsum dolor</h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et
                dolore magna aliqua. Quis ipsum suspendisse ultrices gravida. Risus commodo viverra maecenas accumsan
                lacus vel facilisis. </p>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et
                dolore magna aliqua. Quis ipsum suspendisse ultrices gravida. Risus commodo viverra maecenas </p>
        </div>
    </div>
    <div class="row before-footer">

    </div>

</div>

<script src="assets/js/jQuery/jquery-3.6.4.min.js"></script>
<script src="assets/js/toastr/js/toastr.min.js" type="text/javascript"></script>
<script src="assets/js/toastr-init.js" type="text/javascript"></script>
<script src="assets/js/bootstrap.bundle.min.js"></script>

</body>
</html>