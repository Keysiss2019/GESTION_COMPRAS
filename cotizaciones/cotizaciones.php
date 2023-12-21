<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cotizaciones</title>
    <link rel="stylesheet" href="../css/estilos.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/860e3c70ee.js" crossorigin="anonymous"></script>
    <script src="../estilos.js"></script>
    <style>
        .solicitud-table {
            border-collapse: collapse;
            width: 100%;
        }
        .solicitud-table th, .solicitud-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
    </style>    

</head>
<body>
<h2><i class="fas fa-book"></i>Cotizaciones</h2>
<?php
// Conectar a la base de datos (reemplaza con tu propia configuración)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gestion_compras2";

$db_connection = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($db_connection->connect_error) {
    die("Conexión fallida: " . $db_connection->connect_error);
}

// Consulta SQL para obtener cotizaciones únicas según el número de cotización
$sql = "SELECT DISTINCT c.NUMERO_COTIZACION, c.ID_COTIZACION, c.ID, c.ID_PROVEEDOR, p.NOMBRE as PROVEEDOR, c.FECHA_COTIZACION, c.ESTADO
        FROM tbl_cotizacion c
        INNER JOIN tbl_proveedores p ON c.ID_PROVEEDOR = p.ID_PROVEEDOR
        ORDER BY c.NUMERO_COTIZACION";

$result = $db_connection->query($sql);

if ($result->num_rows > 0) {
    // Mostrar datos en una tabla HTML
    echo "<table class='solicitud-table'>
            <tr>
                <th>Nº Cotización</th>
                <th>Solicitud</th>
                <th>Proveedor</th>
                <th>Fecha</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . $row["NUMERO_COTIZACION"] . "</td>
                <td>" . $row["ID"] . "</td>
                <td>" . $row["PROVEEDOR"] . "</td>
                <td>" . $row["FECHA_COTIZACION"] . "</td>
                <td>" . $row["ESTADO"] . "</td>
                <td>
                <a href='ver_cotizacion.php?id=" . $row["ID_COTIZACION"] . "'><i class='fas fa-eye'></i></a>
                <a href='editar_cotizacion.php?id=" . $row["ID_COTIZACION"] . "' style='color: green;'><i class='fas fa-edit'></i></a>
                <button class='btn btn-danger' onclick='eliminarCotizacion(" . $row["ID_COTIZACION"] . ")'>
                <i class='fas fa-trash'></i></button>
                <a href='../cotizaciones/add_cotizaciones.php?id=" . $row["ID"] . "' style='color: orange;'><i class='fas fa-shopping-cart'></i></a>
            </td>
              </tr>";
    }

    echo "</table>";
} else {
    echo "No se encontraron cotizaciones.";
}

// Cerrar conexión a la base de datos
$db_connection->close();
?>
<script>
        function editarSolicitud(id) {
            // Redirige a la página editar_solicitud.php con el ID de la solicitud como parámetro
            window.location.href = `../solicitudes/editar_solicitud.php?id=${id}`;
        }

        <!-- Agrega este script JavaScript para manejar la eliminación con AJAX -->

    function eliminarCotizacion(idCotizacion) {
        // Mostrar un cuadro de confirmación
        var confirmacion = confirm("¿Seguro que quieres eliminar esta cotización?");

        if (confirmacion) {
            // Realizar una solicitud AJAX para eliminar la cotización
            fetch('eliminar_cotizacion.php?id=' + idCotizacion + '&confirmar=true', {
                method: 'GET',
            })
            .then(response => response.json())
            .then(data => {
                console.log('Respuesta del servidor:', data);
                // Recargar la página después de la eliminación
                location.reload();
            })
            .catch(error => {
                console.error('Error en la solicitud AJAX:', error);
            });
        }
    }
</script>
</body>
</html>



