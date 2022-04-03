<?php
require_once 'config.php';
session_start();
include 'utils.php';

$util = new utils();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <link rel="stylesheet" type="text/css" href="css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <title>Actividad reciente</title>
</head>

<body>
    <header class="header" id="header">
        <div class="row mb-2">
            <div class="col-md-12">
                <div class="header_toggle"> <i class='bx bx-menu' id="header-toggle"></i> </div>
                <h1 id="title"><span style="color:red;">BIENVENIDO AL</span> <span style="color: white;">FORO ASSIST</span></h1>
                <!-- <div class="header_img"> <img src="https://i.imgur.com/hczKIze.jpg" alt=""> </div> -->
            </div>
            <div class="col-md-12 d-flex justify-content-start">
                <div class="col-md-6 col-sm-2 pb-1">
                    <?php
if (isset($_SESSION['id'])) {?>
                        <a href="./User/index.php" type="button" class="btn text-light btn-nav">Temas</a>
                    <?php } else {?>
                        <a href="index.php" type="button" class="btn text-light btn-nav">Temas</a>
                    <?php }?>
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
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    $idUsuario = $_SESSION['id'];
    $queryUser = mysqli_query($link, "SELECT u.idUsuario, CONCAT(u.usuNombres,\" \",u.usuApellidos) AS nombres, r.idRol, r.tipoRol, u.usuCorreo, u.usuImagen, DATE_FORMAT(u.created_at, \"%M de %Y\") as fecha
        FROM usuario u
        INNER JOIN rol r ON u.idRol = r.idRol
        WHERE u.idUsuario = '$idUsuario'");
} else {
    $queryUser = mysqli_query($link, "SELECT CONCAT(u.usuNombres,\" \",u.usuApellidos) AS nombres, u.usuCorreo, u.usuImagen, DATE_FORMAT(u.created_at, \"%M de %Y\") as fecha
        FROM usuario u
        INNER JOIN rol r ON u.idRol = r.idRol");
}
$rowUser = mysqli_fetch_array($queryUser);
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

    if ($rowUser['usuImagen'] != null) {
        ?>
                                <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($rowUser['usuImagen']); ?>" style="object-fit: cover; object-position: center; border:1px solid #ffff;" width="100%" height="100%" class="rounded-circle" alt="Imagen de usuario">
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
                <a href="#" class="nav_link active"> <i class='bx bx-grid-alt nav_icon'></i><span class="nav_name">Notificaciones</span> </a>
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
        <div class="container">
             <div class="row"></div>
             <div class="row mt-3 mb-3 d-flex justify-content-center">
                    <div class="card mb-3 actividad-info">
            <?php
// $queryTema = mysqli_query($link, "SELECT t.idTema, t.idUsuario, CONCAT(u.usuNombres, \" \", u.usuApellidos) AS nombres, usuNombres, t.tituloTema, t.describeTema, u.usuImagen, DATE_FORMAT(t.created_at, \"%d-%m-%Y %H:%i:%s\") AS fecha, likes, unlikes
//             FROM tema t
//             INNER JOIN usuario u ON t.idUsuario = u.idUsuario
//             INNER JOIN rol r ON u.idRol = r.idRol
//             ORDER BY t.created_at DESC");

 $queryNotificacion = mysqli_query($link, "SELECT n.idNotificacion, n.idUsuario, n.idTema, u.usuNombres, u.usuImagen, t.tituloTema, n.tipoNotificacion, DATE_FORMAT(n.created_at, \"%d-%m-%Y %H:%i:%s\") AS fecha
 FROM notificacion n
 INNER JOIN usuario u ON n.idUsuario = u.idUsuario
 INNER JOIN tema t ON n.idtema = t.idTema
 ORDER BY n.created_at DESC");

$queryDateNow = mysqli_query($link, "SELECT DATE_FORMAT(now(),\"%d %m %Y %H %i %s\") as dateNow");
$dateNow = mysqli_fetch_array($queryDateNow);

while ($rowNotificacion = mysqli_fetch_array($queryNotificacion)) {
    ?>
                        <div class="row d-flex justify-content-center" style="width: 90%;">
                            <div class="col-md-3 mt-3 mb-1">
                                <div class="d-flex justify-content-center" >
                                    <?php
if ($rowNotificacion['usuImagen'] != null) {
        ?>
                                            <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($rowNotificacion['usuImagen']); ?>" style="object-fit: cover; object-position: center; border:1px solid #ffff;" width="50%" height="50%" class="rounded-circle" alt="Imagen de usuario">
                                    <?php
} else {?>
                                        <img src="img/user.png"  style="object-fit: cover; object-position: center; border:1px solid #ffff;" width="50%" height="50%" class="rounded-circle" alt="Imagen de usuario">
                                    <?php
}
    ?>
                                    </div>
                            </div>
                            <div class="col-md-9 mt-3 mb-2 d-flex align-items-center">
                                <div class="card-body">
                                    <h5 class="card-title"><b style="color: rgb(7, 26, 57);"><?php echo $rowNotificacion['usuNombres']." ".$rowNotificacion['tipoNotificacion']." "; ?></b><b style="color: rgb(255 50 59);"><?php echo $rowNotificacion['tituloTema'] ?></b></h5>
                                    <p class="card-text"><small class="text-muted"><?php echo $util->get_time_ago($rowNotificacion['fecha'])?></small></p>
                                </div>
                            </div>
                        </div>
            <?php
}
?>
                    </div>
                </div>
        </div>
    </div>

</body>

<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script type="text/javascript" src="js/mainFunctions.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"></script>

</html>