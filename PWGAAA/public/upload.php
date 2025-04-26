<?php
require_once __DIR__ . '/../app/controllers/UploadController.php';

$controller = new UploadController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller->procesarFormulario();
} else {
    $controller->mostrarFormulario();
}
?>