<?php
include('tema.php');
include('config.php');

session_start();
$idUsuario = $_SESSION["id"];
$tema = new tema();

if($_GET['idTema'] && $idUsuario){
   $likesUnlikesTema = $tema -> getLikesUnlikesTema($_GET['idTema']);
   $liketema = $tema -> getLikeTema($_GET['idTema']);

   if($_GET['vote_type'] == 1){ //voto positivo
      if($tema -> isUserAlreadyVoted($idUsuario, $_GET['idTema']) == 0){
         $likesUnlikesTema['likes'] += 1;
         $likesUnlikesTema['unlikes'] = 0;
         $liketema['tipoLike'] = true;
         $LikeTemaData = array(
            'idTema' => $_GET['idTema'],
            'idUsuario' => $idUsuario,
            'likes' => $likesUnlikesTema['likes'],
            'unlikes' => $likesUnlikesTema['unlikes'],
            'tipoLike' => $liketema['tipoLike'],
         );
         $likesUnlikesTema = $tema->updateLikeTema($LikeTemaData); 
      }else{ //si ya votó y se valida si es me gusta o no me gusta
         if($tema -> validateTrueLike($idUsuario, $_GET['idTema']) != 0){ //Si es diferente a cero, es me gusta 
            $likesUnlikesTema['likes'] -= 1; 
            $LikeTemaData = array(
            'idTema' => $_GET['idTema'],
            'idUsuario' => $idUsuario,
            'likes' => $likesUnlikesTema['likes'],
            'unlikes' => $likesUnlikesTema['unlikes'],
         ); 
         $tema -> ifUserVotedToDelete($LikeTemaData);
         $tema -> updateLikes($LikeTemaData);
         }else{

            $likesUnlikesTema['likes'] += 1;
            $likesUnlikesTema['unlikes'] = 0;
            $liketema['tipoLike'] = true;
            $LikeTemaData = array(
            'idTema' => $_GET['idTema'],
            'idUsuario' => $idUsuario,
            'likes' => $likesUnlikesTema['likes'],
            'unlikes' => $likesUnlikesTema['unlikes'],
            'tipoLike' => $liketema['tipoLike'],
         );
         $tema -> ifUserVotedToDelete($LikeTemaData);
         $likesUnlikesTema = $tema->updateLikeTema($LikeTemaData); 
         }
          
      }

   } else if ($_GET['vote_type'] == 0){// voto negativo
      if($tema -> isUserAlreadyVoted($idUsuario, $_GET['idTema']) == 0){
         $likesUnlikesTema['unlikes'] += 1;
         $likesUnlikesTema['likes'] = 0;
         $liketema['tipoLike'] = false;
         $LikeTemaData = array(
            'idTema' => $_GET['idTema'],
            'idUsuario' => $idUsuario,
            'likes' => $likesUnlikesTema['likes'],
            'unlikes' => $likesUnlikesTema['unlikes'],
            'tipoLike' => $liketema['tipoLike'],

         );
         $likesUnlikesTema = $tema->updateLikeTema($LikeTemaData);
      }else{
         if($tema -> validateTrueUnlike($idUsuario, $_GET['idTema']) != 0){
            $likesUnlikesTema['unlikes'] -= 1;
            $LikeTemaData = array(
            'idTema' => $_GET['idTema'],
            'idUsuario' => $idUsuario,
            'likes' => $likesUnlikesTema['likes'],
            'unlikes' => $likesUnlikesTema['unlikes'],
         ); 
         $tema -> ifUserVotedToDelete($LikeTemaData);
         $tema -> updateLikes($LikeTemaData);
         }else{
            $likesUnlikesTema['unlikes'] += 1;
            $likesUnlikesTema['likes'] = 0;
            $liketema['tipoLike'] = false;
            $LikeTemaData = array(
            'idTema' => $_GET['idTema'],
            'idUsuario' => $idUsuario,
            'likes' => $likesUnlikesTema['likes'],
            'unlikes' => $likesUnlikesTema['unlikes'],
            'tipoLike' => $liketema['tipoLike'],
         );
            $tema -> ifUserVotedToDelete($LikeTemaData);
            $likesUnlikesTema = $tema->updateLikeTema($LikeTemaData); 
         }
      }
   }
   
   
   
    
       if($likesUnlikesTema != 0) {
           $response = array(
               'likes' => $likesUnlikesTema['likes'],
               'unlikes' => $likesUnlikesTema['unlikes'],
               'idTema' => $_GET['idTema']          
           );
           echo json_encode($response);
         }

}
        

//  require_once('config.php');

//  var_dump($_GET);
//  var_dump($_REQUEST);
//  session_start();
//  if ($_SERVER["REQUEST_METHOD"] == "POST") {
//  $idUsuario = $_SESSION['id'];
//  $idTema = $_POST["id"];


 //query the user's like in a thread

 
//  if ($stmt = mysqli_prepare($link, $query)) {
//         mysqli_stmt_bind_param($stmt, "ss", $param_idTema, $param_idUsuario);
//         $param_idTema = $idTema;
//         $param_idUsuario = $idUsuario;
//         echo $query;
//       if (mysqli_stmt_execute($stmt)) {
        
//       }
//  }

//         $resultQuery = mysqli_query($link, "SELECT * FROM liketema WHERE idTema = '".$idTema."' AND idUsuario = '".$idUsuario."'");
//         $count= mysqli_fetch_array($resultQuery);
//         $total = $count[0];
//         echo "Total rows: " . $total;

 //Run the query


 //Check that the user has not liked
//  if($total == 0){
//     echo "count = ". $count;
//     $idTema = $_POST['id'];

//     $insertLikeTema = "INSERT INTO liketema (idLike,idTema,idUsuario,created_at) VALUES (idLike,'".$idTema."','".$idUsuario."', now());";
//     echo $insertLikeTema;
//     $insertoLikeTema = mysqli_query($link,$insertLikeTema);

//     $updateLikes = "UPDATE tema SET likes = likes + 1 WHERE idTema = '$idTema'";
//     $updatedLikes = mysqli_query($link,$updateLikes);
//  } else { //if the user already liked it

//     $deleteLikeTema = "DELETE FROM liketema WHERE idTema = '".$idTema."' AND idUsuario = '".$idUsuario."'";
//     $deletedLikeTema = mysqli_query($link,$deleteLikeTema);

//     $updateLikes = "UPDATE tema SET likes = likes - 1 WHERE idTema = '".$idTema."'";
//     $updatedLikes = mysqli_query($link,$updateLikes);
//  }

//  $countLikes = "SELECT likes FROM tema WHERE idTema = '".$idTema."'";
//  $resultCount = mysqli_query($link,$countLikes);
//  $likes = mysqli_fetch_array($resultCount);
//  $totalLikes = $likes['likes'];

//  if($total == 0){
//     $totalLikes = $totalLikes++;
//  }else{
//    $totalLikes = $totalLikes--;
//  }

//  $datoLikeTema = array('likes' => $totalLikes);

//  echo json_encode($datoLikeTema);
//  }else{
//    echo "no llega el post";
//  }
?>