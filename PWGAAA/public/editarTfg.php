<?php
require_once __DIR__ . '/../app/controllers/CorrectionController.php';
$ctrl = new CorrectionController();

if ($_SERVER['REQUEST_METHOD']==='POST') {
    $ctrl->actualizar();
} else {
    $ctrl->editar();
}
