<?php
session_start();
require_once('include/dbController.php');
$db_handle = new DBController();
date_default_timezone_set("Asia/Hong_Kong");

if (isset($_SESSION['userid'])) {
    $userId = $_SESSION['userid'];
    $fetch_user = $db_handle->runQuery("select * from customer where id = '$userId'");
}
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
    <title>Ichi-Catch - Intro</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
          integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <script src="assets/js/custom.js"></script>
</head>
<body class="home-body">
<div class="navbar">
    <a href="index.php" class="icon"><i class="fa-solid fa-house"></i></a>
    <a href="intro.php" class="icon"><i class="fa-solid fa-magnifying-glass"></i></a>
    <a href="steps.php" class="center-icon"><img src="assets/images/homepage/add-button.png" alt="Icon 3"></a>
    <a href="#" class="icon"><i class="fa-solid fa-gamepad"></i></a>
    <?php if (isset($_SESSION['userid'])) {
        ?>
        <a href="profile.php" class="icon"><i class="fa-solid fa-user"></i></a>
        <?php
    } else {
        ?>
        <a href="login.php" class="icon"><i class="fa-solid fa-user"></i></a>
        <?php
    }?>
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
    <div class="row mt-5 mb-3">
        <div class="col-12 intro-header text-center">
            <h2>Membership Page</h2>
        </div>
    </div>

    <div class="container membership-section">
        <div class="row mt-3">
            <div class="col-12 text-end mt-3">
                <a href="#">MEMBER CARD</a>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-2 side-section">
                <p style="color: #ffffff;">Basic</p>
            </div>
            <div class="col-8">
                <div id="chart"></div>
            </div>
            <div class="col-2 side-section" style="color: #ffffff;">
                <span style="color: #ffb178;">Bronze</span></br>
                50</br>
                Points
            </div>
            <div class="col-12 text-center" style="margin-top: -100px; color: #ffffff; font-family: DMSans-M, sans-serif;">
                <p>Current Points</p>
            </div>
        </div>

        <div class="row text-center second-section">
            <div class="col-6">
                <p>Basic</p>
                <h4>MEMBERSHIP TIER</h4>
            </div>
            <div class="col-6">
                <p>40 <span class="badge text-white">Points</span></p>
                <p style="font-size: 12px">away from reaching bronze tier</p>
            </div>
        </div>
        <div class="row mt-3 text-center membership-title mb-3">
            <div class="col-12">
                <h4>TITLE</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <p class="description">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore
                    et dolore magna aliqua. Quis ipsum suspendisse ultrices gravida. Risus commodo viverra maecenas
                    accumsan lacus vel facilisis. Lorem ipsum dolor sit amet, conse
                    ctetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis
                    ipsum suspendisse ultrices gravida. Risus commodo viverra maecenas accumsan lacus vel
                    facilisis. </p>
            </div>
        </div>
    </div>
    <div class="row before-footer">

    </div>

</div>

<script src='https://code.jquery.com/jquery-3.4.1.min.js'></script>
<script src='https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js'></script>
<script src="assets/js/bootstrap.bundle.min.js"></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/echarts/5.0.2/echarts.min.js'></script>
<script src="assets/js/custom.js"></script>

</body>
</html>