<?php

use Videoclub\Modelos\Cliente;
use Videoclub\Modelos\Videoclub;

//Autoload
require_once realpath('../vendor/autoload.php');

// Cargamos la sesion y los datos del usuario
session_start();
if (isset($_SESSION['sesion_usuario'])) {
    $usuario = $_SESSION['sesion_usuario'];
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario editar cliente</title>
</head>

<body>

    <!-- Titulo de la página -->
    <h1>Formulario para editar un usuario</h1>

    <!-- Mensaje de error al iniciar sesion -->
    <div><span><?php echo $error ?? ""; ?></span></div>

    <!-- Formulario de creacion de cliente-->
    <form action="updateCliente.php" method="post">
        <p>
            <label for="nombre">Nombre</label>
            <input type="text" name="nombre" value="<?php echo $usuario->user; ?>" require>
        </p>
        <p>
            <label for="pass">Contraseña</label>
            <input type="password" name="pass" require value="<?php echo $usuario->getPassword(); ?>">
        </p>
        <p>
            <label for="maxAlquileres">Nº alquileres máximo</label>
            <input type="number" name="maxAlquileres" min=1 max=3 value=<?php echo $usuario->getMaxAlquilerConcurrente(); ?>>
        </p>
        <p>
            <input type="submit" name="actualizar" value="actualizar">
        </p>
    </form>
</body>

</html>