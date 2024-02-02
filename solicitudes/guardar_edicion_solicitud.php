<?php
  // Reemplaza estos valores con tus credenciales de base de datos
  include '../conexion/conexion.php';

  if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["solicitud_id"])) {
      $solicitud_id = $_POST["solicitud_id"];
      $idDepartamento = $_POST["idDepartamento"];
      $usuario_nombre = $_POST["usuario_nombre"];
      
      $codigo = $_POST["codigo"];
     
      $estado = $_POST["estado"];
  
      // Crear una conexión a la base de datos
      $conn = new mysqli($servername, $username, $password, $dbname);
      if ($conn->connect_error) {
          die("Error de conexión: " . $conn->connect_error);
      }
  
      // Obtener el ID del usuario a partir del nombre proporcionado
      $sql_usuario = "SELECT id_usuario FROM tbl_ms_usuario WHERE nombre_usuario = ?";
      $stmt_usuario = $conn->prepare($sql_usuario);
      $stmt_usuario->bind_param("s", $usuario_nombre);
      $stmt_usuario->execute();
      $result_usuario = $stmt_usuario->get_result();
      if ($result_usuario->num_rows > 0) {
          $row_usuario = $result_usuario->fetch_assoc();
          $usuario_id = $row_usuario["id_usuario"];
      } else {
          // Si no existe, insertar el nuevo usuario
          $sql_insert_usuario = "INSERT INTO tbl_ms_usuario (nombre_usuario) VALUES (?)";
          $stmt_insert_usuario = $conn->prepare($sql_insert_usuario);
          $stmt_insert_usuario->bind_param("s", $usuario_nombre);
          $stmt_insert_usuario->execute();
  
          $usuario_id = $stmt_insert_usuario->insert_id;
      }
  
      // Actualizar la solicitud con los nuevos datos, incluyendo el estado
      $sql_actualizar = "UPDATE tbl_solicitudes SET idDepartamento = ?, usuario_id = ?,  codigo = ?,  estado = ?, fecha_modificacion = NOW() WHERE id = ?";
      $stmt_actualizar = $conn->prepare($sql_actualizar);
      $stmt_actualizar->bind_param("iissi", $idDepartamento, $usuario_id,  $codigo,  $estado, $solicitud_id);
      if ($stmt_actualizar->execute()) {
          
          header("Location: solicitudes.php");
          exit(); // Asegura que el script se detenga después de la redirección   
      } else {
          echo "Error al guardar los cambios: " . $stmt_actualizar->error;
      }
  
      // Cerrar la conexión
      $conn->close();
  } else {
      echo "Solicitud no válida.";
  }
?>
