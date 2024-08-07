<?php
include 'db_connection.php';

$solicitud_id = $_GET['id']; // Usando el operador de fusión de null para proporcionar un valor predeterminado

// Consulta para recuperar detalles de la solicitud
$sqlSolicitud = "SELECT * FROM tbl_solicitudes WHERE id = ?";
$stmtSolicitud = $conn->prepare($sqlSolicitud);

if ($stmtSolicitud) {
    $stmtSolicitud->bind_param("i", $solicitud_id);
    $stmtSolicitud->execute();
    $resultSolicitud = $stmtSolicitud->get_result();

    // Consulta para recuperar información de la cotización aprobada
    $sqlCotizacionAprobada = "SELECT c.ID_COTIZACION, c.NUMERO_COTIZACION, p.NOMBRE AS NOMBRE_PROVEEDOR, c.ESTADO,  c.URL FROM tbl_cotizacion c
                         INNER JOIN tbl_proveedores p ON c.ID_PROVEEDOR = p.ID_PROVEEDOR
                         WHERE c.id = ? AND (c.ESTADO = 'PRO' OR c.ESTADO = 'PROCESO')";

    $stmtCotizacionAprobada = $conn->prepare($sqlCotizacionAprobada);

    if ($stmtCotizacionAprobada) {
        $stmtCotizacionAprobada->bind_param("i", $solicitud_id);
        $stmtCotizacionAprobada->execute();
        $resultCotizacionAprobada = $stmtCotizacionAprobada->get_result();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Detalle de Solicitud</title>

    <style>
          body {
            text-align: center;
            font-family: Arial, sans-serif;
            background: rgba(255, 255, 255, 0.10); /* Cambia el valor de "0.7" para ajustar la transparencia */
           
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            margin: 0;
            padding: 0;
           
        
        }

        .container {
            display: inline-block;
            text-align: left;
            border: 1px solid #ccc;
            padding: 20px;
            margin: 20px;
            background-color: powderblue; /* Color de fondo azul claro (cielo) */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Sombra ligera */
            opacity: 0.9; /* Valor de opacidad (menos transparente) */
        }

        .table-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }

        .table {
            width: 100%; /* El 2% es para el espacio entre las tablas */
            box-sizing: border-box; /* Para evitar que los bordes agreguen más ancho */
            background-color: cornsilk; /* Color de fondo  para las tablas */
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
    border: 1px solid #ccc;
    padding: 8px;
    text-align: left;
    max-width: 200px; /* Ajusta el ancho máximo de la celda para evitar el desbordamiento */
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis; /* Agrega puntos suspensivos (...) si el contenido es demasiado largo */
}


        th {
            background-color: bisque;
        }

        .button-row {
            text-align: center;
            margin-top: 20px;
        }

       

        /* Estilo del botón */
        button {
            background-color: #4CAF50; /* Color verde para el botón */
            color: white; /* Texto en color blanco */
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049; /* Cambia el color al pasar el mouse sobre el botón */
        }
 
    </style>

<style>
    .red-button {
        background-color: gray;
        color: white;
        padding: 10px 20px;
        text-decoration: none;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }


    .blue-button {
        background-color: #007bff;
        color: white;
        padding: 10px 20px;
        text-decoration: none;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }
</style>

</head>
<body>
<div class="container">
    
<div class="table">
    <h2>DETALLE SOLICITUD</h2>
    <?php
    if ($resultSolicitud->num_rows > 0) {
        $rowSolicitud = $resultSolicitud->fetch_assoc();
        echo "<p>ID: " . $rowSolicitud['id'] . "</p>";
        echo "<p>CÓDIGO: " . $rowSolicitud['codigo'] . "</p>";
       
       
        // Consulta para obtener el nombre del departamento
    $sqlDepartamento = "SELECT nombre_departamento FROM tbl_departamentos WHERE id_departamento = ?";
    $stmtDepartamento = $conn->prepare($sqlDepartamento);

    if ($stmtDepartamento) {
        $stmtDepartamento->bind_param("i", $rowSolicitud['idDepartamento']);
        $stmtDepartamento->execute();
        $resultDepartamento = $stmtDepartamento->get_result();

        if ($resultDepartamento->num_rows > 0) {
            $rowDepartamento = $resultDepartamento->fetch_assoc();
            echo "<p>DEPARTAMENTO: " . $rowDepartamento['nombre_departamento'] . "</p>";
        } else {
            echo "<p>Departamento no encontrado.</p>";
        }
    } else {
        echo "<p>Error al preparar la consulta del departamento.</p>";
    }

       echo "<p>ESTADO: " . $rowSolicitud['estado'] . "</p>";
        // Agrega aquí más detalles de la solicitud según tu estructura de base de datos
    } else {
        echo "Solicitud no encontrada.";
    }
    ?>


<h2 style="text-align: center;">COTIZACIONES APROBADAS</h2>
<table border="1">
    <tr>
        <th style='text-align: center;'>CÓDIGO</th>
        <th style='text-align: center;'>PROVEEDOR</th>
        <th style='text-align: center;'>ESTADO</th>
        <th style='text-align: center;'>URL</th>
        <th style='text-align: center;'>ACCIÓN</th>
    </tr>
    <?php
    if ($resultCotizacionAprobada->num_rows > 0) {
        while ($rowCotizacionAprobada = $resultCotizacionAprobada->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $rowCotizacionAprobada['NUMERO_COTIZACION'] . "</td>";
            echo "<td>" . $rowCotizacionAprobada['NOMBRE_PROVEEDOR'] . "</td>";
            echo "<td>" . $rowCotizacionAprobada['ESTADO'] . "</td>";
            echo "<td><a href='" . $rowCotizacionAprobada['URL'] . "' style='color: blue;' target='_blank'>" . $rowCotizacionAprobada['URL'] . "</a></td>";
            echo "<td><a href='#' class='blue-button orden-compra' data-cotizacion-id='" . $rowCotizacionAprobada['ID_COTIZACION'] . "'>Orden de Compra</a></td>";
          
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='4'>No hay cotizaciones aprobadas disponibles para esta solicitud.</td></tr>";
    }
    ?> 
</table>

    
</div>
<br>






<a href="../solicitudes/solicitudes.php" class="red-button">Cancelar</a>

</div>

<!-- Asegúrate de incluir jQuery en tu página si aún no lo has hecho -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<script>
    $(document).ready(function() {
        // Manejar clic en el botón "Orden de Compra"
        $(".orden-compra").on("click", function(e) {
            e.preventDefault(); // Evitar que el enlace funcione como un enlace normal

            // Obtener el ID de la cotización desde el atributo de datos
            var cotizacionIds = [];
            $(".orden-compra").each(function() {
                cotizacionIds.push($(this).data("cotizacion-id"));
            });

            // Aquí podrías realizar alguna acción para cada cotización, como redirigir a la página de orden de compra
            cotizacionIds.forEach(function(cotizacionId) {
                window.open("../compras/compras.php?cotizacion_id=" + cotizacionId, "_blank");
            });
        });
    });
</script>


</body>
</html>
