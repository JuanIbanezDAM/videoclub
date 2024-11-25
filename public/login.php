<?php

use Videoclub\Modelos\Videoclub;

//Autoload
require_once realpath('../vendor/autoload.php');

// Cargar lista usuarios o crear una vacia.
session_start();

if (empty($_SESSION['sesion_videoclub'])) {
    $vc = new Videoclub("miVideo");
    $vc->incluirSocio("admin", "admin");
    $vc->incluirSocio("usuario", "usuario");
    $_SESSION['sesion_videoclub'] = $vc;
} else {
    $vc = $_SESSION['sesion_videoclub'];
}

// Validar si se envió el formulario
if (isset($_POST["enviar"])) {
    $usuario = $_POST["usuario"];
    $pass = $_POST["pass"];

    // Validar si los campos están vacíos
    if (empty($usuario) || empty($pass)) {
        $error = "No ha rellenado los campos correctamente.";
        include "index.php";
        exit;
    }

    // Comprobar las credenciales con la lista de socios
    $socioEncontrado = null;
    foreach ($vc->getSocios() as $socio) {
        if ($socio->getUser() === $usuario && $socio->getPassword() === $pass) {
            $socioEncontrado = $socio;
            break;
        }
    }

    // Redirigir según el rol o mostrar error
    if ($socioEncontrado) {
        session_start();
        $_SESSION['sesion_usuario'] = $socioEncontrado;
        if ($socioEncontrado->getUser() === "admin") {
            header("Location: mainAdmin.php");
        } else {
            header("Location: mainCliente.php");
        }
        exit;
    } else {
        $error = "Usuario o contraseña incorrectos.";
        include "index.php";
    }
}

