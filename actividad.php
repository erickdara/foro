<?php
require_once('config.php');
include('utils.php');

$util = new utils();

class Actividad{
    
    public function actividad($tipoInteraccion){
        include('config.php');
        require_once('utils.php');
        $util = new Utils();
        $queryTema = mysqli_query($link, "SELECT t.idTema, t.idUsuario, CONCAT(u.usuNombres, \" \", u.usuApellidos) AS nombres, t.tituloTema, t.describeTema, DATE_FORMAT(t.created_at, \"%d %m %Y %H %i %s\") AS fecha, likes, unlikes
            FROM tema t 
            INNER JOIN usuario u ON t.idUsuario = u.idUsuario 
            INNER JOIN rol r ON u.idRol = r.idRol
            ORDER BY t.created_at DESC");
        $queryDateNow = mysqli_query($link, "SELECT DATE_FORMAT(now(),\"%d %m %Y %H %i %s\") as dateNow");
        $dateNow = mysqli_fetch_array($queryDateNow);
        switch($tipoInteraccion){
            case "tema":
                while($rowTema = mysqli_fetch_array($queryTema)){
                    $fecha = $util-> get_time_ago($rowTema['fecha'], $dateNow['dateNow']);
                    return "<div class=\"row d-flex justify-content-center\">
                        <div class=\"card actividad-info\">
                            <div class=\"row d-flex justify-content-center\" style=\"width: 90%;\">
                                <div class=\"col-md-3 mt-3 mb-1\">
                                    <img src=\"img/user.png\" class=\" rounded mx-auto d-block\" alt=\"...\">
                                </div>
                            <div class=\"col-md-9 mt-3 mb-2 d-flex align-items-center\">
                                <div class=\"card-body\">
                                    <h5 class=\"card-title\"><b style=\"color: rgb(7, 26, 57);\"><?php echo $rowTema\['nombres'] . \" creo el tema \"; ?></b><b style=\"color: rgb(255 50 59);\"><?php echo $rowTema\['tituloTema'] ?></b></h5>
                            <p class=\"card-text\"><small class=\"text-muted\"><?php echo $fecha ?></small></p>
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>";
                }
        }
}

}
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
                <a href="perfil.php" class=""> <img style="margin-left: 1rem; margin-bottom: 1rem; margin-right: 1rem;" class="" width="20%" height="14%" src="<?php echo $rowImg['usuImagen']; ?>" alt=""> <span class="nav_logo-name">Perfil</span> </a>
                <a href="#" class="nav_link active"> <i class='bx bx-grid-alt nav_icon'></i><span class="nav_name">Notificaciones</span> </a>
                <a href="comunidadAssist.php" class="nav_link"> <i class='bx bx-user nav_icon'></i> <span class="nav_name">Comunidad Assist</span> </a>
                <a href="#" class="nav_link">
            </div>

            <a href="logout.php" class="nav_link"> <i class='bx bx-log-out nav_icon'></i> <span class="nav_name">Cerrar sesión</span> </a>
        </nav>
    </div>

    <div class="height-100 bg-light">
        <div class="container">
        <?php
            $queryNot = mysqli_query($link, "SELECT n.idNotificacion, n.idUsuario1, CONCAT(u.usuNombres, \" \", u.usuApellidos) AS nombres, n.idUsuario2, n.tipoNotificacion,DATE_FORMAT(n.created_at, \"%d-%m-%Y %H:%i:%s\") AS fecha
            FROM notificacion n 
            INNER JOIN usuario u ON n.idUsuario1 = u.idUsuario 
            ORDER BY n.created_at DESC");

            while ($rowNot = mysqli_fetch_array($queryNot)) {
            ?>
                <div class="row d-flex justify-content-center">
                    <div class="card actividad-info mt-2">
                        <div class="row d-flex justify-content-center" style="width: 90%;">
                            <div class="col-md-3 mt-3 mb-1">
                                <img src="img/user.png" class=" rounded mx-auto d-block" alt="...">
                            </div>
                            <div class="col-md-9 mt-3 mb-2 d-flex align-items-center">
                                <div class="card-body">
                                    <h5 class="card-title"><b style="color: rgb(7, 26, 57);"><?php echo $rowNot['nombres'] ." ".$rowNot['tipoNotificacion']; ?></b><b style="color: rgb(255 50 59);"><?php echo $rowTema['tituloTema'] ?></b></h5>
                                    <p class="card-text"><small class="text-muted"><?php echo $util->get_time_ago($rowTema['fecha']) ?></small></p>
                                </div>
                            </div>
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
<script type="text/javascript" src="js/mainFunctions.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"></script>

</html>