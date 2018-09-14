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

$getMiniStatement = $app->getShoppingTrack();
?>



<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Shopping Request Processed</title>

        <link rel="stylesheet" href="newcss.css">

    </head>
    <body>
        <br><br><br>
        <h3><u>Shopping Request Processed</u></h3>
        <form action="" method= "POST">
            <table align="center">
                <th>Date</th>
                <th>Name</th>
                <th>Card Number</th>
                <th>Amount paid</th>
                <th>Narration</th>


                <?php
                if ($getMiniStatement != "") {
                    while ($rws = array_shift($getMiniStatement)) {

                        echo "<tr>";
                        //echo "<td>".$rws->beneficiary_id."</td>";
                        echo "<td>" . $rws->date . "</td>";
                        echo "<td>" . $rws->customername . "</td>";
                        echo "<td>" . $rws->cardnumber . "</td>";
                        echo "<td>" . $rws->amountpaid . "</td>";
                        echo "<td>" . $rws->narration . "</td>";
                        echo "</tr>";
                    }
                } else {

                    echo 'No transcation to show ';
                }
                ?>
            </table>

        </form>
    </div>
</body>
</html>