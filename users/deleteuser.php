<?php

include "../connect.php";

$id = $_REQUEST['record'];

if (!$connection) {
    die("Connection failed..." . mysqli_connect_error($connection));
} 
else {
        $query = "DELETE FROM stk_users WHERE userId=$id";
        $deleteQuery = mysqli_query($connection, $query);
        if ($deleteQuery) {
                header("location: displayusers.php");
        }
        else {
                die("MySQLI Error..." . mysqli_error($connection));
        }
}
