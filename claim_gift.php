<?php
session_start();
require_once('include/dbController.php');
$db_handle = new DBController();
date_default_timezone_set("Asia/Hong_Kong");
$inserted_at = date("Y-m-d H:i:s");
if (isset($_SESSION['userid'])) {
    $userId = $_SESSION['userid'];
    $fetch_user = $db_handle->runQuery("select * from customer where id = '$userId'");
} else {
    echo "
    <script>
    window.location.href = 'index.php';</script>";
}

$gift = $_GET['data'];

$fetch_grab = $db_handle->insertQuery("INSERT INTO `customer_gifts`(`customer_id`, `gift_name`, `inserted_at`) VALUES ('$userId','$gift','$inserted_at')");

    if($fetch_grab){
        $response = array(
            "success" => true
        );
        echo json_encode($response);
    }else {
        // Query failed
        $response = array(
            "success" => false,
            "error" => "Query failed"
        );
        echo json_encode($response);
    }


