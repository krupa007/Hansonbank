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

$user = $app->CustomerPersonalDetails($try); // get user details

$getUserDetails = json_decode($user, true);
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Profile</title>

        <link rel="stylesheet" href="css/main.css">


    </head>
    <body>
        <form name="refreshForm">
            <input type="hidden" name="visited" value="" />
        </form>
        <h2 class="btn gold">
            Profile
        </h2>
        <table align="center" border="5px">
            
            
            <tr> 
            <td><h3 style="color:#ECF0F1">Name : </h3></td><?php echo "<td>".$getUserDetails['name']. "</td>"; ?>
            </tr>
            <tr>
            
        <td><h3 style="color:#ECF0F1"> LastName : </h3> </td><?php echo"<td>" .$getUserDetails['lastname']."</td>"; ?>
            </tr>
            <tr>
            
            <td><h4 style="color:#ECF0F1"> Gender :</h4> </td><?php echo "<td>".$getUserDetails['gender']."</td>"; ?> 
            </tr>
            <tr>
            
            
            <td><h4 style="color:#ECF0F1"> Date of Birth :</h4></td> <?php echo "<td>".$getUserDetails['dob']."</td>;" ?>
           </tr>
            <tr>
            
            <td> <h4 style="color:#ECF0F1"> address :</h4></td> <?php echo "<td>" .$getUserDetails['address']."</td>"; ?> 
       
            </tr>
            <tr>
            <td> <h4 style="color:#ECF0F1"> Mobile No :</h4></td> <?php echo "<td>" .$getUserDetails['mobile']. "</td>"; ?>
        
            </tr>
            <tr>
            <td> <h4 style="color:#ECF0F1"> Email :</h4></td> <?php echo "<td>" .$getUserDetails['email']."</td>";?> 
        
            </tr>
            <tr>
            <td> <h4 style="color:#ECF0F1">Username :</h4></td> <?php echo "<td>".$getUserDetails['username']."</td>"; ?> 
            
        </tr>
             </table>
            
            
           
<?php
$enc_password = rawurlencode(urlencode(base64_encode($try)));

echo "<td><h1><a id ='edit' href=\"EditCustomerPersonalDetails.php?id=$enc_password\" style='color:#7B241C'>Update Information</a></h1></td>";
?>
    </body>
</html>
