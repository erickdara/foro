<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');

include 'hybridauth/src/autoload.php';
include 'App/Auth/config.php';
include 'utils.php';

$utils = new Utils();
use Hybridauth\Hybridauth;

$hybridauth = new Hybridauth($config);
$adapters = $hybridauth->getConnectedAdapters();
$errors = [];
?>
<div class="d-none text-light">
    <ul>
        <?php foreach ($hybridauth->getProviders() as $name): ?>
        <?php if (!isset($adapters[$name])): ?>
            <li>
            <a id="auth" href="#" onclick="javascript:auth_popup('<?php print $name ?>');">
                Sign in with <?php print $name ?>
            </a>
        </li>
        <?php endif;?>
        <?php endforeach;?>
    </ul>

    <?php require_once 'registerSocial.php'?>
    <?php foreach ($adapters as $name => $adapter): ?>
    <li>
        <strong><?php print $adapter->getUserProfile()->displayName; ?></strong> from
        <i><?php print $name; ?></i>
        <span>(<a href="<?php print $config['callback'] . "?logout={$name}"; ?>">Log Out</a>)</span>
    </li>

       <!--  if(isset(adapters)){
            header("location: logout.php");
        } -->

        $email =  $adapter->{'emailVerified'};

        echo 'email: '.$email;

        <script type="text/javascript">
        var loggedEmail = "<?php echo"$email"?>";
        document.write(loggedEmail);
        console.log(loggedEmail);
        </script>

    <?php print_r($adapter->getUserProfile())?> 
    <?php //echo '' . $name;
    $data = $adapter->getUserProfile();
    var_dump($data);

    $identifier = $data->{'identifier'};
    $mail = $data->{'emailVerified'};

    echo 'El identificador: '.$identifier;
    echo 'El e-mail: '.$mail;

    // if(empty($data)){
    // $register = new RegisterSocial();
    // $register->insertUser($data, $name);
    // }
?>


    <span>(<a href="<?php print $config['callback'] . "?logout={$name}";?>">Log Out</a>)</span>
    <?php endforeach;?>
</div>


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
    <script src="https://www.google.com/recaptcha/api.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <script>
        function auth_popup(provider) {
            // replace 'path/to/hybridauth' with the real path to this script
            var authWindow = window.open('http://localhost/Foro/App/Auth/callback.php?provider=' + provider, 'authWindow', 'width=600,height=400,scrollbars=yes');
            window.closeAuthWindow = function () {
            window.location = 'http://localhost/foro/User/index.php?provider='+ provider;
            authWindow.close();
            }
            return false;
        }
    </script>

    <title>Foro ASSIST</title>
</head>

<!--Container Main start-->
<?php
require_once "config.php";

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
        <div id="idPrincipal" class="col-6 col-md-6 col-sm-6">
            <!-- <h1 id="tituloForo" style="color: white; font-family: 'Alfa Slab One', cursive;"><span class="navbar-nav mt-3 me-auto ms-3 text-uppercase">FORO ASSIST</span></h1>
            <div id="logoForo" class="mt-3 mb-1" style="width: 10rem; height: 5rem;">
            <img  src="./img/logoHorizontalAssist.png" width="100%" height="100%">
            </div> -->
            
        </div>
        <div class="col-6 col-md-6 col-sm-6 d-flex justify-content-end">
        <div class="mt-3 mb-1" style="width: 5rem; height: 5rem;">
            <img src="./img/ForoTech.png" style="object-fit: contain; object-position: center;" width="100%"
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
                        <a href="actividad.php" type="button" class="btn text-light btn-nav">Actividad</a>
                    </li>
                    <li>
                        <a href="comentario.php" type="button" class="btn text-light btn-nav">Comentarios</a>
                    </li>
                    </ul>
                </div>
             
                <div class="collapse navbar-collapse col-sm-12 col-md-5 " id="search">
                    <form class="d-flex ms-auto my-3 my-lg-0">
                        <div class="input-group">
                            
                        <i class='bx bx-search bx-md' style='color:#fffbfb'></i>&nbsp;&nbsp;
                        <input class="form-control input-busqueda text-light" id="buscar" type="texto" placeholder="Búsqueda" name="buscar" onkeyup="strangeBuscar($('#buscar').val())"
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
                <img class="imgLogo" src="./img/Assist.png" width="100%" height="100%" alt="">
        </li>
        <li>
        <a href="#" class="nav_link" data-bs-toggle="modal" data-bs-target="#loginModal" id="logModal"> <i
                    class='bx bx-layer nav_icon bx-sm'></i> <span class="nav_name">Iniciar Sesion</span> </a>
        </li>
        <li>
        <a href="#" class="nav_link active" data-bs-toggle="modal" data-bs-target="#registerModal"> <i
                    class='bx bx-grid-alt nav_icon bx-sm'></i><span class="nav_name">Registrarse</span> </a>
        </li>
        <li>
        <a href="./comunidadAssist.php" class="nav_link"> <i class='bx bx-user nav_icon bx-sm'></i> <span
                    class="nav_name">Comunidad Assist</span> </a>
            <a href="#" class="nav_link">
        </li>
        <li>
        <?php if(isset($_SESSION['id'])){ ?>
            <a href="logout.php" class="nav_link"> <i class='bx bx-log-out nav_icon'></i> <span class="nav_name">Cerrar sesión</span> </a>
        <?php }else{?>
            <a href="#"></a>
        <?php } ?>
        </li>
        <li class="my-4"><hr class="dropdown-divider bg-light" /></li>
      </ul>
  </div>
</div>
<!-- offcanvas -->
    <div class="height-100 bg-light">
        <div class="container">
            <div class="row contain"></div>
            <div id="datos_buscador" class="row">

            </div>
            <?php 
                $queryTop = mysqli_query($link,"SELECT t.idTopic, t.titleTopic, u.usernames as nombres, u.userImage, t.likes, t.unlikes, COUNT(c.idTopic) as num_com 
                FROM commentary c
                INNER JOIN topic t ON c.idTopic = t.idTopic
                INNER JOIN user u ON t.idUser = u.idUser
				WHERE c.idTopic = t.idTopic and t.likes >= 12
                group by t.idTopic
                HAVING num_com >= 6");

                    ?>

            <div class="row mt-4">
            <div class="col-md-3 col-sm-12">
                <div class="row d-flex justify-content-center mt-4">
                    <button type="button" class="btn col-md-10 col-sm-10 justify-content-between align-items-start" data-bs-toggle="modal" data-bs-target="#validateModal">
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
                <!-- <div class="col-md-2 col-sm-12 d-flex align-items-end justify-content-start">
                    <div class="row tema">
                        <button type="button" class="btn justify-content-between align-items-start"
                            data-bs-toggle="modal" data-bs-target="#validateModal">
                            <div class="col-md-6 col-sm-6 d-flex justify-content-end btn">
                                <i class='bx bx-plus-circle bx-md'></i>
                            </div>
                            <div class="col-md-6 col-sm-6 d-flex justify-content-center btn">
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
                                <h6 class="text-center text-light"><?php // echo $rowTotalC['totalComentarios']; ?></h6>
                            </div>
                            <div class="col num-answer pt-2">
                                <h6 class="text-center text-light">RESPUESTAS</h6>
                                <h6 class="text-center text-light"><?php // echo $rowTotalR['totalRespuestas']; ?></h6>
                            </div>
                        </div>
                    </div>
                </div> -->

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
                <div class="col-md-5 col-sm-12 mt-2">
                    <!-- Spinner End -->

                    <!-- Start Carousel -->
                    <div id="carouselExampleControls" style="height: 100%;" class="carousel slide carousel-fade"
                        data-bs-ride="carousel">
                        <div class="carousel-inner">
                        <?php
                            while($resultTop = mysqli_fetch_array($queryTop)){
                        ?>
                        <div class="carousel-item">
                            <div class="card">
                            <a href="#tema_<?php echo $resultTop['idTopic']?>">
                                <div class="row mx-3 ms-3 pt-2">
                                    <div class="col-2 col-md-2 d-flex justify-content-end ms-3">
                        <?php
                        if ($resultTop['userImage'] != null) {
                            ?>
                            <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($resultTop['userImage']); ?>" style="object-fit: cover; object-position: center; border:1px solid #ffff; max-width: 3rem; max-height: 3rem;" class="rounded-circle" alt="Imagen de usuario">
                        <?php
                        } else {?>
                        <img src="./img/user.png"  style="object-fit: cover; object-position: center; border:1px solid #ffff; max-width: 3rem; max-height: 3rem;" class="rounded-circle" alt="Imagen de usuario">
                                    <?php       
                                    }
                        ?>
                                    </div>
                                    <div class="col-9 col-md-9 d-flex justify-content-start align-items-end p-2 text-dark">
                                        <h6><b><?php echo $resultTop['nombres'] ?></b></h6>
                                    </div>
                                    <!-- <div class="col-12 col-md-12 d-flex justify-content-start mt-2">
                                        <b style="color: rgb(255 50 59);">Tema:</b>&nbsp;<b style="color: rgb(7, 26, 57);">Transformación digital</b>
                                    </div> -->
                                </div>
                                <div class="row mt-2 ms-1">
                                    <div class="col-md-12 col-sm-12">
                                        <b style="color: rgb(255 50 59);">Tema:</b>&nbsp;<b
                                            style="color: rgb(7, 26, 57);"><?php echo $resultTop['titleTopic'] ?></b>
                                    </div>
                                </div>
                                <div class="row mt-1 ms-2">
                                    <div class="col-sm-3 col-md-3 ">
                                        <small
                                            style="color:rgb(0, 253, 93);">Likes:<?php echo $resultTop['likes'] ?></small>
                                    </div>
                                    <div class="col-sm-3 col-md-3">
                                        <small style="color: rgb(255, 22, 22);">Unlikes:
                                            <?php echo $resultTop['unlikes'] ?></small>
                                    </div>
                                    <div class="col-sm-12 col-md-4 text-dark ">
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
                            <div class="card bg-light d-flex justify-content-center align-items-center"
                                style="height: 100%;">
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


            <div class="row mt-4 d-flex justify-content-start position-relative">

                <?php
$query = "SELECT t.idTopic, t.idUser, u.usernames, r.roleType, t.titleTopic, t.describeTopic, t.likes, t.unlikes, t.created_at, DATE_FORMAT(t.created_at, \"%M %d de %Y\") AS fecha
                  FROM topic t
                  INNER JOIN user u ON t.idUser = u.idUser
                  INNER JOIN role r ON u.idRole = r.idRole
                  ORDER BY t.idTopic DESC";

$resultQuery = mysqli_query($link, $query);

while ($row = mysqli_fetch_array($resultQuery)) {
    ?> <div id="tema_<?php echo $row['idTopic'] ?>"></div>
                <div class="card tema-informacion mt-2 mb-3">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-5 ">
                                <h6><strong>Publicado por: <?php echo $row['usernames'] ?>
                                        (<?php echo $row['roleType'] ?>)</strong></h6>
                            </div>
                            <div class="col-7">
                                <p class="text-muted" id="month" style="font-size: smaller;">Fecha:
                                    <?php echo $row['fecha']; ?></p>
                            </div>
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
                                <p class="mt-1" style="color: rgb(7, 26, 57); font-size: 15px;"><b>Comentarios del
                                        tema:</b></p>
                                <b class="btn btn-comentarios" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#tema<?php echo $row['idTopic'] ?>" aria-expanded="false"
                                    aria-controls="collapseExample"
                                    style="color: rgb(7, 26, 57); font-size: 13px; font-weight: bold;"><?php echo $rowCountComentario['com'] . " Comentario(s)" ?></b>
                                <!-- <button class="btn d-flex align-items-start" type="button" data-bs-toggle="collapse" data-bs-target="#collapseComentarios" aria-expanded="false" aria-controls="collapseExample"><b style="color: rgb(7, 26, 57); font-size: 13px;">1 Comentario</b></button>-->
                                <!--<p style="color: rgb(7, 26, 57); font-size: 12px;"><b>Comentarios del tema: 1 comentario</b></p>-->
                            </div>
                            <?php

    ?>

                            <form action="likes.php" method="POST" class="col-md-5 d-flex d-wrap"
                                style="font-size: 12px;">
                                <input type="hidden" name="idTemaLike" value="<?php echo $row['idTopic']; ?>">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <a data-bs-toggle="modal" data-bs-target="#validateModal" class="btn">
                                            <i class='bx bx-like' style="color:rgb(0, 253, 93);" id="likeTema"></i>
                                        </a>
                                    </div>
                                    <div class="d-flex align-items-end">
                                        <b>
                                            <p class="text-nowrap" style="color: rgb(0, 253, 93);">Me gusta:
                                                <?php echo $row['likes'] ?></p>
                                        </b>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <a data-bs-toggle="modal" data-bs-target="#validateModal" class="btn">
                                            <i class='bx bx-dislike' style="color:rgb(255, 22, 22);"></i>
                                        </a>
                                    </div>
                                    <div class="d-flex align-items-end">
                                        <b>
                                            <p class="text-nowrap" style="font-size: 12px; color: rgb(255, 22, 22);">No
                                                me gusta: <?php echo $row['unlikes'] ?></p>
                                        </b>
                                    </div>
                                </div>
                            </form>

                            <!-- <div class="col-md-2">
                                <div class="d-flex justify-content-center">
                                    <div class="d-flex justify-content-between">
                                        <img style="width: 20px; height: 15px;" src="../img/agregar.png" alt="">
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
                                    data-bs-target="#collapseComentar" aria-expanded="false"
                                    aria-controls="collapseExample"><b>Comentar</b></button>
                            </div>
                        </div>
                        <div class="row collapse mt-4" id="collapseComentar">
                            <div class="col-md-10">
                                <div class="mb-3">
                                    <input type="text" name="describeComentario" class="form-control"
                                        placeholder="Escribe un comentario...">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <input type="hidden" name="idTema" value="<?php echo $row['idTopic'] ?>">
                                <input name="comentario" type="submit" class="btn btn-danger" data-bs-toggle="modal"
                                    data-bs-target="#validateModal" value="Comentar" />
                            </div>
                        </div>
                        <?php
$idTopic = $row['idTopic'];
    $queryComentario = "SELECT c.idCommentary, c.idTopic, c.idUser, u.usernames, c.describeCommentary, u.userImage, c.likes, c.unlikes, DATE_FORMAT(c.created_at, \"%M %d de %Y\") AS fecha
                                                FROM commentary c
                                                INNER JOIN topic t ON c.idTopic = t.idTopic
                                                INNER JOIN user u ON c.idUser = u.idUser
                                                WHERE c.idTopic = '$idTopic'
                                                ORDER BY c.idCommentary DESC";

    $resultComentario = mysqli_query($link, $queryComentario);
    while ($rowComentario = mysqli_fetch_array($resultComentario)) {
        ?>
                        <div class="row collapse titulo-comentario mt-3" id="tema<?php echo $row['idTopic'] ?>">
                            <div class="col-md-12 mt-3">
                                <h5><b>Comentarios anteriores</b></h5>
                            </div>
                            <div class="row d-flex justify-content-between mt-4">
                                <div class="col-md-3 mt-2 ">
                                    <div class="d-flex justify-content-center" style="width: 100%; height: 100%;">
                                        <?php
if ($rowComentario['userImage'] != null) {
            ?>
                                        <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($rowComentario['userImage']); ?>"
                                            style="object-fit: cover; object-position: center;" width="60%" height="60%"
                                            class="img-thumbnail img-perfil rounded-circle" alt="Imagen de usuario">
                                        <?php
} else {?>
                                        <img src="img/user.png" style="object-fit: cover; object-position: center;"
                                            width="60%" height="60%" class="img-thumbnail img-perfil rounded-circle"
                                            alt="Imagen de usuario">
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
                                <div class="col-md-3 mt-1 d-flex justify-content-center">
                                    <h5><?php echo $rowComentario['usernames'] ?></h5>
                                </div>
                            </div>
                            <?php
$idCommentary = $rowComentario['idCommentary'];
        $queryCountRespuesta = "SELECT COUNT(*) AS res FROM answer a WHERE a.idCommentary = '$idCommentary' ";
        $resultCount = mysqli_query($link, $queryCountRespuesta);
        $rowCountRespuesta = mysqli_fetch_array($resultCount);
        ?>
                            <div class="row">
                                <div class="col-md-4 d-flex d-wrap">
                                    <p class="mt-1" style="color: rgb(7, 26, 57); font-size: 15px;"><b>Respuestas:</b>
                                    </p>
                                    <b class="btn btn-comentarios" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#comentario<?php echo $rowComentario['idCommentary'] ?>"
                                        aria-expanded="false" aria-controls="collapseExample"
                                        style="color: rgb(7, 26, 57); font-size: 13px; font-weight: bold;"><?php echo $rowCountRespuesta['res'] . " Respuesta(s)" ?></b>
                                </div>
                                <div class="col-md-4 d-flex justify-content-end">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <a class="likeComentario btn" data-bs-toggle="modal"
                                                data-bs-target="#validateModal" data-vote-type="1"
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
                                            <a class="likeComentario btn" data-bs-toggle="modal"
                                                data-bs-target="#validateModal" data-vote-type="0"
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
                                <div class="row collapse mt-4"
                                    id="collapseResponder_com<?php echo $rowComentario['idCommentary'] ?>">
                                    <div class="col-md-10">
                                        <div class="mb-3">
                                            <input type="text" name="describeRespuesta" class="form-control"
                                                placeholder="Escribe una respuesta...">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <input type="hidden" name="idComentario"
                                            value="<?php echo $rowComentario['idCommentary'] ?>">
                                        <input name="respuesta" type="submit" data-bs-toggle="modal"
                                            data-bs-target="#validateModal" class="btn btn-danger" value="Responder">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php
$idCommentary = $rowComentario['idCommentary'];
        $queryRespuesta = "SELECT a.idAnswer, a.idCommentary, a.idUser, u.usernames, a.describeAnswer, a.likes, a.unlikes, u.userImage, DATE_FORMAT(a.created_at, \"%M %d de %Y\") AS fecha
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
                                        <img src="./img/user.png" style="object-fit: cover; object-position: center;"
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
                <?php } ?>

            </div>
        </div>
    </div>
    <!--Container Main end-->

    <!--Start Register Modal -->
    <div class="modal fade" id="registerModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
        <?php require_once "registerUser.php"?> aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <h4 class="modal-title w-100 font-weight-bold">Registrarse</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <!-- <span aria-hidden="true">&times;</span> -->
                    </button>
                </div>
                <div class="modal-body mx-3">
                    <!-- <form action="registerUser.php" method="post"> -->
                    <div class="md-form mb-4">
                        <i class="fas fa-user prefix grey-text"></i>
                        <label data-error="wrong" data-success="right" for="orangeForm-name">Nombres</label>
                        <input type="text" id="usernames" name="username" class="form-control"
                            placeholder="Formato: Jon Smith">
                        <span><small class="text-danger" id="usercheck" style="color: red;">Falta nombre de
                                usuario</small></span>
                    </div>
                    <div class="md-form mb-4">
                        <i class="fas fa-envelope prefix grey-text"></i>
                        <label data-error="wrong" data-success="right" for="email">Correo</label>
                        <input type="email" id="email" name="email" class="form-control ">

                        <span><small id="emailvalid" class="form-text text-muted invalid-feedback text-danger">Su email
                                debe ser un email válido </small></span>
                    </div>

                    <div class="md-form mb-4">
                        <i class="fas fa-lock prefix grey-text"></i>
                        <label data-error="wrong" data-success="right" for="orangeForm-pass">Contraseña</label>
                        <input type="password" id="password" name="pass" class="form-control ">

                        <span><small id="passcheck" class="text-danger">Por favor llene el password</small></span>
                    </div>

                    <div class="md-form mb-4">
                        <i class="fa-solid fa-key"></i>
                        <!-- <i class="fas fa-lock prefix grey-text"></i> -->
                        <label data-error="wrong" data-success="right" for="orangeForm-pass">Confirm password</label>
                        <input type="password" id="conpassword" name="username" class="form-control ">
                        <span><small id="conpasscheck" class="text-danger">Contraseña no coincide</small></span>
                    </div>
                    <div class="mb-3 d-flex justify-content-center">

                        <a href="#" onclick="document.getElementById('provider0').click();" class="fa fa-facebook"></a>
                        <a href="#" onclick="document.getElementById('auth').click();" class="fa fa-google"></a>

                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <input type="submit" id="submitbtn" class="btn btn-success" value="Registrar"></input>
                    <!-- </form> -->
                </div>
            </div>
        </div>
        ?>
    </div>

    <!--End Register Modal -->

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
                    <button type="button" class="btn btn-info" id="loginAlert" data-bs-dismiss="modal">Registro</button>
                </div>
            </div>
        </div>
    </div>
    <!-- fin validateModal -->

    <!-- Go to www.addthis.com/dashboard to customize your tools -->
    <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-6236821402b458e6"></script>

</body>


<!-- Modal Login -->

<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <?php require_once 'loginUser.php';?>
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="loginModalLabel" data-bs-toggle="modal" data-bs-target="#loginModal">INICIAR
                    SESIÓN</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="loginUser.php" method="post">
                    <div class="mb-3">
                        <i class="fas fa-envelope prefix grey-text"></i>
                        <label for="correo usuario" class="col-form-label">Correo:</label>
                        <input type="text" id="correo" name="mail" class="form-control" <?php echo $usuCorreo; ?>>
                        <small id="emailvalid" class="form-text text-muted invalid-feedback">
                            Su email debe ser un email válido
                        </small>
                        <span class="invalid-feedback"><?php echo $mail_err; ?></span>
                    </div>
                    <div class="mb-3">
                        <i class="fas fa-lock prefix grey-text"></i>
                        <label for="password" class="col-form-label">Contraseña:</label>
                        <input type="password" id="pass" name="password"
                            class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>">
                        <h6 id="passcheckLogin" style="color: red;">
                            Por favor llene el password
                        </h6>
                        <text id=validation></text>
                        <span class="invalid-feedback"><?php echo $password_err; ?></span>
                    </div>
                    <div>
                        <div class="mb-3 d-flex justify-content-center">

                            <a href="#" onclick="document.getElementById('provider1').click();"
                                class="fa fa-facebook"></a>
                            <a href="#" onclick="document.getElementById('auth').click();"
                                class="fa fa-google"></a>

                        </div>
                        <div class="text-center">
                            <p><a href="enter_email.php">¿Olvidó su contraseña?</a></p>
                        </div>
                    </div>


            </div>
            <div class="modal-footer d-flex justify-content-center">


                <!--
            <button class="g-recaptcha"
            data-sitekey="6LfZh9UeAAAAAGoCYH8PZoqKbYpo6lKDLqhWPDei"
            data-callback='onSubmit'
            data-action='submit'>Submit</button> -->


                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <!-- <button type="button" class="btn btn-primary">Send message</button> -->
                <input type="button" onclick="loginUser()" class="btn btn-primary" value="Login">
                </form>
            </div>
        </div>
    </div>
    <!-- Fin Modal Login -->

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script type="text/javascript" src="js/mainFunctions.js"></script>
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</html>