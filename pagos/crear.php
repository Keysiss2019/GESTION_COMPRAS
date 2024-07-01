<!DOCTYPE html>
<html>
<head>
    <title>Crear Pago</title>
    <style>
        body {
            text-align: left;
            font-family: Arial, sans-serif;
            background: rgba(255, 255, 255, 0.10);
            background-image: url('../imagen/IHCIS.jpg');
            background-size: 40%;
            background-position: center;
            background-repeat: no-repeat;
            margin: 0;
            padding: 0;
        }
        .container {
            display: flex;
            justify-content: center;
            border: 1px solid #ccc;
            padding: 20px;
            margin: 20px;
            background-color: powderblue;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            opacity: 0.9;
        }

        .table {
            width: 100%;
            box-sizing: border-box;
            background-color: cornsilk;
            padding: 10px;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }

        .table h2 {
            text-align: center;
            width: 100%;
        }

        .left-column {
            width: calc(50% - 5px);
        }

        .right-column {
            width: calc(50% - 5px);
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="date"],
        textarea {
            width: calc(100% - 20px);
            padding: 8px;
            margin-bottom: 10px;
            box-sizing: border-box;
        }

        button[type="submit"] {
            padding: 20px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
        }

        button[type="submit"]:hover {
            background-color: #0056b3;
        }

        .error-message-container {
            text-align: center;
            margin-top: 20px;
        }
     
        .contacto-select {
          width: 96.5%;
           height: 34px;
           font-size: 14px;
           padding: 5px;
           margin-bottom: 15px; /* Añade margen inferior para espaciarlo del siguiente campo */
        }
        .cantidad-input {
          width: 100%;  /* Asegura que el campo use todo el ancho disponible */
          height: 35px; /* Ajusta la altura del campo */
          font-size: 16px; /* Ajusta el tamaño de la fuente */
          padding: 5px; /* Agrega relleno para mejor presentación */
          margin-bottom: 15px; /* Añade margen inferior para espaciarlo del siguiente campo */
        }

        .button-group {
            display: flex;
            justify-content: flex-start; /* Cambia a 'flex-end' o 'center' según sea necesario */
            gap: 10px; /* Espacio entre los botones */
            margin-top: 15px; /* Espacio arriba de los botones */
        }

        /* Estilo para el botón de cancelar */
       
        .cancel-button {
            width: 120px; /* Ancho  */
            padding: 10px; /* Relleno uniforme */
            background-color: #6c757d; /* Gris */
            color: white; /* Texto blanco */
            border: 1px solid #555; /* Borde gris más oscuro */
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
            margin-right: 1120px;
        }
    </style>
</head>
<body>
   <?php
     include('../conexion/conexion.php');

        // Verificar si se proporcionó un número de orden válido en la URL
       if(isset($_GET['numero_orden'])) {
          // Obtener el número de orden de la URL
         $numero_orden = $_GET['numero_orden'];

         // Consulta para obtener los detalles de la orden de compra
         $sql_orden = "SELECT oc.*, p.NOMBRE AS NOMBRE_PROVEEDOR 
                      FROM tbl_orden_compra oc
                      INNER JOIN tbl_proveedores p ON oc.ID_PROVEEDOR = p.ID_PROVEEDOR
                      WHERE oc.ID_ORDEN_COMPRA = '$numero_orden'";
          $result_orden = $conn->query($sql_orden);

          if($result_orden->num_rows > 0) {
              $row_orden = $result_orden->fetch_assoc();

              // Obtener el monto de la orden de compra producto (si es necesario)
              $monto = obtenerMontoOrdenCompraProducto($conn, $numero_orden);
           
              // Obtener la lista de contactos del proveedor
               $contactos = obtenerContactosProveedor($conn, $row_orden['ID_PROVEEDOR']);
    ?>


            <form id="formulario_orden_pago" action="procesar_pago.php" method="POST">
                 
                <div class="container">
                   
                    <!-- Tabla -->
                    <div class="table">
                       <div id="mensaje_error" style="color: red;"></div>
    
                        <h2>ORDEN DE PAGO</h2>
                        
                        <!-- Columna Izquierda -->
                        <div class="left-column">
                            <label for="lugar">Lugar:</label>
                            <input type="text" id="lugar" name="lugar" required>

                            <label for="fecha_orden">Fecha:</label>
                            <input type="date" id="fecha_orden" name="fecha_orden" required>

                            <label for="nombre_proveedor">A favor:</label>
                            <input type="text" id="nombre_proveedor" name="nombre_proveedor" value="<?php echo $row_orden['NOMBRE_PROVEEDOR']; ?>" readonly>
                            <input type="hidden" name="id_proveedor" value="<?php echo $row_orden['ID_PROVEEDOR']; ?>">

                            <label for="contacto_proveedor">Contacto:</label>
                            <select id="contacto_proveedor" name="contacto_proveedor" required class="contacto-select">
                                <?php foreach ($contactos as $contacto): ?>
                                 <option value="<?php echo $contacto['NOMBRE']; ?>"><?php echo $contacto['NOMBRE']; ?></option>
                                 <?php endforeach; ?>
                            </select>

                            <label for="monto_total">Cantidad:</label>
                            <input type="text" id="monto_total" name="monto_total" value="<?php echo $monto; ?>" readonly class="cantidad-input">
                        
                           
                        </div>

                        <!-- Columna Derecha -->
                        <div class="right-column">
                        
                        <label for="banco">Banco:</label>
                            <input type="text" id="banco" name="banco" value="<?php echo obtenerBancoProveedor($conn, $row_orden['ID_PROVEEDOR']); ?>" readonly>

                            <label for="numero_cuenta">Número de Cuenta:</label>
                            <input type="text" id="numero_cuenta" name="numero_cuenta" value="<?php echo obtenerNumeroCuentaProveedor($conn, $row_orden['ID_PROVEEDOR']); ?>" readonly>

                            <label for="tipo_cuenta">Tipo de Cuenta:</label>
                            <input type="text" id="tipo_cuenta" name="tipo_cuenta" value="<?php echo obtenerTipoCuentaProveedor($conn, $row_orden['ID_PROVEEDOR']); ?>" readonly>

                            <label for="solicitante">Nombre del Solicitante:</label>
                            <input type="text" id="solicitante" name="solicitante" required>
                            <input type="hidden" name="id_orden_compra" value="<?php echo $numero_orden; ?>">
                            <label for="concepto">Concepto:</label>
                            <textarea id="concepto" name="concepto" rows="4" cols="30" required></textarea>

                        </div>
                        <div class="button-group">
                        <button type="submit">Crear Pago</button>
                        <button type="button" onclick="window.location.href='../compras/ordenes_compras.php';" class="cancel-button">Cancelar</button>
                    </div>
                    </div>
                </div>
                
            </form>
            <?php
        } else {
            echo "Error: No se encontró la orden de compra especificada.";
        }
    } else {
        echo "Error: No se proporcionó un número de orden válido.";
    }

    $conn->close();
   
    function obtenerMontoOrdenCompraProducto($conn, $numero_orden) {
        // Consulta para obtener el monto de la orden de compra producto
        $sql_monto = "SELECT SUM(MONTO) AS MONTO FROM tbl_orden_compra WHERE ID_ORDEN_COMPRA= '$numero_orden'";
        $result_monto = $conn->query($sql_monto);
        if($result_monto->num_rows > 0) {
            $row_monto = $result_monto->fetch_assoc();
            return $row_monto['MONTO'];
        } else {
            return 0;
        }
    }

    function obtenerNumeroCuentaProveedor($conn, $idProveedor) {
        $sql = "SELECT NUMERO_CUENTA FROM tbl_cuenta_proveedor WHERE ID_PROVEEDOR = '$idProveedor'";
        $result = $conn->query($sql);
        if($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row['NUMERO_CUENTA'];
        } else {
            return "";
        }
    }

    function obtenerTipoCuentaProveedor($conn, $idProveedor) {
        $sql = "SELECT DESCRIPCION_CUENTA FROM tbl_cuenta_proveedor WHERE ID_PROVEEDOR = '$idProveedor'";
        $result = $conn->query($sql);
        if($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row['DESCRIPCION_CUENTA'];
        } else {
            return "";
        }
    }

    function obtenerBancoProveedor($conn, $idProveedor) {
        $sql = "SELECT BANCO FROM tbl_cuenta_proveedor WHERE ID_PROVEEDOR = '$idProveedor'";
        $result = $conn->query($sql);
        if($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row['BANCO'];
        } else {
            return "";
        }
    }

    function obtenerContactosProveedor($conn, $idProveedor) {
        $sql = "SELECT ID_CONTACTO_PROVEEDOR, NOMBRE FROM tbl_contactos_proveedores WHERE ID_PROVEEDOR = '$idProveedor'";
        $result = $conn->query($sql);
        $contactos = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $contactos[] = $row;
            }
        }
        return $contactos;
    }
    
    ?>

    <!-- Script de JavaScript para enviar el formulario mediante AJAX -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Cuando se envíe el formulario
            $('#formulario_orden_pago').submit(function(event) {
                // Detener el envío del formulario por defecto
                event.preventDefault();

                // Obtener los datos del formulario
                var formData = $(this).serialize();

                // Enviar los datos al servidor usando AJAX
                $.ajax({
                    type: 'POST',
                    url: 'procesar_pago.php', // Archivo PHP que procesará el formulario
                    data: formData,
                    success: function(response) {
                        // Si se recibe una respuesta del servidor
                        $('#mensaje_error').html(response);
                    }
                });
            });
        });


    </script>
</body>
</html>


