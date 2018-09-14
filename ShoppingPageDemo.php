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





        <form action="http://localhost/HB123/test.php?APIKEY=<?php echo $api; ?>" method="post">

            <label for="">card number</label>
            <input type="text" name="cardnumber" />

            <label for="">cvv</label>
            <input type="text" name="cvv" />

            <label for="">Amount</label>
            <input type="text" name="amount" />

            <label for="">expire date</label>
            <input type="date" name="expdate"/>


            <input type="submit" name="checkout"  value="checkout"/>

        </form>




    </body>
</html>

