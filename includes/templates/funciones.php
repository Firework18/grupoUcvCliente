<?php
function estaAutenticado() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    return isset($_SESSION['login']) && $_SESSION['login'];
}
?>
