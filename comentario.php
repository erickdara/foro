<?php
include('config.php');
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

    <title>Document</title>
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
                    <a href="comentarios.php" type="button" class="btn text-light btn-nav">Comentarios</a>
                </div>

                <div class="col-md-6 col-sm- 4 d-flex align-items-center justify-content-end">
                    <i class='bx bx-search bx-sm' style='color:#fffbfb'></i>&nbsp;&nbsp;&nbsp;
                    <input type="text" style="background-color: rgb(7, 26, 57); border: 0;" class="input-busqueda text-light" placeholder="Búsqueda">
                </div>
            </div>
        </div>
    </header>
    <div class="l-navbar" id="nav-bar">
            <nav class="nav">
                <div class="nav_list">
                    <div class="">
                        <img class="imgLogo" style="margin-left: 0.6rem; margin-bottom: 1rem; border-radius: 50%;" src="../img/logo.jpg" width="27%" height="17%" alt="">
                    </div>
                    <a href="perfil.php" class=""> <img style="margin-left: 1rem; margin-bottom: 1rem; margin-right: 1rem;" class="" width="20%" height="14%" src="<?php echo $rowImg['usuImagen']; ?>" alt=""> <span class="nav_logo-name">Perfil</span> </a>
                    <a href="#" class="nav_link active"> <i class='bx bx-grid-alt nav_icon'></i><span class="nav_name">Notificaciones</span> </a>
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
            <?php
                          $queryComentario = "SELECT c.idComentario, c.idTema, c.idUsuario, t.tituloTema, CONCAT(u.usuNombres, \" \", u.usuApellidos) AS nombres, c.describeComentario, c.likes, c.unlikes, DATE_FORMAT(c.created_at, \"%M %d de %Y\") AS fecha
                          FROM comentario c 
                          INNER JOIN tema t ON c.idTema = t.idTema
                          INNER JOIN usuario u ON c.idUsuario = u.idUsuario 
                          ORDER BY c.created_at DESC";

                          $resultComentario = mysqli_query($link, $queryComentario);
                          while($rowComentario = mysqli_fetch_array($resultComentario)){
                        ?>
                        
                <div class="row card comentario">
                            <div class="row d-flex justify-content-between mt-4">
                                <div class="col-md-3 mt-2 d-flex justify-content-center">
                                        <img class="img-user img-fluid" src="./img/user.png" alt="">
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
                            <div class="row mb-2">
                                <div class="col-md-6 d-flex justify-content-end">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <a class="likeComment btn" data-vote-type="1" id="like_<?php echo $rowComentario['idComentario']?>">
                                                <i class='bx bx-like' style="color:rgb(0, 253, 93);"></i>
                                            </a>
                                        </div>
                                        <div class="d-flex align-items-end">
                                            <b>
                                                <p id="likeComentario_<?php echo $rowComentario['idComentario']?>" class="text-nowrap mt-2" style="font-size: 12px; color: rgb(0, 253, 93);">Me gusta:&nbsp;<span class="counter" id="likeCount_<?php echo $rowComentario['idComentario'] ?>"><?php echo $rowComentario['likes'] ?></span></p>
                                            </b>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <a class="likeComment btn" data-vote-type="0" id="unlike_<?php echo $rowComentario['idComentario']?>">
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
                                    <h5><b style="color: rgb(7, 26, 57);">Tema: </b> <b style="color: rgb(255 50 59);"><?php echo $rowComentario['tituloTema']?></b></h5>
                                </div>
                            </div>
                        </div>
                        <?php
                          }
                        ?>
            </div>
        </div>   

    
</body>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script type="text/javascript" src="./js/mainFunctions.js"></script>
    <script type="text/javascript" src="./js/likes.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"></script>

</html>