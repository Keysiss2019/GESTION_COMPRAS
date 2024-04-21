<?php
include 'db_connect.php'; // Incluye el archivo de conexión a la base de datos

// Obtener el ID de la empresa a eliminar desde la URL
$id_empresa = $_GET['id'];

// Preparar la consulta SQL para eliminar la empresa
$sql = "DELETE FROM tbl_empresa WHERE id_empresa=?";
$stmt = $conn->prepare($sql);

// Ejecutar la consulta SQL pasando el ID de la empresa como parámetro
if ($stmt->execute([$id_empresa])) {
    // Redirigir a la página de listado de empresas si la eliminación fue exitosa
    header("Location: listarempresa.php");
    exit();
} else {
    // Mostrar un mensaje de error si ocurrió un problema con la eliminación
    echo "Error al eliminar la empresa: " . $stmt->error;
}
?>
