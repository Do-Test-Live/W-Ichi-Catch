<?php
session_start();
require_once('include/dbController.php');
$db_handle = new DBController();
date_default_timezone_set("Asia/Hong_Kong");

if (isset($_SESSION['userid'])) {
    $userId = $_SESSION['userid'];
    $fetch_user = $db_handle->runQuery("select * from customer where id = '$userId'");
}

$fetch_pro = $db_handle->runQuery("SELECT * FROM `gifts`");


$data = ['ipad']; // Initialize the array with 'ipad'
$fetch_gift = $db_handle->runQuery("SELECT * FROM gift_list");
$no_fetch_gift = $db_handle->numRows("SELECT * FROM gift_list");

for ($i = 0; $i < $no_fetch_gift; $i++) {
    $data[] = $fetch_gift[$i]['gift_title']; // Add other values to the array
    $image[] = $fetch_gift[$i]['gift_image'];
}

// Use the $data array directly
$commaSeparated = $data;
$images = $image;

// Convert the PHP array to JSON format
$data_json = json_encode($commaSeparated);
$gift_image = json_encode($images);


if (isset($_GET['payment'])) {
    if ($_GET['payment'] == 'alipay') {
    }
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
    <title>Ichi-Catch - Home</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
          integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <link href="assets/js/toastr/css/toastr.min.css" rel="stylesheet" type="text/css"/>
    <script src="assets/js/custom.js"></script>
    <style>
        .card {
            margin: 5%;
            flex-direction: row;
        }

        .card-body {
            padding: 0.5em 1em;
        }

        .card1.card img {
            max-width: 6em;
            height: 100%;
            border-bottom-left-radius: calc(0.25rem - 1px);
            border-top-left-radius: calc(0.25rem - 1px);
            margin-right: 22px;
        }
    </style>
</head>
<body class="home-gift">
<div class="navbar">
    <a href="index.php" class="icon"><i class="fa-solid fa-house"></i></a>
    <a href="intro.html" class="icon"><i class="fa-solid fa-magnifying-glass"></i></a>
    <a href="steps.html" class="center-icon"><img src="assets/images/homepage/add-button.png" alt="Icon 3"></a>
    <a href="membership.html" class="icon"><i class="fa-solid fa-gamepad"></i></a>
    <a href="login.php" class="icon"><i class="fa-solid fa-user"></i></a>
</div>

<div class="container" style="padding: 20px; margin-top: 80px; margin-bottom: 50px;">
    <?php
    $fetch_gift = $db_handle->runQuery("select * from gift_list");
    $no_fetch_gift = $db_handle->numRows("select * from gift_list");
    for ($i = 0; $i < $no_fetch_gift; $i++) {
        ?>
        <div class="row d-flex align-items-center justify-content-center text-center">
            <div class="col-4">
                <p class="text-gift-name"><?php echo $fetch_gift[$i]['gift_title']; ?></p>
            </div>
            <div class="col-4">
                <img src="https://ichi-catcher.com/shop/admin/<?php echo $fetch_gift[$i]['gift_image']; ?>"
                     style="width: 100px">
            </div>
            <div class="col-4">
                <p class="text-gift-percent"><?php echo $fetch_gift[$i]['percent']; ?>%</p>
            </div>
        </div>
        <?php
    }
    ?>


</div>


<script src="assets/js/jQuery/jquery-3.6.4.min.js"></script>
<script src="assets/js/toastr/js/toastr.min.js" type="text/javascript"></script>
<script src="assets/js/toastr-init.js" type="text/javascript"></script>
<script src="assets/js/bootstrap.bundle.min.js"></script>


</body>
</html>