<?php
require_once("config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
//if(isset($_POST['crearTema'])){
    
    $tituloTema = $_POST['tituloTema'];
    $describeTema = $_POST['describeTema'];

    session_start();
    if(isset($_SESSION['id'])){
        $idUsuario = $_SESSION['id'];

        if($idUsuario != 2){
            echo "Tiene que ser administrador para publicar un tema.";
        }else{
            
            $query = "INSERT INTO tema (idTema, idUsuario, tituloTema, describeTema, created_at) 
            VALUES (idTema, '$idUsuario', '$tituloTema', '$describeTema', now());";

            $resultQuery = mysqli_query($link,$query);
            header("Location: index.php");

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