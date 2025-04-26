<?php
require_once __DIR__.'/../app/controllers/CorrectionController.php';

$controller = new CorrectionController();

$action = $_GET['action'] ?? 'listar'; // o lo que sea tu acción por defecto

switch ($action) {
    case 'calificar':
        $controller->calificar();
        break;
    case 'validar':
        $controller->validar();
        break;
    // otros cases...
    default:
        // Redirigir a algún sitio si no es válido
        header('Location: index.php');
        exit;
}
?>
