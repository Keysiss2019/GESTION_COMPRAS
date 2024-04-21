<?php
include('db.php');

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];
    
    // Eliminar registros relacionados en tbl_cotizacion
    $query_delete_cotizacion = "DELETE FROM tbl_cotizacion WHERE ID_PROVEEDOR = ?";
    $stmt_delete_cotizacion = $conexion->prepare($query_delete_cotizacion);
    $stmt_delete_cotizacion->bind_param("i", $id);
    $stmt_delete_cotizacion->execute();
    $stmt_delete_cotizacion->close();
    
    // Ahora, eliminar el proveedor
    $query_delete_proveedor = "DELETE FROM tbl_proveedores WHERE ID_PROVEEDOR = ?";
    $stmt_delete_proveedor = $conexion->prepare($query_delete_proveedor);
    $stmt_delete_proveedor->bind_param("i", $id);
    
    if ($stmt_delete_proveedor->execute()) {
        header('Location: listar_proveedores.php');
        exit;
    } else {
        echo "Error al eliminar el proveedor: " . $stmt_delete_proveedor->error;
    }

    $stmt_delete_proveedor->close();
}
?>
