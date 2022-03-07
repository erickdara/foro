<?php
setlocale(LC_ALL, "es_ES");
// Initialize the session
session_start();

// Check if the user is already logged in, if yes then redirect him to welcome page
//if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
  //header("location: index.php");
 // exit;
 //}

// Include config file
require_once "config.php";

// Define variables and initialize with empty values
$usuCorreo = $usuPassword = "";
$username_err = $password_err = $mail_err = $login_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Check if username is empty
    if (empty(trim($_POST['mail']))) {
        $mail_err = "Please enter user mail.";
    } else {
        $usuCorreo = trim($_POST['mail']);
    }

    // Check if password is empty
    if (empty(trim($_POST['password']))) {
        $password_err = "Please enter your password.";
    } else {
        $usuPassword = trim($_POST['password']);
    }

    // Validate credentials
    if (empty($mail_err) && empty($password_err)) {
        // Prepare a select statement
        $sql = "SELECT idRol, idUsuario, usuCorreo, usuPassword FROM usuario WHERE usuCorreo = ?";

        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_mail);

            // Set parameters
            $param_mail = $usuCorreo;

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Store result
                mysqli_stmt_store_result($stmt);

                // Check if username exists, if yes then verify password
                if (mysqli_stmt_num_rows($stmt) == 1) {
                    echo "Estoy encontrando resultados de la consulta";
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $idRol, $idUsuario, $usuCorreo ,$hashed_password);
                    if (mysqli_stmt_fetch($stmt)) {

                        if (password_verify($usuPassword, $hashed_password)) {
                            echo "Estoy entrando a la validación de la password";
                            // Password is correct, so start a new session
                            session_start();

                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $idUsuario;
                            $_SESSION["rol"] = $idRol;
                            //TODO: Validate this field if is neccesary
                            $_SESSION["username"] = $usuCorreo;

                            // Redirect user to welcome page
                            header("location: index.php");
                        } else {
                            // Password is not valid, display a generic error message
                            $login_err = "Invalid username or password.";
                        }
                    }
                } else {
                    // Username doesn't exist, display a generic error message
                    $login_err = "Invalid username or password.";
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            // mysqli_stmt_close($stmt);
        }
    }

    // Close connection
    //mysqli_close($link);
}
?>




<?php
if (!empty($login_err)) {
    echo '<div class="alert alert-danger">' . $login_err . '</div>';
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <title>Foro ASSIST</title>
</head>
<header class="header" id="header">
    <div class="row">
        <div class="col-md-12">
            <div class="header_toggle"> <i class='bx bx-menu' id="header-toggle"></i> </div>
            <h1 id="title"><span style="color:red;">BIENVENIDO AL</span> <span style="color: white;">FORO ASSIST</span></h1>
            <!-- <div class="header_img"> <img src="https://i.imgur.com/hczKIze.jpg" alt=""> </div> -->
        </div>
        <div class="col-md-12 d-flex justify-content-start">
            <div class="col-md-6 col-sm-2 pb-1">
                <a href="index.html" type="button" class="btn text-light btn-nav">Temas</a>
                <a href="actividad.html" type="button" class="btn text-light btn-nav">Actividad Reciente</a>
                <a href="comentarios.html" type="button" class="btn text-light btn-nav">Comentarios</a>
            </div>

            <div class="col-md-6 col-sm- 4 d-flex align-items-center justify-content-end">
                <img style="width: 40px; height: 30px;" class="img img-busqueda" src="./img/busqueda.png" alt="">
                <input type="text" style="background-color: rgb(7, 26, 57);" class="input-busqueda text-light" placeholder="Búsqueda">
            </div>
        </div>
    </div>
</header>
<div class="l-navbar" id="nav-bar">
    <nav class="nav">
        <div>
            
            <div class="nav_list">
            <a href="#" class="nav_logo" data-bs-toggle="modal" data-bs-target="#exampleModal"> <i class='bx bx-layer nav_logo-icon'></i> <span class="nav_logo-name">Iniciar Sesion</span> </a>
                <a href="#" class="nav_link active" data-bs-toggle="modal" data-bs-target="#modalRegisterForm"> <i class='bx bx-grid-alt nav_icon'></i><span class="nav_name">Registrarse</span> </a>
                <a href="#" class="nav_link"> <i class='bx bx-user nav_icon'></i> <span class="nav_name">Comunidad Assist</span> </a>
                <a href="#" class="nav_link">
            </div>
        </div>
        <a href="logout.php" class="nav_link"> <i class='bx bx-log-out nav_icon'></i> <span class="nav_name">Cerrar sesión</span> </a>
    </nav>
</div>
<!--Container Main start-->
<?php

    // if(isset($_SESSION['id']))
    $idUsuario = $_SESSION['id'];
    $totalC = "SELECT COUNT(idUsuario) AS totalComentarios FROM comentario c
    WHERE c.idUsuario != '$idUsuario';";
    

    $resultTotalC = mysqli_query($link,$totalC);
    $rowTotalC = mysqli_fetch_array($resultTotalC);

    $totalR = "SELECT COUNT(idUsuario) AS totalRespuestas FROM respuesta r
    WHERE r.idUsuario = '$idUsuario';";

    $resultTotalR = mysqli_query($link,$totalR);
    $rowTotalR = mysqli_fetch_array($resultTotalR);
  
?>
<div class="height-100 bg-light">
    <div class="container">
        <div class="row d-flex justify-content-end">
            <div class="col-md-5 mt-3 d-flex justify-content-end">
                <div class="card info">
                    <div class="row card-body d-flex">
                        <div class="col num-commentary pt-2">
                            <h6 class="text-center titulo">COMENTARIOS</h6>
                            <h6 class="text-center text-light"><?php echo $rowTotalC['totalComentarios'];?></h6>
                        </div>
                        <div class="col num-answer pt-2">
                            <h6 class="text-center titulo">RESPUESTAS</h6>
                            <h6 class="text-center text-light"><?php echo $rowTotalR['totalRespuestas'];?></h6>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-5 d-flex align-items-end justify-content-center">
                <div class="row tema">
                    <button type="button" class="btn d-flex justify-content-between align-items-center" data-bs-toggle="modal" data-bs-target="#modalTema">
                        <div class="col-md-6 d-flex justify-content-end btn">
                            <img class="img img-add-tema" src="img/agregar.png" alt="">
                        </div>
                        <div class="col-md-6 d-flex justify-content-center btn">
                            <h5 class="text-center text-add-tema text-nowrap">CREAR TEMA</h5>
                        </div>
                    </button>
                </div>
            </div>
        </div>

        <div class="row mt-4 d-flex justify-content-start">

            <!-- Modal para crear tema-->
            <div class="modal fade" id="modalTema" tabindex="-1" aria-labelledby="modalTema" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalTema">Crear tema</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="crearTema.php" method="POST">
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="tituloTema" class="form-label">Titulo:</label>
                                    <input type="text" class="form-control" name="tituloTema">
                                </div>
                                <div class="mb-3">
                                    <label for="describeTema" class="form-label">Descripción:</label>
                                    <textarea name="describeTema" class="form-control" cols="30" rows="8"></textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <input name="crearTema" type="submit" class="btn btn-primary" value="Publicar tema"></input>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Fin del modal-->

            <!--Start Register Modal -->
<div class="modal fade" id="modalRegisterForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    <?php require "registerUser.php" ?>
  aria-hidden="true">
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
          <label data-error="wrong" data-success="right" for="orangeForm-name">Nombre</label>
          <input type="text" id="username" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
          <span class="invalid-feedback"><?php echo $username_err; ?></span>
        </div>
        <div class="md-form mb-4">
          <i class="fas fa-envelope prefix grey-text"></i>
          <label data-error="wrong" data-success="right" for="email">Correo</label>
          <input type="email" id="mail" name="mail" class="form-control <?php echo (!empty($mail_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $mail; ?>">
          <span class="invalid-feedback"><?php echo $mail_err; ?></span>
        </div>

        <div class="md-form mb-4">
          <i class="fas fa-lock prefix grey-text"></i>
          <label data-error="wrong" data-success="right" for="orangeForm-pass">Contraseña</label>
          <input type="password" id="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>">
          <span class="invalid-feedback"><?php echo $password_err; ?></span>
        </div>

        <div class="md-form mb-4">
        <i class="fa-solid fa-key"></i>
          <!-- <i class="fas fa-lock prefix grey-text"></i> -->
          <label data-error="wrong" data-success="right" for="orangeForm-pass">Confirm password</label>
          <input type="password" id="confirm_password" name="confirm_password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $confirm_password; ?>">
          <span class="invalid-feedback"><?php echo $confirm_password_err; ?>
        </div>

      </div>
      <div class="modal-footer d-flex justify-content-center">
        <button type="button" onclick="registerUser()" class="btn">Registrar</button>
        <!-- </form> -->
      </div>
    </div>
  </div>
 ?></div>

            <!--End Register Modal -->


            <?php
            $query = "SELECT t.idTema, t.idUsuario, r.tipoRol, u.usuNombres, t.tituloTema, t.describeTema, DATE_FORMAT(t.created_at, \"%M %d de %Y\") AS fecha
                  FROM tema t 
                  INNER JOIN usuario u ON t.idUsuario = u.idUsuario 
                  INNER JOIN rol r ON u.idRol = r.idRol
                  ORDER BY t.idTema DESC";

            $resultQuery = mysqli_query($link, $query);
            while ($row = mysqli_fetch_array($resultQuery)) {
            ?>
                <div class="card tema-informacion mt-2 mb-3">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-5 ">
                                <h6><strong>Publicado por: <?php echo $row['usuNombres'] ?> (<?php echo $row['tipoRol'] ?>)</strong></h6>
                            </div>
                            <div class="col-7">
                                <p class="text-muted" style="font-size: smaller;">Fecha: <?php echo $row['fecha'] ?></p>
                            </div>
                        </div>
                        <div class="row titulo titulo-tema">
                            <div class="col">
                                <h1><strong><?php echo $row['tituloTema']; ?></strong></h1>
                            </div>
                        </div>
                        <div class="row cuerpo-tema mt-3">
                            <div class="col">
                                <?php echo $row['describeTema']; ?>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <?php
                            $idTemaC = $row['idTema']; 
                            $queryCountComentario = "SELECT COUNT(*) AS com FROM comentario c WHERE c.idTema = '$idTemaC' ";
                            $resultCount = mysqli_query($link,$queryCountComentario);
                            $rowCountComentario = mysqli_fetch_array($resultCount);
                            ?>
                            <div class="col-md-4 d-flex d-wrap">
                                <p class="mt-1" style="color: rgb(7, 26, 57); font-size: 15px;"><b>Comentarios del tema:</b></p>
                                <b class="btn btn-comentarios" type="button" data-bs-toggle="collapse" data-bs-target="#tema<?php echo $row['idTema'] ?>" aria-expanded="false" aria-controls="collapseExample" style="color: rgb(7, 26, 57); font-size: 13px; font-weight: bold;"><?php echo $rowCountComentario['com'] . " Comentario(s)" ?></b>
                                <!-- <button class="btn d-flex align-items-start" type="button" data-bs-toggle="collapse" data-bs-target="#collapseComentarios" aria-expanded="false" aria-controls="collapseExample"><b style="color: rgb(7, 26, 57); font-size: 13px;">1 Comentario</b></button>-->
                                <!--<p style="color: rgb(7, 26, 57); font-size: 12px;"><b>Comentarios del tema: 1 comentario</b></p>-->
                            </div>
                            <?php
                                
                            ?>
                            
                                <form  action="likes.php" method="POST" class="col-md-5 d-flex d-wrap"  style="font-size: 12px;">
                                <input type="hidden" name="idTemaLike" value="<?php echo $row['idTema'];?>">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <button class="btn-outline-light">
                                            <input type="hidden" name="meGustaTema" value="1">
                                            <input type="image" src="img/agregar.png" style="width: 20px; height: 15px;">
                                        </button>
                                    </div>
                                    <div>
                                        <b>
                                            <p class="text-nowrap" style="color: rgb(0, 253, 93);">Me gusta:1</p>
                                        </b>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <button class="btn-outline-light">
                                            <input type="hidden" name="noGustaTema" value="1">
                                            <input type="image" src="img/agregar.png" style="width: 20px; height: 15px;">
                                        </button>
                                    </div>
                                    <div>
                                        <b>
                                            <p class="text-nowrap" style="font-size: 12px; color: rgb(255, 22, 22);">No me gusta:0</p>
                                        </b>
                                    </div>
                                </div>
                                </form>
                           
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
                                <button class="btn btn-vermas" type="button" data-bs-toggle="collapse" data-bs-target="#collapseComentar" aria-expanded="false" aria-controls="collapseExample"><b>Comentar</b></button>
                            </div>
                        </div>

                        <form action="comentar.php" method="POST">
                           <div class="row collapse mt-4" id="collapseComentar">
                                <div class="col-md-10">
                                    <div class="mb-3">
                                        <input type="text" name="describeComentario" class="form-control" placeholder="Escribe un comentario...">
                                    </div> 
                                </div>
                                <div class="col-md-2">
                                    <input type="hidden" name="idTema" value="<?php echo $row['idTema']?>">
                                    <input name="comentario" type="submit" class="btn btn-danger" value="Comentar">
                                </div>
                            </div>
                        </form>
                         
                        <?php
                          $idTema = $row['idTema'];
                          $queryComentario = "SELECT c.idComentario, c.idTema, c.idUsuario, c.describeComentario, DATE_FORMAT(c.created_at, \"%M %d de %Y\") AS fecha
                          FROM comentario c 
                          INNER JOIN tema t ON c.idTema = t.idTema
                          INNER JOIN usuario u ON c.idUsuario = u.idUsuario 
                          WHERE C.idTema = '$idTema'
                          ORDER BY c.idComentario DESC";

                          $resultComentario = mysqli_query($link, $queryComentario);
                          while($rowComentario = mysqli_fetch_array($resultComentario)){
                        ?>
                        <div class="row collapse titulo-comentario mt-3" id="tema<?php echo $row['idTema'] ?>">
                            <div class="col-md-12 mt-3">
                                <h5><b>Comentarios anteriores</b></h5>
                            </div>
                            <div class="row d-flex justify-content-between mt-4">
                                <div class="col-md-3 mt-2 d-flex justify-content-center">
                                        <img class="img-user img-fluid" src="img/user.png" alt="">
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
                            <div class="row">
                                <div class="col-md-6 d-flex justify-content-end">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <button class="btn-outline-light">
                                                <img style="width: 20px; height: 15px;" src="img/agregar.png" alt="">
                                            </button>
                                        </div>
                                        <div>
                                            <b>
                                                <p class="text-nowrap" style="font-size: 12px; color: rgb(0, 253, 93);">Me gusta:1</p>
                                            </b>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <button class="btn-outline-light">
                                                <img style="width: 20px; height: 15px;" src="img/agregar.png" alt="">
                                            </button>
                                        </div>
                                        <div>
                                            <b>
                                                <p class="text-nowrap" style="font-size: 12px; color: rgb(255, 22, 22);">No me gusta:0</p>
                                            </b>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 d-flex justify-content-end">
                                    <button class="btn btn-vermas">
                                        responder comentario
                                    </button>
                                </div>
                            </div>
                        </div>
                        <?php
                          }
                        ?>

                    </div>
                </div>
            <?php
            }
            ?>
        </div>
    </div>
</div>
<!--Container Main end-->

</body>

<!-- Modal Login -->

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel" data-bs-toggle="modal" data-bs-target="#exampleModal">INICIAR SESIÓN</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="mb-3">
                        <i class="fas fa-envelope prefix grey-text"></i>
                        <label for="correo usuario" class="col-form-label">Correo:</label>
                        <input type="text" name="mail" class="form-control" <?php echo $usuCorreo; ?>>
                        <span class="invalid-feedback"><?php echo $mail_err; ?></span>
                    </div>
                    <div class="mb-3">
                        <i class="fas fa-lock prefix grey-text"></i>
                        <label for="password" class="col-form-label">Contraseña:</label>
                        <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>">
                        <span class="invalid-feedback"><?php echo $password_err; ?></span>
                    </div>
            </div>
            <div class="modal-footer d-flex justify-content-center">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <!-- <button type="button" class="btn btn-primary">Send message</button> -->
                <input type="submit" class="btn btn-primary" value="Login">
                </form>
            </div>
        </div>
    </div>
    <!-- Fin Modal Login -->

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script type="text/javascript" src="js/mainFunctions.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"></script>

</html>