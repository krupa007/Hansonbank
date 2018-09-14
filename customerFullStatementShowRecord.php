<?php
// Start Session
session_start();
// Database connection
require __DIR__ . '/database.php';
$db = DB();
$error_message = "";
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
echo $username;

if ($_POST['endDate'] < $_POST['startDate']) {
    $error_message = 'End date must be more than start date!';
} else {
    $getFullStatement = $app->FullStatement($try, $_POST['startDate'], $_POST['endDate']);
}
?>

<?php
if ($error_message != "") {
    echo $error_message;
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Full Statement</title>

        <link rel="stylesheet" href="">
    </head>
    <body>


        <br><br><br>
        <h3><u>Full Statement</u></h3>

        <table align="center" border="5px">
            <th>Date</th>
            <th>Name</th>
            <th>Withdrawal</th>
            <th>Deposit</th>
            <th>Balance</th>
            <th>Note</th>

            <?php
            if (!empty($getFullStatement)) {
                while ($rws = array_shift($getFullStatement)) {

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
                echo 'No record to show!!';
            }
            ?>
        </table>


    </div>
</body>
</html>