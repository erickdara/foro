<?php 


class Utils{

    private $host  = 'localhost';
    private $user  = 'root';
    private $password   = '';
    private $database  = 'forumdatabase';    
    private $temaTable = 'topic';
    private $liketopicTable = 'liketopic';
    private $comentarioTable = 'commentary';
    private $likecommentaryTable = 'likecommentary';
    private $respuestaTable = 'answer';
    private $likeanswerTable = 'likeanswer';
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

    public function isUserAlreadyVotedTema($idUser, $idTopic){
        $query = "SELECT idLike, idTopic, idUser, created_at FROM liketopic WHERE idUser = '".$idUser."' AND idTopic = '".$idTopic."'";
        $result = mysqli_query($this -> dbConnect, $query);
        return $result -> num_rows;
    }

    public function updatelikeTema($liketopicData){
        $queryUpdate = "UPDATE ".$this -> temaTable." SET likes = '".$liketopicData['likes']."' , unlikes = '".$liketopicData['unlikes']."' WHERE idTopic = '".$liketopicData['idTopic']."'";
        mysqli_query($this -> dbConnect, $queryUpdate);

        $sqlLikeQuery = "INSERT INTO ".$this->liketopicTable." (idLike, idTopic, idUser,typeLike, created_at) VALUES ('', '".$liketopicData['idTopic']."', '".$liketopicData['idUser']."', '".$liketopicData['typeLike']."', now())";
        if($sqlLikeQuery) {
            mysqli_query($this->dbConnect, $sqlLikeQuery);  
            return true;
        }
    }

    public function validateTrueLike($idUser, $idTopic){
        $query = "SELECT * FROM liketopic WHERE idUser = '".$idUser."' AND idTopic = '".$idTopic."' AND typeLike = '".TRUE."'";
        $result = mysqli_query($this -> dbConnect, $query);
        return $result -> num_rows;
    }

    public function validateTrueUnlike($idUser, $idTopic){
        $query = "SELECT * FROM liketopic WHERE idUser = '".$idUser."' AND idTopic = '".$idTopic."' AND typeLike = '".FALSE."'";
        $result = mysqli_query($this -> dbConnect, $query);
        return $result -> num_rows;
    }

    public function getlikeTema($idTopic){
        $sqlQuery = 'SELECT idLike, idTopic, idUser, typeLike, created_at FROM '.$this->liketopicTable." WHERE idTopic = '".$idTopic."'";
        $result = mysqli_query($this->dbConnect, $sqlQuery);
        $row = mysqli_fetch_array($result);
        return  $row;
    }  

    public function getLikesUnlikesTema($idTopic){
        $sqlQuery = 'SELECT idTopic, idUser, likes, unlikes FROM '.$this->temaTable." WHERE idTopic = '".$idTopic."'";
        $result = mysqli_query($this->dbConnect, $sqlQuery);
        $row = mysqli_fetch_array($result);
        return  $row;
    }   

    public function ifUserVotedToDelete($liketopicData){
        $sqlQuery = "DELETE FROM ".$this->liketopicTable." WHERE idUser = '".$liketopicData['idUser']."' AND idTopic = '".$liketopicData['idTopic']."'";
        $result = mysqli_query($this -> dbConnect, $sqlQuery);
        return true;
    }

    public function updateLikes($liketopicData){
        $updateQuery = "UPDATE ".$this->temaTable." SET likes = '".$liketopicData['likes']."', unlikes = '".$liketopicData['unlikes']."' WHERE idTopic = '".$liketopicData['idTopic']."'";
        $resultUpdate = mysqli_query($this->dbConnect, $updateQuery);
    }

    //Métodos de likes unlikes respuesta

    public function isUserAlreadyVotedRespuesta($idUser, $idAnswer){
        
        $query = "SELECT idLike, idAnswer, idUser, created_at FROM likeanswer WHERE idUser = '".$idUser."' AND idAnswer = '".$idAnswer."'";
        $result = mysqli_query($this -> dbConnect, $query);
        return $result -> num_rows;
    }

    public function updatelikeRespuesta($likeanswerData){
        $queryUpdate = "UPDATE ".$this -> respuestaTable." SET likes = '".$likeanswerData['likes']."' , unlikes = '".$likeanswerData['unlikes']."' WHERE idAnswer = '".$likeanswerData['idAnswer']."'";
        mysqli_query($this -> dbConnect, $queryUpdate);

        $sqlLikeQuery = "INSERT INTO ".$this->likeanswerTable." (idLike, idAnswer, idUser,typeLike, created_at) VALUES ('', '".$likeanswerData['idAnswer']."', '".$likeanswerData['idUser']."', '".$likeanswerData['typeLike']."', now())";
        if($sqlLikeQuery) {
            mysqli_query($this->dbConnect, $sqlLikeQuery);  
            return true;
        }
    }

    public function validateTruelikeRespuesta($idUser, $idAnswer){
        $query = "SELECT * FROM likeanswer WHERE idUser = '".$idUser."' AND idAnswer = '".$idAnswer."' AND typeLike = '".TRUE."'";
        $result = mysqli_query($this -> dbConnect, $query);
        return $result -> num_rows;
    }

    public function validateTrueUnlikeRespuesta($idUser, $idAnswer){
        $query = "SELECT * FROM likeanswer WHERE idUser = '".$idUser."' AND idAnswer = '".$idAnswer."' AND typeLike = '".FALSE."'";
        $result = mysqli_query($this -> dbConnect, $query);
        return $result -> num_rows;
    }

    public function getlikeRespuesta($idAnswer){
        $sqlQuery = 'SELECT idLike, idAnswer, idUser, typeLike, created_at FROM '.$this->likeanswerTable." WHERE idAnswer = '".$idAnswer."'";
        $result = mysqli_query($this->dbConnect, $sqlQuery);
        $row = mysqli_fetch_array($result);
        return  $row;
    }  

    public function getLikesUnlikesRespuesta($idAnswer){
        $sqlQuery = 'SELECT idAnswer, idCommentary, idUser, likes, unlikes FROM '.$this->respuestaTable." WHERE idAnswer = '".$idAnswer."'";
        $result = mysqli_query($this->dbConnect, $sqlQuery);
        $row = mysqli_fetch_array($result);
        return  $row;
    }   

    public function ifUserVotedToDeletelikeRespuesta($likeanswerData){
        $sqlQuery = "DELETE FROM ".$this->likeanswerTable." WHERE idUser = '".$likeanswerData['idUser']."' AND idAnswer = '".$likeanswerData['idAnswer']."'";
        $result = mysqli_query($this -> dbConnect, $sqlQuery);
        return true;
    }

    public function updateLikesRespuesta($likeanswerData){
        $updateQuery = "UPDATE ".$this->respuestaTable." SET likes = '".$likeanswerData['likes']."', unlikes = '".$likeanswerData['unlikes']."' WHERE idAnswer = '".$likeanswerData['idAnswer']."'";
        $resultUpdate = mysqli_query($this->dbConnect, $updateQuery);
    }
    
 
    //Métodos likes unlikes comentarios

    public function isUserAlreadyVotedComment($idUser, $idComment){
        
        $query = "SELECT idLike, idCommentary, idUser, created_at FROM likecommentary WHERE idUser = '".$idUser."' AND idCommentary = '".$idComment."'";
        $result = mysqli_query($this -> dbConnect, $query);
        return $result -> num_rows;
    }

    public function updateLikeComment($likeCommentData){
        $queryUpdate = "UPDATE ".$this -> comentarioTable." SET likes = '".$likeCommentData['likes']."' , unlikes = '".$likeCommentData['unlikes']."' WHERE idCommentary = '".$likeCommentData['idCommentary']."'";
        mysqli_query($this -> dbConnect, $queryUpdate);

        $sqlLikeQuery = "INSERT INTO ".$this->likecommentaryTable." (idLike, idCommentary, idUser,typeLike, created_at) VALUES ('', '".$likeCommentData['idCommentary']."', '".$likeCommentData['idUser']."', '".$likeCommentData['typeLike']."', now())";
        if($sqlLikeQuery) {
            mysqli_query($this->dbConnect, $sqlLikeQuery);  
            return true;
        }
    }

    public function validateTrueLikeComment($idUser, $idComment){
        $query = "SELECT * FROM likecommentary WHERE idUser = '".$idUser."' AND idCommentary = '".$idComment."' AND typeLike = '".TRUE."'";
        $result = mysqli_query($this -> dbConnect, $query);
        return $result -> num_rows;
    }

    public function validateTrueUnlikeComment($idUser, $idComment){
        $query = "SELECT * FROM likecommentary WHERE idUser = '".$idUser."' AND idCommentary = '".$idComment."' AND typeLike = '".FALSE."'";
        $result = mysqli_query($this -> dbConnect, $query);
        return $result -> num_rows;
    }

    public function getlikeComentario($idComment){
        $sqlQuery = 'SELECT idLike, idCommentary, idUser, typeLike, created_at FROM '.$this->likecommentaryTable." WHERE idCommentary = '".$idComment."'";
        $result = mysqli_query($this->dbConnect, $sqlQuery);
        $row = mysqli_fetch_array($result);
        return  $row;
    }  

    public function getLikesUnlikesComment($idComment){
        $sqlQuery = 'SELECT idCommentary, idTopic, idUser, likes, unlikes FROM '.$this->comentarioTable." WHERE idCommentary = '".$idComment."'";
        $result = mysqli_query($this->dbConnect, $sqlQuery);
        $row = $result->fetch_array(MYSQLI_ASSOC);
        return  $row;
    }   

    public function ifUserVotedToDeletelikeComentario($likeCommentData){
        $sqlQuery = "DELETE FROM ".$this->likecommentaryTable." WHERE idUser = '".$likeCommentData['idUser']."' AND idCommentary = '".$likeCommentData['idCommentary']."'";
        $result = mysqli_query($this -> dbConnect, $sqlQuery);
        return true;
    }

    public function updateLikesComentario($likeCommentData){
        $updateQuery = "UPDATE ".$this->comentarioTable." SET likes = '".$likeCommentData['likes']."', unlikes = '".$likeCommentData['unlikes']."' WHERE idCommentary = '".$likeCommentData['idCommentary']."'";
        $resultUpdate = mysqli_query($this->dbConnect, $updateQuery);
    }

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
    $time_difference = (time() - $timeCreate) - 25200;

    if( $time_difference < 1 ) { return 'Hace 1 segundo'; }
    $condition = array( 12 * 30 * 24 * 60 * 60 =>  'año',
                30 * 24 * 60 * 60       =>  'mes',
                24 * 60 * 60            =>  'día',
                60 * 60                 =>  'hora',
                60                      =>  'minuto',
                1                       =>  'segundo'
    );

    //echo "tiempo creacion: ".$timeCreate." ";
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