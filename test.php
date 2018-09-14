<?php

// Start Session
session_start();
// Database connection
require __DIR__ . '/database.php';
$db = DB();

// Application library ( with DemoLib class )
require __DIR__ . '/lib/library.php';
$app = new DemoLib();

if ($_GET['APIKEY'] == 1) {

    $cardNumber = $_POST['cardnumber'];
    $cvvNumber = $_POST['cvv'];
    $finalAmount = $_POST['amount'];
    $expireDate = $_POST['expdate'];
    echo $result = $app->shoppingCheckout($cardNumber, $cvvNumber, $finalAmount, $expireDate);
} else {
    echo 'Api key is invalid';
}
?>