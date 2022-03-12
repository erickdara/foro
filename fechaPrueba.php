<?php
  include('config.php');
  include('utils.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php
    $queryTema = mysqli_query($link, "SELECT t.idTema, t.idUsuario, CONCAT(u.usuNombres, \" \", u.usuApellidos) AS nombres, t.tituloTema, t.describeTema, DATE_FORMAT(t.created_at, \"%d-%m-%Y %H:%i:%s\") AS fecha, likes, unlikes
    FROM tema t 
    INNER JOIN usuario u ON t.idUsuario = 2
    INNER JOIN rol r ON u.idRol = r.idRol
    where t.idTema = 15");

$rowTema = mysqli_fetch_array($queryTema);


?>
<?php 
$util = new Utils();
$unix = $util -> fechaunix($rowTema['fecha']);
echo "fecha: ".$rowTema['fecha'].'<br>'.$unix.'<br><br>';

$time = time();
echo $n = $time - $rowTema['fecha'];
?> 

<?php
    
?>
</body>
</html>