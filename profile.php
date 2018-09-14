<?php
// Start Session
session_start();

// check user login
if (empty($_SESSION['admin_id'])) {
    header("Location: index.php");
}

// Database connection
require __DIR__ . '/database.php';
$db = DB();

// Application library ( with DemoLib class )
require __DIR__ . '/lib/library.php';
$app = new DemoLib();

$user = $app->UserDetails($_SESSION['admin_id']); // get user details
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Profile</title>

        <link rel="stylesheet" href="css/main.css">
    </head>
    <body>
        <h2>
            Profile
        </h2>
        <h3>Hello <?php echo $user->name ?>, </h3>
        <h4>Your Email : <?php echo $user->email ?> </h4>
        <h4>Last Login : <?php echo $user->last_login ?> </h4>

        <ul>
            <b>Customer</b>
            <li> <a href="Add_New_Customer.php" class="btn gold">Add new customer</a></li>
            <li> <a href="Edit_Delete_Customer_Main.php" class="btn gold">Edit/Delete customer</a></li>
        </ul>

        <ul>
            <b>Customer</b>
            <li> <a href="shoppingRequestDone.php"  class="btn gold">Shopping Requests Processed</a></li>
            <li><a href=""  class="btn gold">Other Bank Requests</a></li>
        </ul>


        <ul>
            <b>Government</b>
            <li> <a href="government.php"  class="btn gold">List name from government</a></li>
        </ul>

        <a href="logout.php?id=<?Php $user->user_id ?>"  class="btn gold">Logout</a>
    </body>
</html>
