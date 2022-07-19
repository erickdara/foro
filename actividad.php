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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <link rel="stylesheet" type="text/css" href="css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <title>Actividad reciente</title>
</head>

<body>
    <!-- top navigation bar -->
    <nav class="navbar-expand-lg navbar-dark container-fluid" id="header">
    
        <div class="row">
            <div class="col-6 col-md-6 col-sm-6">
                <h1 style="color: white; font-family: 'Alfa Slab One', cursive;"><span class="navbar-nav mt-3 me-auto ms-3 text-uppercase">FORO ASSIST</span></h1>
            </div>
            <div class="col-6 col-md-6 col-sm-6 d-flex justify-content-end">
            <div class="mt-3 mb-1" style="width: 5rem; height: 5rem;">
                <img src="img/ForoTech.png" style="object-fit: contain; object-position: center;" width="100%"
                    height="100%">
            </div>
            </div>
            <div class="col-sm-12 mt-2 mb-2 col-md-12 d-flex justify-content-between">
                <button class="navbar-toggler clickMenu" type="button" data-bs-toggle="offcanvas" data-bs-target="#nav-bar" aria-controls="offcanvasExample">
                    <span class="clickMenu" data-bs-target="#nav-bar"><i class='bx bxs-home-alt-2 clickMenu' style='color:#ffffff'></i></span>
                </button>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#topNavBar" aria-controls="topNavBar" aria-expanded="false" aria-label="Toggle navigation">
                            <span data-bs-target="#topNavBar"><i class='bx bx-menu' style='color:#f3efef'></i></span>
                </button>
            </div>
            <div class="col-12 col-md-12 col-sm-12 ">
                <div class="row">
                  
                    <div class="col-sm-12 col-md-7 align-items-end collapse navbar-collapse" id="topNavBar">
                     <ul class="d-flex">
                        <li>
                    <?php
                    if (isset($_SESSION['id'])) {?>
                            <a href="./User/index.php" type="button" class="btn text-light btn-nav">Temas</a>
                <?php } else {?>
                            <a href="index.php" type="button" class="btn text-light btn-nav">Temas</a>
                <?php }?>
                        </li>
                        <li>
                            <a href="actividad.php" type="button" class="btn text-light btn-nav">Actividad</a>
                        </li>
                        <li>
                            <a href="comentario.php" type="button" class="btn text-light btn-nav">Comentarios</a>
                        </li>
                        </ul>
                    </div>
                
                </div>
                
            </div>     
      </div>
    </nav>
    <!-- top navigation bar -->
    <?php
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    $idUsuario = $_SESSION['id'];
    $queryUser = mysqli_query($link, "SELECT u.idUser, r.idRole, r.roleType, u.userMail, u.userImage, DATE_FORMAT(u.created_at, \"%M de %Y\") as fecha
        FROM user u
        INNER JOIN role r ON u.idRole = r.idRole
        WHERE u.idUser = '$idUsuario'");
} else {
    $queryUser = mysqli_query($link, "SELECT u.userMail, u.userImage, DATE_FORMAT(u.created_at, \"%M de %Y\") as fecha
        FROM user u
        INNER JOIN role r ON u.idRole = r.idRole");
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

$rowUser = mysqli_fetch_array($queryUser);
?>
     <!-- offcanvas -->
     <div class="offcanvas offcanvas-start sidebar-nav" tabindex="-1" id="nav-bar">
      <div class="offcanvas-body p-0" style="height:100%;">
       
          <ul class="navbar-nav">
          <li class="nav_logo" style="width:5rem; height:4rem; margin-bottom: 2rem; margin-top:1rem;">
                    <img class="imgLogo" src="img/Assist.png" width="100%" height="100%" alt="">
            </li>
            <a href="perfil.php" class="d-flex">
            <li  style="column-gap: 1.2rem;width: 1.5rem; height: 1.6rem; margin-left: 2rem;" class="d-flex mb-4">
            <?php
            if (isset($_SESSION['id'])) {

                if ($rowUser['userImage'] != null) {
                    ?>
                                            <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($rowUser['userImage']); ?>" style="object-fit: cover; object-position: center; border:1px solid #ffff;" width="100%" height="100%" class="rounded-circle" alt="Imagen de usuario">
                                    <?php
            } else {?>
                                        <img src="img/user.png"  style="object-fit: cover; object-position: center; border:1px solid #ffff;" width="100%" height="100%" class="rounded-circle" alt="Imagen de usuario">
                                    <?php
            }
                ?>
                    <span class="nav_link">Perfil</span>
            </li>
            </a>
            <li>
            <a class="nav_link active btn" id="notification" data-bs-toggle="collapse" href="#collapseNotificacion"
                role="button" aria-expanded="false" aria-controls="collapseNotificacion"><i
                    class='bx bxs-bell-ring bx-sm'><span id="notification_count"></span></i>Notificaciones </a>
                    <div class="collapse text-light" style="background-color: #d0252d; font-size: 13px;"
                id="collapseNotificacion">
                <?php 
                    while($resultQueryNotificacion = mysqli_fetch_array($queryNotificacion)){
                        $notificacion = $resultQueryNotificacion['idNotificationType'] == 1 ? 'creaste el tema': ($resultQueryNotificacion['idNotificationType'] == 2 ? 'comentó tu publicación' : 'respondió tu comentario en');?>
                <div class="p-2">
                    <p><b> <?php echo $resultQueryNotificacion['usernames'];?></b>
                        <?php echo $notificacion." "."\"".$resultQueryNotificacion['titleTopic']."\""; ?></p>
                </div>
                <hr>

                <?php }?>
            </div>  
            </li>
            <?php } else {?>
                <li>
                <a href="#" class="nav_link" data-bs-toggle="modal" data-bs-target="#loginModal" id="logModal"> <i class='bx bx-layer nav_icon bx-sm'></i> <span class="nav_name" onclick="showModalLogin()">Iniciar Sesion</span> </a>
                </li>
                <li>
                <a href="#" class="nav_link active" data-bs-toggle="modal" data-bs-target="#registerModal"> <i class='bx bx-grid-alt nav_icon bx-sm'></i><span class="nav_name" onclick="showRegisterModal()">Registrarse</span> </a>
                </li>
                <?php }?>
            <li>
                <a href="comunidadAssist.php" class="nav_link"> <i class='bx bx-user nav_icon bx-sm'></i> <span
                        class="nav_name">Comunidad Assist</span> </a>
                <a href="#" class="nav_link">
            </li>
            <?php if(isset($_SESSION['id'])){ ?>
            <li>    
                <a href="logout.php" onclick="logoutSocial(provider)" class="nav_link"> <i class='bx bx-log-out nav_icon bx-sm'></i> <span class="nav_name">Cerrar sesión</span> </a>
            </li>   
        <?php }else{?>
            <li>
                <a href="#"></a>
            </li>    
        <?php } ?> 
            <li class="my-4"><hr class="dropdown-divider bg-light" /></li>
          </ul>
      </div>
    </div>
    <!-- offcanvas -->

    <div class="height-100 bg-light">
        <div class="container">
            <div class="row"></div>
             <div class="row mt-4"></div>
             <div class="row mt-4 mb-3 d-flex justify-content-center">
                    <div class="card mb-3 actividad-info">
            <?php

 $queryActividad = mysqli_query($link, "SELECT n.idNotification, n.idUser, n.idTopic, u.usernames, u.userMail, u.charge, u.company, u.userImage, t.titleTopic, n.idNotificationType, tn.describeNotification, DATE_FORMAT(n.created_at, \"%d-%m-%Y %H:%i:%s\") AS fecha
 FROM notification n
 INNER JOIN user u ON n.idUser = u.idUser
 INNER JOIN topic t ON n.idTopic = t.idTopic
 INNER JOIN notificationType tn ON n.idNotificationType = tn.idType
 ORDER BY n.created_at DESC");

$queryDateNow = mysqli_query($link, "SELECT DATE_FORMAT(now(),\"%d %m %Y %H %i %s\") as dateNow");
$dateNow = mysqli_fetch_array($queryDateNow);

while ($rowActividad = mysqli_fetch_array($queryActividad)) {
    ?>
                        <div class="row d-flex justify-content-center" style="width: 90%;">
                            <div class="col-md-3 mt-3 mb-1">
                                <div class="d-flex justify-content-center" >
                                    <?php
if ($rowActividad['userImage'] != null) {
        ?>
                                            <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($rowActividad['userImage']); ?>" style="object-fit: cover; object-position: center;" width="50%" height="50%" class="rounded-circle img-perfil img-thumbnail" alt="Imagen de usuario">
                                    <?php
} else {?>
                                        <img src="img/user.png"  style="object-fit: cover; object-position: center; " width="50%" height="50%" class="rounded-circle img-thumbnail img-perfil" alt="Imagen de usuario">
                                    <?php
}
    ?>
                                    </div>
                            </div>
                            <div class="col-md-9 mt-3 mb-2 d-flex align-items-center">
                                <div class="card-body">
                                    <h5 class="card-title"><b style="color: rgb(7, 26, 57);"><?php echo $rowActividad['usernames']." ".$rowActividad['describeNotification']." "; ?></b><b style="color: rgb(255 50 59);"><?php echo $rowActividad['titleTopic'] ?></b></h5>
                                    <?php if(isset($_SESSION['rol']) && $_SESSION['rol'] == 1){ ?>
                                        <p class="card-text row"> <small class="text-muted col-md-12"><?php echo  "Empresa: ".$rowActividad['company'] ?></small> <small class="text-muted col-md-12"><?php echo "Cargo: ".$rowActividad['charge'] ?></small> <small class="text-muted col-md-12"><?php echo "Correo: ".$rowActividad['userMail'] ?></small></p>
                                    <?php } ?>
                                    <p class="card-text"><small class="text-muted"><?php echo $util->get_time_ago($rowActividad['fecha'])?></small></p>
                                    <hr class="line">
                                </div>
                            </div>
                        </div>
            <?php
}
?>
                    </div>
<?php
$numActividad = mysqli_num_rows($queryActividad);
if($numActividad == 0){?>
    <div class="text-center" style="background-color: #a99f9f36; border-radius: 20px;">
        <h3 class="p-4" style="color: #928b8b;">No hay actividad reciente</h3>
    </div>
<?php
}
?>
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</html>