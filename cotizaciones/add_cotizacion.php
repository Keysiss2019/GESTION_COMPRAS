<?php
include 'db_connection.php';

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
            background-color: #ddd; /* Color de fondo del contenedor */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            opacity: 0.9;
        }

        .table {
            width: 100%; /* Ajusta el ancho de la tabla al 100% del contenedor */
            box-sizing: border-box;
            margin-bottom: 20px; /* Agrega margen inferior */
            background-color: #ddd; /* Color de fondo para las tablas */
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
            margin-bottom: 60px; /* Agrega un margen inferior de 20px entre las secciones de cotización */
    
        }

        .table-container table {
            width: 80%; /* Ajusta el ancho de la tabla al 100% del contenedor */
            margin-bottom: 20px; /* Agrega margen inferior */
            background-color: cornsilk; /* Color de fondo para las tablas */
            margin-left: 64px;
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

        /* Estilo para el botón "Agregar" */
       .custom-button.create-add {
         background-color: green; /* Azul */
         color: #fff; /* Texto blanco */
         border: 1px solid #0056b3; /* Borde azul más oscuro */
         margin-right: 40px;
        }

        /* Estilo para el botón "Guardar" */
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
    
       .custom-select {
          width: 200px; /* Ancho personalizado */
          height: 35px; /* Altura personalizada */
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
        
           <h2 style="text-align: center;">Cotización
             <button id="addQuote" class="custom-button create-add" style="float: right; margin-top: -10px;">Agregar Cotización</button>
          </h2>
          <form  method="post" action="guardar_cotizacion.php?id=<?php echo $idSolicitud; ?>">

           <!-- Sección de Cotización -->
           <div id="quoteSection">
              <div class="table-container">
                 <table style="width: 80%; margin: 0 auto;">
                       <tr>
                          <th>Proveedor:</th>
                          <td>
                             <select name="id_proveedor[]" required class="custom-select">
                                 <option value="">--Seleccione--</option>
                                  <?php
                                     // Ajusta la consulta para buscar proveedores con estado "A" (activo)
                                      $sql = "SELECT ID_PROVEEDOR, NOMBRE FROM tbl_proveedores WHERE ESTADO_PROVEEDOR = 'A'";
                                      $result = $conn->query($sql);
                                      if ($result->num_rows > 0) {
                                          while ($row = $result->fetch_assoc()) {
                                              echo "<option value='" . $row["ID_PROVEEDOR"] . "'>" . $row["NOMBRE"] . "</option>";
                                            }
                                        } else {
                                          echo "<option value='' disabled>No hay proveedores activos disponibles</option>";
                                        }
                                    ?>
                               </select>
                           </td>
                             <th>Número:</th>
                             <td><input type="text" name="numero_cotizacion[]" style="max-width: 100px; height: 30px;"></td>
                       </tr>
                        <tr style="display: none;">
                          <th>Departamento:</th>
                          <td><input required type="text" name="departamento[]" style="width: 290px;" value="<?php echo $departamentoSolicitud; ?>"></td>                
                       </tr>
                       <tr>
                         <th>URL:</th>
                         <td>
                             <textarea name="url[]" required class="custom-textarea" rows="2"></textarea>
                           </td>
                          <th>Fecha:</th>
                           <td><input type="date" name="fecha_cotizacion[]" style="max-width: 100px; height: 30px;"></td>
                           <th>Estado:</th>
                           <td><input type="text" name="estado[]" value="PENDIENTE" required style="max-width: 100px; height: 30px;"></td>
                       </tr>
                   </table>
                   <!-- Tabla de Productos de la Solicitud -->
                   <table id="quoteTable">
                      <tr>
                         <th>Cantidad</th>
                         <th>Descripción</th>
                         <th>Categoría</th>
                          <th>Acciones</th>
                      </tr>
                       <?php
                          // Obtener y mostrar información de los productos
                          $sqlProductos = "SELECT cantidad, descripcion, categoria FROM tbl_productos WHERE id_solicitud = $idSolicitud";
                          $resultProductos = $conn->query($sqlProductos);

                          if ($resultProductos->num_rows > 0) {
                               while ($rowProducto = $resultProductos->fetch_assoc()) {
                                  echo "<tr>";
                                  echo "<td><input type='number' name='cantidad[]' value='" . $rowProducto['cantidad'] . "' class='editable-field'></td>";
                                 echo "<td><textarea name='descripcion[]' class='editable-field'>" . $rowProducto['descripcion'] . "</textarea></td>";
                                  // Obtener la categoría asociada al producto
                                  $categoriaId = $rowProducto['categoria'];
                                  $sqlCategoria = "SELECT id, categoria FROM tbl_categorias WHERE id = $categoriaId";
                                  $resultCategoria = $conn->query($sqlCategoria);
                                   if ($resultCategoria->num_rows > 0) {
                                      $rowCategoria = $resultCategoria->fetch_assoc();
                                     echo "<td><input type='text' name='categoria[]' value='" . $rowCategoria['categoria'] . "' class='editable-field'></td>";
                                    } else {
                                      echo "<td>Categoría no encontrada</td>";
                                    }
                                 // Botón de eliminar
                                 echo "<td><button class='btn btn-danger deleteRow'>Eliminar</button></td>";

                                  echo "</tr>";
                                }
                            } else {
                              echo "<tr><td colspan='4'>No hay productos asociados a esta solicitud.</td></tr>";
                            }
                       ?>
                   </table>
               </div>
           </div>
    
           <!-- Botones de Crear y Cancelar -->
           <div id="actionButtons" style="margin-top: 20px; float: left;">
              <input type="submit" value="Guardar" class="custom-button create-button">
              <input type="button" value="Cancelar" class="btn btn-warning custom-button cancel-button" onclick="window.location.href='../solicitudes/solicitudes.php';">
           </div>
           </form>
       </div>
       

       <script>
          // Función para agregar dinámicamente más secciones de cotización
           function addQuoteSection() {
              var newQuoteSection = document.createElement('div');
               newQuoteSection.classList.add('table-container');

               var htmlContent = `
                <table style="width: 80%; margin: 0 auto; margin-left: 63px;">
                <tr>
                    <th>Proveedor:</th>
                    <td>
                        <select name="id_proveedor[]" required class="custom-select">
                            <option value="">--Seleccione--</option>
                            <?php
                              // Ajusta la consulta para buscar proveedores con estado "A" (activo)
                              $sql = "SELECT ID_PROVEEDOR, NOMBRE FROM tbl_proveedores WHERE ESTADO_PROVEEDOR = 'A'";
                              $result = $conn->query($sql);
                              if ($result->num_rows > 0) {
                                  while ($row = $result->fetch_assoc()) {
                                     echo "<option value='" . $row["ID_PROVEEDOR"] . "'>" . $row["NOMBRE"] . "</option>";
                                    }
                                } else {
                                  echo "<option value='' disabled>No hay proveedores activos disponibles</option>";
                                }
                            ?>
                        </select>
                    </td>
                    <th>Número:</th>
                    <td><input type="text" name="numero_cotizacion[]" style="max-width: 100px; height: 30px;"></td>
                </tr>
                <tr style="display: none;">
                    <th>Departamento:</th>
                    <td><input required type="text" name="departamento[]" style="width: 290px;" value="<?php echo $departamentoSolicitud; ?>"></td>
                    
                </tr>
                <tr>
                    <th>URL:</th>
                    <td>
                        <textarea name="url[]" required class="custom-textarea" rows="2"></textarea>
                    </td>
                    <th>Fecha:</th>
                    <td><input type="date" name="fecha_cotizacion[]" style="max-width: 100px; height: 30px;"></td>
                    <th>Estado:</th>
                    <td><input type="text" name="estado[]" value="PENDIENTE" required style="max-width: 100px; height: 30px;"></td>
                </tr>
               </table>

               <!-- Tabla de Productos de la Solicitud -->
               <table id="quoteTable">
                <tr>
                    <th>Cantidad</th>
                    <th>Descripción</th>
                    <th>Categoría</th>
                    <th>Acciones</th>
                </tr>
                <?php
                  // Obtener y mostrar información de los productos
                  $sqlProductos = "SELECT cantidad, descripcion, categoria FROM tbl_productos WHERE id_solicitud = $idSolicitud";
                  $resultProductos = $conn->query($sqlProductos);
 
                    if ($resultProductos->num_rows > 0) {
                        while ($rowProducto = $resultProductos->fetch_assoc()) {
                           echo "<tr>";
                           echo "<td><input type='number' name='cantidad[]' value='" . $rowProducto['cantidad'] . "' class='editable-field'></td>";
                           echo "<td><textarea name='descripcion[]' class='editable-field'>" . $rowProducto['descripcion'] . "</textarea></td>";

                           // Obtener la categoría asociada al producto
                           $categoriaId = $rowProducto['categoria'];
                           $sqlCategoria = "SELECT id, categoria FROM tbl_categorias WHERE id = $categoriaId";
                           $resultCategoria = $conn->query($sqlCategoria);
                           if ($resultCategoria->num_rows > 0) {
                               $rowCategoria = $resultCategoria->fetch_assoc();
                               echo "<td><input type='text' name='categoria[]' value='" . $rowCategoria['categoria'] . "' class='editable-field'></td>";
                            } else {
                               echo "<td>Categoría no encontrada</td>";
                            }
                           // Botón de eliminar
                           echo "<td><button class='btn btn-danger deleteRow'>Eliminar</button></td>";

                           echo "</tr>";
                        }
                    } else {
                      echo "<tr><td colspan='4'>No hay productos asociados a esta solicitud.</td></tr>";
                    }
                ?>
               </table>
               </div>
                `;

              newQuoteSection.innerHTML = htmlContent;
              document.getElementById('quoteSection').appendChild(newQuoteSection);
               // Vincular evento de eliminación para el botón de eliminar en la nueva sección de cotización
               var deleteButtons = newQuoteSection.querySelectorAll('.deleteRow');
               deleteButtons.forEach(function(button) {
                  button.addEventListener('click', function() {
                      var row = button.closest('tr'); // Obtener la fila que contiene el botón de eliminar
                      row.remove(); // Eliminar solo la fila correspondiente, no la sección completa
                    });
                });

               // Agregar el margen entre las secciones de cotización
               newQuoteSection.style.marginBottom = '60px';
            }

            // Llama a la función para agregar una nueva sección de cotización al hacer clic en el botón
            document.getElementById('addQuote').addEventListener('click', addQuoteSection);

           // Función para vincular el evento click para el botón de eliminar
           function bindDeleteRowEvent() {
              var deleteButtons = document.querySelectorAll('.deleteRow');
               deleteButtons.forEach(function(button) {
                   button.addEventListener('click', function() {
                        var row = button.closest('tr');
                        row.remove();
                    });
                });
            }

           // Llama a la función para vincular el evento click para el botón de eliminar
           bindDeleteRowEvent();
        </script>
        
    </div>

</body>
</html>

















