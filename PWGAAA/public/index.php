<?php
//Verificar si hay una sesión activa para no volver a arrancarla, evitar "errores" de noticias
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
require_once __DIR__ . '/../app/controllers/IndexController.php';

$controller = new TfgController();
$controller->index();