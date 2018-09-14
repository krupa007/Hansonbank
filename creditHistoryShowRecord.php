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


$getFullStatement = $app->FullCreditStatement($try);
?>



<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Full Statement</title>

        <link rel="stylesheet" href="css/main.css">
    </head>
    <body>


        <br><br><br>
        <h3><u class="btn gold">Full Statement</u></h3>

        <table align="center" border="5px">
            <th style="color:#ECF0F1">Date</th>
            <th style="color:#ECF0F1">Name</th>
            <th style="color:#ECF0F1">Debit</th>
            <th style="color:#ECF0F1">Credit</th>
            <th style="color:#ECF0F1">Balance</th>
            <th style="color:#ECF0F1">Note</th>

<?php
while ($rws = array_shift($getFullStatement)) {

    echo "<tr>";
    //echo "<td>".$rws->beneficiary_id."</td>";
    echo "<td>" . $rws->credittransactiondate . "</td>";
    echo "<td>" . $rws->name . "</td>";
    echo "<td>" . $rws->debit . "</td>";
    echo "<td>" . $rws->credit . "</td>";
    echo "<td>" . $rws->balance . "</td>";
    echo "<td>" . $rws->narration . "</td>";
    echo "</tr>";
}
?>
        </table>


    </div>
</body>
</html>