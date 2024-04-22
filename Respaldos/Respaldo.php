<?php

$db_host = 'localhost';
$db_name = 'gestion_compras2';
$db_user = 'root'; // Usuario predeterminado en XAMPP
$db_pass = '';     // Sin contraseña por defecto en XAMPP

$fecha = date("Ymd-His");

$salida_sql = $db_name . '_' . $fecha . '.sql';

// Ruta al ejecutable mysqldump en XAMPP
$dump_command = "C:/xampp/mysql/bin/mysqldump --user=" . $db_user . " --password=" . $db_pass . " --host=" . $db_host . " " . $db_name . " > $salida_sql";

// Ejecutar el comando y capturar el estado
$output = '';
$status = 0;
exec($dump_command, $output, $status);

// Verificar si hubo algún error
if ($status !== 0) {
    $mensaje = "Error al realizar el volcado de la base de datos.\n";
    $mensaje .= "Salida del comando:\n";
    $mensaje .= implode("\n", $output);
} else {
    // Verificar si se ha creado el archivo de volcado
    if (file_exists($salida_sql) && filesize($salida_sql) > 0) {
        $mensaje = "Respaldo de base de datos completado exitosamente.\n";
    } else {
        $mensaje = "Error: El archivo de volcado está vacío o no se ha generado.\n";
    }
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado del volcado de base de datos</title>
</head>
<body>
    <h1>Resultado del volcado de base de datos</h1>
    <p><?php echo $mensaje; ?></p>
</body>
</html>

