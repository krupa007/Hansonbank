<?php
// Start Session
session_start();
// Database connection
require __DIR__ . '/database.php';
$db = DB();

// Application library ( with DemoLib class )
require __DIR__ . '/lib/library.php';
$app = new DemoLib();
$session = $_SESSION['customer_id'];
$username = $_SESSION['username'];
$pastTime = time() - $_SESSION['login_time'];

// check user login
if (empty($session)) {

    unset($_SESSION['customer_id'], $_SESSION['login_time']);
    header("Location: indexCustomer.php");
}
if ($pastTime > 1000) {
    $try = $app->deleteHash($session);
    unset($_SESSION['customer_id'], $_SESSION['login_time']);
    header("Location: indexCustomer.php");
} else {
    $_SESSION['login_time'] = time();
    $try = $app->checkHash($session);
}
echo $pastTime;
echo '<br>';
//echo $username;

$getCreditDetails = $app->creditDetails($try); // get user details
$obj = json_decode($getCreditDetails, true);
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Profile</title>

        <link rel="stylesheet" href="css/main.css">
    </head>
    <body>
        <h1 style="color:#ECF0F1">
            Credit Card Details
        </h1>
        <h2 style="color:#ECF0F1">Credit Limit :  <?php echo $obj['totalCredit']; ?></h2>

        <h3 style="color:#ECF0F1">Available credit :  <?php echo $obj['availableBalance']; ?> </h3>
        <h4 style="color:#ECF0F1">Balance owing :   <?php echo $obj['balanceOwing']; ?></h4>

        <h1> <a href="creditHistoryShowRecord.php" style="color: #7B241C">Show Records</a></h1>
        <h1><a href="creditPayment.php" style="color:#7B241C">Make a Payment</a></h1>
    </body>
</html>
