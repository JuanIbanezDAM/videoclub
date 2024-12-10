<?php

//Autoload
require_once realpath('../vendor/autoload.php');

// Validar si se envió el formulario
if (isset($_POST["crear"])) {
    $nombre = $_POST["nombre"];
    $pass = $_POST["pass"];
    $maxAlquileres = (int) $_POST["maxAlquileres"] ?? 3;

    // Validar si los campos están vacíos, maxAlquileres si no se especifica por defecto sera 3
    if (empty($nombre) || empty($pass)) {
        $error = "No ha rellenado los campos correctamente.";
        include "formCreateCliente.php";
        exit;
    }

    // Cargar la sesion del videoclub
    session_start();
    $vc = $_SESSION['sesion_videoclub'];

    // Añadir el nuevo socio a la sesion y volver a guardarla
    $vc->incluirSocio($nombre, $pass, $maxAlquileres);
    $_SESSION['sesion_videoclub'] =  $vc;

    // Regiridir a mainAdmin
    header("Location: mainAdmin.php");
}
