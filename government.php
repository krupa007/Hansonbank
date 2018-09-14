<?php

// Start Session
session_start();
if (empty($_SESSION['admin_id'])) {
    header("Location: index.php");
}
// Database connection
require __DIR__ . '/database.php';
$db = DB();



$error_message = '';

//API Key testbank
$url = 'http://lilyfactory.net/AliAPI/getPeopleList.php?APIKey=' . 'cdf8b533eeaafd9eb724b6b3c27a08a0b9369dbb817e4646e90ec7f65db7b62a';

$json = file_get_contents($url);

$obj = json_decode($json, true);
$ErrorCode = $obj['ErrorCode'];
$Message = $obj['Message'];

if ($ErrorCode == 100) {
    foreach ($obj['People'] as $item) {
        echo 'First Name: ' . $item['firstName'] . '   ';
        echo 'Last Name: ' . $item['lastName'] . '<br />';

        echo' <br/> ';
    }
} else {
    echo $ErrorCode . " " . $Message;
}
?>
