<?php
// Include config file
require_once "config.php";

$sql = "SELECT * FROM menu";

$stmt = mysqli_prepare($link, $sql);
$stmt->execute();
$resultSet = $stmt->get_result();
$items = $resultSet->fetch_all(MYSQLI_ASSOC);
//var_dump($data);
//print_r($items);
