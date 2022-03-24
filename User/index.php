<?php
setlocale(LC_ALL, "es_ES");
// Initialize the session
session_start();

// Check if the user is already logged in, if yes then redirect him to welcome page
if ($_SESSION["id"] == null) {
    header("location: ../index.php");
    die();
}

// Include config file
require_once "../config.php";
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <link rel="stylesheet" type="text/css" href="../css/styles.css">

    <title>Foro ASSIST</title>
</head>
<header class="header" id="header">
    <div class="row">
        <div class="col-md-12">
            <div class="header_toggle"> <i class='bx bx-menu' id="header-toggle"></i> </div>
            <h1 id="title"><span style="color:red;">BIENVENIDO AL</span> <span style="color: white;">FORO ASSIST</span></h1>
            <!-- <div class="header_img"> <img src="https://i.imgur.com/hczKIze.jpg" alt=""> </div> -->
        </div>
        <div class="col-md-12 d-flex justify-content-start">
            <div class="col-md-6 col-sm-2 pb-1">
                <?php
                if(isset($_SESSION['id'])){?>
                    <a href="../User/index.php" type="button" class="btn text-light btn-nav">Temas</a>
                <?php }else{?>
                    <a href="index.php" type="button" class="btn text-light btn-nav">Temas</a>
                <?php } ?>    
                <a href="../actividad.php" type="button" class="btn text-light btn-nav">Actividad Reciente</a>
                <a href="../comentario.php" type="button" class="btn text-light btn-nav">Comentarios</a>
            </div>

            <div class="col-md-6 col-sm- 4 d-flex align-items-center justify-content-end">
                <i class='bx bx-search bx-sm' style='color:#fffbfb'></i>&nbsp;&nbsp;&nbsp;
                <input type="text" id="buscar" name="buscar" onkeyup="buscar($('#buscar').val())" style="background-color: rgb(7, 26, 57); border: 0;" class="input-busqueda text-light" placeholder="Búsqueda">
            </div>
        </div>
    </div>
</header>
<?php
$idUsuario = $_SESSION['id'];

$queryUser = mysqli_query($link, "SELECT u.idUsuario, CONCAT(u.usuNombres,\" \",u.usuApellidos) AS nombres, r.idRol, r.tipoRol, u.usuCorreo, u.usuImagen, DATE_FORMAT(u.created_at, \"%M de %Y\") as fecha
    FROM usuario u
    INNER JOIN rol r ON u.idRol = r.idRol
    WHERE u.idUsuario = '$idUsuario'");
$rowUser = mysqli_fetch_array($queryUser);
?>
<div class="l-navbar" id="nav-bar">
    <nav class="nav">
            <div class="nav_list">
            <div class="">
            <img class="imgLogo" style="margin-left: 0.6rem; margin-bottom: 1rem; border-radius: 50%;" src="../img/logo.jpg" width="27%" height="17%" alt="">
            </div>
            <div style="column-gap: 2rem;width: 1.5rem; height: 1.6rem; margin-left: 1.5rem;" class="d-flex mb-4">
                    <?php
if ($rowUser['usuImagen'] != null) {
    ?>
                            <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($rowUser['usuImagen']); ?>" style="object-fit: cover; object-position: center; border:1px solid #ffff;" width="100%" height="100%" class="rounded-circle" alt="Imagen de usuario">
                    <?php
} else {?>
                        <img src="../img/user.png"  style="object-fit: cover; object-position: center; border:1px solid #ffff;" width="100%" height="100%" class="rounded-circle" alt="Imagen de usuario">
                    <?php
}
?>
            <a href="../perfil.php" class="d-flex" >
                <span class="nav_logo-name">Perfil</span>
            </a>
            </div>
                <a href="#" class="nav_link active"> <i class='bx bx-grid-alt nav_icon'></i><span class="nav_name">Notificaciones</span> </a>
                <a href="../comunidadAssist.php" class="nav_link"> <i class='bx bx-user nav_icon'></i> <span class="nav_name">Comunidad Assist</span> </a>
                <a href="#" class="nav_link">
            </div>

        <a href="../logout.php" class="nav_link"> <i class='bx bx-log-out nav_icon'></i> <span class="nav_name">Cerrar sesión</span> </a>
    </nav>
</div>
<!--Container Main start-->
<?php
$idUsuario = $_SESSION['id'];
$totalC = "SELECT COUNT(*) AS totalComentarios FROM comentario";

$resultTotalC = mysqli_query($link, $totalC);
$rowTotalC = mysqli_fetch_array($resultTotalC);

$totalR = "SELECT COUNT(*) AS totalRespuestas FROM respuesta";

$resultTotalR = mysqli_query($link, $totalR);
$rowTotalR = mysqli_fetch_array($resultTotalR);
?>
<div class="height-100 bg-light">
    <div class="container">
            <div id="datos_buscador" class="row mt-2">

            </div>
        <div class="row d-flex justify-content-end">
            <div class="col-md-5 mt-3 d-flex justify-content-end">
                <div class="card info">
                    <div class="row card-body d-flex">
                        <div class="col num-commentary pt-2">
                            <h6 class="text-center titulo">COMENTARIOS</h6>
                            <h6 class="text-center text-light"><?php echo $rowTotalC['totalComentarios']; ?></h6>
                        </div>
                        <div class="col num-answer pt-2">
                            <h6 class="text-center titulo">RESPUESTAS</h6>
                            <h6 class="text-center text-light"><?php echo $rowTotalR['totalRespuestas']; ?></h6>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-5 d-flex align-items-end justify-content-center">
                <div class="row tema">
                    <button type="button" class="btn d-flex justify-content-between align-items-center" data-bs-toggle="modal" data-bs-target="#modalTema">
                        <div class="col-md-6 d-flex justify-content-end btn">
                            <img class="img img-add-tema" src="../img/agregar.png" alt="">
                        </div>
                        <div class="col-md-6 d-flex justify-content-center btn">
                            <h5 class="text-center text-add-tema text-nowrap">CREAR TEMA</h5>
                        </div>
                    </button>
                </div>
            </div>
        </div>

        <div class="row mt-4 d-flex justify-content-start">

            <!-- Modal para crear tema-->
            <div class="modal fade" id="modalTema" tabindex="-1" aria-labelledby="modalTema" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalTema">Crear tema</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="../crearTema.php" method="POST">
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="tituloTema" class="form-label">Titulo:</label>
                                    <input type="text" class="form-control" name="tituloTema">
                                </div>
                                <div class="mb-3">
                                    <label for="describeTema" class="form-label">Descripción:</label>
                                    <textarea name="describeTema" class="form-control" cols="30" rows="8"></textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <input name="crearTema" type="submit" class="btn btn-primary" value="Publicar tema"></input>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Fin del modal-->
            <?php
$query = "SELECT t.idTema, t.idUsuario, CONCAT(u.usuNombres, \" \", u.usuApellidos) AS nombres, r.tipoRol, t.tituloTema, t.describeTema, DATE_FORMAT(t.created_at, \"%M %d de %Y\") AS fecha, likes, unlikes
                  FROM tema t
                  INNER JOIN usuario u ON t.idUsuario = u.idUsuario
                  INNER JOIN rol r ON u.idRol = r.idRol
                  ORDER BY t.idTema DESC";

$resultQuery = mysqli_query($link, $query);
while ($row = mysqli_fetch_array($resultQuery)) {
    ?>
                <div class="card tema-informacion mt-2 mb-3">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-5 ">
                                <h6><strong>Publicado por: <?php echo $row['nombres'] ?> (<?php echo $row['tipoRol'] ?>)</strong></h6>
                            </div>
                            <div class="col-7">
                                <p class="text-muted" style="font-size: smaller;">Fecha: <?php echo $row['fecha'] ?></p>
                            </div>
                        </div>
                        <div class="row titulo titulo-tema">
                            <div class="col">
                                <h1><strong><?php echo $row['tituloTema']; ?></strong></h1>
                            </div>
                        </div>
                        <div class="row cuerpo-tema mt-3">
                            <div class="col">
                                <?php echo $row['describeTema']; ?>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <?php
$idTemaC = $row['idTema'];
    $queryCountComentario = "SELECT COUNT(*) AS com FROM comentario c WHERE c.idTema = '$idTemaC' ";
    $resultCount = mysqli_query($link, $queryCountComentario);
    $rowCountComentario = mysqli_fetch_array($resultCount);
    ?>
                            <div class="col-md-4 d-flex d-wrap">
                                <p class="mt-1" style="color: rgb(7, 26, 57); font-size: 15px;"><b>Comentarios del tema:</b></p>
                                <b class="btn btn-comentarios" type="button" data-bs-toggle="collapse" data-bs-target="#tema<?php echo $row['idTema'] ?>" aria-expanded="false" aria-controls="collapseExample" style="color: rgb(7, 26, 57); font-size: 13px; font-weight: bold;"><?php echo $rowCountComentario['com'] . " Comentario(s)" ?></b>
                                <!-- <button class="btn d-flex align-items-start" type="button" data-bs-toggle="collapse" data-bs-target="#collapseComentarios" aria-expanded="false" aria-controls="collapseExample"><b style="color: rgb(7, 26, 57); font-size: 13px;">1 Comentario</b></button>-->
                                <!--<p style="color: rgb(7, 26, 57); font-size: 12px;"><b>Comentarios del tema: 1 comentario</b></p>-->
                            </div>
                            <?php

    ?>

                                <div class="col-md-5 d-flex d-wrap"  style="font-size: 12px;">
                                <input type="hidden" name="idTemaLike" value="<?php echo $row['idTema']; ?>">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <a class="likeTema btn" data-vote-type="1" id="like_<?php echo $row['idTema'] ?>">
                                        <i class='bx bx-like' style="color:rgb(0, 253, 93);" id="likeTema"></i>
                                        </a>
                                    </div>
                                    <div class="d-flex align-items-end">
                                        <b>
                                            <p id="likeTema_<?php echo $row['idTema']; ?>" class="text-nowrap" style="color: rgb(0, 253, 93);">Me gusta: <span class="counter" id="likeCount_<?php echo $row['idTema'] ?>"><?php echo $row['likes'] ?></span></p>
                                        </b>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <a class="likeTema btn" data-vote-type="0" id="unlike_<?php echo $row['idTema'] ?>">
                                            <i class='bx bx-dislike' style="color:rgb(255, 22, 22);" id="unlikeTema"></i>
                                        </a>
                                    </div>
                                    <div class="d-flex align-items-end">
                                        <b>
                                            <p id="unlikeTema_<?php echo $row['idTema']; ?>" class="text-nowrap" style="font-size: 12px; color: rgb(255, 22, 22);">No me gusta: <span class="counter" id="unlikeCount_<?php echo $row['idTema'] ?>"><?php echo $row['unlikes'] ?></span></p>
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
                                <button class="btn btn-vermas" type="button" data-bs-toggle="collapse" data-bs-target="#collapseComentar_tema<?php echo $row['idTema'] ?>" aria-expanded="false" aria-controls="collapseExample"><b>Comentar</b></button>
                            </div>
                        </div>

                        <form action="../comentar.php" method="POST">
                           <div class="row collapse mt-4" id="collapseComentar_tema<?php echo $row['idTema'] ?>">
                                <div class="col-md-10">
                                    <div class="mb-3">
                                        <input type="text" name="describeComentario" class="form-control" placeholder="Escribe un comentario...">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <input type="hidden" name="idTema" value="<?php echo $row['idTema'] ?>">
                                    <input name="comentario" type="submit" class="btn btn-danger" value="Comentar">
                                </div>
                            </div>
                        </form>

                        <?php
$idTema = $row['idTema'];
    $queryComentario = "SELECT c.idComentario, c.idTema, c.idUsuario, CONCAT(u.usuNombres, \" \", u.usuApellidos) AS nombres, c.describeComentario, c.likes, c.unlikes, u.usuImagen, DATE_FORMAT(c.created_at, \"%M %d de %Y\") AS fecha
                          FROM comentario c
                          INNER JOIN tema t ON c.idTema = t.idTema
                          INNER JOIN usuario u ON c.idUsuario = u.idUsuario
                          WHERE C.idTema = '$idTema'
                          ORDER BY c.idComentario DESC";

    $resultComentario = mysqli_query($link, $queryComentario);
    while ($rowComentario = mysqli_fetch_array($resultComentario)) {
        ?>
                        <div class="row collapse titulo-comentario mt-3" id="tema<?php echo $row['idTema'] ?>">
                            <div class="col-md-12 mt-3">
                                <h5><b>Comentario anterior</b></h5>
                            </div>
                            <?php

        ?>
                            <div class="row d-flex justify-content-between mt-4">
                                <div class="col-md-3 mt-2">
                                <div class="d-flex justify-content-center mb-2" style="width: 100%; height: 100%;">
                                    <?php
if ($rowComentario      ['usuImagen'] != null) {
            ?>
                                            <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($rowComentario['usuImagen']); ?>" style="object-fit: cover; object-position: center;" width="60%" height="60%" class="img-thumbnail img-perfil rounded-circle" alt="Imagen de usuario">
                                    <?php
} else {?>
                                        <img src="../img/user.png"  style="object-fit: cover; object-position: center;" width="60%" height="60%" class="img-thumbnail img-perfil rounded-circle" alt="Imagen de usuario">
                                    <?php
}
        ?>
                                </div>
                                </div>
                                <div class="col-md-9 container-commentary">
                                    <p class="mt-2"><?php echo $rowComentario['describeComentario'] ?></p>
                                </div>
                            </div>
                            <div class="row mt-2 ">
                                <div class="col-md-3 mt-1 d-flex justify-content-center">
                                <h5><?php echo $rowComentario['nombres'] ?></h5>
                                </div>
                            </div>
                            <?php
$idComentario = $rowComentario['idComentario'];
        $queryCountRespuesta = "SELECT COUNT(*) AS res FROM respuesta r WHERE r.idComentario = '$idComentario' ";
        $resultCount = mysqli_query($link, $queryCountRespuesta);
        $rowCountRespuesta = mysqli_fetch_array($resultCount);
        ?>
                            <div class="row mt-3">
                                <div class="col-md-4 d-flex d-wrap">
                                <p class="mt-1" style="color: rgb(7, 26, 57); font-size: 15px;"><b>Respuestas:</b></p>
                                <b class="btn btn-comentarios" type="button" data-bs-toggle="collapse" data-bs-target="#comentario<?php echo $rowComentario['idComentario'] ?>" aria-expanded="false" aria-controls="collapseExample" style="color: rgb(7, 26, 57); font-size: 13px; font-weight: bold;"><?php echo $rowCountRespuesta['res'] . " Respuesta(s)" ?></b>
                                </div>
                                <div class="col-md-4 d-flex justify-content-end">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <a class="likeComentario btn" data-vote-type="1" id="like_<?php echo $rowComentario['idComentario'] ?>">
                                                <i class='bx bx-like' style="color:rgb(0, 253, 93);"></i>
                                            </a>
                                        </div>
                                        <div>
                                            <b>
                                            <p id="likeComentario_<?php echo $rowComentario['idComentario'] ?>" class="text-nowrap mt-2" style="font-size: 12px; color: rgb(0, 253, 93);">Me gusta:<span class="counter" id="likeCount_<?php echo $rowComentario['idComentario'] ?>">&nbsp;<?php echo $rowComentario['likes'] ?></span></p>
                                            </b>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <a class="likeComentario btn" data-vote-type="0" id="unlike_<?php echo $rowComentario['idComentario'] ?>">
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
                                <div class="col-md-4 d-flex justify-content-end">
                                    <button class="btn btn-vermas"  data-bs-toggle="collapse" data-bs-target="#collapseResponder_com<?php echo $rowComentario['idComentario'] ?>" aria-expanded="false" aria-controls="collapseExample">
                                        Responder comentario
                                    </button>
                                </div>
                                    <form action="../respuesta.php" method="POST">
                                        <div class="row collapse mt-4" id="collapseResponder_com<?php echo $rowComentario['idComentario'] ?>">
                                            <div class="col-md-10">
                                                <div class="mb-3">
                                                    <input type="text" name="describeRespuesta" class="form-control" placeholder="Escribe una respuesta...">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <input type="hidden" name="idComentario" value="<?php echo $rowComentario['idComentario'] ?>">
                                                <input name="respuesta" type="submit" class="btn btn-danger" value="Responder">
                                            </div>
                                        </div>
                                    </form>
                            </div>
                        </div>

                        <?php
$idComentario = $rowComentario['idComentario'];
        $queryRespuesta = "SELECT r.idRespuesta, r.idComentario, r.idUsuario, CONCAT(u.usuNombres, \" \", u.usuApellidos) AS nombres, r.describeRespuesta, r.likes, r.unlikes, u.usuImagen, DATE_FORMAT(c.created_at, \"%M %d de %Y\") AS fecha
                          FROM respuesta r
                          INNER JOIN comentario c ON r.idComentario = c.idComentario
                          INNER JOIN usuario u ON r.idUsuario = u.idUsuario
                          WHERE r.idComentario = '$idComentario'
                          ORDER BY r.idRespuesta DESC";

        $resultRespuesta = mysqli_query($link, $queryRespuesta);
        while ($rowRespuesta = mysqli_fetch_array($resultRespuesta)) {
            ?>

                        <!-- Collapse respuestas -->

                        <div class="row collapse mt-3" id="comentario<?php echo $rowComentario['idComentario'] ?>">
                            <div class="col-md-12 mt-3">
                                <h5><b>Respuesta anterior</b></h5>
                            </div>
                            <div class="row d-flex justify-content-between mt-4">
                                <div class="col-md-3 mt-2">
                                <div class="d-flex justify-content-center mb-2" style="width: 100%; height: 100%;">
                                    <?php
if ($rowRespuesta['usuImagen'] != null) {
                ?>
                                            <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($rowRespuesta['usuImagen']); ?>" style="object-fit: cover; object-position: center;" width="60%" height="60%" class="img-thumbnail img-perfil rounded-circle" alt="Imagen de usuario">
                                    <?php
} else {?>
                                        <img src="../img/user.png"  style="object-fit: cover; object-position: center;" width="60%" height="60%" class="img-thumbnail img-perfil rounded-circle" alt="Imagen de usuario">
                                    <?php
}
            ?>
                                </div>
                                </div>
                                <div class="col-md-9 container-commentary">
                                    <p class="mt-2"><?php echo $rowRespuesta['describeRespuesta'] ?></p>
                                </div>
                            </div>
                            <div class="row mt-2 ">
                                <div class="col-md-3 mt-1 d-flex justify-content-center">
                                    <h5><?php echo $rowRespuesta['nombres'] ?></h5>
                                </div>
                                <div class="col-md-4 d-flex justify-content-end">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <a class="likeRespuesta btn" data-vote-type="1" id="like_<?php echo $rowRespuesta['idRespuesta'] ?>">
                                                <i class='bx bx-like' style="color:rgb(0, 253, 93);"></i>
                                            </a>
                                        </div>
                                        <div>
                                            <b>
                                            <p id="likeRespuesta_<?php echo $rowRespuesta['idRespuesta'] ?>" class="text-nowrap mt-2" style="font-size: 12px; color: rgb(0, 253, 93);">Me gusta:<span class="counter" id="likeCount_<?php echo $rowRespuesta['idRespuesta'] ?>">&nbsp;<?php echo $rowRespuesta['likes'] ?></span></p>
                                            </b>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <a class="likeRespuesta btn" data-vote-type="0" id="unlike_<?php echo $rowRespuesta['idRespuesta'] ?>">
                                                <i class='bx bx-dislike' style="color:rgb(255, 22, 22);"></i>
                                            </a>
                                        </div>
                                        <div>
                                            <b>
                                            <p id="unlikeRespuesta_<?php echo $rowRespuesta['idRespuesta']; ?>" class="text-nowrap mt-2" style="font-size: 12px; color: rgb(255, 22, 22);">No me gusta:<span class="counter" id="unlikeCount_<?php echo $rowRespuesta['idRespuesta'] ?>">&nbsp;<?php echo $rowRespuesta['unlikes'] ?></span></p>
                                            </b>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php
}
        ?>
                        <?php
}
    ?>

                    </div>
                </div>
            <?php
}
?>
        </div>
    </div>
</div>
<!--Container Main end-->


    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script type="text/javascript" src="../js/mainFunctions.js"></script>
    <script type="text/javascript" src="../js/likes.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"></script>

</html>