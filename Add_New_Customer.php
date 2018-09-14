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


// check Register request
if (!empty($_POST['btnAddNewCustomer'])) {
    if ($_POST['name'] == "") {
        $error_message = 'Name field is required!';
    } else if ($_POST['lastname'] == "") {
        $error_message = 'last name is required!';
    } else if ($_POST['dob'] == "") {
        $error_message = 'Date of Birth is required!';
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
        $user_id = $app->Add_New_Customer($_POST['name'], $_POST['lastname'], $_POST['gender'], $_POST['dob'], $_POST['type'], $_POST['debit'], $_POST['credit'], $_POST['address'], $_POST['mobile'], $_POST['email'], $_POST['username'], $_POST['password']);
        // set session and redirect user to the profile page
        if ($user_id == 'success') {
            $error_message = 'success';
            header("Location: profile.php");
        }
    }
}
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Add New Customer</title>

        <link rel="stylesheet" href="css/">
    </head>
    <body>




        <h4>Add New Customer</h4>
        <?php
        if ($error_message != "") {
            echo $error_message;
        }
        ?>
        <form action="Add_New_Customer.php" method="post">

            <label for="">Name</label>
            <input type="text" name="name" />

            <label for="">Last Name</label>
            <input type="text" name="lastname" />

            M<input type="radio" name="gender" value="Male" checked/>
            F<input type="radio" name="gender" value="Female" />

            <label for="">Date of Birth</label>
            <input type="date" name="dob" required=""/>

            <label for="">Type</label>
            <select name="type">
                <option>Savings</option>
                <option>Current</option>
            </select>


            <label for="">Debit</label>
            <input type="text" name="debit" required=""/>
            <label for="">Credit</label>
            <input type="text" name="credit" required=""/>

            <label for="">Address</label>
            <textarea name="address" required=""></textarea>

            <label for="">Mobile</label>
            <input type="text" name="mobile" required=""/>

            <label for="">Email</label>
            <input type="email" name="email" />


            <label for="">Username</label>
            <input type="text" name="username" />

            <label for="">Password</label>
            <input type="password" name="password"/>


            <input type="submit" name="btnAddNewCustomer"  value="Register"/>

        </form>




    </body>
</html>