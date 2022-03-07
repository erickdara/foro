<?php
require_once("config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
//if(isset($_POST['crearTema'])){
    
    $tituloTema = $_POST['tituloTema'];
    $describeTema = $_POST['describeTema'];

    session_start();
    if(isset($_SESSION['id'])){
        $idUsuario = $_SESSION['id'];
        $idRol = $_SESSION['rol'];
        echo "EL usuario que encuentra: ".$idUsuario;
        echo "EL rol que se encuentra: ".$idRol;
        
        if($idRol == 1){
            $query = "INSERT INTO tema (idTema, idUsuario, tituloTema, describeTema, created_at) 
            VALUES (idTema, '$idUsuario', '$tituloTema', '$describeTema', now());";
    
            $resultQuery = mysqli_query($link,$query);
            header("Location: index.php");
    
        if(!$resultQuery){
            echo("Query failed");
        }
    }else{
            echo "Tiene que ser administrador para publicar un tema.";
        }

        
        // if($idUsuario != 2){
        //     echo "Tiene que ser administrador para publicar un tema.";
        // }else{
        // }
  
    }else{
        echo "Query failed, don't have idUsuario";
    }
//}
}

?>