<?php
// editarTfg.php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__.'/../app/controllers/CorrectionController.php';


$controller = new CorrectionController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller->actualizar();
} else {
    $controller->editar();
}
?>
