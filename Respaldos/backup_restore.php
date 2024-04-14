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
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        header {
            text-align: center;
            margin-bottom: 20px;
        }
        header h1 {
            color: #333;
        }
        section {
            margin-bottom: 20px;
        }
        h2 {
            color: #333;
            margin-bottom: 10px;
        }
        form {
            margin-top: 10px;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        select, input[type="submit"] {
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
            width: 100%;
            box-sizing: border-box;
            margin-bottom: 10px;
        }
        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>Respaldo y Restauración de Base de Datos</h1>
        </header>
        
        <section>
            <h2>Respaldo de Base de Datos</h2>
            <form action="Respaldo.php" method="post">
                <input type="submit" name="dump" value="Realizar respaldo">
            </form>
        </section>
        
        <section>
            <h2>Restauración de Base de Datos</h2>
            <form action="restauracion.php" method="post">
                <label for="archivo">Selecciona el archivo .sql:</label>
                <select name="archivo" id="archivo">
                    <?php echo $options; ?>
                </select>
                <input type="submit" name="restore" value="Restaurar Base de Datos">
            </form>
        </section>
    </div>
</body>
</html>
