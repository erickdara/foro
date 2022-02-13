<?php
include "connect.php";

$username = $_POST['username'];
$password = $_POST['password'];

// echo "" . $username;
// echo "" . $password;

// echo "Register credentials : ";
// echo "$username : $username" . "<br/>";
// echo "Password : $password";

$sql = "INSERT INTO forum_test.users(username, password)
        VALUES ('$username', '$password');
        ";

$res = mysqli_query($link, $sql);

if ($res) {
    echo "Succesfully registered as : " . $username;
} else {
    echo "Failed to register, please try again. ( Please make sure that
    you've filled in all of the blanks in the form. )<br/>";
    echo "Mysql Error : " . mysql_error();
}
