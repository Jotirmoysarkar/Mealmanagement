<?php
    // db conn
    include("dbconn.php");
    include("orderingdbconn.php");

    // start session
    session_start();

    if (!$_SESSION["admin"]) {
        header("Location: admin_login.php");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inspect | HMMS</title>
    <link rel="stylesheet" href="assets/css/inspect_style.css">
</head>
<body>
<h1><a href="admin_control_panel.php">Admin Control Panel</a> | Inspect</h1>
    <hr>
    <div id="main-container">
        <?php
            $sql = "SELECT tablename FROM ordering_allowance WHERE allowance = 'true'";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($result);
            if (empty($row["tablename"])) {
                echo "&nbsp;No table is currently allowed. ";
            } else {
                $currentlyAllowedTable = $row["tablename"];
                $sql = "SELECT * FROM ".$currentlyAllowedTable;
                $result = mysqli_query($orderingconn, $sql);
                echo "<table>";
                echo "<tr>";
                echo "<td class='tbl-head'>ID</td>";
                echo "<td class='tbl-head'>Name</td>";
                echo "<td class='tbl-head'>Breakfast</td>";
                echo "<td class='tbl-head'>Lunch</td>";
                echo "<td class='tbl-head'>Dinner</td>";
                echo "<td class='tbl-head'>Extra</td>";
                echo "<td class='tbl-head'>Payment</td>";
                echo "</tr>";
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>";
                    echo $row["member_id"];
                    echo "</td>";
                    echo "<td>";
                    echo $row["member_name"];
                    echo "</td>";
                    echo "<td>";
                    echo $row["breakfast_flag"];
                    echo "</td>";
                    echo "<td>";
                    echo $row["lunch_flag"];
                    echo "</td>";
                    echo "<td>";
                    echo $row["dinner_flag"];
                    echo "</td>";
                    echo "<td>";
                    echo $row["extrameal_flag"];
                    echo "</td>";
                    echo "<td>";
                    echo $row["payment"];
                    echo "</td>";
                    echo "</tr>";
                }
                echo "</table>";
            }
        ?>
    </div>
</body>
</html>