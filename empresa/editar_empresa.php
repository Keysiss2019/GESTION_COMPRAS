<?php
include 'db_connect.php'; // Incluye el archivo de conexión a la base de datos

// Verificar si se ha enviado el formulario de edición
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Procesar el formulario de edición
    $id_empresa = $_POST['id_empresa'];
    $nombre_empresa = $_POST['nombre_empresa'];
    $fecha_inicio_operacion = $_POST['fecha_inicio_operacion'];
    $tel_empresa = $_POST['tel_empresa'];
    $email_empresa = $_POST['email_empresa'];
    $direccion = $_POST['direccion'];
    $estado = $_POST['estado'];

    // Preparar la consulta SQL para actualizar los datos
    $sql = "UPDATE tbl_empresa SET nombre_empresa = ?, fecha_inicio_operacion = ?, tel_empresa = ?, email_empresa = ?, direccion = ?, estado = ? WHERE id_empresa = ?";
    $stmt = $conn->prepare($sql);

    // Vincular los parámetros
    $stmt->bindValue(1, $nombre_empresa);
    $stmt->bindValue(2, $fecha_inicio_operacion);
    $stmt->bindValue(3, $tel_empresa, PDO::PARAM_INT);
    $stmt->bindValue(4, $email_empresa);
    $stmt->bindValue(5, $direccion);
    $stmt->bindValue(6, $estado);
    $stmt->bindValue(7, $id_empresa, PDO::PARAM_INT);

    // Ejecutar la consulta SQL
    if ($stmt->execute()) {
        // Redirigir a la página de listado de empresas si la actualización fue exitosa
        header("Location: listarempresa.php");
        exit();
    } else {
        // Mostrar un mensaje de error si ocurrió un problema con la actualización
        echo "Error al actualizar la empresa: " . $stmt->error;
    }
} else {
    // Obtener el ID de la empresa de la URL
    if(isset($_GET['id'])){
        $id_empresa = $_GET['id'];

        // Obtener los datos de la empresa de la base de datos
        $stmt = $conn->prepare("SELECT * FROM tbl_empresa WHERE id_empresa = ?");
        $stmt->bindValue(1, $id_empresa, PDO::PARAM_INT);
        $stmt->execute();
        $empresa = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verificar si se encontró la empresa
        if (!$empresa) {
            echo "Empresa no encontrada.";
            exit();
        }
    } else {
        echo "ID de empresa no especificado.";
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Empresa</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* Estilos CSS */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }
        
        .container {
            margin-top: 40px;
            width: 50%;
            background-color: #ddd;
            padding: 10px;
            border-radius: 5px;
            box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.1);
        }
        
        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #007BFF; /* Cambiar el color del título a azul */
            font-weight: bold; /* Hacer el título en negrita */
        }
        
        label {
            /*font-weight: bold;*/
            margin-bottom: 5px; /* Reducir el espacio inferior de las etiquetas */
        }
        
        input[type="text"], input[type="tel"], input[type="email"], textarea, select {
            width: 100%;
            padding: 5px;
            margin-bottom: 0px; /* Reducir el espacio inferior de los campos de entrada */
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        
        .custom-button, .cancel-button {
            padding: 10px 20px; /* Igualar el padding de ambos botones */
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            margin-right: 10px;
        }
        
        .custom-button {
            background-color: #007bff;
            color: #fff;
        }
        
        .cancel-button {
            background-color: gray;
            color: #fff;
        }
    </style>
</head>
<body>
<div class="container">
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
        <h2>EMPRESA</h2>
        <input type="hidden" name="id_empresa" value="<?php echo $empresa['id_empresa']; ?>">

        <label for="nombre_empresa">Nombre de la Empresa:</label>
        <input type="text" name="nombre_empresa" value="<?php echo $empresa['nombre_empresa']; ?>" required>

        <label for="fecha_inicio_operacion">Inicio de Operación:</label><br>
        <input type="date" name="fecha_inicio_operacion" value="<?php echo $empresa['fecha_inicio_operacion']; ?>" required>
        <br>
        <label for="tel_empresa">Teléfono:</label>
        <input type="tel" name="tel_empresa" value="<?php echo $empresa['tel_empresa']; ?>" required>

        <label for="email_empresa">Correo Electrónico:</label>
        <input type="email" name="email_empresa" value="<?php echo $empresa['email_empresa']; ?>" required>

        <label for="direccion">Dirección:</label>
        <textarea name="direccion" required><?php echo $empresa['direccion']; ?></textarea>

        <label for="estado">Estado:</label>
        <select name="estado" required>
            <option value="Activo" <?php if($empresa['estado'] == 'Activo') echo 'selected'; ?>>Activo</option>
            <option value="Inactivo" <?php if($empresa['estado'] == 'Inactivo') echo 'selected'; ?>>Inactivo</option>
        </select>

        <br><br>
        <div class="text-center"> <!-- Centrar los botones -->
            <button type="submit" class="custom-button">Guardar</button>
            <a href="listarempresa.php" class="cancel-button">Cancelar</a>
        </div>
    </form>
</div>
</body>
</html>


