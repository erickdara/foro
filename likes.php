<?php
 require_once('config.php');

  $meGustaTema = $_POST['meGustaTema'];
  $noGustaTema = $_POST['noGustaTema'];
  $idTema = $_POST['idTemaLike'];
  $validador = 0;

  if($_SERVER["REQUEST_METHOD"] == "POST"){
   // $validador + 1;
    //if($validador == 1){
        if($meGustaTema == true){
            $meGustaTema = true; 
            $noGustaTema = false;
     
            $query = "INSERT INTO likes (idLike, idTema, idComentario, idRespuesta, meGusta, noGusta, created_at) 
             VALUES (idLike, '$idTema', idComentario, idRespuesta,'$meGustaTema','$noGustaTema', now())";
     
             $resultLike = mysqli_query($link,$query);
             header('Location:index.php');
         }else{
             $meGustaTema = false;
             $noGustaTema = true;

             $query = "INSERT INTO likes (idLike, idTema, idComentario, idRespuesta, meGusta, noGusta, created_at) 
             VALUES (idLike, '$idTema', '','','$meGustaTema','$noGustaTema', now())";
     
             $resultLike = mysqli_query($link,$query);
             header('Location:index.php');
         }
   // }else{
     //   $validador - 1;
       // echo "ya le dio like";
   // }
  }
?>