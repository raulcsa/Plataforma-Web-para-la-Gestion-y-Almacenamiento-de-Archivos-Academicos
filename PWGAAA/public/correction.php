<?php
require_once __DIR__ . '/../app/controllers/CorrectionController.php';
$ctrl = new CorrectionController();

$action = $_GET['action'] ?? 'calificar';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $action === 'validar') {
    $ctrl->validar();
} else {
    $ctrl->calificar();
}
