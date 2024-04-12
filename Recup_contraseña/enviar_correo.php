<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer\src\PHPMailer.php';
require 'PHPMailer\src\SMTP.php';
require 'PHPMailer\src\Exception.php';

// Crear una nueva instancia de PHPMailer
$mail = new PHPMailer(true);

// Establecer la codificación de caracteres a UTF-8
$mail->CharSet = PHPMailer::CHARSET_UTF8;

try {
    // Configuración del servidor SMTP
    $mail->SMTPDebug = SMTP::DEBUG_OFF; // Puedes cambiarlo a DEBUG_SERVER o DEBUG_CLIENT para depuración
    $mail->isSMTP();
    $mail->Host = 'smtp.office365.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'sistemadecompras2023@outlook.com';
    $mail->Password = 'Compras2024';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Puedes cambiarlo a ENCRYPTION_SSL si es necesario
    $mail->Port = 587; // Puerto SMTP

    // Remitente y destinatario
    $mail->setFrom('sistemadecompras2023@outlook.com', 'Sistema de compras');
    $mail->addAddress($correo, 'Usted'); // La dirección de correo del usuario

    // Contenido del correo
    $mail->isHTML(true);
    $mail->Subject = 'Recuperación de Contraseña';
    $mail->Body = 'Su nueva contraseña es: ' . $nuevaContrasena;

 // Enviar el correo
    $mail->send();
    $mensaje = "Se ha enviado una nueva contraseña a su correo electrónico.";
 } catch (Exception $e) {
    $mensaje = "Error al enviar el correo: {$mail->ErrorInfo}";
 }
 
 // Incluir el HTML del modal
 include 'modal.php';
?>
