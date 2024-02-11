<?php
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

    
    // Validar si el número de orden ya existe en la base de datos para evitar duplicados
    $sqlCheckExistence = "SELECT NUMERO_ORDEN FROM tbl_orden_compra WHERE NUMERO_ORDEN = '$numero_orden'";
    $resultCheckExistence = $conn->query($sqlCheckExistence);
    if ($resultCheckExistence->num_rows > 0) {
        echo json_encode(array("success" => false, "message" => "El número de orden ya existe en la base de datos."));
        exit(); // Salir del script si ya existe un registro con el mismo número de orden
    }

    // Insertar la información principal en la tabla tbl_orden_compra
$sql = "INSERT INTO tbl_orden_compra (NUMERO_ORDEN, FECHA_ORDEN, ID_PROVEEDOR, ID_CONTACTO, MONTO)
VALUES ('$numero_orden', '$fecha_orden', '$proveedor', '$contacto', '$totalFactura')";


    if ($conn->query($sql) === TRUE) {
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
                           VALUES ('$orden_id', '$cantidad', '$descripcion', '$precio', '$total',  '$subtotal', ' $isv',  '$excento')";

            $conn->query($sqlDetalle);
        }

        echo json_encode(array("success" => true, "message" => "Orden de compra guardada correctamente."));
    } else {
        echo json_encode(array("success" => false, "message" => "Error al guardar la orden de compra: " . $conn->error));
    }

    // Cerrar la conexión a la base de datos
    $conn->close();
} else {
    echo json_encode(array("success" => false, "message" => "No se recibieron datos correctamente."));
}
?>
