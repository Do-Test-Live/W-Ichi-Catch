<?php
require 'PHPMailer.php';
require 'SMTP.php';


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
$mail = new PHPMailer();

session_start();
require_once ('include/dbController.php');
$db_handle = new DBController();
date_default_timezone_set("Asia/Hong_Kong");
if(isset($_POST['verify'])){
    $email = $db_handle->checkValue(strtolower($_POST['email']));
    $check_customer = $db_handle->numRows("select * from customer where email = '$email'");
if($check_customer == 1){
    function generateVerificationCode() {
        // Define the character set for the verification code
        $charset = '0123456789';
        $code_length = 6;
        $code = '';

        // Generate the verification code
        for ($i = 0; $i < $code_length; $i++) {
            $random_index = rand(0, strlen($charset) - 1);
            $code .= $charset[$random_index];
        }

        return $code;
    }
    $verification_code = generateVerificationCode();
    $_SESSION['vcode'] = $verification_code;
    $email_to = $email;
    $mail->isSMTP();
    $mail->Host = 'mail.ngt.hk';  // Specify your SMTP server
    $mail->SMTPAuth = true;
    $mail->Username = 'ichicatcher@ngt.hk';
    $mail->Password = '2K%Iw$^)fb18';
    $mail->Port = 465;  // Specify the SMTP port
    $mail->SMTPSecure = 'ssl';  // Enable encryption, 'ssl' also possible

    // Email content
    $mail->setFrom('verify@ichi-catcher.com', 'Ichi Catcher');
    $mail->addAddress($email_to);  // Add recipient email
    $mail->Subject = 'Verify your email.';
    $mail->isHTML(true);
    $mail->Body = "
            <html>
                <body style='background-color: #eee; font-size: 16px;'>
                <div style='max-width: 600px; min-width: 200px; background-color: #ffffff; padding: 20px; margin: auto;'>
                
                    <p style='text-align: center;color:green;font-weight:bold'>Thank you for reaching out to us!</p>
                
                    <p style='color:black;text-align: center'>
                        6 digit authentication code for your email verification is: <strong>$verification_code</strong>
                    </p>
                </div>
                </body>
            </html>";

    // Send the email
    if ($mail->send()) {
        echo "<script>
alert('An email with verification code has sent to your email');
window.location.href = 'verify_email.php?email=$email';
</script>";
        exit;
    } else {
        echo "Something went wrong: " . $mail->ErrorInfo;
    }
} else{
    echo "<script>
alert('Sorry! This email is not found in our server');
window.location.href = 'forgetpass.php';
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
                <input type="text" class="form-control" aria-describedby="emailHelp" placeholder="Email or Usename" name="email" required>
            </div>
            <div class="row">
                <button type="submit" class="btn" name="verify"><img src="assets/images/svc-button.png" class="img-fluid">
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