<?php
require_once('config.php');
$buscar = $_GET['buscar'];

if(!empty($buscar)){
    $buscador = mysqli_query($link,"SELECT t.idTopic, t.titleTopic, t.describeTopic, t.idUser, u.usernames, t.created_at as fecha, likes, unlikes FROM topic t 
    INNER JOIN user u ON t.idUser = u.idUser
    WHERE t.titleTopic LIKE LOWER('%".$buscar."%')");

$num = mysqli_num_rows($buscador);

    if($num != 0){
?>

    <h5 style="background-color: #07e90f20; color: #004302;" class="card-tittle mt-3 p-1">Resultados encontrados (<?php echo $num?>)</h5>

<?php }else{ ?>
    <h5 style="background-color: #ff060630; color: #850404;" class="card-tittle mt-3 p-1">Resultados encontrados (<?php echo $num?>)</h5>
<?php    }
while($result = mysqli_fetch_array($buscador)){?>
    <div class="card tema-informacion mt-2 mb-3">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-5 col-sm-12">
                                <h6><strong>Publicado por: <?php echo $result['usernames'] ?> </strong></h6>
                            </div>
                            <div class="col-md-7 col-sm-12">
                                <p class="text-muted" style="font-size: smaller;">Fecha: <?php echo $result['fecha'] ?></p>
                            </div>
                        </div>
                        <div class="row titulo titulo-tema">
                            <div class="col">
                                <h1><strong><?php echo $result['titleTopic']; ?></strong></h1>
                            </div>
                        </div>
                        <div class="row cuerpo-tema mt-3">
                            <div class="col">
                                <?php echo $result['describeTopic']; ?>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <?php
                            $idTopicC = $result['idTopic']; 
                            $queryCountComentario = "SELECT COUNT(*) AS com FROM commentary c WHERE c.idTopic = '$idTopicC' ";
                            $resultCount = mysqli_query($link,$queryCountComentario);
                            $rowCountComentario = mysqli_fetch_array($resultCount);
                            ?>
                            <div class="col-md-4 d-flex d-wrap">
                                <p class="mt-1" style="color: rgb(7, 26, 57); font-size: 15px;"><b>Comentarios del tema:</b></p>&nbsp;&nbsp;
                                <b class="mt-1" style="color: rgb(7, 26, 57); font-size: 13px; font-weight: bold;"><?php echo $rowCountComentario['com'] . " Comentario(s)" ?></b>
                                <!-- <button class="btn d-flex align-items-start" type="button" data-bs-toggle="collapse" data-bs-target="#collapseComentarios" aria-expanded="false" aria-controls="collapseExample"><b style="color: rgb(7, 26, 57); font-size: 13px;">1 Comentario</b></button>-->
                                <!--<p style="color: rgb(7, 26, 57); font-size: 12px;"><b>Comentarios del tema: 1 comentario</b></p>-->
                            </div>
                            <?php
                                
                            ?>
                            
                                <div class="col-md-5 d-flex d-wrap"  style="font-size: 12px;">
                                <input type="hidden" name="idTemaLike" value="<?php echo $result['idTopic'];?>">
                                <div class="d-flex justify-content-between">
                                    <div class="d-flex align-items-end">
                                        <b>
                                            <p id="likeTema_<?php echo $result['idTopic']; ?>" class="text-nowrap" style="color: rgb(0, 253, 93);">Me gusta: <span class="counter" id="likeCount_<?php echo $result['idTopic'] ?>"><?php echo $result['likes'] ?></span></p>
                                        </b>
                                    </div>
                                </div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <div class="d-flex justify-content-between">
                                    <div class="d-flex align-items-end">
                                        <b>
                                            <p id="unlikeTema_<?php echo $result['idTopic']; ?>" class="text-nowrap" style="font-size: 12px; color: rgb(255, 22, 22);">No me gusta: <span class="counter" id="unlikeCount_<?php echo $result['idTopic'] ?>"><?php echo $result['unlikes'] ?></span></p>
                                        </b>
                                    </div>
                                </div>
            </div>
                           
                            <div class="col-md-3 d-grid">
                                <a class="btn" style="background-color: rgb(7, 26, 57); color: rgb(255 50 59);" href="#tema_<?php echo $result['idTopic'] ?>"><h6><b>VER TEMA</b></h6></a>
                            </div>
                        </div>
                        </div>
</div>

<?php
}

}else{
    $buscador = null;
}
?>