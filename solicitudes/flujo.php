<?php
  // Iniciar la sesión al principio del archivo
  session_start();

   include("../conexion/conexion.php");

    // Verificar si el usuario ha iniciado sesión
    if (!isset($_SESSION["usuarioId"])) {
       // El usuario no ha iniciado sesión, redirigir a la página de inicio de sesión
       header("Location: index.php");
       exit();
    }
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MVC IHCI</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/860e3c70ee.js" crossorigin="anonymous"></script>
    <script src="../estilos.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.min.js"></script>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
    
    
    <title>Solicitudes</title>
    
    <style>
        /* Estilos para el botón de inicio */
        .boton-inicio {
            background-color: #007bff; /* Color de fondo azul */
            border: none;
            color: white; /* Color del texto en blanco */
            padding: 10px 20px; /* Espaciado interno */
            border-radius: 5px; /* Borde redondeado */
            cursor: pointer;
        }

        .boton-inicio:hover {
            background-color: #0056b3; /* Color de fondo azul más oscuro al pasar el mouse */
        }

        .button-container {
            display: flex;  /* Mostrar en línea horizontal */
            align-items: center; /* Centrar verticalmente los botones si tienen diferentes alturas */
            gap: 20px; /* Espacio entre los botones */
        }

        /* Estilo para los símbolos de check y círculo */
        .check-circle {
            color: green; /* Color verde para el check */
            margin-bottom: 5px; /* Espacio inferior */
        }

        .empty-circle {
            color: grey; /* Color gris para el círculo vacío */
            margin-bottom: 5px; /* Espacio inferior */
        }

        /* Estilo para centrar horizontalmente el contenido */
        .center {
            display: flex;
            justify-content: center;
        }

        /* Estilos para los diferentes colores de botón */
        .green-btn {
            background-color: green;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
        }

        .yellow-btn {
            background-color: green;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
        }

        .orange-btn {
            background-color: green;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
        }

         /* Estilos para el botón de inicio */
         .boton-inicio {
            background-color: #007bff; /* Color de fondo azul */
            border: none;
            color: white; /* Color del texto en blanco */
            padding: 10px 20px; /* Espaciado interno */
            border-radius: 10px; /* Borde redondeado */
            cursor: pointer;
            margin-top: -150px; /* Ajustar el margen superior negativo para subir el botón */
            margin-left: 50px;
        }
        /* Estilo para el botón "Retroceder" */
       .retroceder-btn {
          background-color: #28a745; /* Color de fondo */
          color: #ffffff; /* Color del texto */
          padding: 8px 16px; /* Espaciado interno */
          border: none; /* Sin borde */
          border-radius: 4px; /* Borde redondeado */
          font-size: 14px; /* Tamaño del texto */
          margin-left: 30px; /* Margen izquierdo */
        }

    </style>
</head>
<body>
  <h3 style="margin-left: 50px;">Detalles de la Solicitud</h3>

  <br>
  <?php
       // Obtener el ID de la solicitud seleccionada desde la URL
       if (isset($_GET['id']) && !empty($_GET['id'])) {
           $solicitudId = $_GET['id'];
        } else {
          echo "No se ha proporcionado un ID de solicitud válido.";
          exit();
        }

       // Consultar la base de datos para obtener los detalles de la solicitud seleccionada
        $sql = "SELECT sc.*, u.nombre_usuario, oc.ID_ORDEN_COMPRA 
        FROM tbl_solicitudes sc
        LEFT JOIN tbl_cotizacion ct ON sc.ID = ct.ID
        LEFT JOIN tbl_orden_compra oc ON ct.ID_COTIZACION = oc.ID_COTIZACION
        LEFT JOIN tbl_ms_usuario u ON sc.usuario_id = u.id_usuario
        WHERE sc.id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $solicitudId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
           // Mostrar los botones correspondientes a la solicitud seleccionada
           $row = $result->fetch_assoc();
           $idOrdenCompra = $row['ID_ORDEN_COMPRA'];
           // Convertir el estado a minúsculas antes de la comparación
           $estado = strtolower($row["estado"]);

           echo "<p style='margin-left: 50px;'><strong>Solicitud: Código #</strong> " . $row['codigo'] . "</p>";
           echo "<p style='margin-left: 50px;'><strong>Solicitada Por:</strong> " . $row['nombre_usuario'] . "</p>";
           echo "<p style='margin-left: 50px;'><strong>Estado:</strong> " . $row['estado'] . "</p>";

           // Línea divisoria
           echo "<hr>";

          echo "<br><br>";
           // Mostrar botones en línea horizontal
           echo "<div class='button-container center'>";

          // Botón "Agregar Cotización"
          if (strcasecmp($estado, "nueva") === 0) {
             echo "<div style='display: flex; flex-direction: column; align-items: center;'>";
             echo "<i class='far fa-check-circle check-circle'></i>";
              echo "<br>";
               echo "<a href='../cotizaciones/add_cotizacion.php?id=$solicitudId' class='yellow-btn'><i class='fas fa-book'></i>AGREGAR COTIZACIÓN</a>";
               echo "</div>";
            } else {
              echo "<div style='display: flex; flex-direction: column; align-items: center;'>";
               echo "<i class='far fa-check-circle check-circle'></i>";
               echo "<br>";
                echo "<span class='disabled-btn'><i class='fas fa-book'></i>AGREGAR COTIZACIÓN</span>";
               echo "</div>";
            }

           // Botón "Ver Solicitud"
          if (strcasecmp($estado, "pendiente") === 0) {
              echo "<div style='display: flex; flex-direction: column; align-items: center;'>";
              echo "<i class='far fa-check-circle check-circle'></i>";
              echo "<br>";
              echo "<a href='../cotizaciones/view_solicitud.php?id=$solicitudId' class='green-btn'><i class='fas fa-book-open'></i>APROBAR COTIZACIÓN</a>";
              echo "</div>";
            } else {
              echo "<div style='display: flex; flex-direction: column; align-items: center;'>";
              echo "<i class='far fa-check-circle check-circle'></i>";
              echo "<br>";
              echo "<span class='disabled-btn'><i class='fas fa-book-open'></i>APROBAR COTIZACIÓN</span>";
              echo "</div>";
            }

            // Botón "Generar Compra"
            if (strcasecmp($estado, "proceso") === 0) {
               echo "<div style='display: flex; flex-direction: column; align-items: center;'>";
               echo "<i class='far fa-check-circle check-circle'></i>";
               echo "<br>";
               echo "<a href='../cotizaciones/detalle_solicitud.php?id=$solicitudId' class='orange-btn'><i class='fas fa-file-invoice'></i>ORDEN DE COMPRA</a>";
               echo "</div>";
            } else {
              echo "<div style='display: flex; flex-direction: column; align-items: center;'>";
               echo "<i class='far fa-check-circle check-circle'></i>";
               echo "<br>";
               echo "<span class='disabled-btn'><i class='fas fa-file-invoice'></i>ORDEN DE COMPRA</span>";
               echo "</div>";
            }

            // Botón "Pagos"
           echo "<div style='display: flex; flex-direction: column; align-items: center; margin-right: 20px;'>"; // Contenedor principal del botón de pagos

           // Si el estado es "aprobada", muestra el icono de círculo y habilita el botón; de lo contrario, muestra el icono de cheque y deshabilita el botón
           if (strcasecmp($estado, "aprobada") === 0) {
              echo "<i class='far fa-check-circle check-circle'></i>";
               echo "<br>";
               // Si hay un ID de orden de compra, muestra el enlace
               if (isset($idOrdenCompra)) {
                  echo "<a href='../pagos/crear.php?numero_orden=" . $idOrdenCompra . "' class='orange-btn'><i class='fas fa-dollar-sign'></i> PAGOS</a>";
                } else {
                  echo "<span class='disabled-btn'><i class='fas fa-dollar-sign'></i> PAGOS</span>";
                }
            } else {
              echo "<i class='far fa-check-circle check-circle'></i>";
              echo "<br>";
              echo "<span class='disabled-btn'><i class='fas fa-dollar-sign'></i> PAGOS</span>";
            }

            echo "</div>"; // Fin de div style para el botón de pagos
            // Botón "Retroceder" con lista desplegable
           if (strcasecmp($estado, "nueva") !== 0 && strcasecmp($estado, "pagado") !== 0) {
              echo "<div style='margin-left: 20px; margin-top: 40px;'>"; // Contenedor principal del botón de retroceder
              echo "<select onchange='redirectToPage(this)' class='blue-btn-dropdown retroceder-btn'>";
              echo "<option disabled selected>***</option>";
              // Opción para retroceder a la página de agregar cotización si el estado no es "nueva"
              echo "<option value='../solicitudes/editar_cotizacion.php?id=$solicitudId'>AGREGAR COTIZACIÓN</option>";
    
             // Opción para retroceder a la página de ver solicitud si el estado no es "nueva"
               if (strcasecmp($estado, "pendiente") !== 0) {
                  echo "<option value='../cotizaciones/view_solicitud.php?id=$solicitudId'>APROBAR COTIZACIÓN</option>";
                }
              // Opción para retroceder a la página de detalle de solicitud si el estado no es "nueva" ni "pendiente"
              if (strcasecmp($estado, "pendiente") !== 0 && strcasecmp($estado, "proceso") !== 0) {
                  echo "<option value='../cotizaciones/detalle_solicitud.php?id=$solicitudId'>ORDEN DE COMPRA</option>";
                }
               // Cierre del elemento select
               echo "</select>";
               echo "</div>"; // Fin de div style
            }

        } else {
          echo "No se encontró la solicitud con el ID proporcionado.";
        }

        // Cerrar la conexión a la base de datos
        $stmt->close();
        $conn->close();
    ?>

    <script>
      // Función para redireccionar a la página seleccionada
       function redirectToPage(select) {
          var selectedOption = select.options[select.selectedIndex];
           if (selectedOption.value !== '') {
              window.location.href = selectedOption.value;
            }
        }
    </script>

    <!-- Botón de regreso al final de la página -->
    <div class="fixed-bottom">
      <a href="../solicitudes/solicitudes.php" class="btn btn-secondary boton-inicio">Regresar</a>
    </div>

</body>
</html>













