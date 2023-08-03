<?php
session_start();
require_once("admin/include/dbController.php");
$db_handle = new DBController();
date_default_timezone_set("Asia/Hong_Kong");
$customer_id = 0;
if (isset($_SESSION['id'])) {
    $customer_id = $_SESSION['id'];
}


function randomPassword()
{
    $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < 8; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass); //turn the array into a string
}


if (isset($_POST["placeOrder"])) {

    $f_name = $db_handle->checkValue($_POST['f_name']);
    $l_name = $db_handle->checkValue($_POST['l_name']);
    $phone = $db_handle->checkValue($_POST['phone_number']);
    $email = $db_handle->checkValue($_POST['email']);
    $address = $db_handle->checkValue($_POST['address']);
    $city = $db_handle->checkValue($_POST['city']);
    $zip_code = $db_handle->checkValue($_POST['zip_code']);
    $note = $db_handle->checkValue($_POST['note']);
    $discount = $db_handle->checkValue($_POST['discount']);
    $delivery_charge = $db_handle->checkValue($_POST['delivery_charge']);
    $addInfo = 0;
    $payment = $db_handle->checkValue($_POST['payment']);
    $shipping = $db_handle->checkValue($_POST['shipping']);
    $updated_at = date("Y-m-d H:i:s");
    $total_purchase = 0;
    $purchase_points = 0;
    $final_payment_for_stripe = $db_handle->checkValue($_POST['stripe_value']);

    if (isset($_POST['addInfo'])) {
        $addInfo = 1;
    }

    $points = 0;


    foreach ($_SESSION["cart_item"] as $item) {
        $total_purchase += $item["quantity"] * $item["price"];
    }


    if ($customer_id != 0) {
        $purchase_points = floor($total_purchase);

        if (isset($_POST['points'])) {
            if ($total_purchase >= $_POST['points'] / 40) {
                $purchase_points =- $_POST['points'];
            } else {
                $purchase_points = (int)$total_purchase * 40 - $_POST['points'];
            }

        }
    }


    $insert_user = $db_handle->insertQuery("INSERT INTO `billing_details`(`customer_id`, `f_name`, `l_name`, 
                              `email`, `phone`, `address`, `city`, `zip_code`, `payment_type`,`shipping_method`, 
                              `discount`,`total_purchase`,`delivery_charges`, `updated_at`,`note`,`platform`) 
                              VALUES ('$customer_id','$f_name','$l_name','$email','$phone'
                              ,'$address','$city','$zip_code','$payment','$shipping','$discount','$total_purchase','$delivery_charge','$updated_at','$note','Online Order')");


    $billing_id = $db_handle->runQuery("SELECT * FROM billing_details order by id desc limit 1");

    $id = $billing_id[0]["id"];

    foreach ($_SESSION["cart_item"] as $item) {
        $name = $item["name"];
        $item_price = $item["quantity"] * $item["price"];
        $quantity = $item["quantity"];
        $unit_price = $item["price"];
        $product_id = $item['id'];

        $invoice = $db_handle->insertQuery("INSERT INTO `invoice_details`( `customer_id`, `billing_id`,`product_id`, `product_name`,`product_quantity`, `product_unit_price`,`product_total_price`, `updated_at`) VALUES ('$customer_id','$id','$product_id','$name','$quantity','$unit_price','$item_price', '$updated_at')");
    }

    unset($_SESSION["cart_item"]);

    $name = $f_name . ' ' . $l_name;

    $password = randomPassword();

    $info = '';

    if (!isset($_SESSION['id'])) {
        $select = $db_handle->numRows("SELECT * FROM customer where email='$email'");
        if ($select == 0 && $addInfo == 1) {
            $info = $db_handle->insertQuery("INSERT INTO `customer`(`customer_name`, `email`, `number`, `address`, 
                       `city`, `zip_code`, `password`, `inserted_at`, `updated_at`) 
                       VALUES ('$name','$email','$phone','$address','$city','$zip_code','$password',
                               '$updated_at','$updated_at')");
        }
    }

    if($payment == 'Credit Card') {
        $customer = $_SESSION['id'];
        if($customer != 0){
            $insert_point = $db_handle->insertQuery("INSERT INTO `point`( `customer_id`, `points`, `date`) VALUES ('$customer','$purchase_points','$updated_at')");
        }

    }


    $total_value = 0;

    $data = $db_handle->runQuery("SELECT id FROM billing_details order by id desc LIMIT  1");

    $id = $data[0]['id'];

    $product_details = $db_handle->runQuery("SELECT * FROM `invoice_details`, `product` WHERE `billing_id` = '$id' and invoice_details.product_id = product.id");
    $no_product_details = $db_handle->numRows("SELECT * FROM `invoice_details`, `product` WHERE `billing_id` = '$id' and invoice_details.product_id = product.id");

    $tableHtml = '<table style="border-collapse: collapse; width: 100%;">';
    $tableHtml .= '<tr>
                    <th style="border: 1px solid #000; padding: 8px; text-align: center; text-align: center;">產品名稱</th>
                    <th style="border: 1px solid #000; padding: 8px; text-align: center; text-align: center;">產品代碼</th>
                    <th style="border: 1px solid #000; padding: 8px; text-align: center; text-align: center;">數量</th>
                    <th style="border: 1px solid #000; padding: 8px; text-align: center; text-align: center;">價格</th>
                    <th style="border: 1px solid #000; padding: 8px; text-align: center; text-align: center;">合計</th>
                </tr>';

    for ($i = 0; $i < $no_product_details; $i++) {
        $tableHtml .= '<tr>';
        $tableHtml .= '<td style="border: 1px solid #000; padding: 8px; text-align: center; text-align: center;">' . $product_details[$i]['product_name'] . '</td>';
        $tableHtml .= '<td style="border: 1px solid #000; padding: 8px; text-align: center; text-align: center;">' . $product_details[$i]['product_code'] . '</td>';
        $tableHtml .= '<td style="border: 1px solid #000; padding: 8px; text-align: center; text-align: center;">' . $product_details[$i]['product_quantity'] . '</td>';
        $tableHtml .= '<td style="border: 1px solid #000; padding: 8px; text-align: center; text-align: center;">' . $product_details[$i]['product_unit_price'] . '</td>';
        $tableHtml .= '<td style="border: 1px solid #000; padding: 8px; text-align: center; text-align: center;">' . $product_details[$i]['product_total_price'] . '</td>';
        $tableHtml .= '</tr>';
    }

    $tableHtml .= '</table>';

    $payment1 = '<h3>付款方法說明:</h3>';
    $payment1 .= ' <h3>(一）選用速遞出貨:</h3>';
    $payment1 .= ' <h3>請於7日內，以以下方式付款：</h3>';
    $payment1 .= ' <p>⦁ PayMe (電話號碼：5265-7359 WAYSHK )</p>';
    $payment1 .= ' <p> ⦁ 轉數快 (電話號碼：5265-7359 WAYSHK )</p>';
    $payment1 .= ' <p>⦁ 銀行入數【戶口號碼為 769-334699-883 (恆生銀行) WAYSHK】</p>';
    $payment1 .= ' <p> 請於付款後，將付款憑證Whatsapp到 +852 5605 8389，並提供訂單編號進行確認。</p>';
    $payment1 .= ' <p>亦可直接回覆此電郵。 </p>';
    $payment1 .= ' <p>* 收到款項後，現貨產品送貨期為1星期。</p>';
    $payment1 .= ' <p>* 若訂單包含預購產品，將會於所有貨品齊全後一併寄出。歡迎查詢預計到貨期（約2-6星期）。 </p>';
    $payment1 .= ' <p>* 七天內如無收到付款證明，訂單將自動取消。 </p>';

    $payment2 = '<h3>(二）選用自取方式出貨</h3>';
    $payment2 .= '<p>請WhatsApp +852 5605 8389 聯絡我們查詢自取點現貨詳情並預約取貨時間。</p>';
    $payment2 .= '<p>接受PayMe/轉數快/銀行入數/現場現金付款。</p>';
    $payment2 .= '<h3>自取點A 大圍倉庫</h3>';
    $payment2 .= '<p>地址：大圍成運路21-23號群力工業大廈3樓1室</p>';
    $payment2 .= '<p>大圍火車站A出口右轉，步行約5分鐘</p>';
    $payment2 .= '<p>開放時間：不定 （10:30 – 18:15）</p>';
    $payment2 .= '<p>不設現場入內選貨。與我們確認領取時間，到達後致電並於門口交收。</p>';
    $payment2 .= '<h3>自取點B 兒璞兒童學習及發展中心</h3>';
    $payment2 .= '<p>地址：灣仔軒尼詩道237-239號25樓</p>';
    $payment2 .= '<p>灣仔地鐵站A2出口，步行約5分鐘/ 會展站A3出口，步行約6分鐘</p>';
    $payment2 .= '<p> 開放時間： 星期一至五 09:00 - 18:00；星期六 09:00 - 16:00【午餐時間 12:30-13:45 不開放】</p>';
    $payment2 .= '<p>電話：2877 8787</p>';
    $payment2 .= '<p>請必須預約取貨時間。</p>';

    $button = "<a href='https://wayshk.com/print_receipt.php?id=" . $id . "' class='password-button' style='margin-left: 60px;' target='_blank'>See Details</a>";

    $footer = '<h4 style="font-size: 19px; font-weight: 700; margin: 0;>聯絡我們</h4>';
    $footer .= '<h5 style="font-size: 13px; text-transform: uppercase; margin: 0; letter-spacing:1px; font-weight: 500;">如你有任何關於此訂單的查詢，請與Wayshk聯繫。</h5>';
    $footer .= '<h5 style="font-size: 13px; text-transform: uppercase; margin: 0; letter-spacing:1px; font-weight: 500;">香港大圍成運路21-23號群力工業大廈3樓1室</h5>';
    $footer .= '<h5 style="font-size: 13px; text-transform: uppercase; margin: 0; letter-spacing:1px; font-weight: 500;">產品訂購 WhatsApp +852 56058389/電郵地址wayshk.order@gmail.com</h5>';
    $footer .= '<h5 style="font-size: 13px; text-transform: uppercase; margin: 0; letter-spacing:1px; font-weight: 500;">其他查詢WhatsApp +85252657359 /電郵地址ways00.hk@gmail.com</h5>';

    $img = '<img src="https://wayshk.com/assets/images/welcome-poster.jpg" alt="" style="width: 100%;">';

    if ($payment != 'Credit Card') {
        $to = $email;
        $subject = "Wayshk 活籽兒童用品店 - 訂單編號 WHK #' . $id .'";
        $message = $img . '<br><br> Wayshk 活籽兒童用品店 - 訂單編號 WHK #' . $id .' <br><br>點擊以下連結檢視您的訂單詳情：' . $button . '<br><br> Order Details ' . $tableHtml . '<br><br>' . $payment1 . '<br><br>' . $payment2 . '<br><br>' . $footer;
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= 'From: business@wayshk.com' . "\r\n";

        if (mail($to, $subject, $message, $headers)) {
            $email_to = $db_handle->notify_email();
            $subject = 'Wayshk 活籽兒童用品店 - 訂單編號';

            $headers = "From: Wayshk <" . $db_handle->from_email() . ">\r\n";
            $headers .= "Content-Type: text/html; charset=utf-8\r\n";

            $messege = "
            <html>
                <body style='background-color: #eee; font-size: 16px;'>
                <div style='min-width: 200px; background-color: #ffffff; padding: 20px; margin: auto;'>
                    <p style='color:black;'>
                        New Order Arrived. Pyment option: $payment .
                    </p>
                </div>
                </body>
            </html>";

            if (mail($email_to, $subject, $messege, $headers)) {
                echo "
    <script>
    alert('您的訂單已經成功提交。請查看您的郵件以獲取更多詳細資訊');
    window.location.href = 'Home';
    </script>
    ";
            } else {
                echo "
    <script>
    alert('出了些問題');
    window.location.href = 'Home';
    </script>
    ";
            }
        }
    }



    if (!isset($_SESSION['user_id']) && $info) {
        session_unset();
        session_destroy();

        session_start();
        $_SESSION['user_id'] = $id;

        // Include configuration file
        require_once 'config.php';

    } else if (!isset($_SESSION['user_id']) && $insert_user) {

        // Include configuration file
        require_once 'config.php';
        $_SESSION['user_id'] = $id;

    }
}

$total_purchase = (int)$total_purchase + (int)$shipping - (int)$discount;

?>
<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        .loader {
            position: absolute;
            width: 100px;
            height: 100px;
            left: 50%;
            top: 50%;
            margin-left: -50px;
            margin-top: -50px;
        }

        .loader {
            border: 16px solid #f3f3f3;
            border-radius: 50%;
            border-top: 16px solid #ffcba3;
            width: 120px;
            height: 120px;
            -webkit-animation: spin 2s linear infinite; /* Safari */
            animation: spin 2s linear infinite;
        }

        /* Safari */
        @-webkit-keyframes spin {
            0% {
                -webkit-transform: rotate(0deg);
            }
            100% {
                -webkit-transform: rotate(360deg);
            }
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }
            100% {
                transform: rotate(360deg);
            }
        }
    </style>
</head>
<body>
<div class="loader"></div>
<button class="btn btn-primary stripe-button" id="payButton" style="display: none">
    <div class="spinner hidden" id="spinner"></div>
    <span id="buttonText">Pay Now</span>
</button>

<!-- Stripe JavaScript library -->
<script src="https://js.stripe.com/v3/"></script>

<script>
    window.onload = function () {
        document.getElementById('payButton').click();
    }


    // Set Stripe publishable key to initialize Stripe.js
    const stripe = Stripe('<?php echo STRIPE_PUBLISHABLE_KEY; ?>');

    // Select payment button
    const payBtn = document.querySelector("#payButton");

    // Payment request handler
    payBtn.addEventListener("click", function (evt) {
        setLoading(true);

        createCheckoutSession().then(function (data) {
            if (data.sessionId) {
                stripe.redirectToCheckout({
                    sessionId: data.sessionId,
                }).then(handleResult);
            } else {
                handleResult(data);
            }
        });
    });

    // Create a Checkout Session with the selected product
    const createCheckoutSession = function (stripe) {
        return fetch("payment_init.php?total_purchase=<?php echo $final_payment_for_stripe; ?>", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify({
                createCheckoutSession: 1,
            }),
        }).then(function (result) {
            return result.json();
        });
    };

    // Handle any errors returned from Checkout
    const handleResult = function (result) {
        if (result.error) {
            showMessage(result.error.message);
        }

        setLoading(false);
    };

    // Show a spinner on payment processing
    function setLoading(isLoading) {
        if (isLoading) {
            // Disable the button and show a spinner
            payBtn.disabled = true;
            document.querySelector("#spinner").classList.remove("hidden");
            document.querySelector("#buttonText").classList.add("hidden");
        } else {
            // Enable the button and hide spinner
            payBtn.disabled = false;
            document.querySelector("#spinner").classList.add("hidden");
            document.querySelector("#buttonText").classList.remove("hidden");
        }
    }

    // Display message
    function showMessage(messageText) {

    }


</script>
</body>
</html>


