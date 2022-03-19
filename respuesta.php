<?php
require_once('config.php');

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $describeRespuesta = $_POST['describeRespuesta'];
    $idComentario = $_POST['idComentario'];

    session_start();
    if(isset($_SESSION['id'])){

        $idUsuario = $_SESSION['id'];

        $query = "INSERT INTO respuesta (idRespuesta, idComentario, idUsuario, describeRespuesta, created_at)
         VALUES (idRespuesta,'$idComentario', '$idUsuario', '$describeRespuesta', now());";

         $resultQuery = mysqli_query($link,$query);
         header('Location: ./User/index.php');

         if(!$resultQuery){
            echo "Query failed";
         }
    }
}
?>