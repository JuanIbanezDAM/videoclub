<?php

if (!isset($_SESSION)) {
    session_start();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario cliente</title>
</head>

<body>
    <h1>Formulario de creación de usuario</h1>
    <form action="createCliente.php" method="post">
        <p>
            <label for="nombre">Nombre</label>
            <input type="text" name="nombre" require>
        </p>
        <p>
            <label for="pass">Contraseña</label>
            <input type="password" name="pass" require>
        </p>
        <p>
            <label for="maxAlquileres">Nº alquileres máximo</label>
            <input type="number" name="maxAlquileres" min=1 max=3 default=3>
        </p>
        <p>
            <input type="submit" name="crear" value="crear">
        </p>
    </form>
</body>

</html>