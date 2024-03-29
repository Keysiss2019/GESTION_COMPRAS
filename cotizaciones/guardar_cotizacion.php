<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'db_connection.php';

// Verifica si el formulario se envió correctamente
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recuperar datos del formulario
    $idProveedor = $_POST['id_proveedor'];
    $numeroCotizacion = $_POST['numero_cotizacion'];
    $departamento = $_POST['departamento'];
    $fechaCotizacion = $_POST['fecha_cotizacion'];
    $estado = isset($_POST['ESTADO']) ? $_POST['ESTADO'] : '';

    $idSolicitud = isset($_GET['id']) ? $_GET['id'] : '';

    $URL = $_POST['url'];

    // Guardar la primera letra del estado en mayúsculas en la base de datos
    $estadoPrimeraLetra = strtoupper(substr($estado, 0, 1));

    // Preparar la consulta SQL para insertar la cotización en tbl_cotizacion
    $sqlInsertCotizacion = "INSERT INTO tbl_cotizacion (ID_PROVEEDOR, NUMERO_COTIZACION, DEPARTAMENTO, FECHA_COTIZACION, ESTADO, ID, url)
                            VALUES (?, ?, ?, ?, ?, ?, ?)";

    $stmtCotizacion = $conn->prepare($sqlInsertCotizacion);
    $stmtCotizacion->bind_param("issssis", $idProveedor, $numeroCotizacion, $departamento, $fechaCotizacion, $estadoPrimeraLetra, $idSolicitud,  $URL);

    if (!$stmtCotizacion->execute()) {
        // Imprimir el contenido de $stmtCotizacion->error
        echo "Error al guardar la cotización en tbl_cotizacion: ";
        print_r($stmtCotizacion->error);

        // O también puedes registrar el error en el log
        error_log("Error al guardar la cotización en tbl_cotizacion: " . print_r($stmtCotizacion->error, true));
    } else {
        // Obtener el ID de la cotización recién insertada
        $idCotizacion = $stmtCotizacion->insert_id;

        // Actualizar el estado de la solicitud a 'Proceso' en tbl_solicitudes
        $sqlActualizarSolicitud = "UPDATE tbl_solicitudes SET estado = 'Proceso' WHERE id = ?";
        $stmtActualizarSolicitud = $conn->prepare($sqlActualizarSolicitud);
        $stmtActualizarSolicitud->bind_param("i", $idSolicitud);

        if ($stmtActualizarSolicitud->execute()) {
            // Recuperar datos del detalle de la cotización del formulario
            $cantidades = $_POST['cantidad'];
            $descripciones = $_POST['descripcion'];

            // Iterar sobre los datos del detalle y guardar en tbl_cotizacion_detalle
            for ($i = 0; $i < count($cantidades); $i++) {
                $cantidad = $cantidades[$i];
                $descripcion = $descripciones[$i];
                $categoria = obtenerCategoria($descripcion);

                // Preparar la consulta SQL para insertar en tbl_cotizacion_detalle
                $sqlInsertDetalle = "INSERT INTO tbl_cotizacion_detalle (ID_COTIZACION, CANTIDAD, DESCRIPCION, ID_CATEGORIA)
                                    VALUES (?, ?, ?, ?)";

                $stmtDetalle = $conn->prepare($sqlInsertDetalle);
                $stmtDetalle->bind_param("iisi", $idCotizacion, $cantidad, $descripcion, $categoria);

                if (!$stmtDetalle->execute()) {
                    // Imprimir el contenido de $stmtDetalle->error
                    echo "Error al guardar el detalle de la cotización en tbl_cotizacion_detalle: ";
                    print_r($stmtDetalle->error);

                    // O también puedes registrar el error en el log
                    error_log("Error al guardar el detalle de la cotización en tbl_cotizacion_detalle: " . print_r($stmtDetalle->error, true));
                }
            }

            // Redirigir a cotizaciones.php
            header("Location: ../solicitudes/solicitudes.php");
            exit();
        } else {
            // Error al actualizar el estado de la solicitud
            echo "Error al actualizar el estado de la solicitud en tbl_solicitudes: " . $stmtActualizarSolicitud->error;
            // También puedes redirigir o mostrar un mensaje de error específico
        }
    }
} else {
    echo "Acceso no permitido.";
}

// Función para obtener la categoría correspondiente a la descripción
function obtenerCategoria($descripcion) {
    global $conn;

    // Consulta para obtener la categoría asociada a la descripción
    $sql = "SELECT C.ID
            FROM tbl_productos P
            LEFT JOIN tbl_categorias C ON P.CATEGORIA = C.ID
            WHERE P.DESCRIPCION = '$descripcion'";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['ID'];
    } else {
        return 0; // Puedes cambiar esto según tus requisitos
    }
}
?>



