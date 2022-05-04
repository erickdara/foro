<?php
include('utils.php');
include('config.php');

session_start();
$idUsuario = $_SESSION["id"];
$util = new Utils();

if($_GET['idTema'] && $idUsuario){
   $likesUnlikesTema = $util -> getLikesUnlikesTema($_GET['idTema']);
   $liketema = $util -> getLikeTema($_GET['idTema']);

   if($_GET['vote_type'] == 1){ //voto positivo
      if($util -> isUserAlreadyVotedTema($idUsuario, $_GET['idTema']) == 0){
         $likesUnlikesTema['likes'] += 1;
         $likesUnlikesTema['unlikes'] = $likesUnlikesTema['unlikes'];
         $liketema['typeLike'] = true;
         $LikeTemaData = array(
            'idTopic' => $_GET['idTema'],
            'idUser' => $idUsuario,
            'likes' => $likesUnlikesTema['likes'],
            'unlikes' => $likesUnlikesTema['unlikes'],
            'typeLike' => $liketema['typeLike'],
         );
         $util->updateLikeTema($LikeTemaData); 
      }else{ //si ya votó y se valida si es me gusta o no me gusta
         if($util -> validateTrueLike($idUsuario, $_GET['idTema']) != 0){ //Si es diferente a cero, es me gusta 
            $likesUnlikesTema['likes'] -= 1; 
            $LikeTemaData = array(
            'idTopic' => $_GET['idTema'],
            'idUser' => $idUsuario,
            'likes' => $likesUnlikesTema['likes'],
            'unlikes' => $likesUnlikesTema['unlikes'],
         ); 
         $util -> ifUserVotedToDelete($LikeTemaData);
         $util -> updateLikes($LikeTemaData);
         }else{ // ya le dio no me gusta y se va a dar megusta
           // if($util -> isUserAlreadyVoted($idUsuario, $_GET['idTema']) == 0){
              
            $likesUnlikesTema['likes'] += 1;
            $likesUnlikesTema['unlikes'] -= 1;
            $liketema['typeLike'] = true;
            $LikeTemaData = array(
            'idTopic' => $_GET['idTema'],
            'idUser' => $idUsuario,
            'likes' => $likesUnlikesTema['likes'],
            'unlikes' => $likesUnlikesTema['unlikes'],
            'typeLike' => $liketema['typeLike'],
         );
         $util -> ifUserVotedToDelete($LikeTemaData);
         $util->updateLikeTema($LikeTemaData); 
            //}
         }
          
      }

   } else if ($_GET['vote_type'] == 0){// voto negativo
      if($util -> isUserAlreadyVotedTema($idUsuario, $_GET['idTema']) == 0){
         $likesUnlikesTema['unlikes'] += 1;
         $likesUnlikesTema['likes'] = $likesUnlikesTema['likes'];
         $liketema['typeLike'] = false;
         $LikeTemaData = array(
            'idTopic' => $_GET['idTema'],
            'idUser' => $idUsuario,
            'likes' => $likesUnlikesTema['likes'],
            'unlikes' => $likesUnlikesTema['unlikes'],
            'typeLike' => $liketema['typeLike'],

         );
         $util->updateLikeTema($LikeTemaData);
      }else{
         if($util -> validateTrueUnlike($idUsuario, $_GET['idTema']) != 0){
            $likesUnlikesTema['unlikes'] -= 1;
            $LikeTemaData = array(
            'idTopic' => $_GET['idTema'],
            'idUser' => $idUsuario,
            'likes' => $likesUnlikesTema['likes'],
            'unlikes' => $likesUnlikesTema['unlikes'],
         ); 
         $util -> ifUserVotedToDelete($LikeTemaData);
         $util -> updateLikes($LikeTemaData);
         }else{
            $likesUnlikesTema['unlikes'] += 1;
            $likesUnlikesTema['likes'] -= 1;
            $liketema['typeLike'] = false;
            $LikeTemaData = array(
            'idTopic' => $_GET['idTema'],
            'idUser' => $idUsuario,
            'likes' => $likesUnlikesTema['likes'],
            'unlikes' => $likesUnlikesTema['unlikes'],
            'typeLike' => $liketema['tipoLike'],
         );
            $util -> ifUserVotedToDelete($LikeTemaData);
            $util->updateLikeTema($LikeTemaData); 
         }
      }
   }
   
    
       if($likesUnlikesTema) {
           $responseT = array(
               'likes' => $likesUnlikesTema['likes'],
               'unlikes' => $likesUnlikesTema['unlikes'],
               'idTema' => $_GET['idTema']          
           );
           echo json_encode($responseT);
         }
}
      

?>