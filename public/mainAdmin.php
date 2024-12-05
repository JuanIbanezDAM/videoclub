<?php

//Autoload
require_once realpath('../vendor/autoload.php');

//Cargamos la sesion
if (!isset($_SESSION)) {
    session_start();
}

// Comprobar que el usuario se haya autentificado 
if (empty($_SESSION['sesion_usuario'])) {
    die("<a href='index.php'> Error, debe identificarse.</a><br />");
}

// Cargamos la sesion del videoclub y la del usuario
$vc = $_SESSION['sesion_videoclub'];
$usuario = $_SESSION['sesion_usuario'];
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main Admin</title>
</head>

<body>
    <!-- Bienvenida de la página  -->
    <h1>Pagina principal!!!!</h1>
    <p>Bienvenido <?php echo $usuario->nombre; ?>, para cerrar sesion pulse aqui <a href="logout.php">cerrar sesion.</a></p>

    <!-- Opciones del administrador -->
    <p><a href="formCreateCliente.php">crear usuario</a></p>
    <p><a href="formUpdateCliente.php">editar usuario</a></p>
    <p><a href="#" id="btonDeleteCliente">eliminar usuario</a></p>

    <!-- Mostrar información de todos los productos y clientes -->
    <?php
    echo "Lista de productos" . "<br>";
    $vc->listarProductos();

    echo "Lista de clientes" . "<br>";
    $vc->listarSocios();
    ?>


    <!-- Script que lanza una alerta de confirmacion para eliminar un cliente -->
    <script>
        const elementBtnEliminarCliente = document.getElementById('btonDeleteCliente');

        elementBtnEliminarCliente.addEventListener("click", function() {
            if (window.confirm("Seguro que deseas eliminar el usuario?")) {
                location.href = "deleteCliente.php";
            }
        });
    </script>

</body>

</html>