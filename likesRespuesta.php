<?php
include('utils.php');
include('config.php');

session_start();
$idUsuario = $_SESSION['id'];
$util = new Utils();

if($_GET['idRespuesta'] && $idUsuario){
   $getLikesUnlikesRespuesta = $util -> getLikesUnlikesRespuesta($_GET['idRespuesta']);
   $getLikeRespuesta = $util -> getLikeRespuesta($_GET['idRespuesta']);

   if($_GET['vote_type'] == 1){
      if($util -> isUserAlreadyVotedRespuesta($idUsuario,$_GET['idRespuesta']) == 0){
         $getLikesUnlikesRespuesta['likes'] += 1;
         $getLikesUnlikesRespuesta['unlikes'] = $getLikesUnlikesRespuesta['unlikes'];
         $getLikeRespuesta['tipoLike'] = TRUE;
         $likeRespuestaData = array(
            'idRespuesta' => $_GET['idRespuesta'],
            'idUsuario' => $idUsuario,
            'likes' => $getLikesUnlikesRespuesta['likes'],
            'unlikes' => $getLikesUnlikesRespuesta['unlikes'],
            'tipoLike' => $getLikeRespuesta['tipoLike'], 
         );
         $util -> updateLikeRespuesta($likeRespuestaData);
      }else{
         if($util -> validateTrueLikeRespuesta($idUsuario, $_GET['idRespuesta']) != 0){//Diferente a cero es "me gusta"
            $getLikesUnlikesRespuesta['likes'] -= 1; 
            $likeRespuestaData = array(
            'idRespuesta' => $_GET['idRespuesta'],
            'idUsuario' => $idUsuario,
            'likes' => $getLikesUnlikesRespuesta['likes'],
            'unlikes' => $getLikesUnlikesRespuesta['unlikes'],
         ); 
         $util -> ifUserVotedToDeleteLikeRespuesta($likeRespuestaData);
         $util -> updateLikesRespuesta($likeRespuestaData);
         }else{
            $getLikesUnlikesRespuesta['likes'] += 1;
            $getLikesUnlikesRespuesta['unlikes'] -= 1;
            $getLikeRespuesta['tipoLike'] = true;
            $likeRespuestaData = array(
            'idRespuesta' => $_GET['idRespuesta'],
            'idUsuario' => $idUsuario,
            'likes' => $getLikesUnlikesRespuesta['likes'],
            'unlikes' => $getLikesUnlikesRespuesta['unlikes'],
            'tipoLike' => $getLikeRespuesta['tipoLike'],
         );
         $util -> ifUserVotedToDeleteLikeRespuesta($likeRespuestaData);
         $util->updateLikeRespuesta($likeRespuestaData); 
         }
      }
   }else if($_GET['vote_type'] == 0){//Voto negativo
      if($util -> isUserAlreadyVotedRespuesta($idUsuario,$_GET['idRespuesta']) == 0){
         $getLikesUnlikesRespuesta['unlikes'] += 1;
         $getLikesUnlikesRespuesta['likes'] = $getLikesUnlikesRespuesta['likes'];
         $getLikeRespuesta['tipoLike'] = FALSE;
         $likeRespuestaData = array(
            'idRespuesta' => $_GET['idRespuesta'],
            'idUsuario' => $idUsuario,
            'likes' => $getLikesUnlikesRespuesta['likes'],
            'unlikes' => $getLikesUnlikesRespuesta['unlikes'],
            'tipoLike' => $getLikeRespuesta['tipoLike'], 
         );
         $util -> updateLikeRespuesta($likeRespuestaData);
   }else{
      if($util -> validateTrueUnlikeRespuesta($idUsuario, $_GET['idRespuesta']) != 0){
         $getLikesUnlikesRespuesta['unlikes'] -= 1; 
            $likeRespuestaData = array(
            'idRespuesta' => $_GET['idRespuesta'],
            'idUsuario' => $idUsuario,
            'likes' => $getLikesUnlikesRespuesta['likes'],
            'unlikes' => $getLikesUnlikesRespuesta['unlikes'],
         ); 
         $util -> ifUserVotedToDeleteLikeRespuesta($likeRespuestaData);
         $util -> updateLikesRespuesta($likeRespuestaData);
      }else{
            $getLikesUnlikesRespuesta['unlikes'] += 1;
            $getLikesUnlikesRespuesta['likes'] -= 1;
            $getLikeRespuesta['tipoLike'] = FALSE;
            $likeRespuestaData = array(
            'idRespuesta' => $_GET['idRespuesta'],
            'idUsuario' => $idUsuario,
            'likes' => $getLikesUnlikesRespuesta['likes'],
            'unlikes' => $getLikesUnlikesRespuesta['unlikes'],
            'tipoLike' => $getLikeRespuesta['tipoLike'],
         );
         $util -> ifUserVotedToDeleteLikeRespuesta($likeRespuestaData);
         $util->updateLikeRespuesta($likeRespuestaData); 
      }
   }
}   

   if($getLikesUnlikesRespuesta) {
      $responseC = array(
          'likes' => $getLikesUnlikesRespuesta['likes'],
          'unlikes' => $getLikesUnlikesRespuesta['unlikes'],
          'idRespuesta' => $_GET['idRespuesta']          
      );
      echo json_encode($responseC);
    }

}
?>