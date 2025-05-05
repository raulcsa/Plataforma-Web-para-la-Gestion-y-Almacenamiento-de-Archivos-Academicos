<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once __DIR__ . '/../app/mailer.php'; // Ajusta si lo pusiste en otra ruta

try {
    enviarCorreo(
        'ser.buenoro@gmail.com',               // Cambia esto por tu correo real
        '📬 Prueba de correo desde PWGAAA',
        '<p>Este es un correo de prueba enviado desde <strong>PWGAAA</strong> usando PHPMailer.</p>'
    );
    echo "Correo enviado correctamente.";
} catch (Exception $e) {
    echo "Error al enviar el correo: " . $e->getMessage();
}
