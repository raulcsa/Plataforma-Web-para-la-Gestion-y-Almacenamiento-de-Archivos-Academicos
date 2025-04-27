<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/vendor/autoload.php';

/**
 * Envía un correo utilizando PHPMailer.
 *
 * @param string $to Destinatario.
 * @param string $subject Asunto del correo.
 * @param string $body Contenido HTML del correo.
 * @param array  $attachments Array de rutas a archivos adjuntos (opcional).
 */
function sendEmail(string $to, string $subject, string $body, array $attachments = []): void {
    $mail = new PHPMailer(true);
    try {
        // Configuración del servidor SMTP
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = false;
        $mail->Username   = 'pwgavisos@gmail.com';
        $mail->Password   = 'ixju yykf zmuo rvrc';
        //$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        // Remitente y destinatario
        $mail->setFrom('pwgavisos@gmail.com', 'TFG App');
        $mail->addAddress($to);

        // Adjuntos
        foreach ($attachments as $filePath) {
            $mail->addAttachment($filePath);
        }

        // Contenido
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $body;

        $mail->send();
    } catch (Exception $e) {
        error_log('Mailer Error: ' . $mail->ErrorInfo);
    }
}