<?php

$db_host = 'localhost';
$db_name = 'gestion_compras2';
$db_user = 'root'; // Usuario predeterminado en XAMPP
$db_pass = '';     // Sin contraseña por defecto en XAMPP

$sql_file = 'ruta/al/archivo.sql'; // Ruta al archivo SQL que contiene el volcado de la base de datos

// Comando para restaurar la base de datos desde el archivo SQL
$restore_command = "C:/xampp/mysql/bin/mysql --user={$db_user} --password={$db_pass} --host={$db_host} {$db_name} < {$sql_file}";

// Ejecutar el comando y capturar el estado
$output = '';
$status = 0;
exec($restore_command, $output, $status);

// Verificar si hubo algún error
if ($status !== 0) {
    echo "Error al restaurar la base de datos desde el archivo SQL.\n";
    echo "Salida del comando:\n";
    print_r($output);
} else {
    echo "Restauración de base de datos completada exitosamente.\n";
}

?>
