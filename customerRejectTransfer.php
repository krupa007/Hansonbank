<?php

// Start Session
session_start();
$id = $_GET['id'];
$transfer_id = base64_decode(urldecode(rawurldecode($id)));
// Database connection
require __DIR__ . '/database.php';
$db = DB();



$error_message = '';
$status = 'REJECTED';

$query = $db->prepare("UPDATE TransferFromOther SET status=:status WHERE transfer_id =:transfer_id");
$query->bindParam("status", $status, PDO::PARAM_STR);
$query->bindParam("transfer_id", $transfer_id, PDO::PARAM_STR);
$query->execute();

header("Location:incomingTransferMain.php");
?>
  