<?php
// Start Session
session_start();

// Database connection
require __DIR__ . '/database.php';
$db = DB();


// Application library ( with DemoLib class )
require __DIR__ . '/lib/library.php';
$app = new DemoLib();

$error_message = '';
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Edit/Delete Customer</title>

        <link rel="stylesheet" href="css/">
    </head>
    <body>




        <h4>Customer List</h4>

        <form action="" method="POST">

            <table align="center">
                <caption align='center'><h3><u>Customer Details</u></h3></caption>
                <th>id</th>
                <th>name</th>
                <th>type</th>
                <th>email</th>
                <th>username</th>
                <th>debit number</th>
                <th>credit number</th>
                <th>account number</th>

                <?php
                $query = $db->prepare("SELECT hansonCustomer.customer_id, hansonCustomer.name, hansonCustomer.type, hansonUsers.email, hansonUsers.username,hansonUsersNumbers.debitnumber,hansonUsersNumbers.creditnumber,hansonUsersNumbers.accountnumber FROM hansonCustomer INNER JOIN hansonUsers ON hansonCustomer.customer_id = hansonUsers.user_id INNER JOIN hansonUsersNumbers ON hansonUsersNumbers.user_id = hansonUsers.user_id");
                $query->execute();


                for ($i = 0; $rws = $query->fetch(); $i++) {
                    echo "<tr><td>" . $rws[0];
                    echo "</td>";
                    echo "<td>" . $rws[1] . "</td>";
                    echo "<td>" . $rws[2] . "</td>";
                    echo "<td>" . $rws[3] . "</td>";
                    echo "<td>" . $rws[4] . "</td>";
                    echo "<td>" . $rws[5] . "</td>";
                    echo "<td>" . $rws[6] . "</td>";
                    echo "<td>" . $rws[7] . "</td>";

                    $enc_password = rawurlencode(urlencode(base64_encode($rws[0])));
                    echo "<td><a id ='edit' href=\"Edit_Customer.php?id=$enc_password\">Edit</a></td>";
                    echo "<td><a id = 'delete' href='Delete_Customer.php?id=$enc_password' onClick=\"return confirm('Are you sure you want to delete?')\">Delete</a></td>";
                    echo "</tr>";
                }
                ?>
            </table>



        </form>

    </body>
</html>