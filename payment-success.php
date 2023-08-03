<?php
session_start();
require_once("admin/include/dbController.php");
$db_handle = new DBController();
// Include configuration file
require_once 'config.php';

// Include database connection file
include_once 'dbConnect.php';

$payment_id = $statusMsg = $customer_email = '';
$status = 'error';

// Check whether stripe checkout session is not empty
if (!empty($_GET['session_id'])) {
    $session_id = $_GET['session_id'];

    // Fetch transaction data from the database if already exists
    $sqlQ = "SELECT * FROM transactions WHERE stripe_checkout_session_id = ?";
    $stmt = $db->prepare($sqlQ);
    $stmt->bind_param("s", $db_session_id);
    $db_session_id = $session_id;
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Transaction details
        $transData = $result->fetch_assoc();
        $payment_id = $transData['id'];
        $transactionID = $transData['txn_id'];
        $paidAmount = $transData['paid_amount'];
        $paidCurrency = $transData['paid_amount_currency'];
        $payment_status = $transData['payment_status'];

        $customer_name = $transData['customer_name'];
        $customer_email = $transData['customer_email'];

        $status = 'success';
        $statusMsg = 'Your Payment has been Successful!';
    } else {
        // Include the Stripe PHP library
        require_once 'stripe-php/init.php';

        // Set API key
        $stripe = new \Stripe\StripeClient(STRIPE_API_KEY);

        // Fetch the Checkout Session to display the JSON result on the success page
        try {
            $checkout_session = $stripe->checkout->sessions->retrieve($session_id);
        } catch (Exception $e) {
            $api_error = $e->getMessage();
        }

        if (empty($api_error) && $checkout_session) {
            // Get customer details
            $customer_details = $checkout_session->customer_details;

            // Retrieve the details of a PaymentIntent
            try {
                $paymentIntent = $stripe->paymentIntents->retrieve($checkout_session->payment_intent);
            } catch (\Stripe\Exception\ApiErrorException $e) {
                $api_error = $e->getMessage();
            }

            if (empty($api_error) && $paymentIntent) {
                // Check whether the payment was successful
                if (!empty($paymentIntent) && $paymentIntent->status == 'succeeded') {
                    // Transaction details
                    $transactionID = $paymentIntent->id;
                    $paidAmount = $paymentIntent->amount;
                    $paidAmount = ($paidAmount / 100);
                    $paidCurrency = $paymentIntent->currency;
                    $payment_status = $paymentIntent->status;

                    // Customer info
                    $customer_name = $customer_email = '';
                    if (!empty($customer_details)) {
                        $customer_name = !empty($customer_details->name) ? $customer_details->name : '';
                        $customer_email = !empty($customer_details->email) ? $customer_details->email : '';
                    }

                    // Check if any transaction data is exists already with the same TXN ID
                    $sqlQ = "SELECT id FROM transactions WHERE txn_id = ?";
                    $stmt = $db->prepare($sqlQ);
                    $stmt->bind_param("s", $transactionID);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $prevRow = $result->fetch_assoc();

                    if (!empty($prevRow)) {
                        $payment_id = $prevRow['id'];
                    } else {
                        $user_id = $_SESSION['user_id'];
                        // Insert transaction data into the database
                        $sqlQ = "INSERT INTO transactions (customer_name,customer_email,billing_id,item_name,item_number,item_price,item_price_currency,paid_amount,paid_amount_currency,txn_id,payment_status,stripe_checkout_session_id,created,modified) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,NOW(),NOW())";
                        $stmt = $db->prepare($sqlQ);
                        $stmt->bind_param("ssissdsdssss", $customer_name, $customer_email, $user_id, $productName, $productID, $productPrice, $currency, $paidAmount, $paidCurrency, $transactionID, $payment_status, $session_id);
                        $insert = $stmt->execute();

                        if ($insert) {
                            $payment_id = $stmt->insert_id;
                        }
                    }

                    $status = 'success';
                    $statusMsg = 'Your Payment has been Successful!';
                } else {
                    $statusMsg = "Transaction has been failed!";
                }
            } else {
                $statusMsg = "Unable to fetch the transaction details! $api_error";
            }
        } else {
            $statusMsg = "Invalid Transaction! $api_error";
        }
    }
} else {
    $statusMsg = "Invalid Request!";
}
?>

<?php if ($statusMsg=="Your Payment has been Successful!") {
    $orderdetails = '<table class="customTable" style="margin-top: 20px; margin-bottom: 20px;">';
    $orderdetails .= '<thead>
                             <tr>
                                <th>產品名稱</th>
                                <th>產品代碼</th>
                                <th>數量</th>
                                <th>價格</th>
                                <th>合計</th>
                            </tr>
                      </thead>';
    $orderdetails .= '<tbody>';

    $data = $db_handle->runQuery("SELECT id FROM billing_details order by id desc LIMIT  1");

    $id = $data[0]['id'];

    $product_details = $db_handle->runQuery("SELECT * FROM `invoice_details` WHERE `billing_id` = '$id'");
    $no_product_details = $db_handle->numRows("SELECT * FROM `invoice_details` WHERE `billing_id` = '$id'");

    $tableHtml = '<table style="border-collapse: collapse; width: 100%;">';
    $tableHtml .= '<tr>
                    <th style="border: 1px solid #000; padding: 8px; text-align: center;">產品名稱</th>
                    <th style="border: 1px solid #000; padding: 8px; text-align: center;">產品代碼</th>
                    <th style="border: 1px solid #000; padding: 8px; text-align: center;">數量</th>
                    <th style="border: 1px solid #000; padding: 8px; text-align: center;">價格</th>
                    <th style="border: 1px solid #000; padding: 8px; text-align: center;">合計</th>
                </tr>';

    for ($i = 0; $i < $no_product_details; $i++) {
        $tableHtml .= '<tr>';
        $tableHtml .= '<td style="border: 1px solid #000; padding: 8px; text-align: center;">' . $product_details[$i]['product_name'] . '</td>';
        $tableHtml .= '<td style="border: 1px solid #000; padding: 8px; text-align: center;">' . $product_details[$i]['product_id'] . '</td>';
        $tableHtml .= '<td style="border: 1px solid #000; padding: 8px; text-align: center;">' . $product_details[$i]['product_quantity'] . '</td>';
        $tableHtml .= '<td style="border: 1px solid #000; padding: 8px; text-align: center;">' . $product_details[$i]['product_unit_price'] . '</td>';
        $tableHtml .= '<td style="border: 1px solid #000; padding: 8px; text-align: center;">' . $product_details[$i]['product_total_price'] . '</td>';
        $tableHtml .= '</tr>';
    }

    $tableHtml .= '</table>';

    $footer = '<h4 style="font-size: 19px; font-weight: 700; margin: 0;>聯絡我們</h4>';
    $footer .= '<h5 style="font-size: 13px; text-transform: uppercase; margin: 0; letter-spacing:1px; font-weight: 500;">如你有任何關於此訂單的查詢，請與Wayshk聯繫。</h5>';
    $footer .= '<h5 style="font-size: 13px; text-transform: uppercase; margin: 0; letter-spacing:1px; font-weight: 500;">香港大圍成運路21-23號群力工業大廈3樓1室</h5>';
    $footer .= '<h5 style="font-size: 13px; text-transform: uppercase; margin: 0; letter-spacing:1px; font-weight: 500;">產品訂購 WhatsApp +852 56058389/電郵地址wayshk.order@gmail.com</h5>';
    $footer .= '<h5 style="font-size: 13px; text-transform: uppercase; margin: 0; letter-spacing:1px; font-weight: 500;">其他查詢WhatsApp +85252657359 /電郵地址ways00.hk@gmail.com</h5>';


    $button = "<a href='https://wayshk.com/print_receipt.php?id=" . $id . "' class='password-button' style='margin-left: 60px;' target='_blank'>See Details</a>";

    $img = '<img src="https://wayshk.com/assets/images/welcome-poster.jpg" alt="" style="width: 100%;">';

    $to = $customer_email;
    $subject = 'Wayshk 活籽兒童用品店 - 訂單編號';
    $message = $img . '<br><br>： Wayshk 活籽兒童用品店 - 訂單編號 WHK #' . $id .' <br><br>點擊以下連結檢視您的訂單詳情：' . $button . '<br><br> Order Details ' . $tableHtml . '<br><br>' . $footer;
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
                        New Order Arrived. Payment completed.
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
