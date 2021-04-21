<?php
    // db conn
    include("dbconn.php");

    // start session
    session_start();

    if (!$_SESSION["admin"]) {
        header("Location: admin_login.php");
    }

    // global variables
    $msg = "";

    if (isset($_POST["refill"])) {
        $memberId = $_POST["member_id"];
        $amount = $_POST["amount"];

        $sql = "SELECT account_balance FROM member WHERE member_id = '$memberId'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);

        if (empty($row["account_balance"])) {
            $msg = "Invalid member id";
        } else {
            $existing_balance = $row["account_balance"];
            $existing_balance = (int)$existing_balance;
            $amount = (int)$amount;
            $new_balance = $existing_balance + $amount;
            $new_balance = (string)$new_balance;

            $sql = "UPDATE member SET account_balance = '$new_balance' WHERE member_id = '$memberId'";
            $result = mysqli_query($conn, $sql);

            if ($result) {
                $msg = "Account refilled successful of member id: ".$new_balance;
            } else {
                $msg = "Account refilled unsuccessful of member id: ".$memberId;
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Refill Account | HMMS</title>
    <link rel="stylesheet" href="assets/css/refill_style.css">
</head>
<body>
<h1><a href="admin_control_panel.php">Admin Control Panel</a> | Refill Account</h1>
    <hr>
    <div id="refill-account-container">
        <br>
        <h2>Refill Account</h2>
        <br> <br>
        <form method="post">
            <input class="input-fields" type="number" name="member_id" placeholder="Enter member id" required> <br> <br>
            <input class="input-fields" type="number" name="amount" placeholder="Enter amount" required> <br> <br> <br>
            <input type="submit" name="refill" value="refill">
        </form>
        <br> <br>
        <div id="msg"><?php echo $msg; ?></div>
    </div>

    <div id="footer">
        <a href="index.php">Hostel Meal-Management System</a>
    </div>
</body>
</html>