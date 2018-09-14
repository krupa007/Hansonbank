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

    $email = $_POST['email'];
    $amount = $_POST['amount'];
    $securityQuestion = $_POST['securityQuestion'];
    $securityAnswer = $_POST['securityAnswer'];
    $senderName = $_POST['sendername'];
    $senderEmail = $_POST['senderemail'];

    echo $result = $app->otherBankTransfer($email, $amount, $securityQuestion, $securityAnswer, $senderName, $senderEmail);
} else {
    echo 'Api key is invalid';
}
?>