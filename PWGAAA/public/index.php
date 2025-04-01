<?php
session_start();
require_once __DIR__ . '/../app/controllers/IndexController.php';

$controller = new TfgController();
$controller->index();