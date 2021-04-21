<?php
    // db conn
    include("dbconn.php");
    include("orderingdbconn.php");

    // start session
    session_start();

    if (!$_SESSION["admin"]) {
        header("Location: admin_login.php");
    }

    // global variables
    $msg = "";

    if (isset($_POST["create"])) {
        $orderingTable = $_POST["ordering_table"];
        list($year,$month,$day) = explode("-", date($orderingTable));
        $orderingTable = "y".$year."m".$month."d".$day;
        // echo $orderingTable;

        $sql = "SELECT tablename FROM ordering_allowance WHERE tablename = '$orderingTable'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);

        if (empty($row["tablename"])) {
            $sql = "CREATE TABLE ".$orderingTable." (
                member_id varchar(255) PRIMARY KEY,
                member_name varchar(255),
                breakfast_flag varchar(255),
                lunch_flag varchar(255),
                dinner_flag varchar(255),
                extrameal_flag varchar(255),
                payment varchar(255)
            )";
            $result = mysqli_query($orderingconn, $sql);

            if ($result) {
                $msg = "Ordering table created successfully. ";
            } else {
                $msg = "Error in creating ordering table. ".mysqli_error($orderingconn);
            }

            $sql = "INSERT INTO ordering_allowance (tablename, allowance) 
            VALUES ('$orderingTable', 'false')";
            $result = mysqli_query($conn, $sql);

            if ($result) {
                $msg = $msg."Insertion into ordering allowance successful";
            } else {
                $msg = $msg."Error to insert into ordering allowance";
            }
        } else {
            $msg = "Table already exists";
        }
    }

    if (isset($_POST["allow"])) {
        $allowedTable = $_POST["slct_table_name"];
        
        $sql = "UPDATE ordering_allowance SET allowance = 'false'";
        $result = mysqli_query($conn, $sql);
        
        if ($result) {
            $msg = "Ordering allowance has been reset. ";
        } else {
            $msg = "Failed to reset ordering allowance. ";
        }

        $sql = "UPDATE ordering_allowance SET allowance = 'true' WHERE tablename = '$allowedTable'";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            $msg = $msg." Allowance update successful.";
        } else {
            $msg = $msg."Falied to update allowance.";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Allow Ordering | HMMS</title>
    <link rel="stylesheet" href="assets/css/allow_ordering_style.css">
</head>
<body>
<h1><a href="admin_control_panel.php">Admin Control Panel</a> | Allow Ordering</h1>
    <hr>
    <div id="main-container">
        <br>
        <div id="msg"><?php echo $msg; ?></div> 
        <br>
        <form method="post">
            <table>
                <tr>
                    <td>Select a date:</td>
                    <td><input type="date" name="ordering_table" required></td>
                </tr>
                <tr>
                    <td colspan="2"><input type="submit" name="create" value="Create Ordering Table"></td>
                </tr>
            </table>
        </form>
        <br> <br>
        <form method="post">
            &nbsp;Allow ordering for table:
            <?php 
                $sql = "SELECT tablename FROM ordering_allowance";
                $result = mysqli_query($conn, $sql);
                echo "<form method='post'>";
                echo "<select name='slct_table_name'>";
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<option>";
                    echo $row["tablename"];
                    echo "</option>";
                }
                echo "</select>";
                echo "<br>&nbsp;<input type='submit' name='allow' value='Allow'>";
                echo "</form>";
            ?>
        </form>
    </div>

    <div id="footer">
        <a href="index.php">Hostel Meal-Management System</a>
    </div>
</body>
</html>