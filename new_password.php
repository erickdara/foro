<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restablecimiento de contraseña</title>
    <link rel="stylesheet" href="./css/styles.css">
</head>
<body>
    <form action="reset_password.php" class="login-form" method="post">
        <h2 class="form-title">Nueva Contraseña</h2>
        <!-- Form validation messages -->
        
        <div class="form-group">
            <label for="">Nueva contraseña</label>
            <input type="password" name="new_pass" id="">
        </div>
        <div class="form-group">
			<label>Confirmar nuevo password</label>
			<input type="password" name="new_pass_c">
		</div>
        <div class="form-group">
            <button type="submit" name="new_password" class="login-btn">Enviar</button>
        </div>
    </form>
    
</body>
</html>