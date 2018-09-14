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

if (!empty($_POST['btnchange'])) {
    $Pattern = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])[A-Za-z\d$@$!%*?&]{8,}/';
    if ($_POST['oldPassword'] == "") {
        $error_message = 'Old password field is required!';
    } else if ($_POST['newPassword'] == "") {
        $error_message = 'new password field is required!';
    } else if (preg_match($Pattern, $_POST['repeatPassword']) == false) {
        $error_message = 'Minimum eight characters, at least one uppercase letter, one lowercase letter, one number and one special character!';
    } else if ($_POST['repeatPassword'] == "") {
        $error_message = 'Repeat password field is required!';
    } else if ($app->customerCheckPassword($try, $_POST['oldPassword']) === FALSE) {
        $error_message = 'Old Password is incorrect!';
    } else if ($_POST['newPassword'] != $_POST['repeatPassword']) {
        $error_message = 'repeat password do not match!';
    } else {
        $ProceedChange = $app->customerUpdatePassword($try, $_POST['repeatPassword']);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Change Password</title>

        <link rel="stylesheet" href="css/main.css">
    </head>
    <body>




        <h4 class="btn gold">Change Password</h4>
<?php
if ($error_message != "") {
    echo $error_message;
}
?>
      
        
        
        
        <form action="customerChangePassword.php" method="post">

        <table align="center" border="0px" style="background-color=#626567" padding="20px">
            <tr><td> <label for="" style="color:#ECF0F1" >Old Password</label></td>
                <td> <input type="text" name="oldPassword" /></td></tr>

           <tr> <td><label for="" style="color:#ECF0F1">New Password</label></td>
               <td><input type="text" name="newPassword" /></td></tr>


           <tr> <td>  <label for="" style="color:#ECF0F1">Repeat Password</label></td>
               <td><input type="password" name="repeatPassword"/></td></tr>


           <tr> <td>   <input type="submit" name="btnchange"  value="Apply" class="btn gold"/></td></tr>
            
            </table>
    
    


        </form>




    </body>
</html>

