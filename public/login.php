<?php

use Videoclub\Modelos\Videoclub;

//Autoload
require_once realpath('../vendor/autoload.php');

// Cargar la sesion del videoclub o si no existe, crear una vacia con admin y usuario.
session_start();
if (empty($_SESSION['sesion_videoclub'])) {
    $vc = new Videoclub("miVideo");
    $vc->incluirSocio("admin", "admin");
    $vc->incluirSocio("usuario", "usuario");
    $vc->incluirCintaVideo("Los cazafantasmas", 3.5, 107);
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

    // Comprobar las credenciales con la lista de socios del videoclub
    $socioEncontrado = null; // Si algun usuario coincide lo guardaremos en esta variable
    foreach ($vc->getSocios() as $socio) {
        if ($socio->getUser() === $usuario && $socio->getPassword() === $pass) {
            $socioEncontrado = $socio;
            break;
        }
    }

    // Redirigir a mainAdmin, mainUsuario o mostrar error
    if ($socioEncontrado) {
        // Crear la sesion del usuario y guardar sus datos
        session_start();
        $_SESSION['sesion_usuario'] = $socioEncontrado;

        if ($socioEncontrado->getUser() === "admin") {
            header("Location: mainAdmin.php");
        } else {
            header("Location: mainCliente.php");
        }
    } else {
        $error = "Usuario o contraseña incorrectos.";
        include "index.php";
    }
}
