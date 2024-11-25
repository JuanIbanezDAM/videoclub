<?php

// Valida si se envio el formulario
if (isset($_POST["enviar"])) {
    $usuario = $_POST["usuario"];
    $pass = $_POST["pass"];
}

// Valida si se envio los campos vacios, si es admin o si es usuario.
if (empty($usuario) || empty($pass)) {
    $error = "No ha rellenado los campos corrctamente.";
    include "index.php";
} else if ($usuario === "admin" && $pass  === "admin") {
    session_start();
    $_SESSION['sesion_usuario'] = $usuario;
    header("Location: mainAdmin.php");
} else if ($usuario === "usuario" && $pass  === "usuario") {
    session_start();
    $_SESSION['sesion_usuario'] = $usuario;
    header("Location: mainCliente.php");
} else {
    $error = "No existe.";
    include "index.php";
}
