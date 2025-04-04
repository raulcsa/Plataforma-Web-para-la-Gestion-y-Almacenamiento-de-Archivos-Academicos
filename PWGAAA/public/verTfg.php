<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once __DIR__ . '/../app/controllers/IndexController.php';
// O si tu controlador se llama TfgController, ajusta el require accordingly

$controller = new TfgController();
$controller->verDetalle();
