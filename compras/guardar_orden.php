<?php
// Iniciar sesión si no está iniciada
session_start();

// Verificar si el usuario ha iniciado sesión
if(isset($_SESSION['usuarioId'])) {
    $usuarioID = $_SESSION['usuarioId']; // Corregir el nombre de la clave
} else {
    // Si el usuario no ha iniciado sesión, redirigirlo a la página de inicio de sesión
    header("Location: login.php");
    exit();
}

// Conectar a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gestion_compras2";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Verificar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $numero_orden = $_POST["numero_orden"];
    $fecha_orden = $_POST["fecha_orden"];
    $proveedor = $_POST["proveedor"];
    $contacto = $_POST["contacto"];
    $subtotal = $_POST["subtotal"];
    $isv = $_POST["isv"];
    $totalFactura = $_POST["total_factura"];
    $excentos = isset($_POST['excento']) ? $_POST['excento'] : array();
    $monto = $_POST["monto"];
    $cotizacionId = isset($_POST["cotizacion_id"]) ? $_POST["cotizacion_id"] : null;

    // Obtener el ID de la cotización asociada a la orden de compra
    $sqlObtenerIdCotizacion = "SELECT ID FROM tbl_cotizacion WHERE ID_COTIZACION = ?";
    $stmtObtenerIdCotizacion = $conn->prepare($sqlObtenerIdCotizacion);
    $stmtObtenerIdCotizacion->bind_param("i", $cotizacionId);
    $stmtObtenerIdCotizacion->execute();
    $resultIdCotizacion = $stmtObtenerIdCotizacion->get_result();

    if ($resultIdCotizacion->num_rows > 0) {
        $rowIdCotizacion = $resultIdCotizacion->fetch_assoc();
        $idCotizacion = $rowIdCotizacion['ID'];
        
        // Verificar si ya existe una orden de compra para esta cotización asociada a la solicitud
        $sqlVerificarOrdenAnterior = "SELECT ID_ORDEN_COMPRA FROM tbl_orden_compra WHERE ID_ORDEN_COMPRA = ? OR ID_COTIZACION = ?";
        $stmtVerificarOrdenAnterior = $conn->prepare($sqlVerificarOrdenAnterior);
        $stmtVerificarOrdenAnterior->bind_param("ii", $cotizacionId, $cotizacionId);
        $stmtVerificarOrdenAnterior->execute();
        $resultOrdenAnterior = $stmtVerificarOrdenAnterior->get_result();

        if ($resultOrdenAnterior->num_rows > 0) {
            // Si existe una orden anterior, eliminarla primero
            while ($rowOrdenAnterior = $resultOrdenAnterior->fetch_assoc()) {
                $idOrdenAnterior = $rowOrdenAnterior['ID_ORDEN_COMPRA'];

                // Eliminar la orden de pago asociada a la orden de compra anterior, si existe
                $sqlEliminarOrdenPagoAnterior = "DELETE FROM tbl_orden_pago WHERE ID_ORDEN = ?";
                $stmtEliminarOrdenPagoAnterior = $conn->prepare($sqlEliminarOrdenPagoAnterior);
                $stmtEliminarOrdenPagoAnterior->bind_param("i", $idOrdenAnterior);
                $stmtEliminarOrdenPagoAnterior->execute();
                $stmtEliminarOrdenPagoAnterior->close();

                // Ahora eliminamos la orden de compra anterior
                $sqlEliminarOrdenAnterior = "DELETE FROM tbl_orden_compra WHERE ID_ORDEN_COMPRA = ?";
                $stmtEliminarOrdenAnterior = $conn->prepare($sqlEliminarOrdenAnterior);
                $stmtEliminarOrdenAnterior->bind_param("i", $idOrdenAnterior);
                $stmtEliminarOrdenAnterior->execute();
                $stmtEliminarOrdenAnterior->close();
            }
        }

        // Insertar la información principal en la tabla tbl_orden_compra
        $sql = "INSERT INTO tbl_orden_compra (NUMERO_ORDEN, FECHA_ORDEN, ID_PROVEEDOR, ID_CONTACTO, MONTO, ID_COTIZACION, ESTADO, CREADO_POR)
        VALUES (?, ?, ?, ?, ?, ?, 'APROBADA', ?)";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssiiidi", $numero_orden, $fecha_orden, $proveedor, $contacto, $totalFactura, $cotizacionId, $usuarioID);
        if ($stmt->execute()) {
            // Obtener el ID de la orden recién insertada
            $orden_id = $conn->insert_id;

            // Recorrer los datos de las cotizaciones enviados por el formulario
            $cotizaciones = isset($_POST["cotizaciones"]) ? json_decode($_POST["cotizaciones"], true) : array();
            $precios = isset($_POST["precios"]) ? json_decode($_POST["precios"]) : array();
          
            foreach ($cotizaciones as $index => $cotizacion) {
                $cantidad = intval($cotizacion["cantidad"]); // Convertir a entero
                $descripcion = $cotizacion["descripcion"];
                $precio = $precios[$index];
                $excento = in_array($index, $excentos) ? "SI" : "NO";

                // Calcular el total (cantidad * precio)
                $total = $cantidad * $precio;

                // Insertar los datos de cantidad, descripción y precio en la tabla tbl_orden_compra_productos
                $sqlDetalle = "INSERT INTO tbl_orden_compra_productos (ID_ORDEN, CANTIDAD, DESCRIPCION, PRECIO, TOTAL, SUBTOTAL, ISV,  EXCENTO)
                               VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

                $stmtDetalle = $conn->prepare($sqlDetalle);
                $stmtDetalle->bind_param("iisdidds", $orden_id, $cantidad, $descripcion, $precio, $total,  $subtotal, $isv,  $excento);
                $stmtDetalle->execute();
                $stmtDetalle->close();
            }

            // Obtener el ID de la solicitud asociada a la cotización
            $sqlObtenerIdSolicitud = "SELECT id FROM tbl_cotizacion WHERE ID = ?";
            $stmtObtenerIdSolicitud = $conn->prepare($sqlObtenerIdSolicitud);
            $stmtObtenerIdSolicitud->bind_param("i", $idCotizacion);
            $stmtObtenerIdSolicitud->execute();
            $resultIdSolicitud = $stmtObtenerIdSolicitud->get_result();

            if ($resultIdSolicitud->num_rows > 0) {
                $rowIdSolicitud = $resultIdSolicitud->fetch_assoc();
                $idSolicitud = $rowIdSolicitud['id'];

                // Actualizar el estado de la solicitud a "Aprobada"
                $sqlActualizarEstadoSolicitud = "UPDATE tbl_solicitudes SET estado = 'APROBADA' WHERE id = ?";
                $stmtActualizarEstadoSolicitud = $conn->prepare($sqlActualizarEstadoSolicitud);
                $stmtActualizarEstadoSolicitud->bind_param("i", $idSolicitud);
                $stmtActualizarEstadoSolicitud->execute();
                $stmtActualizarEstadoSolicitud->close();
            } else {
                echo "Error: No se pudo encontrar la solicitud asociada a la cotización.";
            }

            // Redirigir a la página de flujo con el ID de solicitud
            echo "<script>window.location.replace('../solicitudes/solicitudes.php');</script>";
            exit(); // Asegurarse de que el script se detenga después de redirigir
        } else {
            echo json_encode(array("success" => false, "message" => "Error al guardar la orden de compra: " . $conn->error));
        }
        $stmt->close();
    } else {
        echo "Error: No se pudo encontrar la cotización asociada a la orden de compra.";
    }

    // Cerrar la conexión a la base de datos
    $conn->close();
} else {
    echo json_encode(array("success" => false, "message" => "No se recibieron datos correctamente."));
}
?>
