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
require_once "../config.php";

// Define variables and initialize with empty values
$usuCorreo = $usuPassword = "";
$username_err = $password_err = $login_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Check if username is empty
    if (empty(trim($_POST['username']))) {
        $username_err = "Please enter username.";
    } else {
        $usuCorreo = trim($_POST['username']);
    }

    // Check if password is empty
    if (empty(trim($_POST['password']))) {
        $password_err = "Please enter your password.";
    } else {
        $usuPassword = trim($_POST['password']);
    }

    // Validate credentials
    if (empty($username_err) && empty($password_err)) {
        // Prepare a select statement
        $sql = "SELECT idUsuario, usuCorreo, usuPassword FROM usuario WHERE usuCorreo = ?";

        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            // Set parameters
            $param_username = $usuCorreo;

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Store result
                mysqli_stmt_store_result($stmt);

                // Check if username exists, if yes then verify password
                if (mysqli_stmt_num_rows($stmt) == 1) {
                    echo "Estoy encontrando resultados de la consulta";
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $idUsuario, $usuCorreo, $hashed_password);
                    if (mysqli_stmt_fetch($stmt)) {

                        if (password_verify($usuPassword, $hashed_password)) {
                            echo "Estoy entrando a la validación de la password";
                            // Password is correct, so start a new session
                            session_start();

                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $idUsuario;
                            $_SESSION["username"] = $usuCorreo;

                            // Redirect user to welcome page
                            header("location: ../User/index.php");
                        } else {
                            // Password is not valid, display a generic error message
                            $login_err = "Invalid username orrr password.";
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
    <link rel="stylesheet" type="text/css" href="../css/styles.css">

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
                <img style="width: 40px; height: 30px;" class="img img-busqueda" src="../img/busqueda.png" alt="">
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
                <a href="#" class="nav_link active" data-bs-toggle="modal" data-bs-target="#registerModal"> <i class='bx bx-grid-alt nav_icon'></i><span class="nav_name">Registrarse</span> </a>
                <a href="#" class="nav_link"> <i class='bx bx-user nav_icon'></i> <span class="nav_name">Comunidad Assist</span> </a>
                <a href="#" class="nav_link">
            </div>
        </div>
        <a href="logout.php" class="nav_link"> <i class='bx bx-log-out nav_icon'></i> <span class="nav_name">Cerrar sesión</span> </a>
    </nav>
</div>
<!--Container Main start-->
<div class="height-100 bg-light">
    <div class="container">
        <div class="row mt-4 d-flex justify-content-start">

            <?php
            $query = "SELECT t.idTema, t.idUsuario, CONCAT(u.usuNombres, \" \", u.usuApellidos) AS nombres, r.tipoRol, t.tituloTema, t.describeTema, DATE_FORMAT(t.created_at, \"%M %d de %Y\") AS fecha
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
                                <h6><strong>Publicado por: <?php echo $row['nombres'] ?> (<?php echo $row['tipoRol'] ?>)</strong></h6>
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
                                            <input type="image" src="../img/agregar.png" style="width: 20px; height: 15px;">
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
                                            <input type="image" src="../img/agregar.png" style="width: 20px; height: 15px;">
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
                          $queryComentario = "SELECT c.idComentario, c.idTema, c.idUsuario, CONCAT(u.usuNombres, \" \", u.usuApellidos) AS nombres, c.describeComentario, DATE_FORMAT(c.created_at, \"%M %d de %Y\") AS fecha
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
                                        <img class="img-user img-fluid" src="../img/user.png" alt="">
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
                                                <img style="width: 20px; height: 15px;" src="../img/agregar.png" alt="">
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
                                                <img style="width: 20px; height: 15px;" src="../img/agregar.png" alt="">
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

<!--Modal Register -->
<div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
           <div class="modal-content">
              <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>Nombres</label>
                <input type="text" name="nombres" class="form-control">
                <span class="invalid-feedback"><?php //echo $username_err; ?></span>
            </div>
            <div class="form-group">
                <label>Apellidos</label>
                <input type="text" name="apellidos" class="form-control" value="">
                <span class="invalid-feedback"><?php //echo $username_err; ?></span>
            </div>
            <div class="form-group">
                <label>Correo</label>
                <input type="text" name="username" class="form-control <?php //echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php // echo $username; ?>">
                <span class="invalid-feedback"><?php // echo $username_err; ?></span>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control <?php //echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php // echo $password; ?>">
                <span class="invalid-feedback"><?php // echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control <?php //echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" value="<?php // echo $confirm_password; ?>">
                <span class="invalid-feedback"><?php // echo $confirm_password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <input type="reset" class="btn btn-secondary ml-2" value="Reset">
            </div>
            <p>Already have an account? <a href="login.php">Login here</a>.</p>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
         </div>
       </div>
    </div>
    <!-- Fin Modal Register -->

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
                        <label for="correo usuario" class="col-form-label">Correo:</label>
                        <input type="text" name="username" class="form-control" <?php echo $usuCorreo; ?>>
                        <span class="invalid-feedback"><?php echo $username_err; ?></span>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="col-form-label">Contraseña:</label>
                        <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>">
                        <span class="invalid-feedback"><?php echo $password_err; ?></span>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <!-- <button type="button" class="btn btn-primary">Send message</button> -->
                <input type="submit" class="btn btn-primary" value="Login">
                </form>
            </div>
        </div>
    </div>
    <!-- Fin Modal Login -->

    



    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script type="text/javascript" src="../js/mainFunctions.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"></script>

</html>