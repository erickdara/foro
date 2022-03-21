<?php

//Initialize the session
session_start();

require_once 'App/Auth/Auth.php';

Auth::logout();

//Unset all of the session variables
$_SESSION = array();

//Destroy the session
session_destroy();

//Redirect the login page
header("location: index.php");
//die();
exit;
