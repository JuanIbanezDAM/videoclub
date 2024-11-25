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
$vc = new Videoclub("Severo 8A");

//Soportes
$soporte1 = new Juego("God of War", 19.99, "PS4", 1, 1);
$soporte2 = new Juego("The Last of Us Part II", 49.99, "PS4", 1, 1);
$soporte3 = new Dvd("Torrente", 4.5, "es", "16:9");
$soporte4 = new Dvd("Origen", 4.5, "es,en,fr", "16:9");
$soporte5 = new Dvd("El Imperio Contraataca", 3, "es,en", "16:9");
$soporte6 = new CintaVideo("Los cazafantasmas", 3.5, 107);
$soporte7 = new CintaVideo("El nombre de la Rosa", 1.5, 140);

//Socios
$cliente1 = new Cliente("Paco");
$cliente1->alquilar($soporte6)->alquilar($soporte1)->alquilar($soporte2);

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
    <p>Bienvenido <?php echo $_SESSION['sesion_usuario']; ?>, para cerrar sesion pulse aqui,  <a href="logout.php">cerrar sesion.</a></p>
    <p><a href="logout.php">crear usuario</a></p>
    <p><a href="logout.php">editar usuario</a></p>
    <p><a href="logout.php">eliminar usuario</a></p>
    
    <?php
    echo "Lista de productos alquilados" . "<br>";
    $cliente1->listaAlquileres();
    ?>

</body>

</html>