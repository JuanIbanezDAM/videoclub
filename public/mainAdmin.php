<?php

use Videoclub\Modelos\Cliente;
use Videoclub\Modelos\Videoclub;
use Videoclub\Modelos\Soportes\CintaVideo;
use Videoclub\Modelos\Soportes\Dvd;
use Videoclub\Modelos\Soportes\Juego;

require_once realpath('../vendor/autoload.php');

if (!isset($_SESSION)) {
    session_start();
}

// Y comprobamos que el usuario se haya autentificado
if (empty($_SESSION['sesion_usuario'])) {
    die("<a href='index.php'> Error, debe identificarse.</a><br />");
}

//Videoclub
$vc = $_SESSION['sesion_videoclub'];
$usuario = $_SESSION['sesion_usuario'];

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

    <h1>Pagina principal!!!!</h1>
    <p>Bienvenido <?php echo $usuario->nombre; ?>, para cerrar sesion pulse aqui  <a href="logout.php">cerrar sesion.</a></p>
    <p><a href="logout.php">crear usuario</a></p>
    <p><a href="logout.php">editar usuario</a></p>
    <p><a href="logout.php">eliminar usuario</a></p>

    <?php
    echo "Lista de productos" . "<br>";
    $vc->listarProductos();
    echo "Lista de clientes" . "<br>";
    $vc->listarSocios();
    ?>

</body>

</html>