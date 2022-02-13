<?php
$database = array();
$database['host'] = "localhost";
$database['port'] = "3306";
$database['name'] = "forum_test";
$database['username'] = "root";
$database['password'] = "";

$link = mysqli_connect($database['host'], $database['username'], $database['password']);

if ($link) {
    // echo "Succesfully connected to database : " . $database['name'];
} else {
    echo "Connect to database : " . $database['name'] . "failed<br/>";
    echo "Error : " . mysql_error();
}
