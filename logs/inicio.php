<?php

//Autoload no va
/* require_once realpath('/vendor/autoload.php'); */
require_once realpath('../vendor/autoload.php');

include_once ("../logs/HolaMonolog.php");

use Videoclub\Modelos\Cliente;
use Videoclub\Modelos\Soportes\CintaVideo;

//Pruebas del monolog
/* $cliente = new Cliente("Luisa", "luisa123", 1);
$cinta1 = new CintaVideo("Los cazafantasmas 1", 3.5, 107);
$cinta2 = new CintaVideo("Los cazafantasmas 2", 5, 120);

$cliente->alquilar($cinta1)->alquilar($cinta2); */

$log = new HolaMonolog(12, "HolaMonolog");

$log->saludar();
