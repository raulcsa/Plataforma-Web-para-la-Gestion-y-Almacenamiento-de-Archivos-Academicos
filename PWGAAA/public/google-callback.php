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

    require_once __DIR__ . '/../app/models/usuario.php';
    $usuario = Usuario::obtenerPorEmail($email);

    if ($usuario) {
        // Ya existe, iniciar sesión
        $_SESSION['usuario'] = $usuario;
        header('Location: index');
    } else {
        // Nuevo usuario → registrar y mostrar mensaje de éxito
        Usuario::registrarDesdeGoogle($name, $email);
        $_SESSION['usuario'] = Usuario::obtenerPorEmail($email);
        header('Location: index?registro=ok');
    }
    exit;
} else {
    echo "Error al autenticar con Google.";
}
