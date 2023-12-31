<?php
session_start();
require_once('include/dbController.php');
$db_handle = new DBController();
date_default_timezone_set("Asia/Hong_Kong");

if (isset($_SESSION['userid'])) {
    $userId = $_SESSION['userid'];
    $fetch_user = $db_handle->runQuery("select * from customer where id = '$userId'");
}?>
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
            <h2>INTRODUCTION</h2>
        </div>
    </div>
    <div class="container intro-text-section mt-3 pt-5 pb-5">
        <div class="col-12">
            <h4>Ichi-Catcher</h4>
            <p>歡迎來到Ichi-Catcher -
                首個線上抽夾公仔的奇妙世界！這是一種刺激又令人著迷的抽獎體驗，讓你有機會抽取到各種驚喜模型和產品。不同於傳統的夾公仔購買方式，線上抽「夾公仔」遊戲讓你隨時隨地參與，無需等待排隊或走遍商店。 </p>
            <p>這個遊戲的玩法非常簡單，首先，前往夾公仔頁面。然後，你只需購買相應的金幣，這比起傳統購買夾公仔的價格更經濟實惠。完成支付後，簡單點擊抽獎按鈕，等待結果揭曉。 </p>
            <p>你有機會抽到超稀有的限量版模型或心儀已久的產品，也可能會獲得一些精美的收藏品或實用的日常用品。每次抽獎都像是在參與一場充滿未知的冒險，讓人心跳不已。</p>
            <p>值得一提的是，Ichi-Catcher強調公平性，每位參與者都有均等的機會獲得稀有物品，避免了一些傳統抽獎方式中的不公現象。</p>
            <p>成為Ichi-Catcher，你可以盡情期待、感受幸運，並有機會收穫那些令人心動的模型和產品。快來參與其中，開啟屬於你的抽獎之旅吧！</p>
        </div>
    </div>
    <div class="row before-footer">

    </div>

</div>


<script src="assets/js/bootstrap.bundle.min.js"></script>

</body>
</html>