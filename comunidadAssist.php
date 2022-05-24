<?php
require_once('config.php');
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
    <link rel="stylesheet" type="text/css" href="css/styles.css">

    <title>Comunidad de Assist</title>
</head>

<body>
    <header class="header" id="header">
        <div class="row mb-2">
            <div class="col-md-12">
                <div class="header_toggle"> <i class='bx bx-menu' style="color: #071a39;" id="header-toggle"></i> </div>
            </div>
            <div class="col-md-6 d-flex justify-content-start">
                <h1 id="title"><span style="color: white; font-family: 'Alfa Slab One', cursive;">FORO ASSIST</span></h1>
            </div>
            <div class="col-md-6 d-flex align-items-start justify-content-end">
                <div style="width: 5rem; height: 5rem;">
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
        $queryUser = mysqli_query($link, "SELECT u.idUser, u.usernames, u.userImage, r.idRole, r.roleType, created_at FROM user u 
        INNER JOIN role r ON u.idRole = r.idRole 
        ORDER BY r.idRole AND u.created_at DESC");

        if(isset($_SESSION['id'])){
        $idUsuario = $_SESSION['id'];
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
                    <img class="imgLogo" style="margin-left: 0.6rem; margin-bottom: 1rem; " src="./img/Assist.png" width="27%" height="17%" alt="">
                </div>
                <div style="column-gap: 2rem;width: 1.5rem; height: 1.6rem; margin-left: 1.5rem;" class="d-flex mb-4">
                    <?php
                            if(isset($_SESSION['id'])){
                            
                            $idUsuario = $_SESSION['id'];
                            $user = mysqli_query($link,"SELECT * FROM user u WHERE idUser = '$idUsuario'");
                            $imgUser = mysqli_fetch_array($user);

                                if($imgUser['userImage'] != null){
                            ?>
                                    <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($imgUser['userImage']); ?>" style="object-fit: cover; object-position: center; border:1px solid #ffff;" width="100%" height="100%" class="rounded-circle" alt="Imagen de usuario">
                            <?php   
                            }else{?>
                                <img src="img/user.jpeg"  style="object-fit: cover; object-position: center; border:1px solid #ffff;" width="100%" height="100%" class="rounded-circle" alt="Imagen de usuario">
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
                <?php } else{?>
                </div>    
                <a href="#" class="nav_logo" data-bs-toggle="modal" data-bs-target="#loginModal" id="logModal"> <i class='bx bx-layer nav_logo-icon'></i> <span class="nav_logo-name"  onclick="showModalLogin()">Iniciar Sesion</span> </a>
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
        <div class="container">
            <div class="row"></div>
        <div class="row d-flex justify-content-center mt-4">
            <div class="card actividad-info mt-4 mb-4">
        <?php
            while ($rowUser = mysqli_fetch_array($queryUser)) {
            $rol = $rowUser['idRole'] == 1 ? '(Administrador)' : ''; 
            ?>
                
                        <div class="row d-flex justify-content-center" style="width: 90%;">
                            <div class="col-md-3 mt-3">
                                <div class="d-flex justify-content-end align-items-center">
                                    <?php
                                        if($rowUser['userImage'] != null){
                                    ?>
                                            <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($rowUser['userImage']); ?>" style="object-fit: cover; object-position: center; border:1px solid #ffff;" width="40%" height="40%" class="img-thumbnail img-perfil rounded-circle" alt="Imagen de usuario">
                                    <?php   
                                    }else{?>
                                        <img src="img/user.jpeg"  style="object-fit: cover; object-position: center; border:1px solid #ffff;" width="40%" height="40%" class="img-thumbnail img-perfil rounded-circle" alt="Imagen de usuario">
                                    <?php
                                    }
                                    ?> 
                                </div>
                            </div>
                            <div class="col-md-9 mt-3 mb-2 d-flex align-items-center">
                                <div class="card-body">
                                    <h5 class="card-title"><b style="color: rgb(7, 26, 57);"><?php echo $rowUser['usernames'] ." $rol"?></b></h5>
                                    <p class="card-text"><small class="text-muted"></small></p>
                                </div>
                            </div>
                        </div>
                        <hr size="3" style="border-top: rgb(7, 26, 57);">
                   
            <?php
            }
            ?>
                    </div>
                </div>
        </div>
    </div>


</body>
<script type="text/javascript">
        var getCountNotifications = "<?php echo"$num_rows"?>";
        document.write('<text style="visibility: hidden">getCountNotifications</text>');
    </script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script type="text/javascript" src="js/mainFunctions.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"></script>

</html>