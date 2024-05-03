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

// Obtener los datos de todas las cotizaciones asociadas a la solicitud
$sqlCotizaciones = "SELECT * FROM tbl_cotizacion WHERE id = $idSolicitud";
$resultCotizaciones = $conn->query($sqlCotizaciones);

// Crear un array para almacenar las cotizaciones
$cotizaciones = array();

if ($resultCotizaciones->num_rows > 0) {
    while ($rowCotizacion = $resultCotizaciones->fetch_assoc()) {
        $cotizacion = array(
            'numero' => $rowCotizacion['NUMERO_COTIZACION'],
            'fecha' => $rowCotizacion['FECHA_COTIZACION'],
            'url' => $rowCotizacion['URL'],
            'estado' => $rowCotizacion['ESTADO']
        );
        $cotizaciones[] = $cotizacion;
    }
}

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles de Solicitud y Cotizaciones</title>
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
       
        margin-right: 630px;
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

    </style>
</head>

<body>
    <div class="container">
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

        <!-- Sección de cotizaciones -->
        <div class="table" style="margin: 0 auto; text-align: center;">
    
           <?php
             // Consultar todas las cotizaciones asociadas a la solicitud
              $sqlCotizaciones = "SELECT * FROM tbl_cotizacion WHERE id = $idSolicitud";
              $resultCotizaciones = $conn->query($sqlCotizaciones);
              // Obtener el número total de cotizaciones
              $totalCotizaciones = $resultCotizaciones->num_rows;

              // Variable para llevar un conteo de las cotizaciones mostradas
              $cotizacionesMostradas = 0;

               // Verificar si hay cotizaciones disponibles
               if ($totalCotizaciones > 0) {
                  // Iterar sobre cada cotización
                  while ($rowCotizacion = $resultCotizaciones->fetch_assoc()) {
                      $cotizacionesMostradas++;
                      // Obtener los detalles de la cotización
                      $numeroCotizacion = $rowCotizacion['NUMERO_COTIZACION'];
                      $fechaCotizacion = $rowCotizacion['FECHA_COTIZACION'];
                      $urlCotizacion = $rowCotizacion['URL'];
                      $estadoCotizacion = $rowCotizacion['ESTADO'];

                      // Obtener el ID de la cotización y del proveedor asociado
                       $idCotizacion = $rowCotizacion['ID_COTIZACION'];
                       $idProveedor = $rowCotizacion['ID_PROVEEDOR'];

                      // Consultar el nombre del proveedor asociado con el ID
                       $sqlProveedor = "SELECT ID_PROVEEDOR, NOMBRE FROM tbl_proveedores WHERE ID_PROVEEDOR = $idProveedor AND ESTADO_PROVEEDOR = 'A'";
                       $resultProveedor = $conn->query($sqlProveedor);
                       $rowProveedor = $resultProveedor->fetch_assoc();
                       $nombreProveedor = $rowProveedor['NOMBRE'];

                      // Consultar todos los proveedores activos excepto el proveedor asociado a esta cotización
                      $sqlProveedores = "SELECT ID_PROVEEDOR, NOMBRE FROM tbl_proveedores WHERE ID_PROVEEDOR != $idProveedor AND ESTADO_PROVEEDOR = 'A'";
                       $resultProveedores = $conn->query($sqlProveedores);
            ?>
                     <!-- Detalles de la cotización -->
                     <form method="post" action="actualizar_cotizacion.php">
                          <input type="hidden" name="id_solicitud" value="<?php echo $idSolicitud; ?>">
                          <input type="hidden" name="id_cotizacion[]" value="<?php echo $rowCotizacion['ID_COTIZACION']; ?>">

                           <h2 style="text-align: center;">Cotización</h2>   
                            <table style="width: 80%; margin: 0 auto;">
                             <tr>
                                   <!-- Dentro del bucle de las cotizaciones -->
                                   <th style="text-align: left;">Proveedor:</th>
                                   <td style="text-align: left;" >
                                   <!-- Crear la lista desplegable de proveedores -->
                                   <select name="id_proveedor[<?php echo $rowCotizacion['ID_COTIZACION']; ?>]" style="width: 300px; height: 30px;">
                                      <!-- Mostrar primero el proveedor asociado a la cotización -->
                                     <option value="<?php echo $idProveedor; ?>"><?php echo $nombreProveedor; ?></option>
                                     <?php
                                          // Mostrar otros proveedores en la lista desplegable
                                          while ($rowProveedor = $resultProveedores->fetch_assoc()) {
                                              $idProveedorOption = $rowProveedor['ID_PROVEEDOR'];
                                               $nombreProveedorOption = $rowProveedor['NOMBRE'];
                                              echo "<option value='$idProveedorOption'>$nombreProveedorOption</option>";
                                            }
                                       ?>
                                   </select>

                                   </td>
                                  <th style="text-align: left;">Número:</th>
                                  <td><input type="text" name="numeroCotizacion[<?php echo $rowCotizacion['ID_COTIZACION']; ?>]" style="max-width: 100px; height: 30px;" value="<?php echo $numeroCotizacion; ?>"></td>
                                  <th style="display: none;">Departamento:</th>
                                  <td style="display: none;"><input required type="text" name="departamento" style="width: 290px;" value="<?php echo $departamentoSolicitud; ?>"></td>
                       
                                </tr>
                   
                                <tr>
                                  <th style="text-align: left;">Fecha:</th>
                                  <td style="text-align: left;"><input type="date" name="fechacotizacion" style="width: 290px; height: 30px;" value="<?php echo $fechaCotizacion; ?>"></td>

                                  <th style="text-align: left;">Estado:</th>
                                  <td><input type="text" name="estado" value="<?php 
                                  $estadoCompleto = '';
                                   switch ($estadoCotizacion) {
                                      case 'PE':
                                          $estadoCompleto = 'PENDIENTE';
                                          break;
                                       case 'PENDIENTE':
                                           $estadoCompleto = 'PENDIENTE';
                                           break;
                                       case 'PRO':
                                          $estadoCompleto = 'PROCESO';
                                          break;
                                        case 'PROCESO':
                                          $estadoCompleto = 'PROCESO';
                                          break;
                                       case 'AP':
                                          $estadoCompleto = 'APROBADA';
                                          break;
                                       case 'APROBADA':
                                           $estadoCompleto = 'APROBADA';
                                           break;
                                       default:
                                        $estadoCompleto = 'Desconocido';
                                        break;
                                    }
                                       echo $estadoCompleto;
                                    ?>" style="max-width: 100px; height: 30px;" readonly></td>
                               </tr>
                               <tr>
                                  <th style="text-align: left;">URL:</th>
                                  <td><textarea name="url" required class="custom-textarea" rows="4" style="width: 100%;"><?php echo $urlCotizacion; ?></textarea></td>
                               </tr>
                          </table>
                
                          <table style="width: 80%; margin: 10px auto;">
                              <!-- Encabezados de la tabla -->
                              <tr>
                                  <th style="width: 10%;">Cantidad</th>
                                  <th style="width: 70%;">Descripción</th>
                                  <th style="width: 20%;">Categoría</th>
                               </tr>
                               <!-- Mostrar productos de la solicitud con opciones de edición -->
                              <?php
                                   $idCotizacion = $rowCotizacion['ID_COTIZACION'];
                                   $sqlProductos = "SELECT CD.ID, CD.CANTIDAD, CD.DESCRIPCION, C.CATEGORIA AS NOMBRE_CATEGORIA
                                   FROM tbl_cotizacion_detalle CD
                                   INNER JOIN tbl_categorias C ON CD.ID_CATEGORIA = C.id
                                   WHERE CD.ID_COTIZACION = $idCotizacion";

                                   $resultProductos = $conn->query($sqlProductos);

                                  if ($resultProductos->num_rows > 0) {
                                      while ($rowProducto = $resultProductos->fetch_assoc()) {
                                          echo "<tr>";
                                          echo "<input type='hidden' name='id[]' value='" . $rowProducto['ID'] . "'>"; // Campo oculto para el ID del detalle
                                          echo "<td><input type='number' name='cantidad[]' value='" . $rowProducto['CANTIDAD'] . "' class='cant-input' style='width: 80%; height: 45px;' required></td>";
                                          echo "<td><textarea name='descripcion[]' readonly class='same-width' style='width: 100%; height: 75px;'>" . $rowProducto['DESCRIPCION'] . "</textarea></td>";

                                          echo "<td>";
                                          echo "<input type='text' name='categoria[]' value='" . $rowProducto['NOMBRE_CATEGORIA'] . "' readonly class='same-width' style='width: 80%; height: 45px;' >";

                                         echo "</td>";
                                          echo "</tr>";
                                        }
                                    } else {
                                      echo "<tr><td colspan='3'>No hay productos asociados a esta solicitud para esta cotización.</td></tr>";
                                    }
                    
                                ?>
                 
                            </table>
                            <?php
                               }
                               // Botones de guardar fuera del bucle
                                ?>
                         <!-- Botones de guardar -->
                         <div style="text-align: center; margin-top: 20px;">
                              <input type="submit" value="Guardar" class="custom-button create-button">
                              <input type="button" value="Cancelar" class="btn btn-warning custom-button cancel-button" onclick="window.location.href='../solicitudes/solicitudes.php';">
                            </div>
                      </form>
                 <?php
               } else {
                  echo "No se encontraron cotizaciones para esta solicitud.";
               }

            ?>

    
        </div>

    </div>
</body>
</html>
