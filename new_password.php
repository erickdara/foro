<?php $token = $_GET['token']; 
session_start();
$_SESSION['token'] = $token;
// var_dump($_SESSION['token']);
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css">
        <title>Restablecimiento de contraseña</title>
        <link rel="stylesheet" href="./css/styles.css">
    </head>
        <body>
            <div class="row d-flex justify-content-center">
                <div class="col-md-6">
                    <div class="card">
                        <form action="reset_password.php" class="login-form" method="post">
                            <div class="card-header">
                                <h2 class="card-tittle">Restablecer contraseña</h2>
                            </div>
                            <!-- Form validation messages -->
                            <div class="mb-3 mt-4 ms-2 px-2">
                                <label class="form-label" for="">Nueva contraseña</label>
                                <input type="password" class="form-control" name="new_pass" id="password">
                                <span><small class="text-danger" id="passcheck"></small></span>
                            </div>
                            <div class="mb-3 ms-2 px-2">
                                <label class="form-label">Confirmar nueva password</label>
                                <input class="form-control" type="password" name="new_pass_c" id="conpassword">
                                <span><small class="text-danger" id="conpasscheck"></small></span>
                            </div>
                            <div class="mb-3 ms-4">
                                <input type="submit" name="new_password" class="login-btn btn btn-success" value="Enviar">
                                <!-- <button type="submit" name="new_password" class="login-btn">Enviar</button> -->
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
        </body>
            <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
            <script type="text/javascript" src="js/mainFunctions.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
</html>