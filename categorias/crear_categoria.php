<?php
 session_start();

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Nueva Categoría</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            margin: 0;
            padding: 0;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        form {
            width: 550px;
            padding: 20px;
            background-color: #ddd;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-bottom: 10px;

        }

        h2 {
            text-align: center;
            color: #007BFF; /* Cambiar el color del título a azul */
           font-weight: bold; /* Hacer el título en negrita */
        }

        label {
            display: block;
            margin-top: 10px;
            /*font-weight: bold;*/
        }

        input {
            width: 95%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ddd;
            border-radius: 3px;
        }

        .button-section {
    clear: both; /* Limpiar el flotado para que los elementos debajo no floten */
    text-align: center; /* Alinear los botones a la izquierda */
    margin-top: 20px; /* Espacio superior para separar de las columnas */
}

        .custom-button {
            display: inline-block;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            /*font-weight: bold;*/
            cursor: pointer;
            text-align: center;
        }

        .custom-button.cancel-button {
            background-color: gray;
            color: #fff;
            text-decoration: none;
        }

        .custom-button {
            background-color: #007bff;
            color: #fff;
            font-size: 16px; /* Aumenta ligeramente el tamaño de la letra del botón "Guardar" */
        }
    </style>
</head>
<body>
<div class="container">
    <form action="guardar_categoria.php" method="POST">
        <h2>CATEGORÍA</h2>
        <label for="categoria">Categoría:</label>
        <input type="text" name="categoria" required>

        <label for="creado">Creado por:</label>
        <input type="text" name="creado" value="<?php echo $_SESSION['nombre_usuario']; ?>">
        
        <label for="fecha_creacion">Fecha de Creación:</label>
        <input type="text" name="fecha_creacion" value="<?php echo date("Y-m-d"); ?>" readonly>
        <br><br>
        
        <div class="button-section">
        <button type="submit" class="custom-button">Guardar</button>
        <a href="listar_categorias.php" class="custom-button cancel-button">Cancelar</a>
    </div>
    </form>
</div>
</body>
</html>
