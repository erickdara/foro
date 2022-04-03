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
            
            $query = "INSERT INTO tema (idTema, idUsuario, tituloTema, describeTema, created_at) 
            VALUES (idTema, '$idUsuario', '$tituloTema', '$describeTema', now());";
            
            $resultQuery = mysqli_query($link,$query);

            $llamado = mysqli_query($link,"SELECT idTema, created_at FROM tema ORDER BY created_at DESC LIMIT 1");
            $resultLlamado = mysqli_fetch_array($llamado);
            $id_sub = $resultLlamado['idTema'];

            if($resultQuery){
                $queryTema = mysqli_query($link,"SELECT * FROM tema order by idTema DESC LIMIT 1");
                $resultQueryTema = mysqli_fetch_array($queryTema);

                $idTema = $resultQueryTema['idTema'];
                $idUsuario = $resultQueryTema['idUsuario'];

                $queryNotificacion = mysqli_query($link,"INSERT INTO notificacion (idNotificacion, idUsuario, idTema, tipoNotificacion, created_at) VALUES (idNotificacion, '$idUsuario', '$idTema', 'creó el tema', now());");

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