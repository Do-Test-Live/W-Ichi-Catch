<?php
session_start();
require_once ('include/dbController.php');
$db_handle = new DBController();
date_default_timezone_set("Asia/Hong_Kong");
if(isset($_POST['signup'])){
    $name = $db_handle->checkValue($_POST['name']);
    $email = $db_handle->checkValue(strtolower($_POST['email']));
    $number = $db_handle->checkValue($_POST['number']);
    $password = $db_handle->checkValue($_POST['password']);
    $inserted_at = date("Y-m-d H:i:s");

    $check_customer = $db_handle->numRows("select * from customer where email = '$email'");

    if($check_customer == 0){
        $add_customer = $db_handle->insertQuery("INSERT INTO `customer`(`customer_name`, `email`, `number`, `password`, `inserted_at`) VALUES ('$name','$email','$number','$password','$inserted_at')");

        if($add_customer){
            $fetch_customer = $db_handle->runQuery("select * from customer order by id desc limit 1");
            session_start();
            $_SESSION['userid'] = $fetch_customer[0]['id'];
            echo "
        <script>
        alert('Account Created Successfully!');
        window.location.href = 'index.php';
</script>
        ";
        }
    } else{
        echo "
        <script>
        alert('Sorry! This email is already registered');
        window.location.href = 'signup.php';
</script>
        ";
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
                <input type="text" class="form-control" aria-describedby="emailHelp" placeholder="Full Name" name="name" required>
            </div>
            <div class="mb-3">
                <input type="text" class="form-control" aria-describedby="emailHelp" placeholder="Email" name="email" required>
            </div>
            <div class="mb-3">
                <input type="text" class="form-control" aria-describedby="emailHelp" placeholder="Contact Number" name="number" required>
            </div>
            <div class="mb-3">
                <input type="password" class="form-control" aria-describedby="emailHelp" name="password" placeholder="Password" required>
            </div>
            <div class="mb-3">
                <input class="form-check-input" style="padding: 7px;" type="checkbox" value="" id="flexCheckChecked" required>
                <label class="form-check-label" for="flexCheckChecked">
                    <a href="terms.php" style="text-decoration: none; color: #fff; font-weight: bold;">我已閱讀並同意使用者協議</a>
                </label>
            </div>
            <div class="row mt-3">
                <button type="submit" name="signup" class="btn"><img src="assets/images/login/create-account.webp" class="img-fluid">
                </button>
            </div>
            <div class="row text-center mt-3">
                <div class="horizontal-lines">
                    <span class="line"></span>
                    <span class="or-text">OR</span>
                    <span class="line"></span>
                </div>
            </div>
            <div class="row">
                <a href="login.php" class="btn" name="login"><img src="assets/images/login/login-button.webp" class="img-fluid">
                </a>
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