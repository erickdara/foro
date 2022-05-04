<?php 
require_once("config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    session_start();
    $idUsuario = $_SESSION['id'];

    $nombre = $_POST['nombre'];
    $empresa = $_POST['empresa'];
    $cargo = $_POST['cargo'];
    $skills = $_POST['skills'];
    
    $query = mysqli_query($link,"UPDATE user SET usernames = '$nombre', company = '$empresa', charge = '$cargo', skills = '$skills' WHERE idUser = '$idUsuario';");
    
    if($query){
        header('Location: perfil.php');
        exit;
    }else{
        echo "No se pudo actualizar el perfil";
    }
}else{
    echo "No hay post";
}

?>