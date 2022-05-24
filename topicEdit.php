<?php 
require("config.php");

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $tilteTopic = $_POST['titleTopic'];
    $describeTopic  = $_POST['describeTopic'];
    $idTopic = $_POST['idTopic'];
    
    $queryUpdate = "UPDATE topic SET titleTopic = '$tilteTopic', describeTopic = '$describeTopic', created_at = now() WHERE idTopic = '$idTopic'";
    $resultUpdate = mysqli_query($link,$queryUpdate);

    if($resultUpdate){
        header("Location: ./User/index.php");
    }else{
        echo "Query topic update failed";
    }


}
?>