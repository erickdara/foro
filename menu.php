<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <link rel="stylesheet" type="text/css" href="css/sty.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Frontendfunn - Bootstrap 5 Admin Dashboard Template</title>
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
                <img src="./img/ForoTech.png" style="object-fit: contain; object-position: center;" width="100%"
                    height="100%">
            </div>
            </div>
            <div class="col-sm-12 mt-2 mb-2 col-md-12 d-flex justify-content-between">
                <button class="navbar-toggler clickMenu" type="button" data-bs-toggle="offcanvas" data-bs-target="#nav-bar" aria-controls="offcanvasExample">
                    <span class="clickMenu" data-bs-target="#nav-bar"><i class='bx bxs-home-alt-2 clickMenu' style='color:#ffffff'></i></span>
                </button>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#topNavBar" aria-controls="topNavBar" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon" data-bs-target="#topNavBar"></span>
                </button>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#buscar" aria-controls="bsc" aria-expanded="false" aria-label="Toggle navigation">
                            <span data-bs-target="#buscar"><i class='bx bx-search-alt-2' style='color:#ffffff'></i></span>
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
                 
                    <div class="collapse navbar-collapse col-sm-12 col-md-5 " id="buscar">
                        <form class="d-flex ms-auto my-3 my-lg-0">
                            <div class="input-group">
                            <i class='bx bx-search bx-md' style='color:#fffbfb'></i>&nbsp;&nbsp;
                            <input class="form-control" type="search" placeholder="Search" aria-label="Search"/>
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
          <li class="nav_logo" style="width:5rem; height:4rem; margin-bottom: 1rem; margin-top:1rem;">
                    <img class="imgLogo"
                        src="./img/Assist.png" width="100%" height="100%" alt="">
            </li>
            <li>
            <a href="#" class="nav_link" data-bs-toggle="modal" data-bs-target="#loginModal" id="logModal"> <i
                        class='bx bx-layer nav_icon'></i> <span class="nav_name">Iniciar Sesion</span> </a>
            </li>
            <li>
            <a href="#" class="nav_link active" data-bs-toggle="modal" data-bs-target="#registerModal"> <i
                        class='bx bx-grid-alt nav_icon'></i><span class="nav_name">Registrarse</span> </a>
            </li>
            <li>
            <a href="./comunidadAssist.php" class="nav_link"> <i class='bx bx-user nav_icon'></i> <span
                        class="nav_name">Comunidad Assist</span> </a>
                <a href="#" class="nav_link">
            </li>
            <li class="my-4"><hr class="dropdown-divider bg-light" /></li>
          </ul>
  
      </div>
    </div>
    <!-- offcanvas -->

</body>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script type="text/javascript" src="js/mainFunctions.js"></script>
<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"></script> -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</html>