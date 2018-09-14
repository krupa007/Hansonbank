<?php

// start session
session_start();


// Database connection
require __DIR__ . '/database.php';
$db = DB();

$id = $_SESSION['admin_id'];
$date = date('l jS \of F Y h:i:s A');

$query = $db->prepare("UPDATE users SET last_login='$date' WHERE user_id = '$id'");
$query->execute();



// Destroy user session
unset($_SESSION['admin_id']);

// Redirect to index.php page
header("Location: index.php");
?>