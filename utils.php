<?php 


class Utils{

    private $host  = 'localhost';
    private $user  = 'root';
    private $password   = '';
    private $database  = 'databaseforo';    
    private $temaTable = 'tema';
    private $likeTemaTable = 'liketema';
    private $comentarioTable = 'comentario';
    private $likeComentarioTable = 'likecomentario';
    private $respuestaTable = 'respuesta';
    private $likeRespuestaTable = 'likerespuesta';
    private $dbConnect = false;

    public function __construct(){
        if(!$this->dbConnect){ 
          $conn = new mysqli($this->host, $this->user, $this->password, $this->database);
          if($conn->connect_error){
             die("Error failed to connect to MySQL: " . $conn->connect_error);
          }else{
             $this->dbConnect = $conn;
          }
        }
     }

    public function isUserAlreadyVotedTema($idUsuario, $idTema){
        $query = "SELECT idLike, idTema, idUsuario, created_at FROM liketema WHERE idUsuario = '".$idUsuario."' AND idTema = '".$idTema."'";
        $result = mysqli_query($this -> dbConnect, $query);
        return $result -> num_rows;
    }

    public function updateLikeTema($likeTemaData){
        $queryUpdate = "UPDATE ".$this -> temaTable." SET likes = '".$likeTemaData['likes']."' , unlikes = '".$likeTemaData['unlikes']."' WHERE idTema = '".$likeTemaData['idTema']."'";
        mysqli_query($this -> dbConnect, $queryUpdate);

        $sqlLikeQuery = "INSERT INTO ".$this->likeTemaTable." (idLike, idTema, idUsuario,tipoLike, created_at) VALUES ('', '".$likeTemaData['idTema']."', '".$likeTemaData['idUsuario']."', '".$likeTemaData['tipoLike']."', now())";
        if($sqlLikeQuery) {
            mysqli_query($this->dbConnect, $sqlLikeQuery);  
            return true;
        }
    }

    public function validateTrueLike($idUsuario, $idTema){
        $query = "SELECT * FROM liketema WHERE idUsuario = '".$idUsuario."' AND idTema = '".$idTema."' AND tipoLike = '".TRUE."'";
        $result = mysqli_query($this -> dbConnect, $query);
        return $result -> num_rows;
    }

    public function validateTrueUnlike($idUsuario, $idTema){
        $query = "SELECT * FROM liketema WHERE idUsuario = '".$idUsuario."' AND idTema = '".$idTema."' AND tipoLike = '".FALSE."'";
        $result = mysqli_query($this -> dbConnect, $query);
        return $result -> num_rows;
    }

    public function getLikeTema($idTema){
        $sqlQuery = 'SELECT idLike, idTema, idUsuario, tipoLike, created_at FROM '.$this->likeTemaTable." WHERE idTema = '".$idTema."'";
        $result = mysqli_query($this->dbConnect, $sqlQuery);
        $row = $result->fetch_array(MYSQLI_ASSOC);
        return  $row;
    }  

    public function getLikesUnlikesTema($idTema){
        $sqlQuery = 'SELECT idTema, idUsuario, likes, unlikes FROM '.$this->temaTable." WHERE idTema = '".$idTema."'";
        $result = mysqli_query($this->dbConnect, $sqlQuery);
        $row = $result->fetch_array(MYSQLI_ASSOC);
        return  $row;
    }   

    public function ifUserVotedToDelete($likeTemaData){
        $sqlQuery = "DELETE FROM ".$this->likeTemaTable." WHERE idUsuario = '".$likeTemaData['idUsuario']."' AND idTema = '".$likeTemaData['idTema']."'";
        $result = mysqli_query($this -> dbConnect, $sqlQuery);
        return true;
    }

    public function updateLikes($likeTemaData){
        $updateQuery = "UPDATE ".$this->temaTable." SET likes = '".$likeTemaData['likes']."', unlikes = '".$likeTemaData['unlikes']."' WHERE idTema = '".$likeTemaData['idTema']."'";
        $resultUpdate = mysqli_query($this->dbConnect, $updateQuery);
    }

    //Métodos de likes unlikes respuesta

    public function isUserAlreadyVotedRespuesta($idUser, $idRespuesta){
        
        $query = "SELECT idLike, idRespuesta, idUsuario, created_at FROM likerespuesta WHERE idUsuario = '".$idUser."' AND idRespuesta = '".$idRespuesta."'";
        $result = mysqli_query($this -> dbConnect, $query);
        return $result -> num_rows;
    }

    public function updateLikeRespuesta($likeRespuestaData){
        $queryUpdate = "UPDATE ".$this -> respuestaTable." SET likes = '".$likeRespuestaData['likes']."' , unlikes = '".$likeRespuestaData['unlikes']."' WHERE idRespuesta = '".$likeRespuestaData['idRespuesta']."'";
        mysqli_query($this -> dbConnect, $queryUpdate);

        $sqlLikeQuery = "INSERT INTO ".$this->likeRespuestaTable." (idLike, idRespuesta, idUsuario,tipoLike, created_at) VALUES ('', '".$likeRespuestaData['idRespuesta']."', '".$likeRespuestaData['idUsuario']."', '".$likeRespuestaData['tipoLike']."', now())";
        if($sqlLikeQuery) {
            mysqli_query($this->dbConnect, $sqlLikeQuery);  
            return true;
        }
    }

    public function validateTrueLikeRespuesta($idUser, $idRespuesta){
        $query = "SELECT * FROM likerespuesta WHERE idUsuario = '".$idUser."' AND idRespuesta = '".$idRespuesta."' AND tipoLike = '".TRUE."'";
        $result = mysqli_query($this -> dbConnect, $query);
        return $result -> num_rows;
    }

    public function validateTrueUnlikeRespuesta($idUser, $idRespuesta){
        $query = "SELECT * FROM likerespuesta WHERE idUsuario = '".$idUser."' AND idRespuesta = '".$idRespuesta."' AND tipoLike = '".FALSE."'";
        $result = mysqli_query($this -> dbConnect, $query);
        return $result -> num_rows;
    }

    public function getLikeRespuesta($idRespuesta){
        $sqlQuery = 'SELECT idLike, idRespuesta, idUsuario, tipoLike, created_at FROM '.$this->likeRespuestaTable." WHERE idRespuesta = '".$idRespuesta."'";
        $result = mysqli_query($this->dbConnect, $sqlQuery);
        $row = $result->fetch_array(MYSQLI_ASSOC);
        return  $row;
    }  

    public function getLikesUnlikesRespuesta($idRespuesta){
        $sqlQuery = 'SELECT idRespuesta, idComentario, idUsuario, likes, unlikes FROM '.$this->respuestaTable." WHERE idRespuesta = '".$idRespuesta."'";
        $result = mysqli_query($this->dbConnect, $sqlQuery);
        $row = $result->fetch_array(MYSQLI_ASSOC);
        return  $row;
    }   

    public function ifUserVotedToDeleteLikeRespuesta($likeRespuestaData){
        $sqlQuery = "DELETE FROM ".$this->likeRespuestaTable." WHERE idUsuario = '".$likeRespuestaData['idUsuario']."' AND idRespuesta = '".$likeRespuestaData['idRespuesta']."'";
        $result = mysqli_query($this -> dbConnect, $sqlQuery);
        return true;
    }

    public function updateLikesRespuesta($likeRespuestaData){
        $updateQuery = "UPDATE ".$this->respuestaTable." SET likes = '".$likeRespuestaData['likes']."', unlikes = '".$likeRespuestaData['unlikes']."' WHERE idRespuesta = '".$likeRespuestaData['idRespuesta']."'";
        $resultUpdate = mysqli_query($this->dbConnect, $updateQuery);
    }
    
 
    //Métodos likes unlikes comentarios

    public function isUserAlreadyVotedComment($idUser, $idComment){
        
        $query = "SELECT idLike, idComentario, idUsuario, created_at FROM likecomentario WHERE idUsuario = '".$idUser."' AND idComentario = '".$idComment."'";
        $result = mysqli_query($this -> dbConnect, $query);
        return $result -> num_rows;
    }

    public function updateLikeComment($likeCommentData){
        $queryUpdate = "UPDATE ".$this -> comentarioTable." SET likes = '".$likeCommentData['likes']."' , unlikes = '".$likeCommentData['unlikes']."' WHERE idComentario = '".$likeCommentData['idComentario']."'";
        mysqli_query($this -> dbConnect, $queryUpdate);

        $sqlLikeQuery = "INSERT INTO ".$this->likeComentarioTable." (idLike, idComentario, idUsuario,tipoLike, created_at) VALUES ('', '".$likeCommentData['idComentario']."', '".$likeCommentData['idUsuario']."', '".$likeCommentData['tipoLike']."', now())";
        if($sqlLikeQuery) {
            mysqli_query($this->dbConnect, $sqlLikeQuery);  
            return true;
        }
    }

    public function validateTrueLikeComment($idUser, $idComment){
        $query = "SELECT * FROM likecomentario WHERE idUsuario = '".$idUser."' AND idComentario = '".$idComment."' AND tipoLike = '".TRUE."'";
        $result = mysqli_query($this -> dbConnect, $query);
        return $result -> num_rows;
    }

    public function validateTrueUnlikeComment($idUser, $idComment){
        $query = "SELECT * FROM likecomentario WHERE idUsuario = '".$idUser."' AND idComentario = '".$idComment."' AND tipoLike = '".FALSE."'";
        $result = mysqli_query($this -> dbConnect, $query);
        return $result -> num_rows;
    }

    public function getLikeComentario($idComment){
        $sqlQuery = 'SELECT idLike, idComentario, idUsuario, tipoLike, created_at FROM '.$this->likeComentarioTable." WHERE idComentario = '".$idComment."'";
        $result = mysqli_query($this->dbConnect, $sqlQuery);
        $row = $result->fetch_array(MYSQLI_ASSOC);
        return  $row;
    }  

    public function getLikesUnlikesComment($idComment){
        $sqlQuery = 'SELECT idComentario, idTema, idUsuario, likes, unlikes FROM '.$this->comentarioTable." WHERE idComentario = '".$idComment."'";
        $result = mysqli_query($this->dbConnect, $sqlQuery);
        $row = $result->fetch_array(MYSQLI_ASSOC);
        return  $row;
    }   

    public function ifUserVotedToDeleteLikeComentario($likeCommentData){
        $sqlQuery = "DELETE FROM ".$this->likeComentarioTable." WHERE idUsuario = '".$likeCommentData['idUsuario']."' AND idComentario = '".$likeCommentData['idComentario']."'";
        $result = mysqli_query($this -> dbConnect, $sqlQuery);
        return true;
    }

    public function updateLikesComentario($likeCommentData){
        $updateQuery = "UPDATE ".$this->comentarioTable." SET likes = '".$likeCommentData['likes']."', unlikes = '".$likeCommentData['unlikes']."' WHERE idComentario = '".$likeCommentData['idComentario']."'";
        $resultUpdate = mysqli_query($this->dbConnect, $updateQuery);
    }

    // public function get_time_ago($date, $now){

    //     $dateNow = explode(" ",$now); 
    //     $dateCreate = explode(" ",$date);

    //     $dayDifference = $dateNow[0] - $dateCreate[0]; //day difference
    //     $monthDifference = $dateNow[1] - $dateCreate[1]; //month difference
    //     $yearDifference = $dateNow[2] - $dateCreate[2]; //year difference
    //     $hourDifference = $dateNow[3] - $dateCreate[3]; //hour difference
    //     $minuteDifference = $dateNow[4] - $dateCreate[4]; //minute difference 
    //     $secondDifference = $dateNow[5] - $dateCreate[5]; //second difference

    //     $month = array("enero","febrero","marzo","abril","mayo","junio","julio","agosto","septiembre","octubre","noviembre","diciembre");

    //     if($dayDifference == 0 && $monthDifference == 0 && $yearDifference == 0){ //if it is fulfilled it was the same day
    //         if($hourDifference >= 1){ //if it is greater than one, it is hours
    //             return "Hace aproximadamente ".$hourDifference." hora(s).";
    //         }else{
    //             if($minuteDifference >= 1){ //if it is greater than one it is minutes
    //                 return "Hace aproximadamente ".$minuteDifference." minuto(s).";
    //             }else{
    //                 return "Hace aproximadamente ".$secondDifference." segundo(s)."; //otherwise seconds
    //             }
    //         }
    //     }else if($dayDifference != 0 && $dayDifference < 8 && $monthDifference == 0 && $yearDifference == 0){//If this condition is met, it oscillates within 7 days.
    //             return "Hace aproximadamente ".$dayDifference." día(s)";
    //     }else {
    //             if($yearDifference >= 1){
    //                 return "Publicado el ".$dateCreate[0]." de ".$month[$dateCreate[1]-1]." del ".$dateCreate[2]; 
    //             }else{
    //                 return "Publicado el ".$dateCreate[0]." de ".$month[$dateCreate[1]-1];
    //             }
                
    //     }

    // }

    function fechaunix($time){
        $unix = strtotime($time);
        if($unix){
            return $unix;
        }else{
            return "no se puede";
        }
        
    }
    function get_time_ago( $time )
{
    $timeCreate = strtotime($time);
    $time_difference = (time() - $timeCreate) - 21600;

    if( $time_difference < 1 ) { return 'less than 1 second ago'; }
    $condition = array( 12 * 30 * 24 * 60 * 60 =>  'año',
                30 * 24 * 60 * 60       =>  'mes',
                24 * 60 * 60            =>  'día',
                60 * 60                 =>  'hora',
                60                      =>  'minuto',
                1                       =>  'segundo'
    );

    foreach( $condition as $secs => $str )
    {
        $d = $time_difference / $secs;

        if( $d >= 1 )
        {
            $t = round( $d );
            return 'Hace aproximadamente ' . $t . ' ' . $str . ( $t > 1 ? 's' : '' ) . '';
        }
    }
}

}

?>