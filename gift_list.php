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
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.1/animate.min.css'><link rel="stylesheet" href="./style.css">
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

<div class="container" style="padding: 20px; margin-top: 80px; margin-bottom: 50px;">
    <?php
    $fetch_gift = $db_handle->runQuery("select * from gift_list");
    $no_fetch_gift = $db_handle->numRows("select * from gift_list");
    $gift = $db_handle->runQuery("select * from gifts");
    $no_gift = $db_handle->numRows("select * from gifts");
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
            <div class="col-2">
                <p><?php echo $fetch_gift[$i]['id'];?></p>
            </div>
            <div class="col-2">
                <p class="text-gift-percent"><?php
                    if($fetch_gift[$i]['id'] == '2'){
                        echo $gift[0]['gift1'];
                    }
                    if($fetch_gift[$i]['id'] == '3'){
                        echo $gift[0]['gift2'];
                    }
                    if($fetch_gift[$i]['id'] == '4'){
                        echo $gift[0]['gift3'];
                    }
                    if($fetch_gift[$i]['id'] == '5'){
                        echo $gift[0]['gift4'];
                    }
                    if($fetch_gift[$i]['id'] == '6'){
                        echo $gift[0]['gift5'];
                    }
                    if($fetch_gift[$i]['id'] == '7'){
                        echo $gift[0]['gift6'];
                    }
                    if($fetch_gift[$i]['id'] == '8'){
                        echo $gift[0]['gift7'];
                    }
                    if($fetch_gift[$i]['id'] == '9'){
                        echo $gift[0]['gift8'];
                    }
                    if($fetch_gift[$i]['id'] == '10'){
                        echo $gift[0]['gift9'];
                    }
                    ?>%</p>
            </div>
        </div>
        <?php
    }
    ?>


</div>
<div id="myModal" class="modal fade" role="dialog" style="background-color: #0000003d !important;">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content" style="background-image: none;">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
            </div>
        </div>
    </div>
</div>

<script src="assets/js/jQuery/jquery-3.6.4.min.js"></script>
<script src="assets/js/toastr/js/toastr.min.js" type="text/javascript"></script>
<script src="assets/js/toastr-init.js" type="text/javascript"></script>
<script src="assets/js/bootstrap.bundle.min.js"></script>
<script>
    $(document).ready(function(){
        $("img").click(function(){
            console.log('Image Clicked');
            var t = $(this).attr("src");
            $(".modal-body").html("<img src='"+t+"' class='modal-img'>");
            $("#myModal").modal('show'); // Use .modal('show') to display the modal
        });
    });
</script>

</body>
</html>