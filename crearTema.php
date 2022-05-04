<?php
require_once("config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
//if(isset($_POST['crearTema'])){
    
    $tituloTema = $_POST['tituloTema'];
    $describeTema = $_POST['describeTema'];

    session_start();
    if(isset($_SESSION['rol'])){
        $idRol = $_SESSION['rol'];
        $idUsuario = $_SESSION['id'];

        if($idRol != 1){
            echo "Tiene que ser administrador para publicar un tema.";
        }else{
            
            $query = "INSERT INTO topic (idTopic, idUser, titleTopic, describeTopic, created_at) 
            VALUES (idTopic, '$idUsuario', '$tituloTema', '$describeTema', now());";
            
            $resultQuery = mysqli_query($link,$query);

            $llamado = mysqli_query($link,"SELECT idTopic, created_at FROM topic ORDER BY created_at DESC LIMIT 1");
            $resultLlamado = mysqli_fetch_array($llamado);
            $id_sub = $resultLlamado['idTopic'];

            if($resultQuery){
                $queryTema = mysqli_query($link,"SELECT * FROM topic order by idTopic DESC LIMIT 1");
                $resultQueryTema = mysqli_fetch_array($queryTema);

                $idTema = $resultQueryTema['idTopic'];
                $idUsuario = $resultQueryTema['idUser'];

                $queryNotificacion = mysqli_query($link,"INSERT INTO notification (idNotification, idUser, idDestUser, idTopic, idNotificationType, created_at) VALUES (idNotification, '$idUsuario', '$idUsuario','$idTema', 1, now());");

                header("Location: ./User/index.php");
            }else{
                echo("Query notificacion failed");
            }
            

            

        if(!$resultQuery){
            echo("Query failed");
        }
        }
  
    }else{
        echo "Query failed, don't have idUsuario";
    }
//}
}

?>