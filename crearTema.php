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

            $queryNot = "INSERT INTO notificacion (idNotificacion, idUsuario1, idUsuario2, tipoNotificacion, general, id_pub, created_at) 
            VALUES (idNotificacion,'$idUsuario',0,'ha creado el tema', TRUE,'$id_sub',now())";
            
            $resultQueryNot = mysqli_query($link,$queryNot);
            header("Location: ./User/index.php");

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