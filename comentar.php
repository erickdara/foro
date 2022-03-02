<?php
require_once('config.php');

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $describeComentario = $_POST['describeComentario'];
    $idTema = $_POST['idTema'];

    session_start();
    if(isset($_SESSION['id'])){

        $idUsuario = $_SESSION['id'];

        $query = "INSERT INTO comentario (idComentario, idTema, idUsuario, describeComentario, created_at)
         VALUES (idComentario,'$idTema', '$idUsuario', '$describeComentario', now());";

         $resultQuery = mysqli_query($link,$query);
         header('Location: index.php');

         if(!$resultQuery){
            echo "Query failed";
         }
    }
}
?>