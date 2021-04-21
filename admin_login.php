<?php
    // stop all errors
    error_reporting(0);

    // db conn
    include("dbconn.php");

    // start session
    session_start();

    if ($_SESSION["admin"]) {
        header("Location: admin_control_panel.php");
    }

    // declare global variables
    $msg = "";

    if (isset($_POST["admin_login"])) {
        $adminId = $_POST["admin_id"];
        $passwd = $_POST["passwd"];

        if (empty($adminId) || empty($passwd)) {
            $msg = "Both fields are required";
        } else {
            $sql = "SELECT admin_id, passwd FROM admin WHERE admin_id = '$adminId' AND passwd = '$passwd'";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($result);
            
            if (empty($row["admin_id"])) {
                $msg = "Invalid admin or password";
            } else {
                $_SESSION["admin"] = $adminId;
            }
        } 
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | HMMS</title>
    <link rel="stylesheet" href="assets/css/admin_login_style.css">
</head>
<body>
    <div id="admin-login-container">
        <br> <br>
        <h2>Admin Login</h2>
        <br> <br> <br> <br> <br> <br>
        <form method="post" id="admin_login_form">
            <input type="text" name="admin_id" placeholder="Enter admin id"> <br> <br>
            <input type="password" name="passwd" placeholder="Enter password"> <br> <br> <br>
            <input type="submit" name="admin_login" value="Admin Login"> <br> <br>
        </form>
        <div id="msg"><?php echo $msg; ?></div>
    </div>
</body>
</html>