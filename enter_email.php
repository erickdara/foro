
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css">
    <title>Restablecer Contraseña</title>
    <link rel="stylesheet" href="./css/styles.css">
</head>
<body>
    

   <div class="row d-flex justify-content-center">
       <div class="col-md-6">
        <div class="card">
            <form class="login-form" action="reset_password.php" method="POST">
                    <div class="card-header">
                    <h2 class="card-tittle">Restablecer Contraseña</h2>
                    <!-- form validation messages -->
                    </div>
                    <div class="mb-3 p-4">
                        <label for="exampleInputEmail1" class="form-label">Su dirección de correo electronico</label>
                        <input type="email" name="email" class="form-control">
                    </div>
                    <div class="mb-3 ms-4">
                        <input type="submit" name="reset-password" class="btn btn-success login-btn" value="Enviar">
                        &nbsp;
                        <a href="index.php" class="btn btn-danger">Volver al inicio</a>
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