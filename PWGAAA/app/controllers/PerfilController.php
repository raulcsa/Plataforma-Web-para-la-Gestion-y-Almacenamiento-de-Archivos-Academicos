<?php
// /app/controllers/PerfilController.php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit;
}

// Asumimos que la información del usuario se guarda en la sesión.
// Si necesitas actualizar o recuperar datos adicionales, aquí podrías incluir el modelo usuario.
$user = $_SESSION['usuario'];

require_once __DIR__ . '/../views/PerfilView.php';
?>