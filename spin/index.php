<?php
require_once ('../include/dbController.php');
$db_handle = new DBController();
date_default_timezone_set("Asia/Hong_Kong");

$fetch_pro = $db_handle->runQuery("SELECT * FROM `gifts`");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lucky Draw</title>
    <link rel="stylesheet" href="./style.css">

</head>
<body>
<!-- partial:index.partial.html -->
<html>
<body>
<!--block-->

<!--block-->

<div style="text-align:center;width:500px;height:400px;margin:0 auto;padding: 30px;-webkit-background-size:500px 500px;  ">

    <div class="square border" id="id1" data-probability="<?php echo $fetch_pro[0]['gift1'];?>">
        <div class="textArea">choose Me</div>
        <div class="textArea">I am gift.</div>
    </div>
    <div class="square border" data-probability="<?php echo $fetch_pro[0]['gift2'];?>">
        <div class="textArea">choose Me</div>
        <div class="textArea">I am gift.</div>
    </div>
    <div class="square border" data-probability="<?php echo $fetch_pro[0]['gift3'];?>">
        <div class="textArea">choose Me</div>
        <div class="textArea">I am gift.</div>
    </div>
    <div class="square border" data-probability="<?php echo $fetch_pro[0]['gift4'];?>">
        <div class="textArea">choose Me</div>
        <div class="textArea">I am gift.</div>
    </div>
    <div class="square border" data-probability="<?php echo $fetch_pro[0]['gift5'];?>">
        <div class="textArea">choose Me</div>
        <div class="textArea">I am gift.</div>
    </div>
    <div class="square border" data-probability="<?php echo $fetch_pro[0]['gift6'];?>">
        <div class="textArea">choose Me</div>
        <div class="textArea">I am gift.</div>
    </div>
    <div class="square border" data-probability="<?php echo $fetch_pro[0]['gift7'];?>">
        <div class="textArea">choose Me</div>
        <div class="textArea">I am gift.</div>
    </div>
    <div class="square border" data-probability="<?php echo $fetch_pro[0]['gift8'];?>">
        <div class="textArea">choose Me</div>
        <div class="textArea">I am gift.</div>
    </div>
    <div class="square border" data-probability="<?php echo $fetch_pro[0]['gift9'];?>">
        <div class="textArea">choose Me</div>
        <div class="textArea">I am gift.</div>
    </div>

    <div id="drawContent"></div>
</div>


<div style="text-align: center;">
    <div id="drawTitle">Click the Button to start</div>
    <div class="buttonDiv">
        <span id="playbutton">Start</span>
    </div>
</div>
</body>
</html>
<!-- partial -->
<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js'></script>
<script src="./script.js"></script>

</body>
</html>
