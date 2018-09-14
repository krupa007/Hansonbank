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



$getMiniStatement = $app->MiniStatement($try);
?>



<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Mini Statement</title>

        <link rel="stylesheet" href="css/main.css">

    </head>
    <body>
        <br><br><br>
        <h3><u class="btn gold">Mini Statement </u></h3>
        <form action="" method= "POST">
            <table align="center" border="5px">
                <th>Date</th>
                <th>Name</th>
                <th>Withdrawl</th>
                <th>Deposit</th>
                <th>Balance</th>
                <th>Note</th>

<?php
if ($getMiniStatement != "") {
    while ($rws = array_shift($getMiniStatement)) {
    
        echo "<tr>";
        //echo "<td>".$rws->beneficiary_id."</td>";
        echo "<td>" . $rws->transactiondate . "</td>";
        echo "<td>" . $rws->name . "</td>";
        echo "<td>" . $rws->withdrawl . "</td>";
        echo "<td>" . $rws->deposit . "</td>";
        echo "<td>" . $rws->balance . "</td>";
        echo "<td>" . $rws->narration . "</td>";
        echo "</tr>";
        

    }
} else {

    echo 'No transcation to show ';
}
?>
            </table>

        </form>
    </div>
</body>
</html>