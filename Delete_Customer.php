<?php

// Start Session
session_start();
$id = $_GET['id'];
$id = base64_decode(urldecode(rawurldecode($id)));
// Database connection
require __DIR__ . '/database.php';
$db = DB();



$error_message = '';


$query = $db->prepare(" Delete FROM hansonCustomer where customer_id = $id");
$query->execute();

header("Location:Edit_Delete_Customer_Main.php");
?>

