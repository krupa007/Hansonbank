<?php
// Start Session
session_start();

if (isset($_SESSION['admin_id'])) {
    header('location:profile.php');
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

    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if ($username == "") {
        $login_error_message = 'Username field is required!';
    } else if ($password == "") {
        $login_error_message = 'Password field is required!';
    } else {
        $user_id = $app->Login($username, $password); // check user login
        if ($user_id > 0) {
            $_SESSION['admin_id'] = $user_id; // Set Session
            header("Location: profile.php"); // Redirect user to the profile.php
        } else {
            $login_error_message = 'Invalid login details!';
        }
    }
}



$ip = $_SERVER['REMOTE_ADDR'];
$browser = $_SERVER['HTTP_USER_AGENT'];

echo "<b>Visitor IP address:</b><br/>" . $ip . "<br/>";
echo "<b>Browser (User Agent) Info:</b><br/>" . $browser . "<br/>";
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Hanson Bank - Admin Login</title>

        <link rel="stylesheet" href="css/main.css">
    </head>
            
<div class="card">
    <div class="top-block">
        <h1 class="title">Hanson Bank - Administration</h1>
    </div>

  
  <header class="card__thumb">
         <div id = formbox>
<form class="form" action="" method="post">
			<input type="text" name="username" placeholder="Email or username">
			<input type="password" name="password"  placeholder="Password">
		 
</div>
  </header>
  
  <div class="card__body">
      <input type="submit" name="btnLogin" value="Login" class="btn gold"/>
  </div>
  </form>
  
    <footer class="card__footer">

    </footer>
       



            