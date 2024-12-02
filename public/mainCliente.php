<?php

require_once realpath('../vendor/autoload.php');

if (!isset($_SESSION)) {
    session_start();
}

// Comprobar que el usuario se haya autentificado 
if (empty($_SESSION['sesion_usuario'])) {
    die("<a href='index.php'> Error, debe identificarse.</a><br />");
}

// Cargamos la sesion del usuario
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
    <!-- Titulo de la página -->
    <h1>Pagina principal!!!!</h1>
    <p>Bienvenido <?php echo $usuario->nombre; ?>, para cerrar sesion pulse aqui <a href="logout.php">cerrar sesion.</a></p>

    <!-- Opciones del usuario -->
    <p><a href="formUpdateCliente.php">editar usuario</a></p>

    <!-- Mostrar la lista de alquileres edl cliente -->
    <?php
    echo "Lista de productos alquilados: " . "<br>";
    $usuario->listaAlquileres();
    ?>

</body>

</html>