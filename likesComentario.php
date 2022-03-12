<?php
include('utils.php');
include('config.php');

session_start();
$idUsuario = $_SESSION['id'];
$util = new Utils();

if($_GET['idComentario'] && $idUsuario){
   $getLikesUnlikesComment = $util -> getLikesUnlikesComment($_GET['idComentario']);
   $getLikeComment = $util -> getLikeComentario($_GET['idComentario']);

   if($_GET['vote_type'] == 1){
      if($util -> isUserAlreadyVotedComment($idUsuario,$_GET['idComentario']) == 0){
         $getLikesUnlikesComment['likes'] += 1;
         $getLikesUnlikesComment['unlikes'] = $getLikesUnlikesComment['unlikes'];
         $getLikeComment['tipoLike'] = TRUE;
         $likeCommentData = array(
            'idComentario' => $_GET['idComentario'],
            'idUsuario' => $idUsuario,
            'likes' => $getLikesUnlikesComment['likes'],
            'unlikes' => $getLikesUnlikesComment['unlikes'],
            'tipoLike' => $getLikeComment['tipoLike'], 
         );
         $util -> updateLikeComment($likeCommentData);
      }else{
         if($util -> validateTrueLikeComment($idUsuario, $_GET['idComentario']) != 0){//Diferente a cero es "me gusta"
            $getLikesUnlikesComment['likes'] -= 1; 
            $likeCommentData = array(
            'idComentario' => $_GET['idComentario'],
            'idUsuario' => $idUsuario,
            'likes' => $getLikesUnlikesComment['likes'],
            'unlikes' => $getLikesUnlikesComment['unlikes'],
         ); 
         $util -> ifUserVotedToDeleteLikeComentario($likeCommentData);
         $util -> updateLikesComentario($likeCommentData);
         }else{
            $getLikesUnlikesComment['likes'] += 1;
            $getLikesUnlikesComment['unlikes'] -= 1;
            $getLikeComment['tipoLike'] = true;
            $likeCommentData = array(
            'idComentario' => $_GET['idComentario'],
            'idUsuario' => $idUsuario,
            'likes' => $getLikesUnlikesComment['likes'],
            'unlikes' => $getLikesUnlikesComment['unlikes'],
            'tipoLike' => $getLikeComment['tipoLike'],
         );
         $util -> ifUserVotedToDeleteLikeComentario($likeCommentData);
         $util->updateLikeComment($likeCommentData); 
         }
      }
   }else if($_GET['vote_type'] == 0){//Voto negativo
      if($util -> isUserAlreadyVotedComment($idUsuario,$_GET['idComentario']) == 0){
         $getLikesUnlikesComment['unlikes'] += 1;
         $getLikesUnlikesComment['likes'] = $getLikesUnlikesComment['likes'];
         $getLikeComment['tipoLike'] = FALSE;
         $likeCommentData = array(
            'idComentario' => $_GET['idComentario'],
            'idUsuario' => $idUsuario,
            'likes' => $getLikesUnlikesComment['likes'],
            'unlikes' => $getLikesUnlikesComment['unlikes'],
            'tipoLike' => $getLikeComment['tipoLike'], 
         );
         $util -> updateLikeComment($likeCommentData);
   }else{
      if($util -> validateTrueUnlikeComment($idUsuario, $_GET['idComentario']) != 0){
         $getLikesUnlikesComment['unlikes'] -= 1; 
            $likeCommentData = array(
            'idComentario' => $_GET['idComentario'],
            'idUsuario' => $idUsuario,
            'likes' => $getLikesUnlikesComment['likes'],
            'unlikes' => $getLikesUnlikesComment['unlikes'],
         ); 
         $util -> ifUserVotedToDeleteLikeComentario($likeCommentData);
         $util -> updateLikesComentario($likeCommentData);
      }else{
            $getLikesUnlikesComment['unlikes'] += 1;
            $getLikesUnlikesComment['likes'] -= 1;
            $getLikeComment['tipoLike'] = FALSE;
            $likeCommentData = array(
            'idComentario' => $_GET['idComentario'],
            'idUsuario' => $idUsuario,
            'likes' => $getLikesUnlikesComment['likes'],
            'unlikes' => $getLikesUnlikesComment['unlikes'],
            'tipoLike' => $getLikeComment['tipoLike'],
         );
         $util -> ifUserVotedToDeleteLikeComentario($likeCommentData);
         $util->updateLikeComment($likeCommentData); 
      }
   }
}   

   if($getLikesUnlikesComment) {
      $responseC = array(
          'likes' => $getLikesUnlikesComment['likes'],
          'unlikes' => $getLikesUnlikesComment['unlikes'],
          'idComentario' => $_GET['idComentario']          
      );
      echo json_encode($responseC);
    }

}
?>