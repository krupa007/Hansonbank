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

$id = $_GET['id'];
$id = base64_decode(urldecode(rawurldecode($id)));
$query = $db->prepare("SELECT sendername,senderemail,securityquestion,securityanswer,amount FROM TransferFromOther WHERE transfer_id=:transfer_id");
$query->bindParam("transfer_id", $id, PDO::PARAM_STR);
$query->execute();


$rws = $query->fetch();
$senderName = $rws[0];
$senderEmail = $rws[1];
$securityQuestion = $rws[2];
$securityAnswer = $rws[3];
$amount = $rws[4];

// check update request
if (!empty($_POST['btnAcceptTransfer'])) {

    if ($_POST['securityAnswer'] == "") {
        $error_message = 'Answer field is required!';
    } else if ($_POST['securityAnswer'] != $securityAnswer) {
        $error_message = 'Security Answer is incorrect!';
    } else {
        $user_id = $app->otherBankTransferAccept($try, $id, $senderName, $senderEmail, $amount);
        // set session and redirect user to the profile page
        if ($user_id == 'success') {
            $error_message = 'success';
        }
    }
}
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Accept Transfer</title>

        <link rel="stylesheet" href="">
    </head>
    <body>




        <h4>Accept Tranfer</h4>


<?php
if ($error_message != "") {
    echo $error_message;
}
?>

        <form action="" method="post">

            <label for="">Sender Name : </label>
            <label for=""><?php echo $senderName ?></label>
            </br>
            <label for="">Security Email : </label>
            <label for=""><?php echo $senderEmail ?></label> 
            </br>
            <label for="">Amount : </label>
            <label for=""><?php echo $amount ?></label> 
            </br>
            <label for="">Security Question : </label>
            <label for=""><?php echo $securityQuestion ?></label>
            </br>

            <label for="">Security Answer : </label>
            <input type="text" name="securityAnswer" required />

            </br>
            <input type="submit" name="btnAcceptTransfer"  value="Accept Transfer"/>

        </form>

    </body>
</html>