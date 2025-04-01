<?php
session_start();
require_once __DIR__ . '/../app/controllers/IndexController.php';
// O si tu controlador se llama TfgController, ajusta el require accordingly

$controller = new TfgController();
$controller->verDetalle();
