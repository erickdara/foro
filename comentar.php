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

        $query = "INSERT INTO commentary (idCommentary, idTopic, idUser, describeCommentary, created_at)
         VALUES (idCommentary,'$idTema', '$idUsuario', '$describeComentario', now());";

        $resultQuery = mysqli_query($link, $query);

        if($resultQuery){
            $queryComentario = mysqli_query($link,"SELECT * FROM commentary order by idCommentary DESC LIMIT 1");
            $resultQueryComentario = mysqli_fetch_array($queryComentario);

            $idTema = $resultQueryComentario['idTopic'];
            $idUsuarioEmisor = $resultQueryComentario['idUser'];

            $queryTema = mysqli_query($link,"SELECT * FROM topic WHERE idTopic = '$idTema'");
            $resultQueryTema = mysqli_fetch_array($queryTema);

            $idUsuarioDestino =  $resultQueryTema['idUser'];

            $queryNotificacion = mysqli_query($link,"INSERT INTO notification (idNotification, idUser, idDestUser, idTopic, idNotificationType, created_at) VALUES (idNotification, '$idUsuarioEmisor', '$idUsuarioDestino','$idTema', 2, now());");

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
