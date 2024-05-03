<?php
include '../conexion/conexion.php';

// Obtén los datos de la solicitud
$idSolicitud = $_POST['id_solicitud'];

// Verifica si se han enviado datos de cotización
if(isset($_POST['id_cotizacion']) && is_array($_POST['id_cotizacion'])) {
    // Convierte el array de ID de cotización a un arreglo indexado
    $idCotizaciones = array_values($_POST['id_cotizacion']);

    // Itera sobre cada ID de cotización enviado
    foreach ($idCotizaciones as $idCotizacion) {
        // Aquí procesa los datos para esta cotización específica usando $idCotizacion
        // Por ejemplo:
        $idProveedor = $_POST['id_proveedor'][$idCotizacion];
        $numeroCotizacion = $_POST['numeroCotizacion'][$idCotizacion];
        $fechaCotizacion = $_POST['fechacotizacion'];
        $estadoCotizacion = $_POST['estado'];
        $urlCotizacion = $_POST['url'];

        // Actualiza los campos en la tabla tbl_cotizacion
        $sqlUpdateCotizacion = "UPDATE tbl_cotizacion SET ID_PROVEEDOR = $idProveedor, NUMERO_COTIZACION = '$numeroCotizacion', FECHA_COTIZACION = '$fechaCotizacion', ESTADO = '$estadoCotizacion', URL = '$urlCotizacion' WHERE ID_COTIZACION = $idCotizacion";
        $conn->query($sqlUpdateCotizacion);

        // Procesa los productos
        foreach ($_POST['id'] as $key => $idProducto) {
          $cantidad = $_POST['cantidad'][$key];
           // Actualiza la cantidad en tbl_cotizacion_detalle
            $sqlUpdateProducto = "UPDATE tbl_cotizacion_detalle SET CANTIDAD = $cantidad WHERE ID = $idProducto";
            $conn->query($sqlUpdateProducto);
        }
    }

    // Redirige a solicitudes.php después de procesar los datos
    header("Location: solicitudes.php");
    exit(); // Asegura que el script se detenga después de la redirección
    
} else {
    echo "No se han recibido datos de cotización o el formato es incorrecto.";
}

?>
