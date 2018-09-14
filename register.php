<?php
// Start Session
session_start();

// Database connection
require __DIR__ . '/database.php';
$db = DB();

// Application library ( with DemoLib class )
require __DIR__ . '/lib/library.php';
$app = new DemoLib();

$login_error_message = '';
$register_error_message = '';

// check Login request
if (!empty($_POST['btnLogin'])) {

    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if ($username == "") {
        $login_error_message = 'Username field is required!';
    } else if ($password == "") {
        $login_error_message = 'Password field is required!';
    } else {
        $user_id = $app->Login($username, $password); // check user login
        if ($user_id > 0) {
            $_SESSION['user_id'] = $user_id; // Set Session
            header("Location: profile.php"); // Redirect user to the profile.php
        } else {
            $login_error_message = 'Invalid login details!';
        }
    }
}

// check Register request
if (!empty($_POST['btnRegister'])) {
    if ($_POST['name'] == "") {
        $register_error_message = 'Name field is required!';
    } else if ($_POST['email'] == "") {
        $register_error_message = 'Email field is required!';
    } else if ($_POST['username'] == "") {
        $register_error_message = 'Username field is required!';
    } else if ($_POST['password'] == "") {
        $register_error_message = 'Password field is required!';
    } else if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $register_error_message = 'Invalid email address!';
    } else if ($app->isEmail($_POST['email'])) {
        $register_error_message = 'Email is already in use!';
    } else if ($app->isUsername($_POST['username'])) {
        $register_error_message = 'Username is already in use!';
    } else {
        $user_id = $app->Register($_POST['name'], $_POST['email'], $_POST['username'], $_POST['password']);
        // set session and redirect user to the profile page
        $_SESSION['user_id'] = $user_id;
        header("Location: profile.php");
    }
}
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Home</title>

        <link rel="stylesheet" href="css/bootstrap.min.css">
    </head>
    <body>

        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2>

                    </h2>
                </div>
            </div>
            <div class="form-group">

            </div>
            <div class="row">
                <div class="col-md-5 well">
                    <h4>Register</h4>
                    <?php
                    if ($register_error_message != "") {
                        echo '<div class="alert alert-danger"><strong>Error: </strong> ' . $register_error_message . '</div>';
                    }
                    ?>
                    <form action="index.php" method="post">
                        <div class="form-group">
                            <label for="">Name</label>
                            <input type="text" name="name" class="form-control"/>
                        </div>
                        <div class="form-group">
                            <label for="">Email</label>
                            <input type="email" name="email" class="form-control"/>
                        </div>
                        <div class="form-group">
                            <label for="">Username</label>
                            <input type="text" name="username" class="form-control"/>
                        </div>
                        <div class="form-group">
                            <label for="">Password</label>
                            <input type="password" name="password" class="form-control"/>
                        </div>
                        <div class="form-group">
                            <input type="submit" name="btnRegister" class="btn btn-primary" value="Register"/>
                        </div>
                    </form>
                </div>
                <div class="col-md-2"></div>
                <div class="col-md-5 well">
                    <h4>Login</h4>
                    <?php
                    if ($login_error_message != "") {
                        echo '<div class="alert alert-danger"><strong>Error: </strong> ' . $login_error_message . '</div>';
                    }
                    ?>
                    <form action="index.php" method="post">
                        <div class="form-group">
                            <label for="">Username/Email</label>
                            <input type="text" name="username" class="form-control"/>
                        </div>
                        <div class="form-group">
                            <label for="">Password</label>
                            <input type="password" name="password" class="form-control"/>
                        </div>
                        <div class="form-group">
                            <input type="submit" name="btnLogin" class="btn btn-primary" value="Login"/>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </body>
</html>