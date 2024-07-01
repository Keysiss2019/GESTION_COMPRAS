<?php
   // Iniciar sesión si no está iniciada
   session_start();
   $solicitud_id = null;

  // Verificar si el usuario ha iniciado sesión
  if (isset($_SESSION['usuarioId'])) {
      $usuarioID = $_SESSION['usuarioId'];
    } else {
       // Si el usuario no ha iniciado sesión, redirigirlo a la página de inicio de sesión
      header("Location: login.php");
      exit();
    }

    // Incluir el archivo de configuración de la base de datos
    include '../conexion/conexion.php';

    // Verificar si se ha enviado el formulario y no ha sido procesado previamente en esta sesión
    if ($_SERVER["REQUEST_METHOD"] == "POST" && !isset($_SESSION['form_submitted'])) {
      // Marcar el formulario como enviado
       $_SESSION['form_submitted'] = true;

      // Obtener los datos del formulario
      $numero_orden = $_POST["numero_orden"];
      $fecha_orden = $_POST["fecha_orden"];
      $proveedor = $_POST["proveedor_id"];
      $contacto = $_POST["contacto"];
      $subtotal = $_POST["subtotal"];
      $isv = $_POST["isv"];
      $totalFactura = $_POST["total_factura"];
      $excentos = isset($_POST['excento']) ? $_POST['excento'] : array();
      $cotizacionId = isset($_POST["cotizacion_id"]) ? $_POST["cotizacion_id"] : null;

       if (!$cotizacionId) {
         echo json_encode(array("success" => false, "message" => "No se recibió el ID de la cotización."));
         exit();
        }

      // Obtener el ID de la solicitud usando el ID de la cotización
      $sqlObtenerSolicitud = "SELECT id FROM tbl_cotizacion WHERE ID_COTIZACION = ?";
      $stmtObtenerSolicitud = $conn->prepare($sqlObtenerSolicitud);
      $stmtObtenerSolicitud->bind_param("i", $cotizacionId);
      $stmtObtenerSolicitud->execute();
      $resultObtenerSolicitud = $stmtObtenerSolicitud->get_result();

      if ($resultObtenerSolicitud->num_rows > 0) {
         $rowSolicitud = $resultObtenerSolicitud->fetch_assoc();
         $solicitud_id = $rowSolicitud['id'];
        } else {
          echo json_encode(array("success" => false, "message" => "No se encontró ninguna solicitud asociada a la cotización."));
          exit();
        }

        // Insertar nueva orden de compra
        $sqlInsertarOrden = "INSERT INTO tbl_orden_compra (NUMERO_ORDEN, FECHA_ORDEN, ID_PROVEEDOR, ID_CONTACTO, MONTO, ID_COTIZACION, ESTADO, CREADO_POR)
                         VALUES (?, ?, ?, ?, ?, ?, 'APROBADA', ?)";
        $stmtInsertarOrden = $conn->prepare($sqlInsertarOrden);
        $stmtInsertarOrden->bind_param("ssiiidi", $numero_orden, $fecha_orden, $proveedor, $contacto, $totalFactura, $cotizacionId, $usuarioID);

        if ($stmtInsertarOrden->execute()) {
          // Obtener el ID de la orden de compra recién insertada
          $orden_id = $stmtInsertarOrden->insert_id;

          // Obtener los detalles del formulario (cotizaciones y precios)
          $cotizaciones = json_decode($_POST["cotizaciones"], true);
          $precios = json_decode($_POST["precios"], true);

          // Insertar los detalles de la orden de compra
          foreach ($cotizaciones as $index => $cotizacion) {
              $cantidad = intval($cotizacion["cantidad"]); // Cantidad proporcionada por el usuario
              $descripcion = $cotizacion["descripcion"];
              $precio = $precios[$index]; // Precio proporcionado por el usuario
              $excento = in_array($index, $excentos) ? "SI" : "NO";

              // Calcular el total (cantidad * precio)
              $total = $cantidad * $precio;

              $sqlDetalle = "INSERT INTO tbl_orden_compra_productos (ID_ORDEN, CANTIDAD, DESCRIPCION, PRECIO, TOTAL, SUBTOTAL, ISV, EXCENTO)
                           VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
              $stmtDetalle = $conn->prepare($sqlDetalle);
              $stmtDetalle->bind_param("iisdidds", $orden_id, $cantidad, $descripcion, $precio, $total, $subtotal, $isv, $excento);

               if (!$stmtDetalle->execute()) {
                  echo json_encode(array("success" => false, "message" => "Error al guardar los detalles de la orden de compra: " . $stmtDetalle->error));
                  exit();
                }
                $stmtDetalle->close();
            }

           // Actualizar el estado de la solicitud asociada
           $sqlActualizarEstadoSolicitud = "UPDATE tbl_solicitudes SET estado = 'APROBADA' WHERE id = ?";
           $stmtActualizarEstadoSolicitud = $conn->prepare($sqlActualizarEstadoSolicitud);
           $stmtActualizarEstadoSolicitud->bind_param("i", $solicitud_id);
           if (!$stmtActualizarEstadoSolicitud->execute()) {
              echo json_encode(array("success" => false, "message" => "Error al actualizar el estado de la solicitud: " . $stmtActualizarEstadoSolicitud->error));
              exit();
            }
            $stmtActualizarEstadoSolicitud->close();

           // Redirigir al usuario después de guardar correctamente en ambas tablas
           header("Location: ../cotizaciones/detalle_solicitud.php?id=" . $solicitud_id);
           exit();
        } else {
          echo json_encode(array("success" => false, "message" => "Error al guardar la orden de compra: " . $conn->error));
        }

        $stmtInsertarOrden->close();
    }

    // Limpiar variables y cerrar la conexión a la base de datos
    unset($_SESSION['form_submitted']);
    $conn->close();
?>


