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

         if($resultQuery){
            $queryRespuesta = mysqli_query($link,"SELECT r.idRespuesta, r.idUsuario, r.idComentario, t.idTema FROM respuesta r
            INNER JOIN comentario c ON r.idComentario = c.idComentario
            INNER JOIN tema t ON c.idTema = t.idTema
            order by idRespuesta DESC LIMIT 1");
            $resultQueryRespuesta = mysqli_fetch_array($queryRespuesta);

            $idTema = $resultQueryRespuesta['idTema'];
            $idComentario = $resultQueryRespuesta['idComentario'];
            $idUsuarioEmisor = $resultQueryRespuesta['idUsuario'];

            $queryComentario = mysqli_query($link,"SELECT * FROM comentario WHERE idComentario ='$idComentario'");
            $resultQueryComentario = mysqli_fetch_array($queryComentario);

            $idUsuarioDestino = $resultQueryComentario['idUsuario'];

            $queryNotificacion = mysqli_query($link,"INSERT INTO notificacion (idNotificacion, idUsuario,idDestUser, idTema, idTipoNotificacion, created_at) VALUES (idNotificacion, '$idUsuarioEmisor', '$idUsuarioDestino','$idTema', 3, now());");

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