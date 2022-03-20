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
        header('Location: ./User/index.php');
        exit;

        if (!$resultQuery) {
            echo "Query failed";
        }
    }
}
