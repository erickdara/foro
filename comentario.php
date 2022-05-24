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
                <div class="header_toggle"> <i class='bx bx-menu' style="color: #071a39;" id="header-toggle"></i> </div>
            </div>
            <div class="col-md-6 d-flex justify-content-start">
                <h1 id="title"><span style="color: white; font-family: 'Alfa Slab One', cursive;">FORO ASSIST</span></h1>
            </div>
            <div class="col-md-6 d-flex align-items-start justify-content-end ">
                <div style="width: 5rem; height: 5rem; margin-right: 87px;">
                    <img src="./img/ForoTech.png" style="object-fit: contain; object-position: center;" width="100%" height="100%">
                </div>
            </div>
            <div class="col-md-12 d-flex justify-content-start">
                <div class="col-md-6 col-sm-2 pb-1">
                    <a href="./User/index.php" type="button" class="btn text-light btn-nav">Temas</a>
                    <a href="actividad.php" type="button" class="btn text-light btn-nav">Actividad Reciente</a>
                    <a href="comentario.php" type="button" class="btn text-light btn-nav">Comentarios</a>
                </div>
            </div>
        </div>
    </header>
    <?php
// Check if the user is already logged in, if yes then redirect him to welcome page
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    $idUsuario = $_SESSION['id'];
    $queryUser = mysqli_query($link, "SELECT u.idUser, u.usernames, r.idRole, r.roleType, u.userMail, u.userImage, DATE_FORMAT(u.created_at, \"%M de %Y\") as fecha
            FROM user u
            INNER JOIN role r ON u.idRole = r.idRole
            WHERE u.idUser = '$idUsuario'");
} else {
    $queryUser = mysqli_query($link, "SELECT u.usernames, u.userMail, u.userImage, DATE_FORMAT(u.created_at, \"%M de %Y\") as fecha
            FROM user u");
    //INNER JOIN rol r ON u.idRole = r.idRole");
}
if(isset($_SESSION['id'])){
    $queryNotificacion = mysqli_query($link,"SELECT n.idNotification, n.idUser, n.idTopic, u.usernames, u.userImage, t.titleTopic, n.idNotificationType, tn.describeNotification, DATE_FORMAT(n.created_at, \"%d-%m-%Y %H:%i:%s\") AS fecha
    FROM notification n
    INNER JOIN user u ON n.idUser = u.idUser
    INNER JOIN topic t ON n.idTopic = t.idTopic
    INNER JOIN notificationType tn ON n.idNotificationType = tn.idType
    WHERE n.idDestUser = '$idUsuario' 
    ORDER BY n.created_at DESC LIMIT 4");

$num_rows = mysqli_num_rows($queryNotificacion);
}

?>
    <div class="l-navbar" id="nav-bar">
            <nav class="nav">
                <div class="nav_list">
                <div class="">
                    <img class="imgLogo" style="margin-left: 0.6rem; margin-bottom: 1rem; " src="img/Assist.png" width="27%" height="17%" alt="">
                </div>
                    <div style="column-gap: 2rem;width: 1.5rem; height: 1.6rem; margin-left: 1.5rem;" class="d-flex mb-4">
                        <?php
if (isset($_SESSION['id'])) {
    $idUsuario = $_SESSION['id'];
    $user = mysqli_query($link, "SELECT * FROM user u WHERE idUser = '$idUsuario'");
    $imgUser = mysqli_fetch_array($user);

    if ($imgUser['userImage'] != null) {
        ?>
                                        <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($imgUser['userImage']); ?>" style="object-fit: cover; object-position: center; border:1px solid #ffff;" width="100%" height="100%" class="rounded-circle" alt="Imagen de usuario">
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
                    <a class="nav_link active btn" id="notification" data-bs-toggle="collapse" href="#collapseNotificacion" role="button" aria-expanded="false" aria-controls="collapseNotificacion"><i class='bx bxs-bell-ring bx-sm'><span id="notification_count"></span></i>Notificaciones </a>
                    <div class="collapse text-light" style="background-color: #d0252d; font-size: 13px;" id="collapseNotificacion">
                        <?php 
                        while($resultQueryNotificacion = mysqli_fetch_array($queryNotificacion)){
                            $notificacion = $resultQueryNotificacion['idNotificationType'] == 1 ? 'creaste el tema': ($resultQueryNotificacion['idNotificationType'] == 2 ? 'comentó tu publicación' : 'respondió tu comentario en');?>
                            <div class="p-2">
                                <p><b> <?php echo $resultQueryNotificacion['usernames'];?></b> <?php echo $notificacion." "."\"".$resultQueryNotificacion['titleTopic']."\""; ?></p>
                            </div>
                            <hr>

                        <?php }?>
                    </div>
                    <?php } else {?>
                        </div>
                        <a href="#" class="nav_link" data-bs-toggle="modal" data-bs-target="#loginModal" id="logModal"> <i class='bx bx-layer nav_icon'></i> <span class="nav_name" onclick="showModalLogin()">Iniciar Sesion</span> </a>
                        <a href="#" class="nav_link active" data-bs-toggle="modal" data-bs-target="#registerModal"> <i class='bx bx-grid-alt nav_icon'></i><span class="nav_name" onclick="showRegisterModal()">Registrarse</span> </a>
                    <?php }?>
                    <a href="comunidadAssist.php" class="nav_link"> <i class='bx bx-user nav_icon'></i> <span class="nav_name">Comunidad Assist</span> </a>
                    <a href="#" class="nav_link">
                </div>
                <?php if(isset($_SESSION['id'])){ ?>
            <a href="logout.php" class="nav_link"> <i class='bx bx-log-out nav_icon'></i> <span class="nav_name">Cerrar sesión</span> </a>
        <?php }else{?>
            <a href="#"></a>
        <?php } ?> 
            </nav>
        </div>
        <div class="height-100 bg-light">
            <div class="container mt-4">
                <div class="row"></div>
                <div class="row mb-4 mt-4">
                </div>
                <div class="row card comentario mb-4">
            <?php
$queryComentario = "SELECT c.idCommentary, c.idTopic, c.idUser, t.titleTopic, u.usernames, c.describeCommentary, c.likes, c.unlikes, u.userImage, DATE_FORMAT(c.created_at, \"%M %d de %Y\") AS fecha
                          FROM commentary c
                          INNER JOIN topic t ON c.idTopic = t.idTopic
                          INNER JOIN user u ON c.idUser = u.idUser
                          ORDER BY c.created_at DESC";

$resultComentario = mysqli_query($link, $queryComentario);
while ($rowComentario = mysqli_fetch_array($resultComentario)) {
    ?>


                            <div class="row d-flex justify-content-between mt-4">
                                <div class="col-md-3 mt-2">
                                    <div class="d-flex justify-content-center" >
                                <?php
if ($rowComentario['userImage'] != null) {
        ?>
                                        <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($rowComentario['userImage']); ?>" style="object-fit: cover; object-position: center; border:1px solid #ffff;" width="50%" height="50%" class="rounded-circle" alt="Imagen de usuario">
                                <?php
} else {?>
                                    <img src="img/user.png"  style="object-fit: cover; object-position: center; border:1px solid #ffff;" width="50%" height="50%" class="rounded-circle" alt="Imagen de usuario">
                                <?php
}
    ?>
                                </div>
                                </div>
                                <div class="col-md-9 container-commentary">
                                    <p class="mt-2"><?php echo $rowComentario['describeCommentary'] ?></p>
                                </div>
                            </div>
                            <div class="row mt-2 ">
                                <div class="col-md-3 d-flex justify-content-center">
                                <h5><?php echo $rowComentario['usernames'] ?></h5>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-md-6 d-flex justify-content-end">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <?php if(isset($_SESSION['id'])){?>
                                                <a class="likeComment btn" data-vote-type="1" id="like_<?php echo $rowComentario['idCommentary'] ?>">
                                                    <i class='bx bx-like' style="color:rgb(0, 253, 93);"></i>
                                                </a>
                                            <?php }else{ ?>
                                                <a  data-bs-toggle="modal" data-bs-target="#validateModal"  class="btn">
                                                    <i class='bx bx-like' style="color:rgb(0, 253, 93);" id="likeTema"></i>
                                                </a>
                                            <?php } ?>
                                        </div>
                                        <div class="d-flex align-items-end">
                                            <b>
                                                <p id="likeComentario_<?php echo $rowComentario['idCommentary'] ?>" class="text-nowrap mt-2" style="font-size: 12px; color: rgb(0, 253, 93);">Me gusta:&nbsp;<span class="counter" id="likeCount_<?php echo $rowComentario['idCommentary'] ?>"><?php echo $rowComentario['likes'] ?></span></p>
                                            </b>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <?php if(isset($_SESSION['id'])){?>
                                                <a class="likeComment btn" data-vote-type="0" id="unlike_<?php echo $rowComentario['idCommentary'] ?>">
                                                    <i class='bx bx-dislike' style="color:rgb(255, 22, 22);"></i>
                                                </a>    
                                            <?php }else{ ?>
                                                <a data-bs-toggle="modal" data-bs-target="#validateModal"  class="btn">
                                                    <i class='bx bx-dislike' style="color:rgb(255, 22, 22);"></i>
                                                </a>
                                            <?php } ?>
                                        </div>
                                        <div class="d-flex align-items-end">
                                            <b>
                                                <p id="unlikeComentario_<?php echo $rowComentario['idCommentary']; ?>" class="text-nowrap mt-2" style="font-size: 12px; color: rgb(255, 22, 22);">No me gusta:&nbsp;<span class="counter" id="unlikeCount_<?php echo $rowComentario['idCommentary'] ?>"><?php echo $rowComentario['unlikes'] ?></span></p>
                                            </b>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 d-flex justify-content-end">
                                    <h5><b style="color: rgb(7, 26, 57);">Tema: </b> <b style="color: rgb(255 50 59);"><?php echo $rowComentario['titleTopic'] ?></b></h5>
                                </div>
                            </div>
                        <?php
}
?>
                        </div>
<?php 
$numComentarios = mysqli_num_rows($resultComentario);
if($numComentarios == 0){
?>
    <div class="text-center" style="background-color: #a99f9f36; border-radius: 20px;">
        <h3 class="p-4" style="color: #928b8b;">Aún no hay comentarios</h3>
    </div>
<?php
 }
 ?>
            </div>
        </div>
<!-- modal validateModal -->
<div class="modal fade" id="validateModal" tabindex="-1" aria-labelledby="validateModal" aria-hidden="true">
  <div class="modal-dialog modal-sm modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-danger">
        <h5 class="modal-title text-light" id="loginModalLabel" style="padding-left: 40%;">Aviso</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center">
        ¡Tienes que iniciar sesion para poder interactuar en el foro!
      </div>
      <div class="modal-footer d-flex justify-content-center">
        <button type="button" class="btn btn-info" id="loginAlert" data-bs-dismiss="modal" onclick="showRegisterModal()">Registro</button>
      </div>
    </div>
  </div>
</div>
<!-- fin validateModal -->

</body>
<script type="text/javascript">
        var getCountNotifications = "<?php echo"$num_rows"?>";
        document.write('<text style="visibility: hidden">getCountNotifications</text>');
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script type="text/javascript" src="./js/mainFunctions.js"></script>
    <script type="text/javascript" src="./js/likes.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"></script>

</html>