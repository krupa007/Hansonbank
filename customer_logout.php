<?php

// start session
session_start();

// Application library ( with DemoLib class )
require __DIR__ . '/lib/library.php';
$app = new DemoLib();


// Database connection
require __DIR__ . '/database.php';
$db = DB();

$id = $_SESSION['username'];
$date = date('l jS \of F Y h:i:s A');

$query = $db->prepare("UPDATE hansonCustomer SET last_login='$date' WHERE name = '$id'");
$query->execute();



// Destroy user session
$app->deleteHash($_SESSION['customer_id']);
unset($_SESSION['customer_id']);
session_destroy();

// Redirect to indexCustomer.php page
header("Location: indexCustomer.php");
?>