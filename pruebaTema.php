<?php
require_once "config.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <link rel="stylesheet" type="text/css" href="css/styles.css">
</head>
<body>
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
                <form action="crearTema.php" method="POST" >
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
</body>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script type="text/javascript" src="js/mainFunctions.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"></script>

</html>