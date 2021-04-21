<?php 
    // stop error reporting
    error_reporting(0);

    // db conn
    include("dbconn.php");

    // start session
    session_start();

    if ($_SESSION["member"]) {
        header("Location: member_profile.php");
    }

    // global variables
    $msg = "";

    if (isset($_POST["member_login"])) {
        $memberId = $_POST["member_id"];
        $memberPasswd = $_POST["member_passwd"];

        $sql = "SELECT member_id FROM member WHERE member_id = '$memberId' AND member_passwd = '$memberPasswd'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);

        if (empty($row["member_id"])) {
            echo "Invaild member id or password";
        } else {
            $_SESSION["member"] = $row["member_id"];
            header("Location: member_profile.php");
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | HMMS</title>
    <link rel="stylesheet" href="assets/css/member_login_style.css">
</head>
<body>
    <div id="member-login-container">
        <br> <br>
        <h2>Member Login</h2>
        <br> <br> <br> <br> <br> <br>
        <form method="post" id="member_login_form">
            <input type="text" name="member_id" placeholder="Enter member id" required> <br> <br>
            <input type="password" name="member_passwd" placeholder="Enter password" required> <br> <br> <br>
            <input type="submit" name="member_login" value="Member Login"> <br> <br>
        </form>
        <div id="msg"><?php echo $msg; ?></div>
    </div>
</body>
</html>