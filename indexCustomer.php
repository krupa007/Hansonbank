<?php
// Start Session
session_start();
if (isset($_SESSION['customer_id'])) {
    header('location:profile_Customer.php');
}

// Database connection
require __DIR__ . '/database.php';
$db = DB();

// Application library ( with DemoLib class )
require __DIR__ . '/lib/library.php';
$app = new DemoLib();

$login_error_message = '';

// check Login request
if (!empty($_POST['btnLogin'])) {

    $username = trim($_POST['user']);
    $password = trim($_POST['pass']);

    if ($username == "") {
        $login_error_message = 'Username field is required!';
    } else if ($password == "") {
        $login_error_message = 'Password field is required!';
    } else {
        $user_id = $app->CustomerLogin($username, $password); // check user login
        if ($user_id != false) {
            $user_id1 = json_decode($user_id, true);
            $_SESSION['customer_id'] = $user_id1['token']; // Set Session
            $_SESSION['username'] = $user_id1['name'];
            $_SESSION['login_time'] = time();
            header("Location: profile_Customer.php"); // Redirect user to the profile.php
        } else {
            $login_error_message = 'Invalid login details!';
        }
    }
}
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Hanson Bank - Customer Login</title>

        <link rel="stylesheet" href="css/main.css">
    </head>
    <body>

        <?php
        if ($login_error_message != "") {
            echo $login_error_message;
        }
        ?>
<!-- 
        <form action="" method="post">
            <div class="form-group">
                <label for="">Username/Email</label>
                <input type="text" name="user"/>
            </div>
            <div >
                <label for="">Password</label>
                <input type="password" name="pass"/>
            </div>
            <div class="form-group">
                <input type="submit" name="btnLogin" value="Login"/> 
            </div>

            ???? -->
            <div class="card">
    <div class="top-block">
        <h1 class="title">Hanson Bank</h1>
    </div>

  
  <header class="card__thumb">
         <div id = formbox>
<form class="form" action="" method="post">
			<input type="text" name="user" placeholder="Email or username">
			<input type="password" name="pass"  placeholder="Password">
		 
</div>
  </header>
  
  <div class="card__body">
      <input type="submit" name="btnLogin" value="Login" class="btn gold"/>
  </div>
  </form>
  
    <footer class="card__footer">

    </footer>