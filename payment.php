<?php
session_start();
require 'PHPMailer.php';
require 'SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
$mail = new PHPMailer();

require_once("include/dbController.php");
$db_handle = new DBController();
date_default_timezone_set("Asia/Hong_Kong");
$customer_id = 0;
if (isset($_SESSION['userid'])) {
    $customer_id = $_SESSION['userid'];
} else{
    echo "
    <script>
    window.location.href = 'login.php';
</script>";
}

if(isset($_POST['place_order'])){
    $amount = $db_handle->checkValue($_POST['amount']);
    $payment = $db_handle->checkValue($_POST['payment']);
    $inserted_at = date("Y-m-d H:i:s");

    $insert = $db_handle->insertQuery("INSERT INTO `payment_details`(`payment_method`, `amount`, `customer_id`, `inserted_at`) VALUES ('$payment','$amount','$customer_id','$inserted_at')");
    if($insert){
        $fetch_customer = $db_handle->runQuery("select * from customer where id = '$customer_id'");
        $email = $fetch_customer[0]['email'];
        $customer_name = $fetch_customer[0]['customer_name'];
        $email_to = 'ichi.catcher@gmail.com';
        $email_cc = 'mingowhk@gmail.com'; // Add the additional recipient email here

        $mail->isSMTP();
        $mail->Host = 'mail.ichi-catcher.com';  // Specify your SMTP server
        $mail->SMTPAuth = true;
        $mail->Username = 'info@ichi-catcher.com';
        $mail->Password = '1@r;1:2|?(3q';
        $mail->Port = 465;  // Specify the SMTP port
        $mail->SMTPSecure = 'ssl';  // Enable encryption, 'ssl' also possible

// Email content
        $mail->setFrom('info@ichi-catcher.com', 'Ichi Catcher');
        $mail->addAddress($email_to);
        $mail->addAddress($email_cc);
        $mail->Subject = 'New Payment Request';
        $mail->isHTML(true);
        $mail->Body = "
    <html>
        <body style='background-color: #eee; font-size: 16px;'>
        <div style='max-width: 600px; min-width: 200px; background-color: #ffffff; padding: 20px; margin: auto;'>
        
            <p style='text-align: center;color:green;font-weight:bold'>A new payment request has just arrived.</p>
        
            <p style='color:black;text-align: center'>
                Customer Name: <strong>$customer_name</strong>
            </p>
            <p style='color:black;text-align: center'>
                Customer Email: <strong>$email;</strong>
            </p>
            <p style='color:black;text-align: center'>
                Amount: <strong>$amount;</strong>
            </p>
            <p style='color:black;text-align: center'>
                Payment Method: <strong>$payment;</strong>
            </p>
        </div>
        </body>
    </html>";

// Send the email
        if ($mail->send()) {
            echo "
    <script>
     console.log('Email sent successfully');
    </script>
    ";
        }
        if($payment == 'payme'){
            echo "<script>
                window.location.href='https://payme.hsbc/ichicatcher';
                </script>";
        } if ($payment == 'fps'){
            echo "
            <script>
            document.cookie = 'alert = 3;';
            window.location.href = 'index.php?payment=fps';
</script>
            ";
        }if ($payment == 'alipay'){
            echo "
            <script>
            document.cookie = 'alert = 3;';
            window.location.href = 'index.php?payment=alipay';
</script>
            ";
        }
    }
}


