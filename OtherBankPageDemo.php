<?php
// Start Session
session_start();
$api = 1;
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Change Password</title>

        <link rel="stylesheet" href="css/">
    </head>
    <body>





        <form action="http://localhost/HB123/test2.php?APIKEY=<?php echo $api; ?>" method="post">

            <label for="">Enter Sender Email</label>
            <input type="text" name="senderemail" />

            <label for="">Enter Sender Name</label>
            <input type="text" name="sendername" />

            <label for="">Enter Email</label>
            <input type="text" name="email" />

            <label for="">Enter amount</label>
            <input type="text" name="amount" />

            <label for="">Enter Security Question</label>
            <input type="text" name="securityQuestion" />

            <label for="">Enter Security Answer</label>
            <input type="text" name="securityAnswer"/>


            <input type="submit" name="checkout"  value="checkout"/>

        </form>




    </body>
</html>

