<?php

session_start();

// Guardar el ID de usuario en una variable antes de limpiar la sesión
$idUsuario = isset($_SESSION['id']) ? $_SESSION['id'] : null;

// Eliminar todas las variables de sesión
$_SESSION = [];

// Destruir la sesión
session_destroy();

// Actualizar el estado de conexión en la base de datos a 0
if ($idUsuario !== null) {
    require 'includes/config/database.php';
    $db = conectarDB();
    $queryUpdate = "UPDATE usuarios_new SET conectado = 0 WHERE id = $idUsuario";
    mysqli_query($db, $queryUpdate);
}

// Redirigir al usuario a la página de inicio de sesión
header('Location: /grupoUCV/login.php');