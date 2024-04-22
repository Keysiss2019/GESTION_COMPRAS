<?php
include '../conexion/conexion.php';

$idSolicitud = $_GET['id']; // Obtener el ID de solicitud desde la URL

// Recupera y muestra información de la solicitud
$sqlSolicitud = "SELECT S.*, S.codigo, U.nombre_usuario, D.nombre_departamento
FROM tbl_solicitudes S
INNER JOIN tbl_ms_usuario U ON S.usuario_id = U.id_usuario
INNER JOIN tbl_departamentos D ON S.idDepartamento = D.id_departamento
WHERE S.id = $idSolicitud";

$resultSolicitud = $conn->query($sqlSolicitud);

if ($resultSolicitud->num_rows > 0) {
    $rowSolicitud = $resultSolicitud->fetch_assoc();
    $numeroSolicitud = $rowSolicitud['id']; // Asigna el número de solicitud a la variable $numeroSolicitud
    $codigo = $rowSolicitud['codigo'];
    $nombreUsuario = $rowSolicitud['nombre_usuario'];
    $departamentoSolicitud = $rowSolicitud['nombre_departamento'];
    $estadoSolicitud = $rowSolicitud['estado'];
} else {
    echo "Solicitud no encontrada.";
    exit; // Agregamos un exit para detener la ejecución si no se encuentra la solicitud
}

// Obtener las descripciones desde la base de datos
$sqlDescripciones = "SELECT DISTINCT descripcion FROM tbl_productos WHERE id_solicitud = $idSolicitud";
$resultDescripciones = $conn->query($sqlDescripciones);

// Crear un array para almacenar descripciones únicas
$descripciones = array();

while ($rowDescripcion = $resultDescripciones->fetch_assoc()) {
    $descripcion = $rowDescripcion["descripcion"];
    $descripciones[] = $descripcion;
}

// Obtener los datos de la cotización existente
$sqlCotizacion = "SELECT * FROM tbl_cotizacion WHERE id = $idSolicitud";
$resultCotizacion = $conn->query($sqlCotizacion);

if ($resultCotizacion->num_rows > 0) {
    // Existe una cotización para esta solicitud
    $rowCotizacion = $resultCotizacion->fetch_assoc();
    $numeroCotizacion = $rowCotizacion['NUMERO_COTIZACION'];
    $fechaCotizacion = $rowCotizacion['FECHA_COTIZACION'];
    $urlCotizacion = $rowCotizacion['URL'];
    $estadoCotizacion = $rowCotizacion['ESTADO'];

     // Obtener el nombre del proveedor asociado con la cotización
     $idProveedor = $rowCotizacion['ID_PROVEEDOR']; // Asegúrate de que este sea el nombre correcto del campo en tu base de datos
     $sqlProveedor = "SELECT NOMBRE FROM tbl_proveedores WHERE ID_PROVEEDOR = $idProveedor";
     $resultProveedor = $conn->query($sqlProveedor);
     
     if ($resultProveedor->num_rows > 0) {
         $rowProveedor = $resultProveedor->fetch_assoc();
         $nombreProveedor = $rowProveedor['NOMBRE'];
     } else {
         $nombreProveedor = "Proveedor no encontrado";
     }
} else {
    // No hay cotización para esta solicitud
    $numeroCotizacion = "";
    $fechaCotizacion = "";
    $urlCotizacion = "";
    $estadoCotizacion = "";
}

?>

<!DOCTYPE html>
<html>

<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles de Solicitud y Productos</title>
    <style>
        body {
            text-align: left;
            font-family: Arial, sans-serif;
            background: rgba(255, 255, 255, 0.10);
            margin: 0;
            padding: 0;
        }

        .container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            text-align: left;
            border: 1px solid #ccc;
            padding: 20px;
            margin: 20px;
            background-color: powderblue; /* Color de fondo del contenedor */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            opacity: 0.9;
        }

        .table {
            width: 100%; /* Ajusta el ancho de la tabla al 100% del contenedor */
            box-sizing: border-box;
            margin-bottom: 20px; /* Agrega margen inferior */
            background-color: cornsilk; /* Color de fondo para las tablas */
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }

        th {
            background-color: bisque;
        }

        /* Estilos específicos para la segunda tabla */
        .table-container {
            margin: 0 auto; /* Centra la tabla horizontalmente */
            width: 80%; /* Ancho del contenedor */
        }

        .table-container table {
            width: 100%; /* Ajusta el ancho de la tabla al 100% del contenedor */
            margin-bottom: 20px; /* Agrega margen inferior */
            background-color: cornsilk; /* Color de fondo para las tablas */
        }

        .table-container th, .table-container td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }

        .table-container th {
            background-color: bisque;
        }

        /* Estilo para los botones "Crear" y "Cancelar" */
    .custom-button {
        width: 150px;
        height: 50px;
        margin-bottom: 15px; /* Ajusta el espacio entre los botones según sea necesario */
       
       
    }

    /* Estilo para el botón "Crear" */
    .custom-button.create-button {
        background-color: #007bff; /* Azul */
    color: #fff; /* Texto blanco */
    border: 1px solid #0056b3; /* Borde azul más oscuro */
    margin-right: 40px;
    
    }

    /* Estilo adicional para el botón "Cancelar" */
.btn-warning.custom-button.cancel-button {
    background-color: #808080; /* Gris */
    color: #fff; /* Texto blanco */
    border: 1px solid #555; /* Borde gris más oscuro */
    margin-top: 10px; /* Ajusta el margen superior según sea necesario */
}

.custom-textarea {
    width: 82%; /* O ajusta el ancho según tus preferencias */
    height: 75px;
    padding: 5px;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
    color: blue; /* Color azul para los enlaces */
    text-decoration: underline; /* Subrayar los enlaces */
}

select[name="id_proveedor"] {
        max-width: 300px; /* Ajusta el valor según sea necesario */
        width: 100%; /* Garantiza que ocupe el ancho completo del contenedor */
        height: 30px; /* Ajusta el valor según sea necesario para la altura */
    }

    input[name="departamento"] {
        height: 30px;
        
    }
    </style>
</head>
<body>
    <div class="container">
        <!-- Información de Solicitud -->
       
        <div class="table-container">
            <h2 style="text-align: center;">Información de Solicitud</h2>
            <table>
                <tr>
                    <th>Código:</th>
                    <td><?php echo $codigo; ?></td>
                </tr>
                <tr>
                    <th>Usuario:</th>
                    <td><?php echo $nombreUsuario; ?></td>
                </tr>
                <tr>
                    <th>Departamento:</th>
                    <td><?php echo $departamentoSolicitud; ?></td>
                </tr>
                <tr>
                    <th>Estado:</th>
                    <td><?php echo $estadoSolicitud; ?></td>
                </tr>
            </table>
        </div>

        <!-- Tabla de Productos de la Solicitud -->
        <div class="table-container">
            
            <table>
                <tr>
                    <th>Cantidad</th>
                    <th>Descripción</th>
                    <th>Categoría</th>
                </tr>
                <?php
// Obtener y mostrar información de los productos
$sqlProductos = "SELECT cantidad, descripcion, categoria FROM tbl_productos WHERE id_solicitud = $idSolicitud";
$resultProductos = $conn->query($sqlProductos);

if ($resultProductos->num_rows > 0) {
    while ($rowProducto = $resultProductos->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $rowProducto['cantidad'] . "</td>";
        echo "<td>" . $rowProducto['descripcion'] . "</td>";
        
        // Obtener la categoría asociada al producto
        $categoriaId = $rowProducto['categoria'];
        $sqlCategoria = "SELECT id, categoria FROM tbl_categorias WHERE id = $categoriaId";
        $resultCategoria = $conn->query($sqlCategoria);
        if ($resultCategoria->num_rows > 0) {
            $rowCategoria = $resultCategoria->fetch_assoc();
            echo "<td>" . $rowCategoria['categoria'] . "</td>";
        } else {
            echo "<td>Categoría no encontrada</td>";
        }
        
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='3'>No hay productos asociados a esta solicitud.</td></tr>";
}
?>

            </table>
        </div>

        <div class="table" style="margin: 0 auto; text-align: center;">
    <h2 style="text-align: center;">Cotización</h2>
   
    <form  method="post" action="actualizar_cotizacion.php?id=<?php echo $idSolicitud; ?>">

    <table style="width: 80%; margin: 0 auto;">
    
    <tr>
    <th>Proveedor:</th>
    <td><input type="text" name="nombreProveedor" style="width: 290px; height: 30px;" value="<?php echo $nombreProveedor; ?>"></td>
    <th>Código:</th>
    <td><input type="text" name="codigo" style="max-width: 100px; height: 30px;" value="<?php echo $codigo; ?>"></td>
</tr>

<tr>
    <th>Departamento:</th>
    <td><input required type="text" name="departamento" style="width: 290px;" value="<?php echo $departamentoSolicitud; ?>"></td>
    <th>Fecha:</th>
    <td><input type="date" name="fecha_cotizacion" style="max-width: 100px; height: 30px;" value="<?php echo $fechaCotizacion; ?>" readonly></td>
</tr>
<tr>
    <th>URL:</th>
    <td><textarea name="url" required class="custom-textarea" rows="2"><?php echo $urlCotizacion; ?></textarea></td>
    <th>Estado:</th>
<td><input type="text" name="estado" value="<?php echo $estadoCotizacion; ?>" required style="max-width: 100px; height: 30px;" readonly></td>

</tr>


   
    <!-- Aquí agregamos la información del proveedor -->
   
</table>


    <form method="post" action="actualizar_cotizacion.php?id=<?php echo $idSolicitud; ?>">
    <div class="table">
    
    <table style="width: 80%; margin: 0 auto;">
        <!-- Encabezados de la tabla -->
        <tr>
            <th style="width: 20%;">Cantidad</th> <!-- Ajustar el ancho de la columna de cantidad -->
            <th style="width: 50%;">Descripción</th> <!-- Ajustar el ancho de la columna de descripción -->
            <th style="width: 30%;">Categoría</th> <!-- Ajustar el ancho de la columna de categoría -->
        </tr>
        <!-- Mostrar productos de la solicitud con opciones de edición -->
        <?php
        // Obtener y mostrar información de los productos
        $sqlProductos = "SELECT P.id, P.cantidad, P.descripcion, C.id, C.categoria 
                         FROM tbl_productos P 
                         INNER JOIN tbl_categorias C ON P.categoria = C.id
                         WHERE P.id_solicitud = $idSolicitud";
        $resultProductos = $conn->query($sqlProductos);

        if ($resultProductos->num_rows > 0) {
            while ($rowProducto = $resultProductos->fetch_assoc()) {
                echo "<tr>";
                // Cantidad editable
                echo "<td><input type='number' name='cantidad[]' value='" . $rowProducto['cantidad'] . "' class='cant-input' required></td>";
                // Descripción (readonly)
                echo "<td><input type='text' name='descripcion[]' value='" . $rowProducto['descripcion'] . "' readonly class='same-width'></td>";
                // Categoría seleccionable desde la lista desplegable
                echo "<td>";
                echo "<select name='categoria[]' class='same-width' required>";
                // Obtener todas las categorías de la tabla tbl_categorias
                $sqlCategorias = "SELECT id, categoria FROM tbl_categorias";
                $resultCategorias = $conn->query($sqlCategorias);
                if ($resultCategorias->num_rows > 0) {
                    while ($rowCategoria = $resultCategorias->fetch_assoc()) {
                        $selected = ($rowCategoria['id'] == $rowProducto['id']) ? 'selected' : '';
                        echo "<option value='" . $rowCategoria['id'] . "' $selected>" . $rowCategoria['categoria'] . "</option>";
                    }
                }
                echo "</select>";
                echo "</td>";
              
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='3'>No hay productos asociados a esta solicitud.</td></tr>";
        }
        ?>
    </table>
</div>
<br>

        <!-- Botones de Crear y Cancelar -->
        <input type="submit" value="Guardar" class="custom-button create-button">
        <input type="button" value="Cancelar" class="btn btn-warning custom-button cancel-button" onclick="window.location.href='../solicitudes/solicitudes.php';">
    </form>
</div>

</div>
</body>
</html>