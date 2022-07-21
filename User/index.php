<?php
setlocale(LC_ALL, "es_ES");
// Initialize the session
//session_start();
if(!isset($_SESSION)) 
    { 
        session_start(); 
    }
    else
    {
        session_destroy();
        session_start(); 
    }

// date_default_timezone_set("America/Bogota");
// Check if the user is already logged in, if yes then redirect him to welcome page


if (empty($_SESSION["id"])) { 
    header("location: ../index.php");
    die();
} else if(isset($_SESSION['loggedin'])){


    $mail = $_SESSION['mail'];


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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <link rel="stylesheet" type="text/css" href="../css/styles.css">

    <title>Foro ASSIST</title>
</head>

<?php

$idUsuario = $_SESSION['id'];

$queryUser = mysqli_query($link, "SELECT u.idUser, r.idRole, r.roleType, u.userMail, u.userImage, DATE_FORMAT(u.created_at, \"%M de %Y\") as fecha
    FROM user u
    INNER JOIN role r ON u.idRole = r.idRole
    WHERE u.idUser = '$idUsuario'");
$rowUser = mysqli_fetch_array($queryUser);

    $queryNotificacion = mysqli_query($link,"SELECT n.idNotification, n.idUser, n.idTopic, u.usernames, u.userImage, t.titleTopic, n.idNotificationType, tn.describeNotification, DATE_FORMAT(n.created_at, \"%d-%m-%Y %H:%i:%s\") AS fecha
    FROM notification n
    INNER JOIN user u ON n.idUser = u.idUser
    INNER JOIN topic t ON n.idTopic = t.idTopic
    INNER JOIN notificationType tn ON n.idNotificationType = tn.idType
    WHERE n.idDestUser = '$idUsuario' 
    ORDER BY n.created_at DESC LIMIT 4"); 

    $num_rows = mysqli_num_rows($queryNotificacion);

?>


<?php
$idUsuario = $_SESSION['id'];
$totalC = "SELECT COUNT(*) AS totalComentarios FROM commentary";

$resultTotalC = mysqli_query($link, $totalC);
$rowTotalC = mysqli_fetch_array($resultTotalC);

$totalR = "SELECT COUNT(*) AS totalRespuestas FROM answer";

$resultTotalR = mysqli_query($link, $totalR);
$rowTotalR = mysqli_fetch_array($resultTotalR);
?>
<body>
     <!-- top navigation bar -->
     <nav class="navbar-expand-lg navbar-dark container-fluid" id="header">
    
    <div class="row">
        <div class="col-6 col-md-6 col-sm-6">
            <h1 style="color: white; font-family: 'Alfa Slab One', cursive;"><span class="navbar-nav mt-3 me-auto ms-3 text-uppercase">FORO ASSIST</span></h1>
        </div>
        <div class="col-6 col-md-6 col-sm-6 d-flex justify-content-end">
        <div class="mt-3 mb-1" style="width: 5rem; height: 5rem;">
            <img src="../img/ForoTech.png" style="object-fit: contain; object-position: center;" width="100%"
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
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#search" aria-controls="bsc" aria-expanded="false" aria-label="Toggle navigation">
                        <span data-bs-target="#search"><i class='bx bx-search-alt-2' style='color:#ffffff'></i></span>
            </button>
        </div>
        <div class="col-12 col-md-12 col-sm-12 ">
            <div class="row">
              
                <div class="col-sm-12 col-md-7 align-items-end collapse navbar-collapse" id="topNavBar">
                 <ul class="d-flex">
                    <li>
                <?php
                if (isset($_SESSION['id'])) {?>
                        <a href="../User/index.php" type="button" class="btn text-light btn-nav">Temas</a>
            <?php } else {?>
                        <a href="index.php" type="button" class="btn text-light btn-nav">Temas</a>
            <?php }?>
                    </li>
                    <li>
                        <a href="../actividad.php" type="button" class="btn text-light btn-nav">Actividad</a>
                    </li>
                    <li>
                        <a href="../comentario.php" type="button" class="btn text-light btn-nav">Comentarios</a>
                    </li>
                    </ul>
                </div>
             
                <div class="collapse navbar-collapse col-sm-12 col-md-5 " id="search">
                    <form class="d-flex ms-auto my-3 my-lg-0">
                        <div class="input-group">
                        <i class='bx bx-search bx-md' style='color:#fffbfb'></i>&nbsp;&nbsp;   
                        <input type="text" id="buscar" name="buscar" onkeyup="userBuscar($('#buscar').val())" class="input-busqueda text-light form-control" placeholder="Búsqueda" 
                        style="height:100%; background-color: #071a39; background: linear-gradient(180deg, rgba(0,69,127,1) 0%, rgba(6,43,77,1) 30%, rgba(3,39,73,1) 39%, rgba(3,33,68,1) 50%, rgba(7,26,57,1) 88%); border: 1px solid #ffff; border-radius: 5px; color:white; font-size:20px;">
                        </div>
                    </form>
                </div>
            
            </div>
            
        </div>     
  </div>
</nav>
<!-- top navigation bar -->
<!-- offcanvas -->
<div class="offcanvas offcanvas-start sidebar-nav" tabindex="-1" id="nav-bar">
  <div class="offcanvas-body p-0" style="height:100%;">
   
      <ul class="navbar-nav">
      <li class="nav_logo" style="width:5rem; height:4rem; margin-bottom: 2rem; margin-top:1rem;">
                <img class="imgLogo" src="../img/Assist.png" width="100%" height="100%" alt="">
        </li>
        <a href="../perfil.php" class="d-flex">
        <li  style="column-gap: 1.2rem;width: 1.5rem; height: 1.6rem; margin-left: 2rem;" class="d-flex mb-4">
                                <?php
if ($rowUser['userImage'] != null) {
?>
            <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($rowUser['userImage']); ?>"
                style="object-fit: cover; object-position: center; border:1px solid #ffff;" width="100%"
                height="100%" class="rounded-circle" alt="Imagen de usuario">
            <?php
} else {?>
            <img src="../img/user.png" style="object-fit: cover; object-position: center; border:1px solid #ffff;"
                width="100%" height="100%" class="rounded-circle" alt="Imagen de usuario">
            <?php
}
?>     
                <span class="nav_link">Perfil</span>     
        </li>
        </a>
        <li>
        <a class="nav_link btn" id="notification" data-bs-toggle="collapse" href="#collapseNotificacion"
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
        <li>
            <a href="../comunidadAssist.php" class="nav_link"> <i class='bx bx-user nav_icon bx-sm'></i> <span
                    class="nav_name">Comunidad Assist</span> </a>
            <a href="#" class="nav_link">
        </li>
        <li>
        <a href="../logout.php" class="nav_link"> <i class='bx bx-log-out nav_icon bx-sm'></i> <span class="nav_name"
            onclick="logoutSocial(provider)">Cerrar sesión</span> </a> 
        </li>
        <li class="my-4"><hr class="dropdown-divider bg-light" /></li>
      </ul>
  </div>
</div>
<!-- offcanvas -->
    <div class="height-100 bg-light">
<!--Container Main start-->
    <div class="container">
        <div class="row contain mb-4"></div>
        <div id="datos_buscador" class="row">

        </div>
        <?php 
                $queryTop = mysqli_query($link,"SELECT t.idTopic, t.titleTopic, u.usernames as nombres, t.likes, COUNT(c.idTopic) as num_com 
                FROM commentary c
                INNER JOIN topic t ON c.idTopic = t.idTopic
                INNER JOIN user u ON t.idUser = u.idUser
				WHERE c.idTopic = t.idTopic and t.likes >= 12
                group by t.idTopic
                HAVING num_com >= 6");

                    ?>

        <!-- <div class="row d-flex justify-start-end mt-4">
            <div class="col-md-2 d-flex align-items-end justify-content-start">
                <div class="row tema">
                    <button type="button" class="btn d-flex justify-content-between align-items-center"
                        data-bs-toggle="modal" data-bs-target="#modalTema<?php echo $_SESSION['rol'] ?>">
                        <div class="col-md-6 d-flex justify-content-end btn">
                            <img class="img img-add-tema" src="../img/agregar.png" alt="">
                        </div>
                        <div class="col-md-6 d-flex justify-content-center btn">
                            <h5 class="text-center text-add-tema text-nowrap">CREAR TEMA</h5>
                        </div>
                    </button>
                </div>
            </div>
            <div class="col-md-5 mt-4 d-flex justify-content-end">
                <div class="card info">
                    <div class="row card-body d-flex">
                        <div class="col num-commentary pt-2">
                            <h6 class="text-center text-light">COMENTARIOS</h6>
                            <h6 class="text-center text-light"><?php echo $rowTotalC['totalComentarios']; ?></h6>
                        </div>
                        <div class="col num-answer pt-2">
                            <h6 class="text-center text-light">RESPUESTAS</h6>
                            <h6 class="text-center text-light"><?php echo $rowTotalR['totalRespuestas']; ?></h6>
                        </div>
                    </div>
                </div>
            </div> -->
            <div class="row mt-4">
            <div class="col-md-3 col-sm-12">
                <div class="row d-flex justify-content-center mt-4">
                    <button type="button" class="btn col-md-10 col-sm-10 justify-content-between align-items-start" data-bs-toggle="modal" data-bs-target="#modalTema<?php echo $_SESSION['rol'] ?>">
                        <div class="row">
                            <i class='col-md-3 col-sm-3 bx bx-plus-circle bx-md'></i>
                            <h5 class="col-md-9 col-sm-9 text-center text-add-tema mt-1">CREAR TEMA</h5>  
                        </div>
                    </button>
                </div>
        </div>
        <div class="col-md-4 col-sm-12 mb-2">
        <div class="card info">
                        <div class="card-body">
                            <div class="row d-flex justify-content-center"> 
                            <div class="col-md-6 col-sm-12 num-commentary pt-2 mb-1">
                                <h6 class="text-center text-light">COMENTARIOS</h6>
                                <h6 class="text-center text-light"><?php echo $rowTotalC['totalComentarios']; ?></h6>
                            </div>
                            <div class="col-md-5 col-sm-12 num-answer pt-2 mb-1">
                                <h6 class="text-center text-light">RESPUESTAS</h6>
                                <h6 class="text-center text-light"><?php echo $rowTotalR['totalRespuestas']; ?></h6>
                            </div>
                        </div>
                        </div>
                    </div>
        </div>

            <!-- Spinner Start -->
            <div id="spinner"
                class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
                <div class="spinner-grow text-dark m-1" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <div class="spinner-grow text-danger m-1" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <div class="spinner-grow text-secondary m-1" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
            <div class="col-md-5">
                <!-- Spinner End -->

                <!-- Start Carousel -->
                <div id="carouselExampleControls" style="height: 100%;" class="carousel slide carousel-fade" data-bs-ride="carousel">
                    <div class="carousel-inner">
                    <?php
                            while($resultTop = mysqli_fetch_array($queryTop)){
                        ?>

                    <div class="carousel-item">
                        <div class="card">
                        <a href="#tema_<?php echo $resultTop['idTopic']?>">
                            <div class="row mx-3 pt-2">
                                <div class="col-2 col-md-2 d-flex justify-content-end">
                                <?php
                            if ($resultTop['userImage'] != null) {
                                ?>
                                <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($resultTop['userImage']); ?>" style="object-fit: cover; object-position: center; border:1px solid #ffff; max-width: 3rem; max-height: 3rem;" class="rounded-circle" alt="Imagen de usuario">
                            <?php
                            } else {?>
                            <img src="../img/user.png"  style="object-fit: cover; object-position: center; border:1px solid #ffff; max-width: 3rem; max-height: 3rem;" class="rounded-circle" alt="Imagen de usuario">
                                    <?php       
                                    }
                                    ?>
                                </div>
                                <div class="col-9 col-md-9 d-flex justify-content-start align-items-end p-2 text-dark">
                                    <h6><b><?php echo $resultTop['nombres'] ?></b></h6>
                                </div>
                            </div>
                            <div class="row mt-2 mx-1">
                                <div class="col-md-12 col-12">
                                    <b style="color: rgb(255 50 59);">Tema:</b>&nbsp;<b
                                        style="color: rgb(7, 26, 57);"><?php echo $resultTop['titleTopic'] ?></b>
                                </div>
                            </div>
                            <div class="row mt-1">
                                <div class="col-3 col-md-3 d-flex justify-content-center">&nbsp;&nbsp;
                                    <small
                                        style="color:rgb(0, 253, 93);">Likes:<?php echo $resultTop['likes'] ?></small>
                                </div>
                                <div class="col-3 col-md-3 d-flex justify-content-start">
                                    <small style="color: rgb(255, 22, 22);">Unlikes:
                                        <?php echo $resultTop['unlikes'] ?></small>
                                </div>
                                <div class="col-4 col-md-4 text-dark">
                                    <small>Comentarios:<?php echo $resultTop['num_com'] ?></small>
                                </div>
                            </div>
                                </a>
                        </div>
                    </div>
                    <?php 
                            }
                            $topUser = mysqli_num_rows($queryTop);
                        ?>
                    <div class="carousel-item <?php if($topUser != 0){echo "active"; }else{ echo ""; } ?>">
                        <div class="card bg-light d-flex justify-content-center align-items-centert-" style="height: 100%;">
                            <h3 style="color: rgb(255 50 59);"><b>Top Temas Interactuados</b></h3>
                        </div>
                    </div>

                    </div>

                    <!-- <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button> -->
                    <!-- <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button> -->
                </div>

                <!-- End Carousel -->
            </div>

        </div>

        <div class="row mt-4 d-flex justify-content-start">


            <!-- Modal para crear tema-->
            <div class="modal fade" id="modalTema1" tabindex="-1" aria-labelledby="modalTema" aria-hidden="true">
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
                                    <input id="tituloTema" type="text" class="form-control" name="tituloTema" required>
                                    <span id="titleTopic"></span>
                                </div>
                                <div class="mb-3">
                                    <label for="describeTema" class="form-label">Descripción:</label>
                                    <textarea id="describeTema" name="describeTema" class="form-control" cols="30"
                                        rows="8" maxlength="1000" required></textarea>
                                    <div class="mt-2" style="font-weight: bold;" id="charNum"></div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <input name="crearTema" type="submit" class="btn btn-primary"
                                    value="Publicar tema"></input>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Fin del modal-->

            <!-- validateModal Tema si no es Admin-->
            <div class="modal fade" id="modalTema2" tabindex="-1" aria-labelledby="modalTema1" aria-hidden="true">
                <div class="modal-dialog modal-sm modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header bg-danger">
                            <h5 class="modal-title text-light" id="loginModalLabel" style="padding-left: 40%;">Aviso
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body text-center">
                            ¡Tienes que ser administrador para poder crear un tema en el foro!
                        </div>
                        <div class="modal-footer d-flex justify-content-center">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- fin validateModal -->

            <?php
$query = "SELECT t.idTopic, t.idUser, u.usernames, r.roleType, t.titleTopic, t.describeTopic, DATE_FORMAT(t.created_at, \"%M %d de %Y\") AS fecha, likes, unlikes
                  FROM topic t
                  INNER JOIN user u ON t.idUser = u.idUser
                  INNER JOIN role r ON u.idRole = r.idRole
                  ORDER BY t.idTopic DESC";

$resultQuery = mysqli_query($link, $query);
while ($row = mysqli_fetch_array($resultQuery)) {
    ?>
            <a name="tema_<?php echo $row['idTopic'] ?>"></a>
            <div class="card tema-informacion mt-2 mb-3">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-5 col-5">
                            <h6><strong>Publicado por: <?php echo $row['usernames'] ?>
                                    (<?php echo $row['roleType'] ?>)</strong></h6>
                        </div>
                        <div class="col-md-5 col-5">
                            <p id="month" class="text-muted" style="font-size: smaller;">Fecha:
                                <?php echo $row['fecha'] ?></p>
                        </div>
                        <?php if($_SESSION['id'] == $row['idUser']){?>
                            <div class="dropdown col-md-2 col-2 d-flex justify-content-end">
                                <i class='bx bx-dots-horizontal-rounded bx-sm btn' id="dropdownEdit" data-bs-toggle="dropdown" aria-expanded="false"></i>
                                <ul class="dropdown-menu" aria-labelledby="dropdownEdit">      
                                    <li><button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modalActualizarTema<?php echo $row['idTopic']; ?>" type="button">Editar</button></li>               
                                </ul>
                            </div>
                            <?php } ?>
                    </div>
                    <div class="row titulo titulo-tema">
                        <div class="col">
                            <h1><strong><?php echo $row['titleTopic']; ?></strong></h1>
                        </div>
                    </div>
                    <div class="row cuerpo-tema mt-3">
                        <div class="col">
                            <?php echo $row['describeTopic']; ?>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <?php
$idTopicC = $row['idTopic'];
    $queryCountComentario = "SELECT COUNT(*) AS com FROM commentary c WHERE c.idTopic = '$idTopicC' ";
    $resultCount = mysqli_query($link, $queryCountComentario);
    $rowCountComentario = mysqli_fetch_array($resultCount);
    ?>
                        <div class="col-md-4 d-flex d-wrap">
                            <p class="mt-1" style="color: rgb(7, 26, 57); font-size: 15px;"><b>Comentarios del tema:</b>
                            </p>
                            <b class="btn btn-comentarios" type="button" data-bs-toggle="collapse"
                                data-bs-target="#tema<?php echo $row['idTopic'] ?>" aria-expanded="false"
                                aria-controls="collapseExample"
                                style="color: rgb(7, 26, 57); font-size: 13px; font-weight: bold;"><?php echo $rowCountComentario['com'] . " Comentario(s)" ?></b>
                            <!-- <button class="btn d-flex align-items-start" type="button" data-bs-toggle="collapse" data-bs-target="#collapseComentarios" aria-expanded="false" aria-controls="collapseExample"><b style="color: rgb(7, 26, 57); font-size: 13px;">1 Comentario</b></button>-->
                            <!--<p style="color: rgb(7, 26, 57); font-size: 12px;"><b>Comentarios del tema: 1 comentario</b></p>-->
                        </div>
                        <?php

    ?>

                        <div class="col-md-5 d-flex d-wrap" style="font-size: 12px;">
                            <input type="hidden" name="idTopicLike" value="<?php echo $row['idTopic']; ?>">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <a class="likeTema btn" data-vote-type="1" id="like_<?php echo $row['idTopic'] ?>">
                                        <i class='bx bx-like' style="color:rgb(0, 253, 93);" id="likeTema"></i>
                                    </a>
                                </div>
                                <div class="d-flex align-items-end">
                                    <b>
                                        <p id="likeTema_<?php echo $row['idTopic']; ?>" class="text-nowrap"
                                            style="color: rgb(0, 253, 93);">Me gusta: <span class="counter"
                                                id="likeCount_<?php echo $row['idTopic'] ?>"><?php echo $row['likes'] ?></span>
                                        </p>
                                    </b>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between">
                                <div>
                                    <a class="likeTema btn" data-vote-type="0"
                                        id="unlike_<?php echo $row['idTopic'] ?>">
                                        <i class='bx bx-dislike' style="color:rgb(255, 22, 22);" id="unlikeTema"></i>
                                    </a>
                                </div>
                                <div class="d-flex align-items-end">
                                    <b>
                                        <p id="unlikeTema_<?php echo $row['idTopic']; ?>" class="text-nowrap"
                                            style="font-size: 12px; color: rgb(255, 22, 22);">No me gusta: <span
                                                class="counter"
                                                id="unlikeCount_<?php echo $row['idTopic'] ?>"><?php echo $row['unlikes'] ?></span>
                                        </p>
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
                            <button class="btn btn-vermas" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseComentar_tema<?php echo $row['idTopic'] ?>"
                                aria-expanded="false" aria-controls="collapseExample"><b>Comentar</b></button>
                        </div>
                    </div>
                    <!-- Actualizar tema Modal-->
            <div class="modal fade" id="modalActualizarTema<?php echo $row['idTopic']?>" tabindex="-1" aria-labelledby="modalActualizarTema" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalTema">Actualizar tema <?php echo $row['idTopic']; ?></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="../topicEdit.php" method="POST">
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="titleTopic" class="form-label">Titulo:</label>
                                    <input id="titleTopic" type="text" class="form-control" name="titleTopic" value="<?php echo $row['titleTopic'] ?>" required>
                                    <span id="titleTopic"></span>
                                </div>
                                <div class="mb-3">
                                    <label for="describeTopic" class="form-label">Descripción:</label>
                                    <textarea id="describeTopic" name="describeTopic" class="form-control" cols="30" rows="8" maxlength="1000" required><?php echo $row['describeTopic'] ?></textarea>
                                    <div class="mt-2" style="font-weight: bold;" id="charNum"></div>
                                </div>
                                <div class="mb-3">
                                    <input type="hidden" name="idTopic" value="<?php echo $row['idTopic']; ?>">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <input name="crearTema" type="submit" class="btn btn-primary" value="Actualizar tema"></input>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Fin modal -->
                    <form action="../comentar.php" method="POST">
                        <div class="row collapse mt-4" id="collapseComentar_tema<?php echo $row['idTopic'] ?>">
                            <div class="col-md-10">
                                <div class="mb-3">
                                    <input type="text" name="describeComentario" class="form-control"
                                        placeholder="Escribe un comentario..." required>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <input type="hidden" name="idTema" value="<?php echo $row['idTopic'] ?>">
                                <input name="comentario" type="submit" class="btn btn-danger" value="Comentar">
                            </div>
                        </div>
                    </form>

                    <?php
$idTopic = $row['idTopic'];
    $queryComentario = "SELECT c.idCommentary, c.idTopic, c.idUser, u.usernames, c.describeCommentary, c.likes, c.unlikes, u.userImage, DATE_FORMAT(c.created_at, \"%M %d de %Y\") AS fecha
                          FROM commentary c
                          INNER JOIN topic t ON c.idTopic = t.idTopic
                          INNER JOIN user u ON c.idUser = u.idUser
                          WHERE c.idTopic = '$idTopic'
                          ORDER BY c.idCommentary DESC";

    $resultComentario = mysqli_query($link, $queryComentario);
    while ($rowComentario = mysqli_fetch_array($resultComentario)) {
        ?>
                    <div class="row collapse titulo-comentario mt-3" id="tema<?php echo $row['idTopic'] ?>">
                        <div class="col-md-12 col-sm-12 mt-3">
                            <h5><b>Comentario anterior</b></h5>
                        </div>
                        <?php

        ?>
                        <div class="row d-flex justify-content-between mt-4">
                            <div class="col-md-3 col-sm-12 mt-2">
                                <div class="d-flex justify-content-center">
                                    <?php
if ($rowComentario['userImage'] != null) {
            ?>
                                    <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($rowComentario['userImage']); ?>"
                                        style="object-fit: cover; object-position: center;" width="50%" height="50%"
                                        class="img-thumbnail img-perfil rounded-circle" alt="Imagen de usuario">
                                    <?php
} else {?>
                                    <img src="../img/user.png" style="object-fit: cover; object-position: center;"
                                        width="50%" height="50%" class="img-thumbnail img-perfil rounded-circle"
                                        alt="Imagen de usuario">
                                    <?php
}
        ?>
                                </div>
                            </div>
                            <div class="col-md-9 col-sm-12 container-commentary">
                                <p class="mt-2"><?php echo $rowComentario['describeCommentary'] ?></p>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-12 mt-1 d-flex justify-content-center">
                                <h5><?php echo $rowComentario['usernames'] ?></h5>
                            </div>
                        <?php
$idCommentary = $rowComentario['idCommentary'];
        $queryCountRespuesta = "SELECT COUNT(*) AS res FROM answer a WHERE a.idCommentary = '$idCommentary' ";
        $resultCount = mysqli_query($link, $queryCountRespuesta);
        $rowCountRespuesta = mysqli_fetch_array($resultCount);
        ?>
                        <div class="row mt-3">
                            <div class="col-md-4 d-flex d-wrap">
                                <p class="mt-1" style="color: rgb(7, 26, 57); font-size: 15px;"><b>Respuestas:</b></p>
                                <b class="btn btn-comentarios" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#comentario<?php echo $rowComentario['idCommentary'] ?>"
                                    aria-expanded="false" aria-controls="collapseExample"
                                    style="color: rgb(7, 26, 57); font-size: 13px; font-weight: bold;"><?php echo $rowCountRespuesta['res'] . " Respuesta(s)" ?></b>
                            </div>
                            <div class="col-md-4 d-flex justify-content-end">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <a class="likeComentario btn" data-vote-type="1"
                                            id="like_<?php echo $rowComentario['idCommentary'] ?>">
                                            <i class='bx bx-like' style="color:rgb(0, 253, 93);"></i>
                                        </a>
                                    </div>
                                    <div>
                                        <b>
                                            <p id="likeComentario_<?php echo $rowComentario['idCommentary'] ?>"
                                                class="text-nowrap mt-2"
                                                style="font-size: 12px; color: rgb(0, 253, 93);">Me gusta:<span
                                                    class="counter"
                                                    id="likeCount_<?php echo $rowComentario['idCommentary'] ?>">&nbsp;<?php echo $rowComentario['likes'] ?></span>
                                            </p>
                                        </b>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <a class="likeComentario btn" data-vote-type="0"
                                            id="unlike_<?php echo $rowComentario['idCommentary'] ?>">
                                            <i class='bx bx-dislike' style="color:rgb(255, 22, 22);"></i>
                                        </a>
                                    </div>
                                    <div>
                                        <b>
                                            <p id="unlikeComentario_<?php echo $rowComentario['idCommentary']; ?>"
                                                class="text-nowrap mt-2"
                                                style="font-size: 12px; color: rgb(255, 22, 22);">No me gusta:<span
                                                    class="counter"
                                                    id="unlikeCount_<?php echo $rowComentario['idCommentary'] ?>">&nbsp;<?php echo $rowComentario['unlikes'] ?></span>
                                            </p>
                                        </b>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 d-flex justify-content-end">
                                <button class="btn btn-vermas" data-bs-toggle="collapse"
                                    data-bs-target="#collapseResponder_com<?php echo $rowComentario['idCommentary'] ?>"
                                    aria-expanded="false" aria-controls="collapseExample">
                                    Responder comentario
                                </button>
                            </div>
                            <form action="../respuesta.php" method="POST">
                                <div class="row collapse mt-4"
                                    id="collapseResponder_com<?php echo $rowComentario['idCommentary'] ?>">
                                    <div class="col-md-10">
                                        <div class="mb-3">
                                            <input type="text" name="describeRespuesta" class="form-control"
                                                placeholder="Escribe una respuesta...">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <input type="hidden" name="idCommentary"
                                            value="<?php echo $rowComentario['idCommentary'] ?>">
                                        <input name="respuesta" type="submit" class="btn btn-danger" value="Responder">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <?php
$idCommentary = $rowComentario['idCommentary'];
        $queryRespuesta = "SELECT a.idAnswer, a.idCommentary, a.idUser, u.usernames, a.describeAnswer, a.likes, a.unlikes, u.userImage, DATE_FORMAT(c.created_at, \"%M %d de %Y\") AS fecha
                          FROM answer a
                          INNER JOIN commentary c ON a.idCommentary = c.idCommentary
                          INNER JOIN user u ON a.idUser = u.idUser
                          WHERE a.idCommentary = '$idCommentary'
                          ORDER BY a.idAnswer DESC";

        $resultRespuesta = mysqli_query($link, $queryRespuesta);
        while ($rowRespuesta = mysqli_fetch_array($resultRespuesta)) {
            ?>

                    <!-- Collapse respuestas -->

                    <div class="row collapse mt-3" id="comentario<?php echo $rowComentario['idCommentary'] ?>">
                        <div class="col-md-12 mt-3">
                            <h5><b>Respuesta anterior</b></h5>
                        </div>
                        <div class="row d-flex justify-content-between mt-4">
                            <div class="col-md-3 mt-2">
                                <div class="d-flex justify-content-center mb-2" style="width: 100%; height: 100%;">
                                    <?php
if ($rowRespuesta['userImage'] != null) {
                ?>
                                    <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($rowRespuesta['userImage']); ?>"
                                        style="object-fit: cover; object-position: center;" width="60%" height="60%"
                                        class="img-thumbnail img-perfil rounded-circle" alt="Imagen de usuario">
                                    <?php
} else {?>
                                    <img src="../img/user.png" style="object-fit: cover; object-position: center;"
                                        width="60%" height="60%" class="img-thumbnail img-perfil rounded-circle"
                                        alt="Imagen de usuario">
                                    <?php
}
            ?>
                                </div>
                            </div>
                            <div class="col-md-9 container-commentary">
                                <p class="mt-2"><?php echo $rowRespuesta['describeAnswer'] ?></p>
                            </div>
                        </div>
                        <div class="row mt-2 ">
                            <div class="col-md-3 mt-1 d-flex justify-content-center">
                                <h5><?php echo $rowRespuesta['usernames'] ?></h5>
                            </div>
                            <div class="col-md-4 d-flex justify-content-end">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <a class="likeRespuesta btn" data-vote-type="1"
                                            id="like_<?php echo $rowRespuesta['idAnswer'] ?>">
                                            <i class='bx bx-like' style="color:rgb(0, 253, 93);"></i>
                                        </a>
                                    </div>
                                    <div>
                                        <b>
                                            <p id="likeRespuesta_<?php echo $rowRespuesta['idAnswer'] ?>"
                                                class="text-nowrap mt-2"
                                                style="font-size: 12px; color: rgb(0, 253, 93);">Me gusta:<span
                                                    class="counter"
                                                    id="likeCount_<?php echo $rowRespuesta['idAnswer'] ?>">&nbsp;<?php echo $rowRespuesta['likes'] ?></span>
                                            </p>
                                        </b>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <a class="likeRespuesta btn" data-vote-type="0"
                                            id="unlike_<?php echo $rowRespuesta['idAnswer'] ?>">
                                            <i class='bx bx-dislike' style="color:rgb(255, 22, 22);"></i>
                                        </a>
                                    </div>
                                    <div>
                                        <b>
                                            <p id="unlikeRespuesta_<?php echo $rowRespuesta['idAnswer']; ?>"
                                                class="text-nowrap mt-2"
                                                style="font-size: 12px; color: rgb(255, 22, 22);">No me gusta:<span
                                                    class="counter"
                                                    id="unlikeCount_<?php echo $rowRespuesta['idAnswer'] ?>">&nbsp;<?php echo $rowRespuesta['unlikes'] ?></span>
                                            </p>
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
$numTemas = mysqli_num_rows($resultQuery);
if( $numTemas == 0){?>
            <div class="text-center" style="background-color: #a99f9f36; border-radius: 20px;">
                <h3 class="p-4" style="color: #928b8b;">Aún no hay temas publicados</h3>
            </div>
            <?php 
}
?>
        </div>
    </div>
</div>
<!--Container Main end-->
</body>
<script type="text/javascript">
var getCountNotifications = "<?php echo"$num_rows"?>";
document.write('<text style="visibility: hidden">getCountNotifications</text>');
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"
    integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script type="text/javascript" src="../js/mainFunctions.js"></script>
<script type="text/javascript" src="../js/likes.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</html>