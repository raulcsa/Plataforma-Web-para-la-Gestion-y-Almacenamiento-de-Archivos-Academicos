<?php
/// app/mailer.php

require_once __DIR__ . '/../vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function enviarCorreo($para, $asunto, $cuerpoHTML): bool {
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'pwgaaa.tfg@gmail.com';
        $mail->Password = 'jlubqkpmuoekzprz';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('pwgaaa.tfg@gmail.com', 'PWGAAA - Plataforma TFG');
        $mail->addAddress($para);
        $mail->isHTML(true);
        $mail->Subject = $asunto;
        $mail->Body = $cuerpoHTML;

        return $mail->send();
    } catch (Exception $e) {
        error_log("Mailer error: " . $mail->ErrorInfo);
        return false;
    }
}

