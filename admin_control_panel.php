<?php
    // db conn
    include("dbconn.php");

    // start session
    session_start();

    if (isset($_POST["logout"])) {
        session_unset();
    }

    if (!$_SESSION["admin"]) {
        header("Location: admin_login.php");
    }

    // echo "welcome ".$_SESSION["admin"];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Control Panel | HMMS</title>
    <link rel="stylesheet" href="assets/css/admin_cpanel_style.css">
</head>
<body>
    <h1>Admin Control Panel</h1>
    <hr>
    <div id="main-container">
        <form method="post" id="logout-form">
            <input type="submit" name="logout" value="Logout"> <br>
        </form>
        <br>
        <h2>Task Options</h2>
        <div id="task-options-container">
            <div class="task-items"><a href="add.php">Add Member</a></div> <br>
            <div class="task-items"><a href="remove.php">View/Remove</a></div> <br>
            <div class="task-items"><a href="refill.php">Refill Account</a></div> <br>
            <div class="task-items"><a href="allow_ordering.php">Allow Ordering</a></div> <br> 
            <div class="task-items"><a href="delete.php">Delete Order Table</a></div> <br>
            <div class="task-items"><a href="inspect.php">Inspect Orders</a></div> <br>
        </div>
    </div>

    <div id="footer">
        <a href="index.php">Hostel Meal-Management System</a>
    </div>
</body>
</html>