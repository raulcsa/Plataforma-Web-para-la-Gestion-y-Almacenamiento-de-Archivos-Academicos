<?php
session_start();
require_once __DIR__ . '/../app/controllers/TfgController.php';

$controller = new TfgController();
$controller->index();

