<?php
require_once('config.php');
$buscar = $_GET['buscar'];

$buscador = mysqli_query($link,"SELECT t.idTema, t.tituloTema, t.describeTema, t.idUsuario, u.usuNombres, u.usuApellidos, t.created_at as fecha, likes, unlikes FROM tema t 
INNER JOIN usuario u ON t.idUsuario = u.idUsuario
WHERE t.tituloTema LIKE LOWER('%".$buscar."%') OR u.usuNombres LIKE LOWER('%".$buscar."%') OR u.usuApellidos LIKE LOWER('%".$buscar."%')");
// % OR u.usuNombres LIKE %'".$buscar."'% OR u.usuApellidos LIKE %'".$buscar."'%
$num = mysqli_num_rows($buscador);
?>

<h5 class="card-tittle">Resultados encontrados (<?php echo $num?>)</h5>

<?php
while($result = mysqli_fetch_array($buscador)){?>
    <div class="card tema-informacion mt-2 mb-3">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-5 ">
                                <h6><strong>Publicado por: <?php echo $result['usuNombres']." ".$result['usuApellidos'] ?> </strong></h6>
                            </div>
                            <div class="col-7">
                                <p class="text-muted" style="font-size: smaller;">Fecha: <?php echo $result['fecha'] ?></p>
                            </div>
                        </div>
                        <div class="row titulo titulo-tema">
                            <div class="col">
                                <h1><strong><?php echo $result['tituloTema']; ?></strong></h1>
                            </div>
                        </div>
                        <div class="row cuerpo-tema mt-3">
                            <div class="col">
                                <?php echo $result['describeTema']; ?>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <?php
                            $idTemaC = $result['idTema']; 
                            $queryCountComentario = "SELECT COUNT(*) AS com FROM comentario c WHERE c.idTema = '$idTemaC' ";
                            $resultCount = mysqli_query($link,$queryCountComentario);
                            $rowCountComentario = mysqli_fetch_array($resultCount);
                            ?>
                            <div class="col-md-4 d-flex d-wrap">
                                <p class="mt-1" style="color: rgb(7, 26, 57); font-size: 15px;"><b>Comentarios del tema:</b></p>
                                <b class="btn btn-comentarios" type="button" data-bs-toggle="collapse" data-bs-target="#tema<?php echo $result['idTema'] ?>" aria-expanded="false" aria-controls="collapseExample" style="color: rgb(7, 26, 57); font-size: 13px; font-weight: bold;"><?php echo $rowCountComentario['com'] . " Comentario(s)" ?></b>
                                <!-- <button class="btn d-flex align-items-start" type="button" data-bs-toggle="collapse" data-bs-target="#collapseComentarios" aria-expanded="false" aria-controls="collapseExample"><b style="color: rgb(7, 26, 57); font-size: 13px;">1 Comentario</b></button>-->
                                <!--<p style="color: rgb(7, 26, 57); font-size: 12px;"><b>Comentarios del tema: 1 comentario</b></p>-->
                            </div>
                            <?php
                                
                            ?>
                            
                                <div class="col-md-5 d-flex d-wrap"  style="font-size: 12px;">
                                <input type="hidden" name="idTemaLike" value="<?php echo $result['idTema'];?>">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <a class="likeTema btn" data-vote-type="1" id="like_<?php echo $result['idTema']?>">
                                        <i class='bx bx-like' style="color:rgb(0, 253, 93);"></i>
                                        </a>
                                    </div>
                                    <div class="d-flex align-items-end">
                                        <b>
                                            <p id="likeTema_<?php echo $result['idTema']; ?>" class="text-nowrap" style="color: rgb(0, 253, 93);">Me gusta: <span class="counter" id="likeCount_<?php echo $result['idTema'] ?>"><?php echo $result['likes'] ?></span></p>
                                        </b>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <a class="likeTema btn" data-vote-type="0" id="unlike_<?php echo $result['idTema']?>">
                                            <i class='bx bx-dislike' style="color:rgb(255, 22, 22);"></i>
                                        </a>
                                    </div>
                                    <div class="d-flex align-items-end">
                                        <b>
                                            <p id="unlikeTema_<?php echo $result['idTema']; ?>" class="text-nowrap" style="font-size: 12px; color: rgb(255, 22, 22);">No me gusta: <span class="counter" id="unlikeCount_<?php echo $result['idTema'] ?>"><?php echo $result['unlikes'] ?></span></p>
                                        </b>
                                    </div>
                                </div>
            </div>
                           
                           <!-- <div class="col-md-2">
                                <div class="d-flex justify-content-center">
                                    <div class="d-flex justify-content-between">
                                        <img style="width: 20px; height: 15px;" src="img/agregar.png" alt="">
                                        <b>
                                            <p class="text-nowrap text-muted" style="font-size: 12px;">Vistas:12</p>
                                        </b>
                                    </div>
                                </div>
                            </div>-->
                            <div class="col-md-3 d-grid">
                                <!--<button class="btn btn-vermas" type="button" data-bs-toggle="collapse" data-bs-target="#collapseComentarios" aria-expanded="false" aria-controls="collapseExample"><b>VER MÁS</b></button>-->
                                <!--<button class="btn btn-vermas" type="button" data-bs-toggle="modal" data-bs-target="#modalComentario"><b>Comentar</b></button>-->
                                <button class="btn btn-vermas" type="button" data-bs-toggle="collapse" data-bs-target="#collapseComentar" aria-expanded="false" aria-controls="collapseExample"><b>Comentar</b></button>
                            </div>
                        </div>

                        <form action="../comentar.php" method="POST">
                           <div class="row collapse mt-4" id="collapseComentar">
                                <div class="col-md-10">
                                    <div class="mb-3">
                                        <input type="text" name="describeComentario" class="form-control" placeholder="Escribe un comentario...">
                                    </div> 
                                </div>
                                <div class="col-md-2">
                                    <input type="hidden" name="idTema" value="<?php echo $result['idTema']?>">
                                    <input name="comentario" type="submit" class="btn btn-danger" value="Comentar">
                                </div>
                            </div>
                        </form>
                         
                        <?php
                          $idTema = $result['idTema'];
                          $queryComentario = "SELECT c.idComentario, c.idTema, c.idUsuario, CONCAT(u.usuNombres, \" \", u.usuApellidos) AS nombres, c.describeComentario, c.likes, c.unlikes, DATE_FORMAT(c.created_at, \"%M %d de %Y\") AS fecha
                          FROM comentario c 
                          INNER JOIN tema t ON c.idTema = t.idTema
                          INNER JOIN usuario u ON c.idUsuario = u.idUsuario 
                          WHERE C.idTema = '$idTema'
                          ORDER BY c.idComentario DESC";

                          $resultComentario = mysqli_query($link, $queryComentario);
                          while($rowComentario = mysqli_fetch_array($resultComentario)){
                        ?>
                        <div class="row collapse titulo-comentario mt-3" id="tema<?php echo $result['idTema'] ?>">
                            <div class="col-md-12 mt-3">
                                <h5><b>Comentarios anteriores</b></h5>
                            </div>
                            <div class="row d-flex justify-content-between mt-4">
                                <div class="col-md-3 mt-2 d-flex justify-content-center">
                                        <img class="img-user img-fluid" src="../img/user.png" alt="">
                                </div>
                                <div class="col-md-9 container-commentary">
                                    <p class="mt-2"><?php echo $rowComentario['describeComentario']?></p>
                                </div>
                            </div>
                            <div class="row mt-2 ">
                                <div class="col-md-3 d-flex justify-content-center">
                                <h5><?php echo $rowComentario['nombres']?></h5>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 d-flex justify-content-end">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <a class="likeComentario btn" data-vote-type="1" id="like_<?php echo $rowComentario['idComentario']?>">
                                                <i class='bx bx-like' style="color:rgb(0, 253, 93);"></i>
                                            </a>
                                        </div>
                                        <div>
                                            <b>
                                            <p id="likeComentario_<?php echo $rowComentario['idComentario']?>" class="text-nowrap mt-2" style="font-size: 12px; color: rgb(0, 253, 93);">Me gusta:<span class="counter" id="likeCount_<?php echo $rowComentario['idComentario'] ?>">&nbsp;<?php echo $rowComentario['likes'] ?></span></p>
                                            </b>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <a class="likeComentario btn" data-vote-type="0" id="unlike_<?php echo $rowComentario['idComentario']?>">
                                                <i class='bx bx-dislike' style="color:rgb(255, 22, 22);"></i>
                                            </a>
                                        </div>
                                        <div>
                                            <b>
                                            <p id="unlikeComentario_<?php echo $rowComentario['idComentario']; ?>" class="text-nowrap mt-2" style="font-size: 12px; color: rgb(255, 22, 22);">No me gusta:<span class="counter" id="unlikeCount_<?php echo $rowComentario['idComentario'] ?>">&nbsp;<?php echo $rowComentario['unlikes'] ?></span></p>
                                            </b>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 d-flex justify-content-end">
                                    <button class="btn btn-vermas">
                                        responder comentario
                                    </button>
                                </div>
                            </div>
                        </div>
                        <?php
                          }
                        ?>

                    </div>
                </div>
<?php
}
?>