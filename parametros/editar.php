<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body {
            text-align: center;
            font-family: Arial, sans-serif;
            background: rgba(255, 255, 255, 0.20);
            background-size: 40%;
            background-position: center;
            background-repeat: no-repeat;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center; /* Centra horizontalmente */
            align-items: center; /* Centra verticalmente */
            min-height: 100vh;
        }

        .container {
            width: 45%; /* Ajusta el ancho del contenedor */
            text-align: center;
            border-radius: 10px; /* Aumentar el radio de la esquina */
            padding: 40px;
            background-color: #ddd; /* Color de fondo gris*/
        }

        .form-group {
            display: flex;
            align-items: center;
            justify-content: center; /* Centra horizontalmente los elementos del formulario */
            margin-bottom: 10px;
        }

        label {
            width: 120px; /* Ancho fijo para las etiquetas, ajusta según sea necesario */
            margin-right: 25px; /* Espacio entre la etiqueta y el campo de entrada */
            text-align: left; /* Alinea el texto a la izquierda */
        }

        input {
            flex: 1; /* El campo de entrada toma el resto del espacio disponible */
            padding: 8px;
            box-sizing: border-box;
        }

        input[type="submit"],
        input[type="button"] {
            background-color: #007bff;
            color: #fff;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 30%; /* Ajusta según sea necesario */
            box-sizing: border-box;
            display: inline-block; /* Muestra en la misma línea que el botón Guardar */
        }

        input[type="submit"] {
            margin-right: 10px; /* Agregar espacio a la derecha del botón de guardar */
        }

        input.cancel {
            background-color: gray;
        }

        h2 {
            color: #007BFF; /* Cambiar el color del título a azul */
            font-weight: bold; /* Hacer el título en negrita */
        }

    </style>
</head>
<body>
    <div class="container">
        <h2>PARÁMETRO</h2>
           <?php
             session_start();

              include('../conexion/conexion.php');

               function obtenerNombreUsuario($conn, $usuario_id) {
                  $sql = "SELECT nombre_usuario FROM tbl_ms_usuario WHERE id_usuario = ?";
                  $stmt = $conn->prepare($sql);
                  $stmt->bind_param("i", $usuario_id);
                  $stmt->execute();
                  $result = $stmt->get_result();
                  $row = $result->fetch_assoc();
                  return $row["nombre_usuario"];
                }

                if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {
                    $parametro_id = $_GET["id"];

                    // Obtener los datos del parámetro a editar
                    $sql = "SELECT * FROM tbl_ms_parametros WHERE ID_PARAMETRO = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("i", $parametro_id);
                    $stmt->execute();
                    $result = $stmt->get_result();

                   if ($result->num_rows == 1) {
                      $row = $result->fetch_assoc();

                      // Obtener los datos del parámetro
                      $parametro = $row["PARAMETRO"];
                      $valor = $row["VALOR"];
                      $fecha_creacion = date('Y-m-d', strtotime($row["FECHA_CREACION"]));
                      $fecha_modificacion = date('Y-m-d', strtotime($row["FECHA_MODIFICACION"]));

                      // Generar el formulario para editar el parámetro
                      echo "<form method='post' action='actualizar.php'>";
        
                      echo "<input type='hidden' name='parametro_id' value='$parametro_id'>";

                      echo "<div class='form-group'><label for='parametro'>Parámetro:</label><input type='text' name='parametro' value='$parametro' required></div>";
                       echo "<div class='form-group'><label for='valor'>Valor:</label><input type='text' name='valor' value='$valor' required></div>";

                       echo "<div class='form-group'><label for='fecha_creacion'>Fecha Creación:</label><input type='text' name='fecha_creacion' value='$fecha_creacion' readonly></div>";

                       // Obtener la fecha actual en formato YYYY-MM-DD
                       $fecha_modificacion_actual = date('Y-m-d');

                      echo "<div class='form-group'><label for='fecha_modificacion'>Fecha Modificación:</label><input type='text' name='fecha_modificacion' value='$fecha_modificacion_actual'></div>"; 

                      // Campo oculto para el nombre del usuario que inició sesión (MODIFICADO_POR)
                     echo "<input type='hidden' name='modificado_por' value='" . (isset($_SESSION['nombre_usuario']) ? $_SESSION['nombre_usuario'] : '') . "'>";

                     // Botones
                     echo '<div class="btn-container">';
                     echo '<input type="submit" value="Guardar" class="btn btn-primary" style="width: 20%;" >';
                      echo '<a href="parametros.php" class="btn btn-secondary" style="width: 20%; background-color: gray; color: white;">Cancelar</a>';
                      echo '</div>';

                      echo "</form>";
                    } else {
                      echo "Parámetro no encontrado.";
                    }
                } else {
                 echo "ID de parámetro no proporcionado.";
                }

                // Cerrar la conexión
                $conn->close();
            ?>

        </div>
    </div>
</body>
</html>
