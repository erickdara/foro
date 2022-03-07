<?php 

require_once('vendor/autoload.php');

// var_dump($_REQUEST['hauth_start']);
// var_dump($_REQUEST['hauth_done']);

if(isset($_REQUEST['hauth_start']) || isset($_REQUEST['hauth_done']))
{
    Hybrid_Endpoint::process();
}

?>