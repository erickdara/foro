<?php
require_once 'config.php';

// Check if the user is already logged in, if yes then redirect him to welcome page
// if (!isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] == false) {
//     header("location: index.php?logged=false");
//     die();
//     //exit;
// }

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $describeComentario = $_POST['describeComentario'];
    $idTema = $_POST['idTema'];

    session_start();
    if (isset($_SESSION['id'])) {

        $idUsuario = $_SESSION['id'];

        $query = "INSERT INTO comentario (idComentario, idTema, idUsuario, describeComentario, created_at)
         VALUES (idComentario,'$idTema', '$idUsuario', '$describeComentario', now());";

        $resultQuery = mysqli_query($link, $query);

        if($resultQuery){
            $queryComentario = mysqli_query($link,"SELECT * FROM comentario order by idComentario DESC LIMIT 1");
            $resultQueryComentario = mysqli_fetch_array($queryComentario);

            $idTema = $resultQueryComentario['idTema'];
            $idUsuario = $resultQueryComentario['idUsuario'];

            $queryNotificacion = mysqli_query($link,"INSERT INTO notificacion (idNotificacion, idUsuario, idTema, tipoNotificacion, created_at) VALUES (idNotificacion, '$idUsuario', '$idTema', 'ha dejado un comentario sobre', now());");

            header("Location: ./User/index.php");
            exit;
        }else{
            echo("Query notificacion failed");
        }

        if (!$resultQuery) {
            echo "Query failed";
        }
    }
}
