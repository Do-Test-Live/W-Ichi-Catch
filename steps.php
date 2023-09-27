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
    <div class="row mt-5">
        <div class="col-12 intro-header text-center">
            <h2>夾熊仔玩法</h2>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <img src="assets/images/steps/content.webp" alt="" class="img-fluid">
        </div>
    </div>
    <div class="row before-footer">

    </div>

</div>


<script src="assets/js/bootstrap.bundle.min.js"></script>

</body>
</html>