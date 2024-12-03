<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio de inicio de sesion</title>
</head>

<body>

    <!-- Mensaje de error al iniciar sesion -->
    <div><span><?php echo $error ?? ""; ?></span></div>

    <!-- Formulario de inicio de sesion -->
    <form action="login.php" method="post">
        <div>
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