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
//echo $username;
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Transfer Funds</title>

        <link rel="stylesheet" href="css/main.css">

        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>

        <script type="text/javascript">

            $(document).ready(function () {

                // submit form using $.ajax() method

                $('#reg-form').submit(function (e) {

                    var amount = $("#amount").val();



                    // Returns successful data submission message when the entered information is stored in database.
                    //var dataString = 'name1=' + name + '&email1=' + email + '&password1=' + password + '&contact1=' + contact;
                    if (amount == '') {
                        alert("Please Fill All Fields");
                    } else {

                        e.preventDefault(); // Prevent Default Submission

                        $.ajax({
                            url: 'creditPaymentProcess.php',
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

    <h3><u class="btn gold" style="color:#ECF0F1">Transfer Funds</u></h3>

    <form action='' method='POST' id="reg-form">
        <table align='center' border="0px">
            <tr><td style="color:#ECF0F1">Enter Amount: </td><td><input type='number' name='transferAmount' required id="amount"></td></table>
        <table align='center'><tr><td style='padding:5px;'><input type='submit' name='btnTransfer' value='Transfer' class='addstaff_button'></td></tr></table></form>

    <div id="form-content2">

    </div>
<?php
// if ($getBeneficiary != "") {
//     echo "<form action='' method='POST'>";
//     echo "<table align='center'>";
//     echo "<tr><td>Select Beneficiary:</td><td> <select name='transferName'>";
//     while ($rws = array_shift($getBeneficiary)) {
//         echo "<option value='$rws->receiver_id'>$rws->receiver_name</option>";
//     }
//     echo "</td></tr></select>";
//     echo "<tr><td>Enter Amount: </td><td><input type='number' name='transferAmount' required></td></table>";
//     echo "<table align='center'><tr><td style='padding:5px;'><input type='submit' name='btnTransfer' value='Transfer' class='addstaff_button'></td></tr></table></form>";
// } else {
//     echo "<br><br><div class='head'><h3>No Benefeciary Added with your account.</h3></div>";
// }
?>
