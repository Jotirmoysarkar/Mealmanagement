<?php 
    $server = "localhost";
    $user = "root";
    $passwd = "";
    $db = "ordering";

    $orderingconn = mysqli_connect($server, $user, $passwd, $db);

    // check connection
    /*if (!$orderingconn) {
        die("Connection failed: ".mysqli_connect_error());
    } else {
        echo "Connected successfully";
    }*/
?>