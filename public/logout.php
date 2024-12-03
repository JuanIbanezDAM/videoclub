
<?php

// Recuperar la sesión
session_start();

// Destruir la sesion y redirigir al formulario
unset($_SESSION['sesion_usuario']);
header("Location: index.php");
