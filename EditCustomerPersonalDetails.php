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
$error_message = '';

// check update request
if (!empty($_POST['btnEditCustomer'])) {

    if ($_POST['lastname'] == "") {
        $error_message = 'Last Name field is required!';
    } else if ($_POST['dob'] == "") {
        $error_message = 'Date of Birth field is required!';
    } else if ($_POST['gender'] == "") {
        $error_message = 'Gender field is required!';
    } else if ($_POST['address'] == "") {
        $error_message = 'address field is required!';
    } else if ($_POST['mobile'] == "") {
        $error_message = 'Mobile field is required!';
    } else if ($_POST['email'] == "") {
        $error_message = 'E-Mail field is required!';
    } else if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $error_message = 'Invalid email address!';
    } else if ($app->isCustomerEmail($_POST['email'])) {
        $error_message = 'Email is already in use!';
    } else {
        $user_id = $app->UpdateCustomerPersonalDetails($_POST['customer_id'], $_POST['lastname'], $_POST['gender'], $_POST['dob'], $_POST['address'], $_POST['mobile'], $_POST['email']);
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
        <title>Edit customer</title>

        <link rel="stylesheet" href="css/main.css">
    </head>
    <body>




        <h4 class="btn gold">Edit Personal Details</h4>


        <table align="center" border="5px">
            <caption align='center' style='color:#2E4372'><h3><u class="btn gold">Customer Details</u></h3></caption>
            <tr> 
                <th style="color:#ECF0F1"> customer ID</th>
                <th style="color:#ECF0F1">last name</th>
            <th style="color:#ECF0F1">gender</th>
            <th style="color:#ECF0F1">DOB</th>
            <th style="color:#ECF0F1">address</th>
            <th style="color:#ECF0F1">mobile</th>
                <th style="color:#ECF0F1">email</th></tr>
<?php
$id = $_GET['id'];
$id = base64_decode(urldecode(rawurldecode($id)));
$query = $db->prepare("SELECT hansonCustomer.customer_id, hansonCustomer.lastname, hansonCustomer.gender, hansonCustomer.dob, hansonCustomer.address, hansonCustomer.mobile, hansonUsers.email FROM hansonCustomer INNER JOIN hansonUsers ON hansonCustomer.customer_id = hansonUsers.user_id WHERE hansonUsers.user_id = $id");
//$query->bindParam("user_id", $try, PDO::PARAM_STR);
$query->execute();

echo"<tr>";
    
$rws = $query->fetch();
echo "<td>" . $rws[0] . "</td>";
echo "<td>" . $rws[1] . "</td>";

echo "<td>" . $rws[2] . "</td>";
echo "<td>" . $rws[3] . "</td>";
            
echo "<td>" . $rws[4] . "</td>";
echo "<td>" . $rws[5] . "</td>";
            
echo "<td>" . $rws[6] . "</td>";






echo "</tr>";
?>
        </table>
        
        
        

        <form action="" method="post">
            <table>
                <tr>
                    <td style="color:#ECF0F1"> Customer ID: </td>
                    <td>
            <input type="text" name="customer_id" hidden="" value="<?php echo $rws[0]; ?>" />
                    </td>
                </tr>
                <tr>
                    
                    <td>


                        <label for="" style="color:#ECF0F1">Last Name</label>
                         </td>
                    
                    <td>

            <input type="text" name="lastname" value="<?php echo $rws[1]; ?>" />
                         </td>
                    </tr>
                <tr>
                    
                    <td>
                    </td>
                    <td>


          <label style="color:#ECF0F1">M</label>  <input type="radio" name="gender" value="Male" <?php if ($rws[2] == 'Male') { ?> checked<?php } ?>/>
            <label style="color:#ECF0F1">F</label><input type="radio" name="gender" value="Female" <?php if ($rws[2] == 'Female') { ?> checked<?php } ?>/>
                        
                    </td>
                
                        
                        </tr>
                <tr>
                    <td>
                    
            <label for="" style="color:#ECF0F1">Date of Birth</label>
                    </td>
                    <td>
            <input type="date" name="dob" value="<?php echo $rws[3]; ?>" required=""/>
                        
                         </td>
                    </tr>
                <tr>
                    
                    <td>




            <label for="" style="color:#ECF0F1">Address</label>
                         </td>
                    
                    <td>

            <textarea name="address" required=""><?php echo $rws[4]; ?>"</textarea>
                         </td>
                    
                    </tr>
                <tr>
                    
                    <td>


            <label for="" style="color:#ECF0F1">Mobile</label>
                         </td>
                    
                    <td>

            <input type="text" name="mobile" required="" value="<?php echo $rws[5]; ?>"/>
                         </td>
                    </tr>
                <tr>
                    
                    
                    <td>

                        
            <label for="" style="color:#ECF0F1">Email</label>
                         </td>
                    
                    <td>

            <input type="email" name="email" value="<?php echo $rws[6]; ?>" />
                         </td>
                    </tr>
                <tr>
                    
                    
                    <td>







            <input type="submit" name="btnEditCustomer"  value="Update Customer Details" class="btn gold"/>
                    </td>
                </tr>
            </table>

        </form>




    </body>
</html>