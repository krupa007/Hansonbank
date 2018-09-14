<?php
// Start Session
session_start();
// Database connection
require __DIR__ . '/database.php';
$db = DB();

// Application library ( with DemoLib class )
require __DIR__ . '/lib/library.php';
$app = new DemoLib();
$session = $_SESSION['customer_id'];
$username = $_SESSION['username'];
$pastTime = time() - $_SESSION['login_time'];

// check user login
if (empty($session)) {

    unset($_SESSION['customer_id'], $_SESSION['login_time']);
    header("Location: indexCustomer.php");
}
if ($pastTime > 1000) {
    $try = $app->deleteHash($session);
    unset($_SESSION['customer_id'], $_SESSION['login_time']);
    header("Location: indexCustomer.php");
} else {
    $_SESSION['login_time'] = time();
    $try = $app->checkHash($session);
}
echo $pastTime;
echo '<br>';
echo $username;
?>



<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Full Statement</title>

        <link rel="stylesheet" href="css/main.css">



        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>

        <script type="text/javascript">
            $(document).ready(function () {

                // submit form using $.ajax() method

                $('#reg-form').submit(function (e) {

                    var startDate = $("#startDate").val();
                    var endDate = $("#endDate").val();


                    // Returns successful data submission message when the entered information is stored in database.
                    //var dataString = 'name1=' + name + '&email1=' + email + '&password1=' + password + '&contact1=' + contact;
                    if (startDate == '' || endDate == '') {
                        alert("Please Fill All Fields");
                    } else {

                        e.preventDefault(); // Prevent Default Submission

                        $.ajax({
                            url: 'customerFullStatementShowRecord.php',
                            type: 'POST',
                            data: $(this).serialize() // it will serialize the form data
                        })
                                .done(function (data) {
                                    $('#form-content2').fadeOut('slow', function () {
                                        $('#form-content2').fadeIn('slow').html(data);
                                    });
                                })
                                .fail(function () {
                                    alert('Ajax Submit Failed ...');
                                });
                    }
                });
            });

        </script>
    </head>
    <body>
        <form action="" method="POST" id="reg-form">
            <table align="center" style="color:#ECF0F1">
                <tr><td>Start Date </td><td>
                        <input type="date" name="startDate" id="startDate" required></td></tr>

                <tr><td>End Date</td><td>
                        <input type="date" name="endDate" id ="endDate" required></td></tr>
                <tr><td><input type="submit" name="btngetFullStatement" value="Show"/></td></tr>
            </table>


        </form>


        <div id ="form-content2">  


        </div>
    </body>
</html>