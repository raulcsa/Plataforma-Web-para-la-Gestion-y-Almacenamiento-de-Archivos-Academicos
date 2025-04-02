<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../app/controllers/LoginController.php';

$controller = new LoginController();
$controller->login();
