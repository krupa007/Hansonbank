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
echo $username;
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Accept/Reject Transfer</title>

        <link rel="stylesheet" href="css/main.css">
    </head>
    <body>

        <form action="" method="POST">

            <table align="center" border="5px">
                <caption align='center'><h3><u class="btn gold">Pending Transfers</u></h3></caption>

                <th>Sender Name</th>
                <th>Sender Email</th>
                <th>Amount</th>


<?php
$query = $db->prepare("SELECT sendername,senderemail,amount,transfer_id FROM TransferFromOther WHERE name=:name AND status='PENDING'");
$query->bindParam("name", $username, PDO::PARAM_STR);
$query->execute();


for ($i = 0; $rws = $query->fetch(); $i++) {
    echo "<tr><td>" . $rws[0];
    echo "</td>";
    echo "<td>" . $rws[1] . "</td>";
    echo "<td>" . $rws[2] . "</td>";


    $enc_password = rawurlencode(urlencode(base64_encode($rws[3])));
    echo "<td><a id ='edit' href=\"customerAcceptTransfer.php?id=$enc_password\">Accept</a></td>";
    echo "<td><a id = 'delete' href='customerRejectTransfer.php?id=$enc_password' onClick=\"return confirm('Are you sure you want to reject this transfer?')\">Reject</a></td>";
    echo "</tr>";
}
?>
            </table>



        </form>

    </body>
</html>