<?php
session_start();
require_once("include/dbController.php");
$db_handle = new DBController();
date_default_timezone_set("Asia/Hong_Kong");
$customer_id = 0;
if (isset($_SESSION['userid'])) {
    $customer_id = $_SESSION['userid'];
} else{
    echo "
    <script>
    window.location.href = 'index.php';
</script>";
}

if(isset($_POST['place_order'])){
    $amount = $db_handle->checkValue($_POST['amount']);
    $payment = $db_handle->checkValue($_POST['payment']);
    $inserted_at = date("Y-m-d H:i:s");

    $insert = $db_handle->insertQuery("INSERT INTO `payment_details`(`payment_method`, `amount`, `customer_id`, `inserted_at`) VALUES ('$payment','$amount','$customer_id','$inserted_at')");
    if($insert){
        if($payment == 'payme'){
            echo "<script>
                window.location.href='https://payme.hsbc/ichicatcher';
                </script>";
        } if ($payment == 'fps'){
            echo "
            <script>
            document.cookie = 'alert = 3;';
            window.location.href = 'home.php?payment=fps';
</script>
            ";
        }if ($payment == 'alipay'){
            echo "
            <script>
            document.cookie = 'alert = 3;';
            window.location.href = 'home.php?payment=alipay';
</script>
            ";
        }
    }
}


