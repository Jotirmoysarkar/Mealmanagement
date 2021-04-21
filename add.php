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

    if (isset($_POST["add"])) {
        $memberId = $_POST["member_id"];
        $memberName = $_POST["member_name"];
        $memberPasswd = $_POST["member_passwd"];
        $accBalance = $_POST["acc_balance"];

        $sql = "SELECT member_id FROM member WHERE member_id = '$memberId'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);

        if (empty($row["member_id"])) {
            $sql = "INSERT INTO member (member_id, member_name, member_passwd, account_balance)
            VALUES ('$memberId', '$memberName', '$memberPasswd', '$accBalance')";
            $result = mysqli_query($conn, $sql);

            if ($result) {
                $msg = "Member Added Successfully";
            } else {
                $msg = "Error to Add Member";
            }
        } else {
            $msg = "Duplicate member id not allowed";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Member | HMMS</title>
    <link rel="stylesheet" href="assets/css/add_style.css">
</head>
<body>
    <h1><a href="admin_control_panel.php">Admin Control Panel</a> | Add Member</h1>
    <hr>
    <div id="add-member-container">
        <br>
        <h2>Add New Member</h2>
        <br> <br>
        <form method="post">
            <input class="input-fields" type="number" name="member_id" placeholder="Add Member ID" required> <br>
            <input class="input-fields" type="text" name="member_name" placeholder="Enter Member Name" required> <br>
            <input class="input-fields" type="password" name="member_passwd" placeholder="Enter Member Password" required> <br>
            <input class="input-fields" type="number" name="acc_balance" placeholder="Enter Account Balance" required> <br>
            <input type="submit" name="add" value="Add">
        </form>
        <br> <br>
        <div id="msg"><?php echo $msg; ?></div>
    </div>

    <div id="footer">
        <a href="index.php">Hostel Meal-Management System</a>
    </div>
</body>
</html>