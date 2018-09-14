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


$user = $app->CustomerDetails($try); // get user details

$getUserDetails = json_decode($user, true);
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title style="color:blue">Profile</title>

        <link rel="stylesheet" href="css/main.css">


    </head>
    <body>
        <form name="refreshForm">
            <input type="hidden" name="visited" value="" />
        </form>
        <h1 style="color:#ECF0F1">
            Profile
        </h1>
        <h2 style="color:#ECF0F1">Hello, <?php echo $getUserDetails['name'] ?> </h2>
        <h3 style="color:#ECF0F1">Your Email : <?php echo $getUserDetails['email']; ?> </h3>
        <h3 style="color:#ECF0F1">Account Number : <?php echo $getUserDetails['accountnumber'] ?> </h3>
        <h3 style="color:#ECF0F1">Debit Number : <?php echo $getUserDetails['debitnumber'] ?> </h3>
        <h3 style="color:#ECF0F1">Credit Number : <?php echo $getUserDetails['creditnumber'] ?> </h3>
        <h3 style="color:#ECF0F1">Account type: <?php echo $getUserDetails['type'] ?> </h3>
        <h3 style="color:#ECF0F1">Savings Balance : <?php echo $getUserDetails['debit'] ?> </h3>
        <h3 style="color:#ECF0F1">Credit Balance : <?php echo $getUserDetails['credit'] ?><h2><a href="creditHistory.php" style="color:#7B241C">Credit Details</a></h2> </h3>

        <h3 style="color:#ECF0F1">Last Login : <?php echo $getUserDetails['last_login'] ?> </h3>

        <ul>
            
           <h1 style="color:#ECF0F1">Account</h1>
            <br><a href="profile_Customer.php"       class="btn gold">Account Summary</a>
            <br>  <a href="customerMiniStatement.php"  class="btn gold" >Mini Statement</a>
        <br><a href="customerFullStatement.php"  class="btn gold">All Statement</a>

        </ul>

        <ul>
            <h1 style="color:#ECF0F1">Fund Transfer</h1>
            <br><a href="AddBeneficiary.php"  class="btn gold">Add Beneficiary</a>
            <br> <a href="display_Beneficiary.php"  class="btn gold">View/Remove Added Beneficiary</a>
            <br><a href="customer_transfer.php"  class="btn gold">Transfer</a>
            <br><a href="incomingTransferMain.php"  class="btn gold">Accept Pending Transfer</a>


        </ul>

        <ul>
            <h1 style="color:#ECF0F1">Profile</h1>
            <br> <a href= "CustomerPersonalDetails.php" class="btn gold">Personal Details</a>
            <br><a href="CustomerChangePassword.php"  class="btn gold">Change Password</a>

        </ul>



        <a href="customer_logout.php?id=<?Php $session ?>"  class="btn gold">Logout</a>

    </body>
</html>
