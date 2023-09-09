<?php
session_start();
require_once('include/dbController.php');
$db_handle = new DBController();
date_default_timezone_set("Asia/Hong_Kong");

if (isset($_SESSION['userid'])) {
    $userId = $_SESSION['userid'];
    $fetch_user = $db_handle->runQuery("select * from customer where id = '$userId'");
} else {
    echo "
    <script>
    window.location.href = 'login.php';</script>";
}

$fetch_grab = $db_handle->runQuery("SELECT `grab` FROM `grab` WHERE `customer_id` = '$userId'");

$grab = $fetch_grab[0]['grab'];
if($grab > 0){
    $grab = $grab - 1;
    $update_grab = $db_handle->insertQuery("UPDATE `grab` SET `grab`='$grab' WHERE `customer_id` = '$userId'");
    if($update_grab){
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
}


