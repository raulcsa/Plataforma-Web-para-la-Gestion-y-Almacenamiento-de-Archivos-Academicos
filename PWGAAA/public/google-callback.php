<?php
require_once __DIR__ . '/../app/google-config.php';
use Google\Service\Oauth2;
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (isset($_GET['code'])) {
    $token = $googleClient->fetchAccessTokenWithAuthCode($_GET['code']);

    if (isset($token['error'])) {
        die('Error al obtener el token de acceso: ' . htmlspecialchars($token['error_description'] ?? $token['error']));
    }
    
    $googleClient->setAccessToken($token);
    
    $google_oauth = new Oauth2($googleClient);
    $google_account_info = $google_oauth->userinfo->get();
    

    $email = $google_account_info->email;
    $name = $google_account_info->name;

    // Buscar en tu base de datos si ya existe este email
    require_once __DIR__ . '/../app/models/usuario.php';
    $usuario = Usuario::obtenerPorEmail($email);
    if ($usuario) {
        // Login
        $_SESSION['usuario'] = $usuario;
    } else {
        // Registro automático con rol alumno por defecto (puedes ajustar esto)
        Usuario::registrarDesdeGoogle($name, $email);
        $_SESSION['usuario'] = Usuario::obtenerPorEmail($email);
    }

    header('Location: index');
    exit;
} else {
    echo "Error al autenticar con Google.";
}
