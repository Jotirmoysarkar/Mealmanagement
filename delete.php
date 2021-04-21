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
    $currentlyAllowedTable = "";
    $temp = "";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Order Table | HMMS</title>
    <link rel="stylesheet" href="assets/css/delete_style.css">
</head>
<body>
<h1><a href="admin_control_panel.php">Admin Control Panel</a> | Delete Order Table</h1>
    <hr>
    <div id="main-container">
        <br>
        &nbsp;<span style="color: blue; font-size: 24px;"><b>Currently Allowed Table:</b></span>
        <?php 
            $sql = "SELECT tablename FROM ordering_allowance WHERE allowance='true'";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($result);
            if (empty($row["tablename"])) {
                echo "No table is allowed currently";
            } else {
                $currentlyAllowedTable = $row["tablename"];
                echo $currentlyAllowedTable;
            }

            if (isset($_POST["delete"])) {
                $tabletobeDeleted = $_POST["slct_table"];
        
                if ($tabletobeDeleted == $currentlyAllowedTable) {
                    $msg = "This table is currently allowed";
                } else {
                    $sql = "DELETE FROM ordering_allowance WHERE tablename = '$tabletobeDeleted'";
                    $result = mysqli_query($conn, $sql);
        
                    if ($result) {
                        $msg = "Table name removed from ordering allowance. ";
                    } else {
                        $msg = "Error to remove table name from ordering allowance. ";
                    }
        
                    $sql = "DROP TABLE ".$tabletobeDeleted;
                    $result = mysqli_query($orderingconn, $sql);
        
                    if ($result) {
                        $msg = $msg."Table deleted successfully.";
                    } else {
                        $msg = $msg."Failed to delete table.".mysqli_connect_error($orderingconn);
                    }
                }
            }
        ?>
        <br> <br>
        <form method="post">
            &nbsp;<span style="color: blue; font-size: 24px;"><b>Select Table to Delete: </b></span>
                <?php 
                    $sql = "SELECT tablename FROM ordering_allowance";
                    $result = mysqli_query($conn, $sql);
                    echo "<select name='slct_table'>";
                    while ($row = mysqli_fetch_assoc($result)) {
                        $temp = $row["tablename"];
                        echo "<option>";
                        echo $temp;
                        echo "</option>";
                    }
                    echo "</select>";
                    echo "<br>&nbsp;<input type='submit' name='delete' value='Delete'>";
                ?>
        </form>
        <br> <br>
        <div style="color: orange;">&nbsp;<?php echo $msg; ?></div>
    </div>

    <div id="footer">
        <a href="index.php">Hostel Meal-Management System</a>
    </div>
</body>
</html>