<?php

//Autoload no va
/* require_once __DIR__ . '/vendor/autoload.php'; */
include("./HolaMonoLog.php");

//Pruebas del monolog
$logger = new HolaMonolog(10);

$logger->saludar();
$logger->despedir();