<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <link rel="stylesheet" type="text/css" href="css/styles.css">

    <title>Foro ASSIST</title>
</head>

<body id="body-pd">
    <header class="header" id="header">
        <div class="header_toggle"> <i class='bx bx-menu' id="header-toggle"></i> </div>
        <h1 id="title"><span style="color:red;">BIENVENIDO AL</span> <span style="color: white;">FORO ASSIST</span></h1>
        <button>Temas</button>
        <button>Actividad Reciente</button>
        <button>Comentarios</button>
        <!-- <div class="header_img"> <img src="https://i.imgur.com/hczKIze.jpg" alt=""> </div> -->
    </header>



    <div class="l-navbar" id="nav-bar">
        <nav class="nav">
        <?php
require "menu.php";

foreach ($items as $i) {
    echo "<div class='nav_logo'> <a href='#' <i class='bx bx-layer nav_logo-icon'></i> <span class='nav_logo-name'>" . $i['item_text'] . "</span> </a> </div>";
    //echo ". $i['item_link'] .";
    // echo $i['item_text'];
    // echo ;
}

/*   <div class="nav_list"> <a href="#" class="nav_link active"> <i class='bx bx-grid-alt nav_icon'></i>
<span class="nav_name">Registrarse</span> </a> <a href="#" class="nav_link"> <i
class='bx bx-user nav_icon'></i> <span class="nav_name">Comunidad Assist</span> </a> <a href="#"
class="nav_link"></div>
</div> <a href="#" class="nav_link"> <i class='bx bx-log-out nav_icon'></i> <span class="nav_name">Comunidad
Assist</span> </a> */
?></nav>
    </div>
    <!--Container Main start-->
    <div class="height-100 bg-light">
        <h4>Main Components</h4>
    </div>
    <!--Container Main end-->

</body>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"
    integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script type="text/javascript" src="js/mainFunctions.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"></script>

</html>