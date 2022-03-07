<?php

//Initialize the session
session_start();

//Unset all of the session variables
$_SESSION = array();

//Destroy the session
session_destroy();

//Redirect the login page
header("location: ./Strange/index.php");
exit;
