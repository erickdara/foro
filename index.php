<?php
// Initialize the session
session_start();

// Check if the user is already logged in, if yes then redirect him to welcome page
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: welcome.php");
    exit;
}

// Include config file
require_once "config.php";

// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = $login_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Check if username is empty
    if (empty(trim($_POST["username"]))) {
        $username_err = "Please enter username.";
    } else {
        $username = trim($_POST["username"]);
    }

    // Check if password is empty
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter your password.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Validate credentials
    if (empty($username_err) && empty($password_err)) {
        // Prepare a select statement
        $sql = "SELECT id, username, password FROM users WHERE username = ?";

        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            // Set parameters
            $param_username = $username;

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Store result
                mysqli_stmt_store_result($stmt);

                // Check if username exists, if yes then verify password
                if (mysqli_stmt_num_rows($stmt) == 1) {
                    echo "Estoy encontrando resultados de la consulta";
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                    if (mysqli_stmt_fetch($stmt)) {

                        if (password_verify($password, $hashed_password)) {
                            echo "Estoy entrando a la validación de la password";
                            // Password is correct, so start a new session
                            session_start();

                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;

                            // Redirect user to welcome page
                            header("location: welcome.php");

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
            mysqli_stmt_close($stmt);
        }
    }

    // Close connection
    mysqli_close($link);
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

    <title>Foro ASSIST</title>
</head>
    <header class="header" id="header">
        <div class="row">
            <div class="col-md-12">
                <div class="header_toggle"> <i class='bx bx-menu' id="header-toggle"></i> </div>
                <h1 id="title"><span style="color:red;">BIENVENIDO AL</span> <span style="color: white;">FORO ASSIST</span></h1>
                <!-- <div class="header_img"> <img src="https://i.imgur.com/hczKIze.jpg" alt=""> </div> -->
            </div>
            <div class="row">
                <div class="btn-group">
                    <div class="col-md-2 d-grid">
                        <button type="button" class="btn text-light btn-nav">Temas</button>
                    </div>
                    <div class="col-md-2 d-grid">
                        <button type="button" class="btn text-light btn-nav">Actividad Reciente</button>
                    </div>
                    <div class="col-md-2 d-grid">
                        <button type="button" class="btn text-light btn-nav">Comentarios</button>
                    </div>
                </div>
                <div class="col-md-2">
                    <img class="img img-busqueda" src="img/Busqueda.png" alt="">
                </div>
            </div>
        </div>
    </header>
    <div class="l-navbar" id="nav-bar">
        <nav class="nav">
            <div>
                <a href="#" class="nav_logo" data-bs-toggle="modal" data-bs-target="#exampleModal"> <i class='bx bx-layer nav_logo-icon'></i> <span class="nav_logo-name">Iniciar Sesion</span> </a>
                <div class="nav_list">
                    <a href="#" class="nav_link active"> <i class='bx bx-grid-alt nav_icon'></i>
                        <span class="nav_name">Registrarse</span> </a>
                    <a href="#" class="nav_link"> <i class='bx bx-user nav_icon'></i> <span class="nav_name">Comunidad Assist</span> </a>
                    <a href="#" class="nav_link"></div>
            </div>
            <a href="#" class="nav_link"> <i class='bx bx-log-out nav_icon'></i> <span class="nav_name">Comunidad
                    Assist</span> </a>
        </nav>
    </div>
    <!--Container Main start-->
    <div class="height-100 bg-light">
        <div class="container">
            <div class="row d-flex justify-content-end">
                <div class="col-md-5 mt-3 d-flex justify-content-end">
                    <div class="card info">
                        <div class="row card-body d-flex">
                            <div class="col num-commentary pt-2">
                                <h6 class="text-center titulo">COMENTARIOS</h6>
                                <h6 class="text-center text-light">####</h6>
                            </div>
                            <div class="col num-answer pt-2">
                                <h6 class="text-center titulo">RESPUESTAS</h6>
                                <h6 class="text-center text-light">####</h6>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-5 d-flex align-items-end justify-content-center">
                    <div class="row tema">
                        <div class="col-md-6 d-flex justify-content-end btn">
                            <img class="img img-add-tema" src="img/agregar.png" alt="">
                        </div>
                        <div class="col-md-6 d-flex justify-content-start align-items-end btn">
                            <h5 class="text-center text-add-tema text-nowrap">CREAR TEMA</h5>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4 d-flex justify-content-start">
                <div class="card tema-informacion">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-5 ">
                                <h6><strong>Publicado por: José Pérez (Administrador)</strong></h6>
                            </div>
                            <div class="col-7">
                                <p class="fs-6 text-muted">Fecha: Junio 31 de 2021</p>
                            </div>
                        </div>
                        <div class="row titulo titulo-tema">
                            <div class="col">
                                <h1><strong>Transformación digital en pandemia</strong></h1>
                            </div>
                        </div>
                        <div class="row cuerpo-tema mt-3">
                            <div class="col">
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eos odit modi ut, totam, dolorem magnam corporis qui doloribus eius optio cupiditate asperiores molestiae fugit. Temporibus id sit voluptatum ea perferendis nesciunt veritatis. Eius repellendus
                                perferendis ad! Quasi illo id, cupiditate rerum, ad quam adipisci amet blanditiis, vero minus facere voluptatum molestias provident ducimus? Quasi voluptatum a deleniti veritatis ipsa illo!
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-md-4">
                                <p style="color: rgb(7, 26, 57); font-size: 12px;"><b>Comentarios del tema: 1 comentario</b></p>
                            </div>
                            <div class="col-md-3 d-flex justify-content-between" style="font-size: 12px;">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <button class="btn-outline-light">
                                            <img style="width: 20px; height: 15px;" src="img/agregar.png" alt="">
                                        </button>
                                    </div>
                                    <div>
                                        <b><p class="text-nowrap" style="color: rgb(0, 253, 93);">Me gusta:1</p></b>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <button class="btn-outline-light">
                                            <img style="width: 20px; height: 15px;" src="img/agregar.png" alt="">
                                        </button>
                                    </div>
                                    <div>
                                        <b><p class="text-nowrap" style="font-size: 12px; color: rgb(255, 22, 22);">No me gusta:0</p></b>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="d-flex justify-content-center">
                                    <div class="d-flex justify-content-between">
                                        <img style="width: 20px; height: 15px;" src="img/agregar.png" alt="">
                                        <b><p class="text-nowrap text-muted" style="font-size: 12px;">Vistas:12</p></b>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 d-grid">
                                <button class="btn btn-vermas" type="button" data-bs-toggle="collapse" data-bs-target="#collapseComentarios" aria-expanded="false" aria-controls="collapseExample"><b>VER MÁS</b></button>
                            </div>
                        </div>
                        <div class="row collapse titulo-comentario mt-3" id="collapseComentarios">
                            <div class="col-md-12 mt-3">
                                <h5><b>Comentarios anteriores</b></h5>
                            </div>
                            <div class="row d-flex justify-content-between mt-4">
                                <div class="col-md-3 mt-2 d-flex justify-content-center">
                                    <div>
                                        <img class="img-user img-fluid" src="img/user.png" alt="">
                                    </div>
                                </div>
                                <div class="col-md-9 container-commentary">
                                    <p class="mt-2">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Numquam explicabo omnis pariatur nostrum exercitationem beatae odit, dolorem, ad at ipsa magnam iure ab et ipsam saepe, odio similique recusandae distinctio?
                                        Aut reiciendis perspiciatis delectus voluptatibus voluptatum doloribus excepturi iusto quod libero, eos praesentium enim placeat at deleniti voluptas nisi suscipit? Architecto molestias laboriosam error vero alias
                                        perferendis neque exercitationem illum.</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 d-flex justify-content-around">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <button class="btn-outline-light">
                                                <img style="width: 20px; height: 15px;" src="img/agregar.png" alt="">
                                            </button>
                                        </div>
                                        <div>
                                            <b><p class="text-nowrap" style="font-size: 12px; color: rgb(0, 253, 93);">Me gusta:1</p></b>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <button class="btn-outline-light">
                                                <img style="width: 20px; height: 15px;" src="img/agregar.png" alt="">
                                            </button>
                                        </div>
                                        <div>
                                            <b><p class="text-nowrap" style="font-size: 12px; color: rgb(255, 22, 22);">No me gusta:0</p></b>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-8 d-flex justify-content-end">
                                    <button class="btn btn-vermas">
                                        responder comentario
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
            <label for="correo usuario" class="col-form-label">Correo:</label>
            <input type="text" name="username" class="form-control<?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
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
<script type="text/javascript" src="js/mainFunctions.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"></script>

</html>