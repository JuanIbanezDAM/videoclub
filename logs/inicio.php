<?php

//Autoload no va

use Videoclub\Modelos\Cliente;
use Videoclub\Modelos\Videoclub;
use Videoclub\HolaMonolog;

require_once __DIR__ . '/../vendor/autoload.php';

//Pruebas del monolog
$logger = new HolaMonolog(10);

$logger->saludar();
$logger->despedir();

//Prueba de videoclub
$vc = new Videoclub("miVideo");
$vc->incluirSocio("prueba", "prueba123", 3);

$vc->incluirCintaVideo("Taxi driver", 4, 120);
$vc->incluirCintaVideo("Blade runner", 4, 120);
$vc->incluirCintaVideo("Madagascar", 4, 120);
$vc->incluirCintaVideo("Algo", 4, 120);

$vc->listarSocios();
$vc->listarProductos();

$vc->alquilaSocioProducto(1, 1);
$vc->alquilaSocioProducto(1, 2);
$vc->alquilaSocioProducto(1, 3);

// Excepcion cupo de alquileres superado
/* $vc->alquilaSocioProducto(1, 4); */
