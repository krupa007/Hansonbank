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



$getBeneficiary = $app->viewAddedBeneficiary($try);
?>



<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Display Beneficiary</title>

        <link rel="stylesheet" href="css/main.css">
    </head>
    <body>
        <br><br><br>
        <h3><u class="btn gold">Added Beneficiary</u></h3>
        <form action="" method= "POST">
            <table align="center" border="5px">

                <th>Name</th>
                <th>Beneficiary No</th>

<?php
if ($getBeneficiary != "") {
    while ($rws = array_shift($getBeneficiary)) {

        echo "<tr>";
        //echo "<td>".$rws->beneficiary_id."</td>";
        echo "<td>" . $rws->receiver_name . "</td>";
        echo "<td>" . $rws->receiver_id . "</td>";
        $enc_password = rawurlencode(urlencode(base64_encode($rws->beneficiary_id)));

        echo "<td><a id = 'delete' href='Delete_Beneficiary.php?id=$enc_password' onClick=\"return confirm('Are you sure you want to delete?')\">Delete</a></td>";
        echo "</tr>";
    }
} else {

    echo 'No Beneficiary added';
}
?>
            </table>

        </form>
    </div>
</body>
</html>