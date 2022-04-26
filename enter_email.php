<?php include('config.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restablecer Contraseña</title>
    <link rel="stylesheet" href="./css/styles.css">
</head>
<body>
    <form class="login-form" action="reset_password.php" method="post">
        <h2 class="form-title">Restablecer Contraseña</h2>
        <!-- form validation messages -->
        <!-- -->
        <div class="form-group">
            <label for="">Su dirección de correo electronico</label>
            <input type="email" name="email" id="">
        </div>
        <div class="form-group">
            <button type="submit" name="reset-password" class="login-btn">Enviar</button>
        </div>
    </form>
    
</body>
</html>