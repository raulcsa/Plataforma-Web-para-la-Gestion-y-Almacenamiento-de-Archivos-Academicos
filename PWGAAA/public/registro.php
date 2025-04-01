<?php
session_start();
require_once __DIR__ . '/../app/controllers/UsuarioController.php';


$usuarioController = new UsuarioController();
$usuarioController->registrar();
