<?php
require_once('config.php');

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $describeRespuesta = $_POST['describeRespuesta'];
    $idCommentary = $_POST['idCommentary'];

    session_start();
    if(isset($_SESSION['id'])){

        $idUsuario = $_SESSION['id'];

        $query = "INSERT INTO answer (idAnswer, idCommentary, idUser, describeAnswer, created_at)
         VALUES (idAnswer,'$idCommentary', '$idUsuario', '$describeRespuesta', now());";

         $resultQuery = mysqli_query($link,$query);

         if($resultQuery){
            $queryRespuesta = mysqli_query($link,"SELECT a.idAnswer, a.idUser, a.idCommentary, t.idTopic FROM answer a
            INNER JOIN commentary c ON a.idCommentary = c.idCommentary
            INNER JOIN topic t ON c.idTopic = t.idTopic
            order by idAnswer DESC LIMIT 1");
            $resultQueryRespuesta = mysqli_fetch_array($queryRespuesta);

            $idTema = $resultQueryRespuesta['idTopic'];
            $idCommentary = $resultQueryRespuesta['idCommentary'];
            $idUsuarioEmisor = $resultQueryRespuesta['idUser'];

            $queryComentario = mysqli_query($link,"SELECT * FROM commentary WHERE idCommentary ='$idCommentary'");
            $resultQueryComentario = mysqli_fetch_array($queryComentario);

            $idUsuarioDestino = $resultQueryComentario['idUser'];

            $queryNotificacion = mysqli_query($link,"INSERT INTO notification (idNotification, idUser,idDestUser, idTopic, idNotificationType, created_at) VALUES (idNotification, '$idUsuarioEmisor', '$idUsuarioDestino','$idTema', 3, now());");

            header("Location: ./User/index.php");
            exit;
        }else{
            echo("Query notificacion failed");
        }


         if(!$resultQuery){
            echo "Query failed";
         }
    }
}
?>