
<?php

// Recuperar la sesión
session_start();

// Destruir la sesion del usuario y redirigir al formulario de inicio de sesion
unset($_SESSION['sesion_usuario']);
header("Location: index.php");
