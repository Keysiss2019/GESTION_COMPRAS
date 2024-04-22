<?php
// Reemplaza estos valores con tus credenciales de base de datos
include '../conexion/conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["solicitud_id"])) {
    $solicitud_id = $_POST["solicitud_id"];
    $idDepartamento = $_POST["idDepartamento"];
    $usuario_nombre = $_POST["usuario_nombre"];
    
    $codigo = $_POST["codigo"];
    $estado = $_POST["estado"];

    // Recibir los datos de cantidad, descripción y categoría de productos
    $cantidades = $_POST["cantidad"];
    $descripciones = $_POST["descripcion"];
    $categorias = $_POST["categoria"];

    // Comenzar una transacción
    $conn->begin_transaction();

    try {
        // Eliminar los detalles del producto asociados con la solicitud
        $sql_eliminar_producto = "DELETE FROM tbl_productos WHERE id_solicitud = ?";
        $stmt_eliminar_producto = $conn->prepare($sql_eliminar_producto);
        $stmt_eliminar_producto->bind_param("i", $solicitud_id);
        $stmt_eliminar_producto->execute();

        // Obtener el ID del usuario a partir del nombre proporcionado
        $sql_usuario = "SELECT id_usuario FROM tbl_ms_usuario WHERE nombre_usuario = ?";
        $stmt_usuario = $conn->prepare($sql_usuario);
        $stmt_usuario->bind_param("s", $usuario_nombre);
        $stmt_usuario->execute();
        $result_usuario = $stmt_usuario->get_result();
        if ($result_usuario->num_rows > 0) {
            $row_usuario = $result_usuario->fetch_assoc();
            $usuario_id = $row_usuario["id_usuario"];
        } else {
            // Si no existe, insertar el nuevo usuario
            $sql_insert_usuario = "INSERT INTO tbl_ms_usuario (nombre_usuario) VALUES (?)";
            $stmt_insert_usuario = $conn->prepare($sql_insert_usuario);
            $stmt_insert_usuario->bind_param("s", $usuario_nombre);
            $stmt_insert_usuario->execute();

            $usuario_id = $stmt_insert_usuario->insert_id;
        }

        // Actualizar la solicitud con los nuevos datos, incluyendo el estado
        $sql_actualizar = "UPDATE tbl_solicitudes SET idDepartamento = ?, usuario_id = ?, codigo = ?, estado = ?, fecha_modificacion = NOW() WHERE id = ?";
        $stmt_actualizar = $conn->prepare($sql_actualizar);
        $stmt_actualizar->bind_param("iissi", $idDepartamento, $usuario_id, $codigo, $estado, $solicitud_id);
        $stmt_actualizar->execute();

        // Insertar los nuevos detalles del producto
        foreach ($cantidades as $index => $cantidad) {
            // Obtener el ID de la categoría
            $categoria_id = $categorias[$index];

            // Insertar cada detalle del producto en la base de datos
            $sql_insert_producto = "INSERT INTO tbl_productos (id_solicitud, cantidad, descripcion, categoria) VALUES (?, ?, ?, ?)";
            $stmt_insert_producto = $conn->prepare($sql_insert_producto);
            $stmt_insert_producto->bind_param("iisi", $solicitud_id, $cantidad, $descripciones[$index], $categoria_id);
            $stmt_insert_producto->execute();
        }

        // Confirmar la transacción
        $conn->commit();

        // Redireccionar a la página de solicitudes después de guardar
        header("Location: solicitudes.php");
        exit(); // Asegura que el script se detenga después de la redirección   
    } catch (Exception $e) {
        // Revertir la transacción en caso de error
        $conn->rollback();
        echo "Error al guardar los cambios: " . $e->getMessage();
    }

    // Cerrar la conexión
    $conn->close();
} else {
    echo "Solicitud no válida.";
}
?>