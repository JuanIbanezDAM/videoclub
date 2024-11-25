<?php

require_once realpath('../vendor/autoload.php');

if (!isset($_SESSION)) {
    session_start();
}

// Y comprobamos que el usuario se haya autentificado
if (empty($_SESSION['sesion_usuario'])) {
    die("<a href='index.php'> Error, debe identificarse.</a><br />");
}

//Cliente
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
    <p><a href="logout.php">editar usuario</a></p>

    <?php
    echo "Lista de productos alquilados: " . "<br>";
    $usuario->listaAlquileres();
    ?>

</body>

</html>