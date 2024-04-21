<?php
$db_host = 'localhost';
$db_name = 'gestion_compras2';
$db_user = 'root'; // Usuario predeterminado en XAMPP
$db_pass = '';     // Sin contraseña por defecto en XAMPP

// Verificar si se ha enviado un archivo para restaurar
if(isset($_POST['archivo']) && !empty($_POST['archivo'])) {
    // Ruta al directorio de respaldos
    $directorio_respaldos = 'C:/xampp/htdocs/GESTION_COMPRAS/Respaldos/';

    // Ruta al archivo SQL seleccionado por el usuario
    $archivo_seleccionado = $directorio_respaldos . $_POST['archivo'];

    // Comando para restaurar la base de datos desde el archivo SQL
    $restore_command = "C:/xampp/mysql/bin/mysql --user={$db_user} --password={$db_pass} --host={$db_host} {$db_name} < {$archivo_seleccionado}";

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
        // Restauración exitosa, mostrar una alerta en JavaScript
        echo "<script>alert('Restauración de base de datos completada exitosamente.'); window.location.href = '../Respaldos/backup_restore.php';</script>";
        exit; // Salir del script después de redirigir
    }
}
?>
