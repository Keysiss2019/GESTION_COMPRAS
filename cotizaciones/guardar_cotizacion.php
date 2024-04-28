<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'db_connection.php';

// Verifica si el formulario se envió correctamente
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recuperar datos del formulario
    $idProveedores = $_POST['id_proveedor'];
    $numerosCotizacion = $_POST['numero_cotizacion'];
    $departamentos = $_POST['departamento'];
    $fechasCotizacion = $_POST['fecha_cotizacion'];
    $estados = isset($_POST['estado']) ? $_POST['estado'] : '';
    $urls = $_POST['url'];
    $cantidades = $_POST['cantidad'];
    $descripciones = $_POST['descripcion'];
    $categorias = $_POST['categoria'];

    $idSolicitud = isset($_GET['id']) ? $_GET['id'] : '';

    // Guardar las cotizaciones y sus detalles
    for ($i = 0; $i < count($idProveedores); $i++) {
        $idProveedor = $idProveedores[$i];
        $numeroCotizacion = $numerosCotizacion[$i];
        $departamento = $departamentos[$i];
        $fechaCotizacion = $fechasCotizacion[$i];
        $estado = isset($estados[$i]) ? strtoupper(substr($estados[$i], 0, 2)) : '';
        $url = $urls[$i];
        $cantidad = $cantidades[$i];
        $descripcion = $descripciones[$i];
        $categoria = $categorias[$i];

        // Verificar si la categoría existe
        $idCategoria = obtenerIdCategoria($categoria);

        if ($idCategoria !== null) {
            // Preparar la consulta SQL para insertar la cotización en tbl_cotizacion
            $sqlInsertCotizacion = "INSERT INTO tbl_cotizacion (ID_PROVEEDOR, NUMERO_COTIZACION, DEPARTAMENTO, FECHA_COTIZACION, ESTADO, ID, url)
                                    VALUES (?, ?, ?, ?, ?, ?, ?)";

            $stmtCotizacion = $conn->prepare($sqlInsertCotizacion);
            $stmtCotizacion->bind_param("issssis", $idProveedor, $numeroCotizacion, $departamento, $fechaCotizacion, $estado, $idSolicitud, $url);

            if (!$stmtCotizacion->execute()) {
                // Imprimir el error o registrar en el log
                echo "Error al guardar la cotización: " . $stmtCotizacion->error;
                exit;
            }

            // Obtener el ID de la cotización recién insertada
            $idCotizacion = $stmtCotizacion->insert_id;

            // Preparar la consulta SQL para insertar los detalles de cotización en tbl_cotizacion_detalle
            $sqlInsertDetalle = "INSERT INTO tbl_cotizacion_detalle (ID_COTIZACION, CANTIDAD, DESCRIPCION, ID_CATEGORIA)
                                 VALUES (?, ?, ?, ?)";

            $stmtDetalle = $conn->prepare($sqlInsertDetalle);
            $stmtDetalle->bind_param("iisi", $idCotizacion, $cantidad, $descripcion, $idCategoria);

            if (!$stmtDetalle->execute()) {
                // Imprimir el error o registrar en el log
                echo "Error al guardar los detalles de la cotización: " . $stmtDetalle->error;
                exit;
            }
        } else {
            // No se pudo encontrar el ID de la categoría, debes manejar esta situación
            echo "Error: No se encontró la categoría correspondiente para '$categoria'.";
            exit;
        }
    }

    // Actualizar el estado de la solicitud a 'Pendiente' en tbl_solicitudes
    $sqlActualizarSolicitud = "UPDATE tbl_solicitudes SET estado = 'Pendiente' WHERE id = ?";
    $stmtActualizarSolicitud = $conn->prepare($sqlActualizarSolicitud);
    $stmtActualizarSolicitud->bind_param("i", $idSolicitud);

    if (!$stmtActualizarSolicitud->execute()) {
        // Imprimir el error o registrar en el log
        echo "Error al actualizar el estado de la solicitud: " . $stmtActualizarSolicitud->error;
        exit;
    }

    // Redirigir a cotizaciones.php después de guardar correctamente
    header("Location: ../solicitudes/solicitudes.php");
    exit;
} else {
    // Si el formulario no se envió correctamente, mostrar un mensaje de error
    echo "Error: Acceso no permitido.";
    exit;
}

// Función para obtener el ID de la categoría basado en el nombre de la categoría
function obtenerIdCategoria($nombreCategoria) {
    global $conn;

    $sql = "SELECT id FROM tbl_categorias WHERE categoria = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $nombreCategoria);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['id'];
    } else {
        return null; // La categoría no existe
    }
}
?>