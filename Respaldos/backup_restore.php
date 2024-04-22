<?php
// Ruta a la carpeta que contiene los archivos .sql
$dir = 'C:/xampp/htdocs/GESTION_COMPRAS/Respaldos';

// Obtener los nombres completos de todos los archivos .sql en la carpeta
$sql_archivos = array_filter(scandir($dir), function($archivo) {
    return pathinfo($archivo, PATHINFO_EXTENSION) === 'sql';
});

// Generar las opciones del menú desplegable
$options = '';
foreach ($sql_archivos as $archivo) {
    $options .= "<option value='$archivo'>$archivo</option>";
}

// Definir la variable $mensaje
$mensaje = '';

// Verificar si se ha enviado el formulario de respaldo
if (isset($_POST['dump'])) {
    // Tu código de respaldo de base de datos aquí
    $mensaje = "El respaldo de la base de datos se ha realizado con éxito.";
}

// Verificar si se ha enviado el formulario de restauración
if (isset($_POST['restore'])) {
    // Tu código de restauración de base de datos aquí
    $mensaje = "La restauración de la base de datos se ha realizado con éxito.";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Volcado y Restauración de Base de Datos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
        }
        .container {
            max-width: 600px; /* Reducir el ancho del contenedor */
            margin: 100px auto 0; /* Ajuste del margen superior */
            padding: 20px;
            background-color: #eee; /* Cambiado a un gris más claro */
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        header {
            text-align: center;
            margin-bottom: 20px;
        }
        header h1 {
            color: #333;
            font-size: 24px; /* Ajuste del tamaño de la fuente del encabezado */
        }
        section {
            margin-bottom: 20px;
        }
        h2 {
            color: #333;
            font-size: 20px; /* Ajuste del tamaño de la fuente del subencabezado */
            margin-bottom: 10px;
        }
        form {
            margin-top: 20px;
            width: 100%; /* Hacer el formulario ocupar todo el ancho disponible */
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-size: 14px; /* Reducir el tamaño de la fuente de las etiquetas */
        }
        select, input[type="submit"] {
            padding: 6px 10px; /* Reducir el relleno de los elementos */
            font-size: 14px; /* Reducir el tamaño de la fuente de los elementos */
            border: 1px solid #ccc;
            border-radius: 5px;
            width: calc(100% - 22px); /* Reducir el ancho del elemento en función del relleno */
            box-sizing: border-box;
            margin-bottom: 10px;
        }
        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            cursor: pointer;
        }
        /* Estilos para el mensaje */
        .mensaje {
            border: 1px solid #007bff; /* Cambiar el color del borde a azul */
            padding: 10px;
            margin-top: 20px;
            border-radius: 5px;
            background-color: #e7f1ff; /* Cambiar el color de fondo a azul celeste */
            display: flex;
            align-items: center;
        }
        .mensaje p {
            flex: 1; /* Ocupar todo el espacio disponible */
            margin: 0; /* Eliminar el margen */
        }
        .mensaje button {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            border-radius: 3px;
            margin-left: 10px; /* Espacio entre el mensaje y el botón */
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>Respaldo y Restauración de Base de Datos</h1>
        </header>
        
        <section>
            <h2>Respaldo de Base de Datos:</h2>
            <form action="Respaldo.php" method="post">
                <input type="submit" name="dump" value="Respaldo" style="width: auto;"> <!-- Establecer el ancho automático para el botón -->
            </form>
        </section>
        
        <section>
            <h2>Restauración de Base de Datos</h2>
            <form action="" method="post">
                <label for="archivo">Archivo:</label> <!-- Cambiar el texto del label -->
                <select name="archivo" id="archivo" style="width: calc(50% - 22px);"> <!-- Reducir el ancho del elemento en función del relleno -->
                    <?php echo $options; ?>
                </select>
                <input type="submit" name="restore" value="Restaurar" style="width: auto;"> <!-- Establecer el ancho automático para el botón -->
            </form>
        </section>

        <!-- Botón de regresar -->
<section>
    <form action="javascript:history.back()" method="post">
        <input type="submit" value="Regresar" style="width: auto;">
    </form>
</section>

        <!-- Mostrar el mensaje aquí mismo -->
        <?php if (!empty($mensaje)) : ?>
        <script>
            alert("<?php echo $mensaje; ?>");
        </script>
        <?php endif; ?>
    </div>
    
    </div>
</body>
</html>
