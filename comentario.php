<?php
include 'config.php';
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <link rel="stylesheet" type="text/css" href="./css/styles.css">

    <title>Comentarios</title>
</head>

<body>
    <header class="header" id="header">
        <div class="row">
            <div class="col-md-12">
                <div class="header_toggle"> <i class='bx bx-menu' id="header-toggle"></i> </div>
                <h1 id="title"><span style="color:red;">BIENVENIDO AL</span> <span style="color: white;">FORO ASSIST</span></h1>
                <!-- <div class="header_img"> <img src="https://i.imgur.com/hczKIze.jpg" alt=""> </div> -->
            </div>
            <div class="col-md-12 d-flex justify-content-start">
                <div class="col-md-6 col-sm-2 pb-1">
                    <a href="./User/index.php" type="button" class="btn text-light btn-nav">Temas</a>
                    <a href="actividad.php" type="button" class="btn text-light btn-nav">Actividad Reciente</a>
                    <a href="comentario.php" type="button" class="btn text-light btn-nav">Comentarios</a>
                </div>

                <div class="col-md-6 col-sm- 4 d-flex align-items-center justify-content-end">
                    <i class='bx bx-search bx-sm' style='color:#fffbfb'></i>&nbsp;&nbsp;&nbsp;
                    <input type="text" style="background-color: rgb(7, 26, 57); border: 0;" class="input-busqueda text-light" placeholder="Búsqueda">
                </div>
            </div>
        </div>
    </header>
    <?php
// Check if the user is already logged in, if yes then redirect him to welcome page
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    $idUsuario = $_SESSION['id'];
    $queryUser = mysqli_query($link, "SELECT u.idUsuario, CONCAT(u.usuNombres,\" \",u.usuApellidos) AS nombres, u.usuNombres, r.idRol, r.tipoRol, u.usuCorreo, u.usuImagen, DATE_FORMAT(u.created_at, \"%M de %Y\") as fecha
            FROM usuario u
            INNER JOIN rol r ON u.idRol = r.idRol
            WHERE u.idUsuario = '$idUsuario'");
} else {
    $queryUser = mysqli_query($link, "SELECT CONCAT(u.usuNombres,\" \",u.usuApellidos) AS nombres, u.usuNombres, u.usuCorreo, u.usuImagen, DATE_FORMAT(u.created_at, \"%M de %Y\") as fecha
            FROM usuario u");
    //INNER JOIN rol r ON u.idRol = r.idRol");
}
if(isset($_SESSION['id'])){
    $queryNotificacion = mysqli_query($link,"SELECT n.idNotificacion, n.idUsuario, n.idTema, u.usuNombres, u.usuImagen, t.tituloTema, n.idTipoNotificacion, tn.describeNotificacion, DATE_FORMAT(n.created_at, \"%d-%m-%Y %H:%i:%s\") AS fecha
    FROM notificacion n
    INNER JOIN usuario u ON n.idUsuario = u.idUsuario
    INNER JOIN tema t ON n.idtema = t.idTema
    INNER JOIN tipoNotificacion tn ON n.idTipoNotificacion = tn.idTipo
    WHERE n.idDestUser = '$idUsuario' 
    ORDER BY n.created_at DESC LIMIT 4");
}

?>
    <div class="l-navbar" id="nav-bar">
            <nav class="nav">
                <div class="nav_list">
                <div class="">
                    <img class="imgLogo" style="margin-left: 0.6rem; margin-bottom: 1rem; border-radius: 50%;" src="img/logo.jpg" width="27%" height="17%" alt="">
                </div>
                    <div style="column-gap: 2rem;width: 1.5rem; height: 1.6rem; margin-left: 1.5rem;" class="d-flex mb-4">
                        <?php
if (isset($_SESSION['id'])) {
    $idUsuario = $_SESSION['id'];
    $user = mysqli_query($link, "SELECT * FROM usuario u WHERE idUsuario = '$idUsuario'");
    $imgUser = mysqli_fetch_array($user);

    if ($imgUser['usuImagen'] != null) {
        ?>
                                        <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($imgUser['usuImagen']); ?>" style="object-fit: cover; object-position: center; border:1px solid #ffff;" width="100%" height="100%" class="rounded-circle" alt="Imagen de usuario">
                                <?php
} else {?>
                                    <img src="img/user.png"  style="object-fit: cover; object-position: center; border:1px solid #ffff;" width="100%" height="100%" class="rounded-circle" alt="Imagen de usuario">
                                <?php
}
    ?>
                        <a href="perfil.php" class="d-flex" >
                            <span class="nav_logo-name">Perfil</span>
                        </a>
                    </div>
                    <a class="nav_link active btn" data-bs-toggle="collapse" href="#collapseNotificacion" role="button" aria-expanded="false" aria-controls="collapseNotificacion"> <i class='bx bx-grid-alt nav_icon'></i>Notificaciones </a>
                    <div class="collapse text-light" style="background-color: #d0252d; font-size: 13px;" id="collapseNotificacion">
                        <?php 
                        while($resultQueryNotificacion = mysqli_fetch_array($queryNotificacion)){
                            $notificacion = $resultQueryNotificacion['idTipoNotificacion'] == 1 ? 'creaste el tema': ($resultQueryNotificacion['idTipoNotificacion'] == 2 ? 'comentó tu publicación' : 'respondió tu comentario en');?>
                            <div class="p-2">
                                <p><b> <?php echo $resultQueryNotificacion['usuNombres'];?></b> <?php echo $notificacion." "."\"".$resultQueryNotificacion['tituloTema']."\""; ?></p>
                            </div>
                            <hr>

                        <?php }?>
                    </div>
                    <?php } else {?>
                        </div>
                        <a href="#" class="nav_logo" data-bs-toggle="modal" data-bs-target="#loginModal" id="logModal"> <i class='bx bx-layer nav_logo-icon'></i> <span class="nav_logo-name" onclick="showModalLogin()">Iniciar Sesion</span> </a>
                        <a href="#" class="nav_link active" data-bs-toggle="modal" data-bs-target="#registerModal"> <i class='bx bx-grid-alt nav_icon'></i><span class="nav_name" onclick="showRegisterModal()">Registrarse</span> </a>
                    <?php }?>
                    <a href="comunidadAssist.php" class="nav_link"> <i class='bx bx-user nav_icon'></i> <span class="nav_name">Comunidad Assist</span> </a>
                    <a href="#" class="nav_link">
                </div>

                <a href="logout.php" class="nav_link"> <i class='bx bx-log-out nav_icon'></i> <span class="nav_name">Cerrar sesión</span> </a>
            </nav>
        </div>
        <div class="height-100 bg-light">
            <div class="container mt-4">
                <div class="row mb-4">
                </div>
                <div class="row card comentario mb-4">
            <?php
$queryComentario = "SELECT c.idComentario, c.idTema, c.idUsuario, t.tituloTema, CONCAT(u.usuNombres, \" \", u.usuApellidos) AS nombres,u.usuNombres, c.describeComentario, c.likes, c.unlikes, u.usuImagen, DATE_FORMAT(c.created_at, \"%M %d de %Y\") AS fecha
                          FROM comentario c
                          INNER JOIN tema t ON c.idTema = t.idTema
                          INNER JOIN usuario u ON c.idUsuario = u.idUsuario
                          ORDER BY c.created_at DESC";

$resultComentario = mysqli_query($link, $queryComentario);
while ($rowComentario = mysqli_fetch_array($resultComentario)) {
    ?>


                            <div class="row d-flex justify-content-between mt-4">
                                <div class="col-md-3 mt-2">
                                    <div class="d-flex justify-content-center" >
                                <?php
if ($rowComentario['usuImagen'] != null) {
        ?>
                                        <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($rowComentario['usuImagen']); ?>" style="object-fit: cover; object-position: center; border:1px solid #ffff;" width="50%" height="50%" class="rounded-circle" alt="Imagen de usuario">
                                <?php
} else {?>
                                    <img src="img/user.png"  style="object-fit: cover; object-position: center; border:1px solid #ffff;" width="50%" height="50%" class="rounded-circle" alt="Imagen de usuario">
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
                                <div class="col-md-3 d-flex justify-content-center">
                                <h5><?php echo $rowComentario['usuNombres'] ?></h5>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-md-6 d-flex justify-content-end">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <a class="likeComment btn" data-vote-type="1" id="like_<?php echo $rowComentario['idComentario'] ?>">
                                                <i class='bx bx-like' style="color:rgb(0, 253, 93);"></i>
                                            </a>
                                        </div>
                                        <div class="d-flex align-items-end">
                                            <b>
                                                <p id="likeComentario_<?php echo $rowComentario['idComentario'] ?>" class="text-nowrap mt-2" style="font-size: 12px; color: rgb(0, 253, 93);">Me gusta:&nbsp;<span class="counter" id="likeCount_<?php echo $rowComentario['idComentario'] ?>"><?php echo $rowComentario['likes'] ?></span></p>
                                            </b>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <a class="likeComment btn" data-vote-type="0" id="unlike_<?php echo $rowComentario['idComentario'] ?>">
                                                <i class='bx bx-dislike' style="color:rgb(255, 22, 22);"></i>
                                            </a>
                                        </div>
                                        <div class="d-flex align-items-end">
                                            <b>
                                                <p id="unlikeComentario_<?php echo $rowComentario['idComentario']; ?>" class="text-nowrap mt-2" style="font-size: 12px; color: rgb(255, 22, 22);">No me gusta:&nbsp;<span class="counter" id="unlikeCount_<?php echo $rowComentario['idComentario'] ?>"><?php echo $rowComentario['unlikes'] ?></span></p>
                                            </b>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 d-flex justify-content-end">
                                    <h5><b style="color: rgb(7, 26, 57);">Tema: </b> <b style="color: rgb(255 50 59);"><?php echo $rowComentario['tituloTema'] ?></b></h5>
                                </div>
                            </div>
                        <?php
}
?>
                        </div>
            </div>
        </div>


</body>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script type="text/javascript" src="./js/mainFunctions.js"></script>
    <script type="text/javascript" src="./js/likes.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"></script>

</html>