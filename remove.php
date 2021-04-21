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
    $temp = "";
    $hmemberId = "";

    if (isset($_POST["remove"])) {
        $hmemberId = $_POST["hmember_id"];
        $sql = "DELETE FROM member WHERE member_id = '$hmemberId'";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            $msg = "Member removed successfully";
        } else {
            $msg = "Error removing member";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View/Remove | HMMS</title>
    <link rel="stylesheet" href="assets/css/remove_style.css">
</head>
<body>
    <h1><a href="admin_control_panel.php">Admin Control Panel</a> | View/Remove</h1>
    <hr>
    <div id="main-container">
        <div id="msg"><?php echo $msg; ?></div> 
        <br>
        <table>
            <tr>
                <td class="th-col">Member ID</td>
                <td class="th-col">Member Name</td>
                <td class="th-col">Account Balance</td>
                <td class="th-col">Remove</td>
            </tr>
        <?php 
            $sql = "SELECT member_id, member_name, account_balance FROM member";
            $result = mysqli_query($conn, $sql);

            while ($row = mysqli_fetch_assoc($result)) { 
                echo "<tr>";
                echo "<form method='post'>";
                echo "<td>";
                echo $row["member_id"];
                $temp = $row["member_id"];
                echo "<input type='hidden' name='hmember_id' value='$temp'>";
                echo "</td>";
                echo "<td>";
                echo $row["member_name"];
                echo "</td>";
                echo "<td>";
                echo $row["account_balance"];
                echo "</td>";
                echo "<td>";
                echo "<input type='submit' name='remove' value='Remove'>";
                echo "</td>";
                echo "</form>";
                echo "</tr>";
            }
        ?>
        </table>
    </div>

    <div id="footer">
        <a href="index.php">Hostel Meal-Management System</a>
    </div>
</body>
</html>