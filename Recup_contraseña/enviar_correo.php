<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer\src\PHPMailer.php';
require 'PHPMailer\src\SMTP.php';
require 'PHPMailer\src\Exception.php';

// Función para conectarse a la base de datos
function conectarBaseDeDatos() {
    $servername = "localhost"; // Cambia esto por el nombre de tu servidor MySQL
    $username = "root"; // Cambia esto por tu nombre de usuario de MySQL
    $password = ""; // Cambia esto por tu contraseña de MySQL
    $dbname = "gestion_compras2"; // Cambia esto por el nombre de tu base de datos

    // Crear conexión
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verificar conexión
    if ($conn->connect_error) {
        die("Error de conexión: " . $conn->connect_error);
    }

    return $conn;
}

// Función para recuperar un parámetro de la tabla tbl_ms_parametros
function obtenerParametro($parametro) {
    // Conectarse a la base de datos
    $conn = conectarBaseDeDatos();

    // Preparar la consulta SQL
    $sql = "SELECT VALOR FROM tbl_ms_parametros WHERE PARAMETRO = ?";

    // Preparar la sentencia
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $parametro);

    // Ejecutar la consulta
    $stmt->execute();

    // Obtener el resultado
    $result = $stmt->get_result();

    // Verificar si se encontró el parámetro
    if ($result->num_rows > 0) {
        // Obtener el valor del parámetro
        $row = $result->fetch_assoc();
        $valor = $row["VALOR"];
    } else {
        // Si el parámetro no se encuentra, devolver un valor por defecto o manejar el error según sea necesario
        $valor = null; // O puedes devolver un valor por defecto
    }

    // Cerrar la conexión y liberar los recursos
    $stmt->close();
    $conn->close();

    return $valor;
}

// Función para generar una nueva contraseña segura
function generarNuevaContrasena($longitud) {
    $caracteres = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%^&*()-_=+[{]}|;:,';
    $longitudCaracteres = strlen($caracteres);
    $contrasena = '';
    for ($i = 0; $i < $longitud; $i++) {
        $contrasena .= $caracteres[rand(0, $longitudCaracteres - 1)];
    }
    return $contrasena;
}

// Actualizar la contraseña en la base de datos y obtener el nombre de usuario asociado
function actualizarContrasena($correo, $nuevaContrasena) {
    $conn = conectarBaseDeDatos();
    $hashedPassword = password_hash($nuevaContrasena, PASSWORD_DEFAULT);
    $sql = "UPDATE tbl_ms_usuario SET contraseña = ? WHERE correo_electronico = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $hashedPassword, $correo);
    $stmt->execute();

    // Obtener el nombre de usuario asociado con el correo electrónico
    $sql = "SELECT nombre_usuario FROM tbl_ms_usuario WHERE correo_electronico = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $nombreUsuario = $row['nombre_usuario'];

    $stmt->close();
    $conn->close();

    return $nombreUsuario;
}

// Crear una nueva instancia de PHPMailer
$mail = new PHPMailer(true);

// Establecer la codificación de caracteres a UTF-8
$mail->CharSet = PHPMailer::CHARSET_UTF8;

try {
    // Configuración del servidor SMTP
    $mail->SMTPDebug = SMTP::DEBUG_OFF;
    $mail->isSMTP();
    $mail->Host = obtenerParametro('SMTP_HOST');
    $mail->Port = obtenerParametro('SMTP_PORT');
    $mail->SMTPAuth = true;
    $mail->Username = obtenerParametro('SMTP_USERNAME');
    $mail->Password = obtenerParametro('SMTP_PASSWORD');
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

    // Remitente y destinatario
    $mail->setFrom(obtenerParametro('SENDER_EMAIL'), obtenerParametro('SENDER_NAME'));
    $mail->addAddress($correo, 'Usted');

    // Generar nueva contraseña
    $nuevaContrasena = generarNuevaContrasena(12); // Genera una contraseña de al menos 12 caracteres

    // Actualizar contraseña en la base de datos y obtener el nombre de usuario
    $nombreUsuario = actualizarContrasena($correo, $nuevaContrasena);

    // Contenido del correo (recuperado de la base de datos)
    $subject = 'Recuperación de Contraseña';
    $body = obtenerParametro('CORREO_RECUPERACION_CONTRASENA');
    $body = str_replace('{nombre_usuario}', $nombreUsuario, $body);
    $body = str_replace('{contrasena}', $nuevaContrasena, $body);

    $mail->isHTML(true);
    $mail->Subject = $subject;
    $mail->Body = $body;

    // Enviar el correo
    $mail->send();
    $mensaje = "Se ha enviado una nueva contraseña a su correo electrónico.";
} catch (Exception $e) {
    $mensaje = "Error al enviar el correo: {$mail->ErrorInfo}";
}

// Incluir el HTML del modal
include 'modal.php';
