<?php
require_once 'config.php';

$status = $statusMsg = '';
session_start();

// Check if the user is already logged in, if yes then redirect him to welcome page
if ($_SESSION["id"] == null) {
    echo 'entra a la validación de sesion';
    print($_SESSION["id"]);
    header("location: index.php");
    die();
} else {
    // $ifImage = $_FILES['image']["tmp_name"];
    if (isset($_POST["submit"])) {

        $idUsuario = $_SESSION['id'];

        if (!empty($_FILES["image"]["name"])) {
            // Get file info
            $fileName = basename($_FILES["image"]["name"]);
            $fileType = pathinfo($fileName, PATHINFO_EXTENSION);

            // Allow certain file formats
            $allowTypes = array('jpg', 'png', 'jpeg', 'gif');
            if (in_array($fileType, $allowTypes)) {
                $image = $_FILES['image']['tmp_name'];
                $imgContent = addslashes(file_get_contents($image));

                // Get Image Dimension
                $fileinfo = @getimagesize($_FILES["image"]["tmp_name"]);
                $width = $fileinfo[0];
                $height = $fileinfo[1];

                if (($_FILES["image"]["size"] < 1000000)) {

                    if ($width <= "400" || $height <= "400") {

                        // Insert image content into database
                        $update = mysqli_query($link, "UPDATE usuario u SET u.usuImagen = '$imgContent' WHERE u.idUsuario = '$idUsuario';");

                        if ($update) {
                            $response = array(
                                "type" => "success",
                                "message" => "La imagen se ha actualizado correctamente.",
                            );
                        } else {
                            $response = array(
                                "type" => "error",
                                "message" => "",
                            );
                            $statusMsg = "No se pudo cargar el archivo, intente nuevamente.";
                        }
                    } else {

                        $response = array(
                            "type" => "error",
                            "message" => "La dimensión de la imagen debe estar dentro de 400x400",
                        );

                    }
                } else {
                    $response = array(
                        "type" => "error",
                        "message" => "El tamaño de la imagen supera 1 MB.",
                    );
                }

            } else {
                $response = array(
                    "type" => "error",
                    "message" => "Lo sentimos, solo se pueden cargar archivos JPG, JPEG, PNG y GIF.",
                );
            }
        } else {
            $response = array(
                "type" => "error",
                "message" => "Seleccione un archivo de imagen para cargar.",
            );
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="css/styles.css">

    <title>Perfil</title>
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
                <a href="./User/index.php" type="button" class="btn text-light btn-nav">Temas</a>
                <a href="actividad.php" type="button" class="btn text-light btn-nav">Actividad Reciente</a>
                <a href="comentario.php" type="button" class="btn text-light btn-nav">Comentarios</a>
            </div>

            <div class="col-md-6 col-sm- 4 d-flex align-items-center justify-content-end">
                <i class='bx bx-search bx-sm' style='color:#fffbfb'></i>&nbsp;&nbsp;&nbsp;
                <input type="text" style="background-color: rgb(7, 26, 57); border: 0;" class="input-busqueda text-light" placeholder="Búsqueda">
            </div>
        </div>
    </div>
</header>
<body>
<?php
$idUsuario = $_SESSION['id'];

$queryUser = mysqli_query($link, "SELECT u.idUsuario, CONCAT(u.usuNombres,\" \",u.usuApellidos) AS nombres, u.usuNombres, r.idRol, r.tipoRol, u.usuCorreo, u.usuImagen, DATE_FORMAT(u.created_at, \"%M de %Y\") as fecha
    FROM usuario u
    INNER JOIN rol r ON u.idRol = r.idRol
    WHERE u.idUsuario = '$idUsuario'");
$rowUser = mysqli_fetch_array($queryUser);
$rol = $rowUser['idRol'] == 1 ? 'Administrador' : 'Usuario';
?>
<div class="l-navbar" id="nav-bar">
    <nav class="nav">
            <div class="nav_list">
            <div class="">
            <img class="imgLogo" style="margin-left: 0.6rem; margin-bottom: 1rem; border-radius: 50%;" src="img/logo.jpg" width="27%" height="17%" alt="">
            </div>
            <div style="column-gap: 2rem;width: 1.5rem; height: 1.6rem; margin-left: 1.5rem;" class="d-flex mb-4">
            <?php
if ($rowUser['usuImagen'] != null) {
    ?>
                            <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($rowUser['usuImagen']); ?>" style="object-fit: cover; object-position: center; border:1px solid #ffff;" width="100%" height="100%" class="rounded-circle" alt="Imagen de usuario">
                    <?php
} else {?>
                        <img src="img/user.png"  style="object-fit: cover; object-position: center; border:1px solid #ffff;" width="100%" height="100%" class="rounded-circle" alt="Imagen de usuario">
                    <?php
}
?>
            <a href="perfil.php" class="d-flex" >
                <span class="nav_logo-name">Perfil</span>
            </a>
            </div>
                <a href="#" class="nav_link active"> <i class='bx bx-grid-alt nav_icon'></i><span class="nav_name">Notificaciones</span> </a>
                <a href="./comunidadAssist.php" class="nav_link"> <i class='bx bx-user nav_icon'></i> <span class="nav_name">Comunidad Assist</span> </a>
                <a href="#" class="nav_link">
            </div>

        <a href="logout.php" class="nav_link"> <i class='bx bx-log-out nav_icon'></i> <span class="nav_name">Cerrar sesión</span> </a>
    </nav>
</div>
<div class="height-100 bg-light">
    <div class="container">
        <div class="row">
        </div>
        <div class="row d-flex justify-content-center">
        <div class="card perfil-info mt-4" style="width: 50rem;">
            <?php
if (!empty($response)) {?>
                    <div class="response perfil-<?php echo $response["type"]; ?> mt-2 text-center">
                        <?php echo $response["message"]; ?>
                    </div>
            <?php }?>
            <div class="col-md-12">
                <div class="d-flex justify-content-center mt-4">
                <div class="d-flex justify-content-center mt-4" style="width: 6rem; height: 6rem;">
                    <?php
if ($rowUser['usuImagen'] != null) {
    ?>
                            <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($rowUser['usuImagen']); ?>" style="object-fit: cover; object-position: center;" width="100%" height="100%" class="img-thumbnail img-perfil rounded-circle" alt="Imagen de usuario">
                    <?php
} else {?>
                        <img src="img/user.jpeg"  style="object-fit: cover; object-position: center;" width="100%" height="100%" class="img-thumbnail img-perfil rounded-circle" alt="Imagen de usuario">
                    <?php
}
?>
                </div>
                </div>
            </div>
                <div class="card-body">
                    <h2 class="card-title text-center mb-4"><b><?php echo $rowUser['usuNombres'] ?></b></h2>
                    <div class="row">
                        <div class="col-sm-12 col-md-6 mt-2">
                            <h6 class="text-center"><b>Tipo de usuario:</b></h6>
                            <hr>
                            <p class="text-center"><?php echo $rol ?></p>
                            <hr>
                        </div>
                        <div class="col-sm-12 col-md-6 mt-2">
                            <h6 class="text-center"><b>Correo:</b></h6>
                            <hr>
                            <p class="text-center"><?php echo $rowUser['usuCorreo'] ?></p>
                            <hr>
                        </div>
                        <div class="col-sm-12 col-md-12 mt-2">
                            <p class="text-muted text-center">Miembro de la Comunidad Assist desde <?php echo $rowUser['fecha'] ?></p>
                        </div>
                        <div class="col-md-12 mt-4">
                        <form id="uploadImage" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" enctype="multipart/form-data">
                                <div class="row mt-2">
                                    <div class="col-md-6 d-flex justify-content-end">
                                        <input type="file" id="image" name="image" class="form-control" >
                                    </div>
                                    <div class="col-md-6 d-flex justify-content-center">
                                        <input type="submit" id="btnSubmit" name="submit" class="btn btn-danger" value="Actualizar imagen">
                                    </div>
                                </div>
                        </form>
                        </div>
                    </div>
                </div>
    </div>
        </div>
    </div>
</div>
</body>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
        <script type="text/javascript" src="js/mainFunctions.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"></script>

</html>