<?php

use Videoclub\Modelos\Videoclub;

//Autoload
require_once realpath('../vendor/autoload.php');

session_start();

if (isset($_POST["crear"])) {
    $nombre = $_POST["nombre"];
    $pass = $_POST["pass"];
    $maxAlquileres = $_POST["maxAlquileres"];

    if (empty($nombre) || empty($pass)) {
        $error = "No ha rellenado los campos correctamente.";
        include "index.php";
        exit;
    }

    $vc = $_SESSION['sesion_videoclub'];

    $vc->incluirSocio($nombre, $pass, $maxAlquileres);
    $_SESSION['sesion_videoclub'] =  $vc;

    header("Location: mainAdmin.php");
}
