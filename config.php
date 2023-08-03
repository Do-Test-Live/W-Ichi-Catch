<?php

// Product Details
// Minimum amount is $0.50 US
$productName = "1小時30分鐘租場服務";
$productID = "DP12345";
$productPrice = 190;
$currency = "hkd";

/*
 * Stripe API configuration
 * Remember to switch to your live publishable and secret key in production!
 * See your keys here: https://dashboard.stripe.com/account/apikeys
 */
define('STRIPE_API_KEY', 'sk_test_51Js7yMEef0ZfRYif2EiZDwOsgckQWfhufIaCy6AA4V2khdgX3HjPVUVayrmgoaSZrbKWurDNaS51ykeUjVkDvH3C00jqJ2LxSf');
define('STRIPE_PUBLISHABLE_KEY', 'pk_test_51Js7yMEef0ZfRYif2yukLvrLbqS7IhDndBYnLlxB6oFfD354C5GDXlrkoUfhR0ICChKmTrzeWi7sfKUvrQmXajXJ00hPvG6I62');
define('STRIPE_SUCCESS_URL', 'https://localhost/W-Wayshk/payment-success.php'); //Payment success URL
define('STRIPE_CANCEL_URL', 'https://localhost/W-Wayshk/payment-cancel.php'); //Payment cancel URL

// Database configuration
define('DB_HOST', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'wayshk');

