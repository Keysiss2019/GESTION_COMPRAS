<?php
  // Inicializar la variable de mensaje de error
  $error_message = "";


  // Verificar si se recibieron los datos del formulario
   if ($_SERVER["REQUEST_METHOD"] == "POST") {
      // Recibir y sanitizar los datos del formulario
     $lugar = htmlspecialchars($_POST["lugar"]);
     $fecha = htmlspecialchars($_POST["fecha_orden"]);
     $a_favor = htmlspecialchars($_POST["id_proveedor"]); 
     $contacto = htmlspecialchars($_POST["contacto_proveedor"]);
     $monto = htmlspecialchars($_POST["monto_total"]); 
     $concepto = htmlspecialchars($_POST["concepto"]);
     $numero_cuenta = htmlspecialchars($_POST["numero_cuenta"]);
     $tipo_cuenta = htmlspecialchars($_POST["tipo_cuenta"]);
     $banco = htmlspecialchars($_POST["banco"]);
     $nombre = htmlspecialchars($_POST["solicitante"]);
     $numero_orden = htmlspecialchars($_POST["id_orden_compra"]);

      // Conexión a la base de datos (debes reemplazar estos valores con los de tu configuración)
      include '../conexion/conexion.php'; 

      // Verificar si ya existe una orden de pago para esta orden de compra
      $sql_verificar_orden_pago = "SELECT * FROM tbl_orden_pago WHERE ID_ORDEN = '$numero_orden'";
      $result_verificar_orden_pago = $conn->query($sql_verificar_orden_pago);

      if ($result_verificar_orden_pago->num_rows > 0) {
          $error_message = "Ya existe una orden de pago para esta orden de compra.";
        } else {
          // Preparar la consulta SQL para insertar los datos en la tabla tbl_orden_pago
          $sql_insertar_pago = "INSERT INTO tbl_orden_pago (LUGAR, FECHA_ORDEN, ID_PROVEEDOR, CONTACTO, MONTO_TOTAL, CONCEPTO, NUMERO_CUENTA, TIPO_CUENTA, BANCO, SOLICITANTE, ID_ORDEN)
                VALUES ('$lugar', '$fecha', '$a_favor', '$contacto', '$monto', '$concepto', '$numero_cuenta', '$tipo_cuenta', '$banco', '$nombre', '$numero_orden')";

          if ($conn->query($sql_insertar_pago) === TRUE) {
             // Consulta SQL para actualizar el estado de la orden de compra a "pagado"
             $sql_actualizar_estado_orden = "UPDATE tbl_orden_compra SET ESTADO = 'pagado' WHERE ID_ORDEN_COMPRA = '$numero_orden'";

              // Ejecutar la consulta SQL
              if ($conn->query($sql_actualizar_estado_orden) === TRUE) {
                 // Consulta SQL para obtener el ID de la solicitud a través de la cotización asociada a la orden de compra
                 $sql_obtener_id_solicitud = "SELECT id FROM tbl_solicitudes WHERE id IN (SELECT ID FROM tbl_cotizacion WHERE ID_COTIZACION IN (SELECT ID_COTIZACION FROM tbl_orden_compra WHERE ID_ORDEN_COMPRA = '$numero_orden'))";

                 $result_obtener_id_solicitud = $conn->query($sql_obtener_id_solicitud);

                   if ($result_obtener_id_solicitud->num_rows > 0) {
                     // Obtener el ID de la solicitud
                     $row = $result_obtener_id_solicitud->fetch_assoc();
                     $id_solicitud = $row['id'];

                     // Consulta SQL para actualizar el estado de la solicitud a "PAGADO"
                     $sql_actualizar_estado_solicitud = "UPDATE tbl_solicitudes SET estado = 'PAGADO' WHERE id = '$id_solicitud'";

                     // Ejecutar la consulta SQL
                       if ($conn->query($sql_actualizar_estado_solicitud) === TRUE) {
                         // Estado de la solicitud actualizado correctamente
                        } else {
                          $error_message .= "Error al actualizar el estado de la solicitud: " . $conn->error;
                        }
                    } else {
                      $error_message .= "No se encontró ninguna solicitud asociada a esta orden de compra.";
                    }
                } else {
                  $error_message .= "Error al actualizar el estado de la orden de compra: " . $conn->error;
                }

              // Cerrar la conexión
              $conn->close();

             // Redirigir a la página de órdenes de compra
             echo "<script>window.location.href = '../solicitudes/solicitudes.php';</script>";
             exit();
            } else {
              $error_message = "Error al guardar los datos: " . $conn->error;
            }
        }

       // Cerrar la conexión
        $conn->close();
    } else {
      // Si no se recibieron los datos por POST, redireccionar a la página principal o mostrar un mensaje de error
      $error_message = "Error: No se recibieron datos del formulario.";
    }

    // Mostrar el mensaje de error en la página procesar_pago.php
    echo $error_message;
?>