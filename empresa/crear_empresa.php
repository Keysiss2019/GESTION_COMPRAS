<?php
include 'db_connect.php'; // Incluye el archivo de conexión a la base de datos

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Procesar el formulario de creación
    $nombre_empresa = $_POST['nombre_empresa'];
    $fecha_inicio_operacion = $_POST['fecha_inicio_operacion'];
    $tel_empresa = $_POST['tel_empresa'];
    $email_empresa = $_POST['email_empresa'];
    $direccion = $_POST['direccion'];
    $estado = $_POST['estado'];

    // Preparar la consulta SQL para insertar los datos
    $sql = "INSERT INTO tbl_empresa (nombre_empresa, fecha_inicio_operacion, tel_empresa, email_empresa, direccion, estado) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    // Vincular los parámetros
    $stmt->bindValue(1, $nombre_empresa);
    $stmt->bindValue(2, $fecha_inicio_operacion);
    $stmt->bindValue(3, $tel_empresa, PDO::PARAM_INT);
    $stmt->bindValue(4, $email_empresa);
    $stmt->bindValue(5, $direccion);
    $stmt->bindValue(6, $estado);

    // Ejecutar la consulta SQL
    if ($stmt->execute()) {
        // Redirigir a la página de listado de empresas si la inserción fue exitosa
        header("Location: listarempresa.php");
        exit();
    } else {
        // Mostrar un mensaje de error si ocurrió un problema con la inserción
        echo "Error al crear la empresa: " . $stmt->error;
    }
} else {
    // Mostrar el formulario de creación de empresas
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Empresa</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* Estilos CSS */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }
        
        .container {
            margin-top: 50px;
            width: 50%;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.1);
        }
        
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        
        label {
            font-weight: bold;
        }
        
        input[type="text"], input[type="tel"], input[type="email"], textarea, select {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        
        .custom-button {
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            margin-right: 10px;
        }
        
        .cancel-button {
            background-color: #dc3545;
        }
        
        .custom-button:hover, .cancel-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
<div class="container">
    <form action="guardar_empresa.php" method="POST">
        <h2>Crear Empresa</h2>

        <label for="nombre_empresa">Nombre de la Empresa:</label>
        <input type="text" name="nombre_empresa" required>

        <label for="fecha_inicio_operacion">Fecha de Inicio de Operación:</label>
        <input type="date" name="fecha_inicio_operacion" required>

        <label for="tel_empresa">Teléfono:</label>
        <input type="tel" name="tel_empresa" required>

        <label for="email_empresa">Correo Electrónico:</label>
        <input type="email" name="email_empresa" required>

        <label for="direccion">Dirección:</label>
        <textarea name="direccion" required></textarea>

        <label for="estado">Estado:</label>
        <select name="estado" required>
            <option value="Activo">Activo</option>
            <option value="Inactivo">Inactivo</option>
        </select>

        <br><br>
        <button type="submit" class="custom-button">Guardar</button>
        <a href="listarempresa.php" class="custom-button cancel-button">Cancelar</a>
    </form>
</div>
</body>
</html>
<?php
}
?>


