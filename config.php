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
define('STRIPE_API_KEY', 'sk_test_51Na513HoWsXuRZanQTdzAtlsWkNO1ycq3ENv1C6GpR1trlGDiNAwkUmuYs0gty8VmdWnC6jV2KUvV93JqfxUnRY100ZbmTLR62');
define('STRIPE_PUBLISHABLE_KEY', 'pk_test_51Na513HoWsXuRZanx7uNHTFOsDGLMt21zprfOXgJM2WDsBIj5S7cpOCsG6EGissMBhUVoIm52IetiXO4t1WilvC4001Qi0D5k3');
define('STRIPE_SUCCESS_URL', 'https://localhost/W-Ichi-Catch/payment-success.php'); //Payment success URL
define('STRIPE_CANCEL_URL', 'https://localhost/W-Ichi-Catch/payment-cancel.php'); //Payment cancel URL

// Database configuration
define('DB_HOST', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'ichicatcher');

