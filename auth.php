<?php
/**
 * Build a simple HTML page with multiple providers.
 */

include 'hybridauth/src/autoload.php';
include 'App/Auth/config.php';

use Hybridauth\Hybridauth;

$hybridauth = new Hybridauth($config);
$adapters = $hybridauth->getConnectedAdapters();
?>

