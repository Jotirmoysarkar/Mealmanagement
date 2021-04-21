<?php
    // stop all error reporting
    // error_reporting(0);

    // db conn
    include("dbconn.php");
    include("orderingdbconn.php");

    // start session
    session_start();

    // global variables
    $msg = "";
    /*
     * $accountFlag denotes the 
     * successful retrive of account balance
     * from database  
     */
    $accountFlag = 0;
    $memberName = "";
    $memberId = "";
    $accountBalance = "";
    $breakfastFlag = "";
    $lunchFlag = "";
    $dinnerFlag = "";
    $extraFlag = "";
    $cost = 0;
    $drawbackCash = 0;
    $hour = "";
    /*
     * if time is from 6:00PM to 11:59PM
     * a member can order into the
     * allowed table  
     */
    $timeFlag = 1; // 0 means false

    if (!$_SESSION["member"]) {
        header("Location: member_login.php");
    } else {
        $memberId = $_SESSION["member"];
        $sql = "SELECT member_name, account_balance FROM member WHERE member_id='$memberId'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        
        if (empty($row["member_name"]) || empty($row["account_balance"])) {
            $msg = "Error to load profile.";
        } else {
            $memberName = $row["member_name"];
            $accountBalance = $row["account_balance"];
            $accountFlag = 1;
        }
    }

    if (isset($_POST["logout"])) {
        session_unset();
        header("Location: member_login.php");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Member Profile | HMMS</title>
    <link rel="stylesheet" href="assets/css/member_profile_style.css">
</head>
<body>
    <h1>Welcome 
        <?php 
            echo $memberName;
        ?>
    </h1>
    <hr>
    <div id="main-container">
        <br>
        <h2>&nbsp;Logout</h2>
        <br>
        <form method="post">
            &nbsp;&nbsp;&nbsp;<input type="submit" name="logout" value="Logout">
        </form>
        <br>
        <h2>&nbsp;Account Balance</h2>
        <br>
        <div id="account-balance">
            <span>&nbsp;&nbsp;&nbsp;Your account balance: </span>
            <?php 
                if ($accountFlag == 1) {
                    echo $accountBalance;
                }
            ?>
        </div>
        <br>
        <h2>&nbsp;Order Meal</h2>
        <br>
        <form method="post">
            <?php
                $sql = "SELECT tablename FROM ordering_allowance WHERE allowance = 'true'";
                $result = mysqli_query($conn, $sql);
                $row = mysqli_fetch_assoc($result);

                if (empty($row["tablename"])) {
                    echo "&nbsp;&nbsp;&nbsp;No table is currently allowed. <br>";
                } else {
                    $currentlyAllowedTable = $row["tablename"];
                    echo "&nbsp;&nbsp;&nbsp;Currently allowed table: ".$currentlyAllowedTable."<br>";
                }
                echo "&nbsp;&nbsp;&nbsp;Select your meal options: <br>";
                echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='checkbox' name='breakfast' value='yes'>Breakfast<br>";
                echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='checkbox' name='lunch' value='yes'>Lunch<br>";
                echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='checkbox' name='dinner' value='yes'>Dinner<br>";
                echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='checkbox' name='extra' value='yes'>Extra<br>";
                echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='submit' name='order' value='Order'><br>";

                if (isset($_POST["order"])) {
                    if (empty($_POST["breakfast"])) {
                        $breakfastFlag = "no";
                    } else {
                        $breakfastFlag = $_POST["breakfast"];
                        $cost = $cost + 30;
                    }
                    if (empty($_POST["lunch"])) {
                        $lunchFlag = "no";
                    } else {
                        $lunchFlag = $_POST["lunch"];
                        $cost = $cost + 55;
                    }
                    if (empty($_POST["dinner"])) {
                        $dinnerFlag = "no";
                    } else {
                        $dinnerFlag = $_POST["dinner"];
                        $cost = $cost + 55;
                    }
                    if (empty($_POST["extra"])) {
                        $extraFlag = "no";
                    } else {
                        $extraFlag = $_POST["extra"];
                        $cost = $cost + 75;
                    }
            
                    /*date_default_timezone_set("UTC");
                    $hour = date("H");
                    $hour = (int)$hour;
                    $hour = $hour + 6;
                    
                    if ($hour >= 18 && $hour <= 24) {
                        $timeFlag = 1;
                    } else {
                        $timeFlag = 0;
                    }*/

                    if ($timeFlag == 1 && $accountFlag == 1) {
                        if ($accountBalance < $cost) {
                            echo "Sorry! You do not have sufficient balance.";
                        } else {
                            if ($breakfastFlag == "no" && $lunchFlag == "no" && $dinnerFlag == "no" && $extraFlag == "no") {
                                echo "Please, select at least one meal option.";
                            } else {
                                $sql = "SELECT member_id FROM ".$currentlyAllowedTable." WHERE member_id = '$memberId'";
                                $result = mysqli_query($orderingconn, $sql);
                                $row = mysqli_fetch_assoc($result);
                                if (empty($row["member_id"])) {
                                    $accountBalance = $accountBalance - $cost;
                                    $accountBalance = (string)$accountBalance;
                                    $cost = (string)$cost;
                                    $sql = "INSERT INTO ".$currentlyAllowedTable." (member_id, member_name, breakfast_flag, lunch_flag, dinner_flag, extrameal_flag, payment) 
                                    VALUES ('$memberId', '$memberName', '$breakfastFlag', '$lunchFlag', '$dinnerFlag', '$extraFlag', '$cost')";
                                    $result = mysqli_query($orderingconn, $sql);
                                    if (!$result) {
                                        echo "Failed to order. ".mysqli_connect_error($orderingconn);
                                    } else {
                                        echo "Order placed successfully. ";
                                    }
                                    $sql = "UPDATE member SET account_balance = '$accountBalance' WHERE member_id = '$memberId'";
                                    $result = mysqli_query($conn, $sql);
                                    if (!$result) {
                                        echo "Failed to update account. ".mysqli_connect_error($orderingconn);
                                    } else {
                                        echo "Account updated successfully.<br>";
                                        echo "Updated account balance: ".$accountBalance." ";
                                    }
                                } else {
                                    echo "You have an order already. ";
                                }
                            }
                        }
                    } else {
                        echo "Not ready to insert into database. ";
                    }
                }
            ?>
        </form>
        <br>
        <h2>&nbsp;Order Status and Cancel Option</h2>
        <br>
        <form method="post">
            &nbsp;&nbsp;&nbsp;Your current order status: <br>
            <?php 
                $sql = "SELECT member_name, breakfast_flag, lunch_flag, dinner_flag, extrameal_flag FROM ".$currentlyAllowedTable." WHERE member_id = '$memberId'";
                $result = mysqli_query($orderingconn, $sql);
                $row = mysqli_fetch_assoc($result);

                if (empty($row["member_name"])) {
                    echo "&nbsp;&nbsp;&nbsp;You have no order currently. ";
                } else {
                    echo "&nbsp;&nbsp;&nbsp;Table: ".$currentlyAllowedTable."<br>";
                    echo "&nbsp;&nbsp;&nbsp;Name: ".$row["member_name"]."<br>";
                    echo "&nbsp;&nbsp;&nbsp;ID: ".$memberId."<br>";
                    echo "&nbsp;&nbsp;&nbsp;Breakfast: ".$row["breakfast_flag"]."<br>";
                    echo "&nbsp;&nbsp;&nbsp;Lunch: ".$row["lunch_flag"]."<br>";
                    echo "&nbsp;&nbsp;&nbsp;Dinner: ".$row["dinner_flag"]."<br>";
                    echo "&nbsp;&nbsp;&nbsp;Extra: ".$row["extrameal_flag"]."<br>";
                    echo "&nbsp;&nbsp;&nbsp;<input type='submit' name='cancel' value='Cancel'><br>";
                    if (isset($_POST["cancel"])) {
                        if ($timeFlag == 1) {
                            if ($row["breakfast_flag"] == "yes") {
                                $drawbackCash = $drawbackCash + 30;
                            }
                            if ($row["lunch_flag"] == "yes") {
                                $drawbackCash = $drawbackCash + 55;
                            }
                            if ($row["dinner_flag"] == "yes") {
                                $drawbackCash = $drawbackCash + 55;
                            }
                            if ($row["extrameal_flag"] == "yes") {
                                $drawbackCash = $drawbackCash + 75;
                            }

                            $sql = "DELETE FROM ".$currentlyAllowedTable." WHERE member_id = '$memberId'";
                            $result = mysqli_query($orderingconn, $sql);
                            if (!$result) {
                                echo "Failed to cancel order. ".mysqli_connect_error($orderingconn);
                            } else {
                                echo "Order cancelled successfully. ";
                            }
                            $sql = "SELECT account_balance FROM member WHERE member_id = '$memberId'";
                            $result = mysqli_query($conn, $sql);
                            $row = mysqli_fetch_assoc($result);
                            if (empty($row["account_balance"])) {
                                echo "Failed to cash drawback. ".mysqli_connect_error($conn);
                            } else {
                                $balance = $row["account_balance"];
                                $balance = (int)$balance;
                                $drawbackCash = (int)$drawbackCash;
                                $balance = $balance + $drawbackCash;
                                $balance = (string)$balance;
                                $sql = "UPDATE member SET account_balance = '$balance' WHERE member_id = '$memberId'";
                                $result = mysqli_query($conn, $sql);
                                if (!$result) {
                                    echo "Failed to drawback cash. ".mysqli_connect_error($conn);
                                } else {
                                    echo "Cash drawbacked successfully.<br>";
                                    echo "Updated account balance: ".$balance." ";
                                }
                            }
                        }
                    }
                }
            ?>
        </form>
    </div>

    <div id="footer">
        <a href="index.php">Hostel Meal-Management System</a>
    </div>
</body>
</html>