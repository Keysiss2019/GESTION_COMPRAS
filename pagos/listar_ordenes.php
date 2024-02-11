<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/860e3c70ee.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-Sv9wsMiyH/xuYvBqxxD2TkgD0b3VxxkyKMTl7REpfl1dHstnoqEHfzibhu9z96AdSzFhAwHTqTr9HyffduU2GA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <title>Listado de Órdenes de Compra</title>
    <style>
       

        .container {
            margin-left: 40px;
            padding: 40px;
            overflow-x: auto;
        }

        #toggle-menu-btn {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            position: absolute;
            top: 10px;
            left: 10px;
            z-index: 1100;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            text-align: center;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 9px;
            text-align: left;
            
        }

        th {
            background-color: #f2f2f2;
            
        }

        tr {
            background-color: white;
        }


        a {
            text-decoration: none;
           
        }

        .pdf-link {
            display: inline-block;
            background-color: blue;
            color: #fff;
            padding: 3px 3px;
            border-radius: 5px;
            text-decoration: none;
        }
       
    </style>
</head>
<body>



<div class="container">
<h1><i class="fas fa-dollar-sign"></i>Orden de Pago</h1>
<?php
include '../conexion/conexion.php';

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$sql = "SELECT op.ID_ORDEN_PAGO, p.NOMBRE AS PROVEEDOR, op.BANCO, op.TIPO_CUENTA, op.FECHA_ORDEN, op.MONTO_TOTAL
        FROM tbl_orden_pago op
        INNER JOIN tbl_proveedores p ON op.ID_PROVEEDOR = p.ID_PROVEEDOR";

$result = $conn->query($sql);

echo '<table>';
echo '<tr>
        <th>ID Orden de Pago</th>
        <th>Proveedor</th>
        <th>Banco</th>
        <th>Tipo de Cuenta</th>
        <th>Fecha de la Orden</th>
        <th>Acciones</th>
      </tr>';

if ($result !== false && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo '<tr>';
        echo '<td>' . $row["ID_ORDEN_PAGO"] . '</td>';
        echo '<td>' . $row["PROVEEDOR"] . '</td>';
        echo '<td>' . $row["BANCO"] . '</td>';
        echo '<td>' . $row["TIPO_CUENTA"] . '</td>';
        echo '<td>' . $row["FECHA_ORDEN"] . '</td>';
        

        // Agregar columna de acciones para generar PDF
        echo '<td><a class="pdf-link" href="generar_pdf.php?id=' . $row["ID_ORDEN_PAGO"] . '"><i class="fas fa-file-pdf fa-2x"></i></a></td>';
       
        echo '</tr>';
    }
} else {
    echo '<tr><td colspan="7">No se encontraron datos de órdenes de pago.</td></tr>';
}

echo '</table>';

$conn->close();
?>


</div>

</body>
</html>