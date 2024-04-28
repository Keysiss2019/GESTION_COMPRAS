<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Parámetros</title>
    <style>
    body {
            text-align: center;
            font-family: Arial, sans-serif;
            background: rgba(255, 255, 255, 0.20);
            /*background-image: url('../imagen/background.jpg'); */
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
            background-color: #ddd; /* Color de fondo azul claro (cielo) */
            /*box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Sombra ligera */
            /*opacity: 0.9; /* Valor de opacidad (menos transparente) */
        }

        .table {
            width: 100%;
            margin-bottom: 10px;
            background-color: #ddd; /* Color de fondo  para las tablas */
        }

        .form-group {
            display: flex;
            align-items: center;
            justify-content: center; /* Centra horizontalmente los elementos del formulario */
            margin-bottom: 10px;
        }

        label {
            width: 120px; /* Ancho fijo para las etiquetas, ajusta según sea necesario */
            margin-right: 10px; /* Espacio entre la etiqueta y el campo de entrada */
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

        input[type="button"] {
            background-color: gray;
        }

        .date-container {
            display: flex;
            align-items: baseline;
            justify-content: center; /* Centra horizontalmente los elementos de la fecha */
        }

        .date-container label {
            margin-right: 10px;
        }

        #fecha_creacion {
            width: 200px; /* Puedes ajustar el valor según tus preferencias */
        }

        /* Estilos para el título */
        h2 {
            color: #007BFF; /* Cambiar el color del título a azul */
            font-weight: bold; /* Hacer el título en negrita */
        }

        label {
    text-align: left;
    display: inline-block;
    width: 120px; /* Ancho fijo para las etiquetas, ajusta según sea necesario */
    margin-right: 10px; /* Espacio entre la etiqueta y el campo de entrada */
}

     </style>
</head>

<body>
<div class="container">
    <div class="table">
        <h2>PARÁMETRO</h2>
        <form action="procesar_parametros.php" method="post">
            <div class="form-group">
                <label for="parametro">Parámetro:</label>
                <input type="text" id="parametro" name="parametro" required>
            </div>

            <div class="form-group">
                <label for="valor">Valor:</label>
                <input type="text" id="valor" name="valor" required>
            </div>

            <div class="form-group">
                <label for="fecha_creacion">Fecha:</label>
                <input type="text" id="fecha_creacion" name="fecha_creacion" value="<?php echo date('Y-m-d'); ?>" readonly>
            </div>

            <input type="submit" value="Guardar">
            <input type="button" value="Cancelar" onclick="location.href='parametros.php';">
        </form>
    </div>
</div>
</body>
</html>
