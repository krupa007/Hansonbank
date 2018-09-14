<?php
// Start Session
session_start();
$error_message = "";
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

$getBeneficiary = $app->viewAddedBeneficiary($try);

$numberPattern = '/^[1-9][0-9]*$/';
if (!empty($_POST['btnTransfer'])) {
    if ($_POST['transferAmount'] == "") {
        $error_message = 'Amount field is required!';
    } else if ($_POST['transferAmount'] < 0) {
        $error_message = 'Amount field must be greater then 0!';
    } else if ($_POST['transferAmount'] < 100) {
        $error_message = 'Minimum transfer amount is 100!';
    } else if ($_POST['transferAmount'] > 1000) {
        $error_message = 'Maximum transfer amount is 1000!';
    } else if (preg_match($numberPattern, $_POST['transferAmount']) == false) {
        $error_message = 'Amount field must contain number only!';
    } else {
        $ProceedTransfer = $app->Transfer($try, $_POST['transferName'], $_POST['transferAmount']);
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Transfer Funds</title>

        <link rel="stylesheet" href="css/main.css">

    </head>

    <h3><u class="btn gold">Transfer Funds</u></h3>
<?php
if ($error_message != "") {
    echo $error_message;
}
?>


    <?php
    if ($getBeneficiary != "") {
        echo "<form action='' method='POST'>";
        echo "<table align='center'>";
        echo "<tr><td style='color:#ECF0F1'>Select Beneficiary:</td><td> <select name='transferName'>";

        $test = 10;

        while ($rws = array_shift($getBeneficiary)) {
            echo "<option value='$rws->receiver_id'>$rws->receiver_name</option>";
        }

        echo "</td></tr></select>";


        echo "<tr><td style='color:#ECF0F1'>Enter Amount: </td><td><input type='number' name='transferAmount' required></td></table>";

        echo "<table align='center'><tr><td style='padding:5px;'><input type='submit' name='btnTransfer' value='Transfer' class='addstaff_button'></td></tr></table></form>";
        echo "<table align='center'><tr><td style='padding:5px;'><h2 class='btn gold'>OR Transfer to Other Bank account</h2></td></tr></table>";
        echo "<form action='http://localhost/HB123/test2.php?API=$test' method='POST'>";
        echo "<table align='center'>";
        echo "<tr><td style='color:#ECF0F1'>Enter Email: </td><td><input type='text' name='email' required></td>";
        echo "<tr><td style='color:#ECF0F1'>Enter Amount: </td><td><input type='number' name='amount' required></td>";
        echo "<tr><td style='color:#ECF0F1'>Enter Security Question: </td><td><input type='text' name='securityQuestion' required></td>";
        echo "<tr><td style='color:#ECF0F1'>Enter Security Answer: </td><td><input type='text' name='securityAnswer' required></td></table>";
        echo "<table align='center'>";
        echo "<table align='center'><tr><td style='padding:5px;'><input type='submit' name='btnTransferToOtherBank' value='Transfer' class='addstaff_button'></td></tr></table></form>";
    } else {
        echo "<br><br><div class='head'><h3>No Benefeciary Added with your account.</h3></div>";
    }
    ?>
