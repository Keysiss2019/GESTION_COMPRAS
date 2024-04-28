<?php
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombreObjeto = $_POST['nombre_objeto'];
    $descripcion = $_POST['descripcion'];

    // Insertar datos en la base de datos
    $stmt = $conn->prepare("INSERT INTO tbl_objetos (NOMBRE_OBJETO, DESCRIPCION) VALUES (:nombreObjeto, :descripcion)");
    $stmt->bindParam(':nombreObjeto', $nombreObjeto);
    $stmt->bindParam(':descripcion', $descripcion);

    if ($stmt->execute()) {
        header('Location: listar_objetos.php'); // Redirige a la lista de objetos después de la creación
        exit;
    } else {
        echo 'Error al crear el objeto.';
    }
}
?>

<!-- Formulario HTML para crear un objeto -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Objeto</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            /*background-image: url('../imagen/background.jpg'); /* Reemplaza con la ruta de tu imagen de fondo */
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            margin: 0;
            padding: 0;
        }

        form {
            max-width: 550px;
            margin: 50px auto;
            padding: 20px;
            background-color: #ddd;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-bottom: 10px; /* Agrega margen inferior al formulario */
        }

        h2 {
            text-align: center;
            color: #007BFF; /* Color azul */
            font-weight: bold; /* Texto en negrita */
        }

        label {
            display: block;
            margin-top: 10px;
            /*font-weight: bold;*/ /* Quita la negrita de las etiquetas */
        }

        textarea {
            width: 100%;
            height: 150px;
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 5px;
            font-size: 14px;
        }

        input {
            width: 95%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ddd;
            border-radius: 3px;
        }

        .button-container {
            text-align: center; /* Centra los botones horizontalmente */
        }

        .custom-button {
            display: inline-block;
            padding: 10px 20px; /* Ajusta el tamaño del botón según tus preferencias */
            margin-top: 10px; /* Añade espacio entre los botones */
            border: none;
            border-radius: 5px;/*se cambio*/
           /* font-weight: bold;*/
            cursor: pointer;
            text-align: center;
            text-decoration: none;
            font-size: 16px; /* Tamaño de letra */
            font-family: Arial, sans-serif; /* Tipo de letra cambiada */
            background-color: #007BFF; /* Fondo azul */
            color: white; /* Texto blanco */
            /*transition: background-color 0.3s; /* Agrega transición para el cambio de color de fondo */
        }

        .custom-button.cancel-button {
            background-color: gray; /* Fondo gris */
            color: #fff; /* Texto oscuro */
        }

        /*.custom-button:hover {
            background-color: #0056b3; /* Cambia el color de fondo al pasar el cursor sobre ambos botones */
        

    </style>
</head>
<body>
    <div class="container">
        <br><br>
        <form action="crear_objeto.php" method="POST">
            <h2>CREAR OBJETOS</h2> <!-- Etiqueta h2 en azul y en negrita -->
            <label for="nombre_objeto">Nombre del Objeto:</label>
            <input type="text" name="nombre_objeto" required>
            <br>
            <label for="descripcion">Descripción:</label>
            <textarea name="descripcion"></textarea>
            <br>
            <div class="button-container">
                <button type="submit" class="custom-button">Guardar</button>
                <!-- Botón de Cancelar que redirige a listar_objetos.php -->
                <a href="listar_objetos.php" class="custom-button cancel-button">Cancelar</a>
            </div>
        </form>
    </div>
</body>
</html>