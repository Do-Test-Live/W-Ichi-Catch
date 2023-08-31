<?php
session_start();
require_once('include/dbController.php');
$db_handle = new DBController();
date_default_timezone_set("Asia/Hong_Kong");

if(isset($_SESSION['userid'])){
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
<body class="home-body">
<div class="navbar">
    <a href="home.php" class="icon"><i class="fa-solid fa-house"></i></a>
    <a href="intro.html" class="icon"><i class="fa-solid fa-magnifying-glass"></i></a>
    <a href="steps.html" class="center-icon"><img src="assets/images/homepage/add-button.png" alt="Icon 3"></a>
    <a href="membership.html" class="icon"><i class="fa-solid fa-gamepad"></i></a>
    <a href="index.php" class="icon"><i class="fa-solid fa-user"></i></a>
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
    <div class="mx-auto text-center mt-5" style="max-width: 550px; display: none;">
        <div class="square border" data-probability="<?php echo (float)($fetch_pro[0]['gift1']/100); ?>" id="id1">
            <div class="textArea">Choose Me</div>
            <div class="textArea2">Gift 1</div>
        </div>
        <div class="square border" data-probability="<?php echo (float)($fetch_pro[0]['gift2']/100); ?>">
            <div class="textArea">Choose Me</div>
            <div class="textArea2">Gift 2</div>
        </div>
        <div class="square border" data-probability="<?php echo (float)($fetch_pro[0]['gift3']/100); ?>">
            <div class="textArea">Choose Me</div>
            <div class="textArea2">Gift 3</div>
        </div>
        <div class="square border" data-probability="<?php echo (float)($fetch_pro[0]['gift4']/100); ?>">
            <div class="textArea">Choose Me</div>
            <div class="textArea2">Gift 4</div>
        </div>
        <div class="square border" data-probability="<?php echo (float)($fetch_pro[0]['gift5']/100); ?>">
            <div class="textArea">Choose Me</div>
            <div class="textArea2">Gift 5</div>
        </div>
        <div class="square border" data-probability="<?php echo (float)($fetch_pro[0]['gift6']/100); ?>">
            <div class="textArea">Choose Me</div>
            <div class="textArea2">Gift 6</div>
        </div>
        <div class="square border" data-probability="<?php echo (float)($fetch_pro[0]['gift7']/100); ?>">
            <div class="textArea">Choose Me</div>
            <div class="textArea2">Gift 7</div>
        </div>
        <div class="square border" data-probability="<?php echo (float)($fetch_pro[0]['gift8']/100); ?>">
            <div class="textArea">Choose Me</div>
            <div class="textArea2">Gift 8</div>
        </div>
        <div class="square border" data-probability="<?php echo (float)($fetch_pro[0]['gift9']/100); ?>">
            <div class="textArea">Choose Me</div>
            <div class="textArea2">Gift 9</div>
        </div>

        <div id="drawContent"></div>
    </div>
    <div class="row flex align-items-center justify-content-center" style="margin-top: -150px;">
        <button class="btn grab-btn" id="playbutton">GRAB</button>
    </div>
    <div class="row flex align-items-center justify-content-center" style="margin-top: -90px;">
        <button class="btn grab" id="grab-value"><?php
            if(isset($_SESSION['userid'])){
                $fetch_grab = $db_handle->runQuery("SELECT * FROM `grab` WHERE customer_id = '$userId'");
                $no_fetch_grab = $db_handle->numRows("SELECT * FROM `grab` WHERE customer_id = '$userId'");
                if($no_fetch_grab > 0)
                echo $fetch_grab[0]['grab'];
                else
                    echo '00';
            } else echo '00';
            ?></button>
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

</div>



<div class="container-fluid mt-5 price-section">
    <div class="row text-center pt-3">
        <img class="img-fluid" src="assets/images/price/title.webp">
    </div>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <a href="payment.php?price=39.99" style="text-decoration: none;">
                    <div class="card1 card align-items-center" style="max-width: 540px;">
                        <div class="card-body">
                            <h5 class="price-quantity">5 夾</h5>
                            <p class="price-details">HK$ 39.99</p>
                        </div>
                        <img src="assets/images/price/1.webp" alt="">
                    </div>
                </a>
            </div>
            <div class="col-12">
                <a href="payment.php?price=69.99" style="text-decoration: none;">
                    <div class="card1 card align-items-center" style="max-width: 540px;">
                        <div class="card-body">
                            <h5 class="price-quantity">10 夾</h5>
                            <p class="price-details">HK$ 69.99</p>
                        </div>
                        <img src="assets/images/price/2.webp" alt="">
                    </div>
                </a>
            </div>
            <div class="col-12">
                <a href="payment.php?price=179.99" style="text-decoration: none;">
                    <div class="card1 card align-items-center" style="max-width: 540px;">
                        <div class="card-body">
                            <h5 class="price-quantity">30 夾</h5>
                            <p class="price-details">HK$ 179.99</p>
                        </div>
                        <img src="assets/images/price/3.webp" alt="">
                    </div>
                </a>
            </div>
            <div class="col-12">
                <a href="payment.php?price=249.99" style="text-decoration: none;">
                    <div class="card1 card align-items-center" style="max-width: 540px;">
                        <div class="card-body">
                            <h5 class="price-quantity">50 夾</h5>
                            <p class="price-details">HK$ 249.99</p>
                        </div>
                        <img src="assets/images/price/4.webp" alt="">
                    </div>
                </a>
            </div>
        </div>
    </div>
    <div class="row before-footer">

    </div>
</div>
<div class="modal" tabindex="-1" id="modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content d-flex align-items-center justify-content-center">
            <div class="modal-body text-center" style="margin-top: 200px;">
                <h4 class="text-white" id="gift-name" style="font-family: Xxx, sans-serif"></h4>
                <img src="" alt="Winning Prize" style="height: 250px; width: 250px;" id="gift-image">
                <div class="row mt-5">
                    <div class="col-12">
                        <button type="button" class="btn grab-btn" id="claim">Claim</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script src="assets/js/jQuery/jquery-3.6.4.min.js"></script>
<script src="assets/js/toastr/js/toastr.min.js" type="text/javascript"></script>
<script src="assets/js/toastr-init.js" type="text/javascript"></script>
<script src="assets/js/bootstrap.bundle.min.js"></script>

<script>
    var data = <?php echo $data_json; ?>;
    let image = <?php echo $gift_image;?>;
    console.log (image);
    var selectedDataValue = -1;
    const slices = document.getElementsByClassName('square');

    for (i = 0; i < data.length; i++) {
        $(".square:nth-child(" + (i + 1) + ") .textArea").text(data[i]);
    }

    var timer = null;
    playbutton.onclick = playRandom;

    function playRandom() {
        var playbutton = document.getElementById('playbutton');
        clearInterval(timer);

        timer = setInterval(function () {
            let totalProbability = 0;

            for (let i = 0; i < slices.length; i++) {
                const probability = parseFloat(slices[i].getAttribute('data-probability'));
                totalProbability += probability;
            }

            const random = Math.random() * totalProbability;
            let accumulatedProbability = 0;
            let selectedIndex = -1;

            for (let i = 0; i < slices.length; i++) {
                const probability = parseFloat(slices[i].getAttribute('data-probability'));
                accumulatedProbability += probability;
                if (random <= accumulatedProbability) {
                    selectedIndex = i;
                    break;
                }
            }

            selectedDataValue = selectedIndex + 1; // Store selected index
            $(".square").css("background", "#f58879"); // Reset all backgrounds
            $(".square:nth-child(" + (selectedIndex + 1) + ")").css("background", "#ffd386");
            playbutton.style.background = '#989898';
            playbutton.innerText = 'Loading';
        }, 30);

        playbutton.style.background = '#ff9342';
        playbutton.innerText = 'GRAB';

        setTimeout(function () {
            stopFun();
        }, 2000);
    }

    function stopFun() {
        clearInterval(timer);
        var modal = document.getElementById('modal');
        var claim = document.getElementById('claim');
        var point = document.getElementById('grab-value');
        var giftName = document.getElementById('gift-name');
        var giftImage = document.getElementById('gift-image');
        let no = point.innerText;
        no -= 1;
        point.innerText = no;
        modal.style.display = 'block';
        var playbutton = document.getElementById('playbutton');
        playbutton.style.background = '#ff9342';
        playbutton.innerText = 'GRAB';

        if (selectedDataValue !== -1) {
            console.log("Selected value:", data[selectedDataValue]); // Corrected index
            giftName.innerText = data[selectedDataValue]; // Corrected index
            giftImage.src = 'https://ichi-catcher.com/admin/' + image[selectedDataValue - 1]; // Corrected index
            console.log(image[selectedDataValue - 1]); // Corrected index
        } else {
            console.log("No value selected.");
        }


        claim.onclick = function() {
            modal.style.display = 'none';
        };
    }
</script>


</body>
</html>