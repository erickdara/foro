<?php
require_once('config.php');
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
                <div class="header_toggle"> <i class='bx bx-menu' id="header-toggle"></i> </div>
                <h1 id="title"><span style="color:red;">BIENVENIDO AL</span> <span style="color: white;">FORO ASSIST</span></h1>
                <!-- <div class="header_img"> <img src="https://i.imgur.com/hczKIze.jpg" alt=""> </div> -->
            </div>
            <div class="col-md-12 d-flex justify-content-start">
                <div class="col-md-6 col-sm-2 pb-1">
                    <a href="./User/index.php" type="button" class="btn text-light btn-nav">Temas</a>
                    <a href="actividad.php" type="button" class="btn text-light btn-nav">Actividad Reciente</a>
                    <a href="comentarios.html" type="button" class="btn text-light btn-nav">Comentarios</a>
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
                <a href="#" class=""> <img style="margin-left: 1rem; margin-bottom: 1rem; margin-right: 1rem;" class="" width="20%" height="14%" src="<?php echo $rowImg['usuImagen']; ?>" alt=""> <span class="nav_logo-name">Perfil</span> </a>
                <a href="#" class="nav_link active"> <i class='bx bx-grid-alt nav_icon'></i><span class="nav_name">Notificaciones</span> </a>
                <a href="#" class="nav_link"> <i class='bx bx-user nav_icon'></i> <span class="nav_name">Comunidad Assist</span> </a>
                <a href="#" class="nav_link">
            </div>

            <a href="../logout.php" class="nav_link"> <i class='bx bx-log-out nav_icon'></i> <span class="nav_name">Cerrar sesión</span> </a>
        </nav>
    </div>

    <div class="height-100 bg-light">
        <div class="container">
        <div class="row d-flex justify-content-center mt-2">
            <div class="card actividad-info mt-4 mb-4">
        <?php
            $queryUser = mysqli_query($link, "SELECT u.idUsuario, CONCAT(u.usuNombres, \" \", u.usuApellidos) as nombres, r.tipoRol FROM usuario u 
            INNER JOIN rol r ON u.idRol = r.idRol 
            ORDER BY u.idRol");

            while ($rowUser = mysqli_fetch_array($queryUser)) {
            ?>
                
                        <div class="row d-flex justify-content-center" style="width: 90%;">
                            <div class="col-md-3 mt-3 mb-1">
                                <img src="img/user.png" class=" rounded mx-auto d-block" alt="...">
                            </div>
                            <div class="col-md-9 mt-3 mb-2 d-flex align-items-center">
                                <div class="card-body">
                                    <h5 class="card-title"><b style="color: rgb(7, 26, 57);"><?php echo $rowUser['nombres'] ." (".$rowUser['tipoRol'].")"; ?></b></h5>
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script type="text/javascript" src="js/mainFunctions.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"></script>

</html>