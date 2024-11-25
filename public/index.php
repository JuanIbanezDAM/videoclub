<?php

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio de inicio de sesion</title>
</head>

<body>
    <form action="login.php" method="post">
        <div>
            <div><span><?php echo $error ?? ""; ?></span></div>
            <label for="usuario">Usuario: </label>
            <input type="text" name="usuario">
        </div>

        <div>
            <label for="pass">Contraseña: </label>
            <input type="password" name="pass">
        </div>

        <div>
            <input type="submit" name="enviar" value="enviar">
        </div>
    </form>

</body>

</html>