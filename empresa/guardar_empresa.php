<?php
include 'db_connect.php'; // Incluye el archivo de conexión a la base de datos

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Procesar el formulario de creación
    $nombre_empresa = $_POST['nombre_empresa'];
    $fecha_inicio_operacion = $_POST['fecha_inicio_operacion'];
    $tel_empresa = $_POST['tel_empresa'];
    $email_empresa = $_POST['email_empresa'];
    $direccion = $_POST['direccion'];
    $estado = $_POST['estado'];

    // Preparar la consulta SQL para insertar los datos
    $sql = "INSERT INTO tbl_empresa (nombre_empresa, fecha_inicio_operacion, tel_empresa, email_empresa, direccion, estado) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    // Vincular los parámetros
    $stmt->bindValue(1, $nombre_empresa);
    $stmt->bindValue(2, $fecha_inicio_operacion);
    $stmt->bindValue(3, $tel_empresa, PDO::PARAM_INT);
    $stmt->bindValue(4, $email_empresa);
    $stmt->bindValue(5, $direccion);
    $stmt->bindValue(6, $estado);

    // Ejecutar la consulta SQL
    if ($stmt->execute()) {
        // Redirigir a la página de listado de empresas si la inserción fue exitosa
        header("Location: listarempresa.php");
        exit();
    } else {
        // Mostrar un mensaje de error si ocurrió un problema con la inserción
        echo "Error al crear la empresa: " . $stmt->error;
    }
} else {
    // Si se accede directamente a este archivo sin enviar datos por POST, redirigir al formulario de creación
    header("Location: formulario_crear_empresa.php");
    exit();
}
?>
