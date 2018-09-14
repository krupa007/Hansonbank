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



$error_message = "";

if (!empty($_POST['btnAddBeneficiary'])) {
    if ($_POST['name'] == "") {
        $error_message = 'Name field is required!';
    } else if ($_POST['receiver_id'] == "") {
        $error_message = 'Account No field is required!';
    } else if ($_POST['email'] == "") {
        $error_message = 'E-Mail field is required!';
    } else if ($_POST['username'] == "") {
        $error_message = 'Username field is required!';
    } else if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $error_message = 'Invalid email address!';
    } else {
        $user_id = $app->Add_Beneficiary($try, $_POST['name'], $_POST['receiver_id'], $_POST['email'], $_POST['username']);

        if ($user_id == 'success') {
            $error_message = 'Success';
            // header("Location: AddRemoveBeneficiary.php");
        }
    }

    if ($error_message == "") {
        
    } else {
        echo $error_message;
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title class="btn gold">Add Beneficiary</title>

        <link rel="stylesheet" href="css/main.css">

    </head>

    <body>
        <form action="" method="POST">
           <table align="center" border="0px">
           
            
            
            
             <div class="form-group" >
               
                 <tr><td><label for=""  style="color:#ECF0F1">Payee Name:</label></td>
                     <td> <input type="text" name="name"/></td></tr>
            </div>
                
                 
            <div >
                
                <tr><td>  <label for="" style="color:#ECF0F1">Account No:</label></td>
                    <td><input type="text" name="receiver_id"/></td></tr>
                
            </div>
            <div >
                <tr><td><label for="" style="color:#ECF0F1">Username:</label></td>
                    <td><input type="text" name="username"/></td></tr>
            </div>
            <div >
                <tr>   <td> <label for="" style="color:#ECF0F1">Email:</label></td>
                    <td><input type="text" name="email"/><td></tr>
            </div>
            <div class="form-group">
                <tr> <td><input type="submit" name="btnAddBeneficiary" value="Add new beneficiary" class="btn gold"/> </td></tr>
            </div>
            </table>
            
           
        </form>




    </body>
</html>
