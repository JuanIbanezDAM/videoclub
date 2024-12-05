<?php

//Autoload
require_once realpath('../vendor/autoload.php');

// Cargar la sesion del videoclub
session_start();
$vc = $_SESSION['sesion_videoclub'];

// Eliminar al cliente de la sesion y volver a guardarla
$vc->eliminarSocio($_SESSION['sesion_usuario']);
$_SESSION['sesion_videoclub'] =  $vc;

// Regiridir a login
header("Location: index.php");
