<?php
require_once __DIR__ . '/../app/controllers/ProyectosCalificadosController.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$controller = new ProyectosCalificadosController();
$controller->index();
?>
