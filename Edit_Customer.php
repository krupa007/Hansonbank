<?php
// Start Session
session_start();
if (empty($_SESSION['admin_id'])) {
    header("Location: index.php");
}
// Database connection
require __DIR__ . '/database.php';
$db = DB();


// Application library ( with DemoLib class )
require __DIR__ . '/lib/library.php';
$app = new DemoLib();

$error_message = '';

// check update request
if (!empty($_POST['btnEditCustomer'])) {

    if ($_POST['name'] == "") {
        $error_message = 'Name field is required!';
    } else if ($_POST['dob'] == "") {
        $error_message = 'Date of Birth field is required!';
    } else if ($_POST['gender'] == "") {
        $error_message = 'Gender field is required!';
    } else if ($_POST['type'] == "") {
        $error_message = 'Type field is required!';
    } else if ($_POST['debit'] == "") {
        $error_message = 'Debit field is required!';
    } else if ($_POST['credit'] == "") {
        $error_message = 'Credit number is required!';
    } else if ($_POST['address'] == "") {
        $error_message = 'address field is required!';
    } else if ($_POST['mobile'] == "") {
        $error_message = 'Mobile field is required!';
    } else if ($_POST['email'] == "") {
        $error_message = 'E-Mail field is required!';
    } else if ($_POST['username'] == "") {
        $error_message = 'Username field is required!';
    } else if ($_POST['password'] == "") {
        $error_message = 'Password field is required!';
    } else if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $error_message = 'Invalid email address!';
    } else if ($app->isCustomerEmail($_POST['email'])) {
        $error_message = 'Email is already in use!';
    } else if ($app->isCustomerUsername($_POST['username'])) {
        $error_message = 'Username is already in use!';
    } else {
        $user_id = $app->Update_Customer($_POST['customer_id'], $_POST['name'], $_POST['gender'], $_POST['dob'], $_POST['type'], $_POST['debit'], $_POST['credit'], $_POST['address'], $_POST['mobile'], $_POST['email'], $_POST['username']);
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

        <link rel="stylesheet" href="css/">
    </head>
    <body>




        <h4>Edit Customer</h4>


        <table align="center">
            <caption align='center' style='color:#2E4372'><h3><u>Customer Details</u></h3></caption>
            <th>id</th>
            <th>name</th>
            <th>type</th>
            <th>email</th>
            <th>username</th>
            <th>debit number</th>
            <th>credit number</th>
            <th>account number</th>
            <?php
            $id = $_GET['id'];
            $id = base64_decode(urldecode(rawurldecode($id)));
            $query = $db->prepare("SELECT hansonCustomer.customer_id, hansonCustomer.name, hansonCustomer.type, hansonUsers.email, hansonUsers.username,hansonUsersNumbers.debitnumber,hansonUsersNumbers.creditnumber,hansonUsersNumbers.accountnumber FROM hansonCustomer INNER JOIN hansonUsers ON hansonCustomer.customer_id = hansonUsers.user_id INNER JOIN hansonUsersNumbers ON hansonUsersNumbers.user_id = hansonUsers.user_id");
            $query->execute();


            $rws = $query->fetch();
            echo "<tr><td>" . $rws[0] . "</td>";
            echo "<td>" . $rws[1] . "</td>";

            echo "<td>" . $rws[2] . "</td>";
            echo "<td>" . $rws[3] . "</td>";
            echo "<td>" . $rws[4] . "</td>";
            echo "<td>" . $rws[5] . "</td>";
            echo "<td>" . $rws[6] . "</td>";
            echo "<td>" . $rws[7] . "</td>";



            echo "</tr>";
            ?>
        </table>

        <form action="" method="post">
            <input type="text" name="customer_id" hidden="" value="<?php echo $rws[0]; ?>" />
            <label for="">Name</label>
            <input type="text" name="name" value="<?php echo $rws[1]; ?>" />

            M<input type="radio" name="gender" value="M" <?php if ($rws[2] == 'M') { ?> checked<?php } ?>/>
            F<input type="radio" name="gender" value="F" <?php if ($rws[2] == 'F') { ?> checked<?php } ?>/>

            <label for="">Date of Birth</label>
            <input type="date" name="dob" value="<?php echo $rws[3]; ?>" required=""/>

            <label for="">Type</label>
            <select name="type">


                <option <?php if ($rws[4] == 'savings') { ?> selected<?php } ?> >savings</option>
                <option <?php if ($rws[4] == 'current') { ?> selected<?php } ?> >current</option>
            </select>


            <label for="">Debit</label>
            <input type="text" name="debit" required="" value="<?php echo $rws[5]; ?>"/>

            <label for="">Credit</label>
            <input type="text" name="credit" required="" value="<?php echo $rws[6]; ?>"/>


            <label for="">Address</label>
            <textarea name="address" required=""><?php echo $rws[7]; ?></textarea>

            <label for="">Mobile</label>
            <input type="text" name="mobile" required="" value="<?php echo $rws[8]; ?>"/>

            <label for="">Email</label>
            <input type="email" name="email" value="<?php echo $rws[9]; ?>" />






            <input type="submit" name="btnEditCustomer"  value="Update Customer Details"/>

        </form>




    </body>
</html>