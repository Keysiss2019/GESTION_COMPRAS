
<!DOCTYPE html>
<html>
<head>
    <title>Orden de Compra</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <style>
        /* Estilos para la cabecera de la orden de compra */
        .order-header {
            margin-right: 100px;
            float: left;
            margin-top: 20px;
        }

        /* Estilos para la tabla de la orden de compra */
        .order-table {
          width: 100%;
          border-collapse: collapse;
          margin-top: 20px;
        }

       .order-table th, .order-table td {
         border: 1px solid black;
         padding: 8px;
         text-align: center;
         white-space: nowrap; /* Evitar que el texto se ajuste automáticamente a la siguiente línea */
         overflow: hidden;
         text-overflow: ellipsis; /* Mostrar puntos suspensivos (...) cuando el texto es demasiado largo */
        }

        .order-table th:first-child,
        .order-table td:first-child {
          width: 5%; /* Ajusta el ancho de la primera columna según tus necesidades */
        }

        .order-table th:nth-child(2),
        .order-table td:nth-child(2) {
         width: 40%; /* Ajusta el ancho de la segunda columna según tus necesidades */
        }

       .order-table th:nth-child(3),
       .order-table td:nth-child(3),
       .order-table th:nth-child(4),
       .order-table td:nth-child(4) {
          width: 15%; /* Ajusta el ancho de las columnas 3 y 4 según tus necesidades */
        }

       .order-table th:last-child,
       .order-table td:last-child {
         width: 20%; /* Ajusta el ancho de la última columna según tus necesidades */
        }

        /* Estilos para la firma del solicitante */
        .order-signature {
            margin-top: 20px;
        } 
    
      
       /* Contenedor de la tabla de orden total */
      .order-total-container {
         position: relative;
        }

       /* Estilos para la tabla de orden total */
       .order-total {
          position: absolute;
          top: 0;
           left: 370px; /* Ajusta el margen derecho según tus necesidades */
           text-align: right;
        }

        .order-total table {
          width: 39%;
          border-collapse: collapse;
          margin-top: 0px;
          margin-left: auto; /* Centra la tabla horizontalmente */
          margin-right: auto; /* Centra la tabla horizontalmente */
        }

        .order-total td {
          /* Estilos para las celdas de la tabla de orden total */
          border: 1px solid black;
          padding: 8px;
          text-align: center;
          white-space: nowrap;
          overflow: hidden;
          text-overflow: ellipsis;
        }


        .order-total td:first-child {
         width: 5%;
        }

        .order-total td:nth-child(2) {
          width: 39%;
        }

        .order-total td:nth-child(3),
        .order-total td:nth-child(4) {
           width: 39%;
        }

        .order-total td:last-child {
          width: 39%;
        }

       .centered-content {
         display: flex;
         flex-direction: column;
         justify-content: center;
         align-items: center;
         height: 10vh;     
        }

       .botones-container {
         display: flex;
        }

      .boton-azul,
      .boton-verde {
         background-color: blue;
         color: white;
         padding: 10px 15px;
         border: none;
         border-radius: 5px;
         cursor: pointer;
         text-decoration: none; /* Para quitar el subrayado en el enlace */
         margin-right: 10px; /* Espaciado entre los botones */
        }

       .boton-verde {
         background-color: green;
        }

    </style>
</head>
<body>
    <div style="text-align: center; position: relative;">
         
      <img src="../imagen/IHCIS.jpg" alt="Logo 1" style="width: 60px; position: absolute; top: 0; left: 0; margin-left: 30px;">

      <div class="centered-content" style="display: inline-block; text-align: center; margin: 0; padding: 0;">
         <p style="margin: 0;"><strong>INSTITUTO HONDUREÑO DE CULTURA INTERAMERICANA</strong></p>
         <p style="margin: 0;"><strong>RTN 08019995223469</strong></p>
          <p style="margin: 0; color: blue;"><strong>SOLICITUD COMPRAS</strong></p>
       </div>


       <img src="../imagen/IHCI1.jpg" alt="Logo 2" style="width: 70px; position: absolute; top: 0; right: 0; margin-right: 140px;">

    </div>

    <div class="order-header">
        <?php
         // Incluir el archivo de configuración de la base de datos
          include '../conexion/conexion.php';
            
           
          // Consulta para obtener el número de orden más alto
          $sql = "SELECT MAX(NUMERO_ORDEN) as max_numero_orden FROM tbl_orden_compra";
           $result = $conn->query($sql);
  
            if ($result->num_rows > 0) {
              $row = $result->fetch_assoc();
              $max_numero_orden = $row["max_numero_orden"];
              $nuevo_numero_orden = str_pad((intval($max_numero_orden) + 1), 4, '0', STR_PAD_LEFT);
            } else {
              // Si no hay órdenes en la base de datos, comienza con 0001
               $nuevo_numero_orden = "0001";
            }
        ?>
        
        <form action="guardar_orden.php" method="POST">
       
        <?php
        // Recuperar el ID de la cotización de la URL
        $cotizacionId = isset($_GET['cotizacion_id']) ? $_GET['cotizacion_id'] : null;

        // Validar el ID de la cotización
        if ($cotizacionId === null || !is_numeric($cotizacionId)) {
            echo "ID de cotización no válido";
            exit;
        }

        // Consulta para obtener el ID de la solicitud basado en el ID de la cotización
        include '../conexion/conexion.php'; // Asegúrate de incluir el archivo de conexión a la base de datos
        $sqlObtenerIdSolicitud = "SELECT ID FROM tbl_cotizacion WHERE ID_COTIZACION = ?";
        $stmtObtenerIdSolicitud = $conn->prepare($sqlObtenerIdSolicitud);
        $stmtObtenerIdSolicitud->bind_param("i", $cotizacionId);
        $stmtObtenerIdSolicitud->execute();
        $resultIdSolicitud = $stmtObtenerIdSolicitud->get_result();

        // Definir la variable $idSolicitud antes de intentar mostrarla en pantalla
        $idSolicitud = null;

        // Verificar si se encontró el ID de la solicitud
        if ($resultIdSolicitud->num_rows > 0) {
            // Obtener el valor del ID de la solicitud
            $rowIdSolicitud = $resultIdSolicitud->fetch_assoc();
            $idSolicitud = $rowIdSolicitud['ID'];
        }

        // Agrega aquí la lógica para mostrar otros detalles de la solicitud según tu estructura de base de datos
        ?>
        <p>ID de Solicitud: <?php echo ($idSolicitud !== null ? $idSolicitud : "No encontrado"); ?></p>


      <!-- Elemento para mostrar el ID de la cotización -->
       <p id="cotizacionIdDisplay">ID de Cotización: </p>

            <p style="display: flex; justify-content: space-between;">
              <span>Nº de Pedido: <?php echo $nuevo_numero_orden; ?></span>
            </p>
           <input type="hidden" name="numero_orden" value="<?php echo $nuevo_numero_orden; ?>">

           <p style="display: flex; align-items: center;"> <!-- Utilizamos flexbox para alinear verticalmente los elementos -->
             <span style="width: 71px;">Fecha:</span> <!-- Establecemos un ancho fijo para el label de la fecha -->
             <input type="text" name="fecha_orden" style="margin-left: 10px; width: 188px;" value="<?php echo date("Y-m-d"); ?>">
            </p>

            <p style="display: flex; align-items: center;"> <!-- Utilizamos flexbox para alinear verticalmente los elementos -->
               <span style="width: 80px;">Proveedor:</span>
              <input type="text" name="proveedor" id="proveedorTexto" readonly> <!-- Campo de texto para mostrar el proveedor -->
           </p>

           <input type="hidden" name="cotizacion_id" id="cotizacionIdInput" value="<?php echo $cotizacionId; ?>">           
           <input type="hidden" name="proveedor_id" id="proveedorId" value="">


    </div>
    <!-- Tabla para mostrar detalles de cotización -->
   
    <table class="order-table">
        <thead>
            <tr>
                <th>Cantidad</th>
                <th>Descripción del Artículo</th>
                <th>Precio Unitario</th>
                <th>Valor Total</th>
                <th>Excento</th>
                
            </tr>

        </thead>
        <tbody id=cotizacionesTable>
        </tbody>
       
    </table>

  <!-- Calcular Sub-Total, 15% ISV y Total Factura debajo de la tabla -->
  <div class="order-total-container">
  <div class="order-total">
        <table>
            <tbody>
                <tr>
                    <td style=" border: none;  text-align: right; font-weight: bold;"><label>Sub-Total:</label></td>
                    <td><span class="subtotalValue" style="font-weight: bold;">0.00</span></td>
                    <input type="hidden" name="subtotal" id="subtotalInput" value="0,00">
                </tr>
                <tr>
                    <td style=" border: none;  text-align: right; font-weight: bold;"><label>15% ISV:</label></td>
                    <td><span id="isvValue" style="font-weight: bold;">0.00</span></td>
                    <input type="hidden" name="isv" id="isvInput" value="">
                </tr>
                <tr>
                    <td style=" border: none;  text-align: right; font-weight: bold;"><label>Total Factura:</label></td>
                    <td><span id="totalValue" style="font-weight: bold;">0.00</span></td>
                    <input type="hidden" id="total_factura_input" name="total_factura" value="0.00">
                    <input type="hidden" id="montoInput" name="monto" value="">


                  </tr>
                
            </tbody>
        </table>
    </div>
    </div>

   
    <br><br>
    <div class="botones-container">
      
    <input type="submit" id="btnGuardarOrden" class="boton-verde" value="Guardar Orden">

      <a href="../solicitudes/solicitudes.php" class="boton-azul">Regresar</a>
    </div>
    </form>

    <script>

        document.addEventListener('DOMContentLoaded', function() {
         const urlParams = new URLSearchParams(window.location.search);
         const cotizacionId = urlParams.get('cotizacion_id');

         // Mostrar el ID de la cotización en pantalla
          document.getElementById('cotizacionIdDisplay').textContent = 'ID de Cotización: ' + cotizacionId;

          // Realizar una solicitud AJAX para obtener el proveedor asociado a la cotización
           $.ajax({
              type: "GET",
              url: "obtener_proveedor.php",
               data: { cotizacion_id: cotizacionId },
               success: function(response) {
              // Verificar si se recibió un nombre de proveedor o un mensaje de error
              const data = JSON.parse(response);
              if (data.nombre) {
                  // Mostrar el nombre del proveedor en el campo de texto correspondiente
                  $('#proveedorTexto').val(data.nombre);

                  // Obtener y asignar el ID del proveedor al campo oculto
                  $('#proveedorId').val(data.id);

                  // Mostrar el ID del proveedor en el elemento HTML correspondiente
                   $('#proveedorIdDisplay').text('ID del proveedor: ' + data.id);
           
                } else {
                  // Mostrar un mensaje de error si no se encuentra el proveedor
                  $('#proveedorTexto').val('Proveedor no encontrado');
                }
            },
           error: function(xhr, status, error) {
               console.error("Error en la solicitud AJAX:", status, error);
            }
        });





        // Realizar una solicitud AJAX para obtener los detalles de la cotización
        $.ajax({
            type: "GET",
            url: "obtener_cotizaciones.php",
            data: { cotizacion_id: cotizacionId },
            success: function(response) {
                // Verificar si se recibieron los detalles de la cotización correctamente
                const data = JSON.parse(response);
                if (data.length > 0) {
                    // Agregar filas a la tabla con los detalles de la cotización
                    data.forEach(function(detalle) {
                        var filaDetalle = '<tr>' +
                            '<td>' + detalle.cantidad + '</td>' +
                            '<td>' + detalle.descripcion + '</td>' +
                            '<td><input type="text" class="precioInput" placeholder="Ingrese el precio"></td>' + // Agregamos un campo de texto para que el usuario ingrese el precio
                            '<td class="valorTotal"></td>' +
                            '<td>' + (detalle.excento ? 'Sí' : 'No') + '</td>' +
                             '</tr>';
                           $("#cotizacionesTable").append(filaDetalle);
                   });
                 
                 // Calcular totales cuando el usuario ingresa el precio
                 $(".precioInput").on("input", function() {
                     calcularTotales();
                  });

                  // Calcular totales
                    calcularTotales();
                } else {
                    // Mostrar un mensaje si no se encontraron detalles de la cotización
                    $("#cotizacionesTable").append('<tr><td colspan="5">No se encontraron detalles de la cotización.</td></tr>');
                }
            },
            error: function(xhr, status, error) {
                console.error("Error en la solicitud AJAX:", status, error);
            }
        });
    });

    // Función para enviar los datos al servidor
    $("#btnGuardarOrden").on("click", function() {
        console.log("Botón Guardar clickeado");
        // Obtener los datos del formulario
        var formData = $("form").serialize();

        // Obtener las cotizaciones y precios
        var cotizaciones = [];
        var precios = [];

        $("#cotizacionesTable tr").each(function(index, row) {
            var cantidad = $(row).find("td:eq(0)").text();
            var descripcion = $(row).find("td:eq(1)").text();
            var precio = parseFloat($(row).find(".precioInput").val()) || 0;

            cotizaciones.push({ cantidad: cantidad, descripcion: descripcion });
            precios.push(precio);
        });

        // Agregar las cotizaciones y precios a los datos del formulario
        formData += "&cotizaciones=" + JSON.stringify(cotizaciones);
        formData += "&precios=" + JSON.stringify(precios);

        // Enviar datos al servidor a través de AJAX
        $.ajax({
            type: "POST",
            url: "guardar_orden.php",
            data: formData,
            dataType: 'json',
            success: function(response) {
                console.log(response);
                // Manejar la respuesta del servidor si es necesario

                // Redirigir a ordenes_compras.php después de guardar
                window.location.href = "compras.php?cotizacion_id=<?php echo $cotizacionId; ?>";
            },
            error: function(xhr, status, error) {
                console.error("Error en la solicitud AJAX:", status, error);
            }
        });
    });

    // Función para limpiar y calcular totales
    function calcularTotales() {
    var subtotal = 0;

    // Calcular y mostrar el valor total en la fila
    $("#cotizacionesTable tr").each(function(index, row) {
        var cantidad = $(row).find("td:eq(0)").text();
        var precio = parseFloat($(row).find(".precioInput").val()) || 0;
        var valorTotal = cantidad * precio;
        $(row).find(".valorTotal").text(valorTotal.toFixed(2));

        subtotal += valorTotal;
    });

    // Realizar una solicitud AJAX para obtener el valor del impuesto ISV
    $.ajax({
        type: "GET",
        url: "obtener_ISV.php",
        success: function(response) {
            // Verificar si se recibió el valor del impuesto ISV correctamente
            const data = JSON.parse(response);
            if (data.impuesto) {
                var impuesto = parseFloat(data.impuesto);
                var isv = subtotal * (impuesto / 100); // Calcular el impuesto (ISV)
                var total = subtotal + isv; // Calcular el total
                // Actualizar los campos ocultos con los totales calculados
                $(".subtotalValue").text(subtotal.toFixed(2));
                $("#isvValue").text(isv.toFixed(2));
                $("#totalValue").text(total.toFixed(2));
                // Actualizar los campos ocultos con los totales calculados (estos se envían al servidor)
                $("#subtotalInput").val(subtotal.toFixed(2));
                $("#isvInput").val(isv.toFixed(2));
                $("#total_factura_input").val(total.toFixed(2));
            } else {
                console.error("Error: No se recibió el valor del impuesto ISV desde el servidor");
            }
        },
        error: function(xhr, status, error) {
            console.error("Error en la solicitud AJAX para obtener el impuesto ISV:", status, error);
        }
    });
}


</script>


</body>
</html>