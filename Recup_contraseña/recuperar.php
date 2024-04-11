<?php
// Conexión a la base de datos
$mysqli = new mysqli("localhost", "root", "", "gestion_compras2");

if ($mysqli->connect_error) {
    die("Error en la conexión: " . $mysqli->connect_error);
}

// Obtener el correo electrónico proporcionado por el usuario
$correo = $_POST['correo'];

// Verificar si el correo existe en la base de datos
$query = "SELECT * FROM TBL_MS_USUARIO WHERE CORREO_ELECTRONICO = '$correo'";
$result = $mysqli->query($query);

if ($result->num_rows > 0) {
    // Generar una nueva contraseña temporal
    $nuevaContrasena = generarNuevaContrasena();

    // Actualizar la contraseña en la base de datos
    $hashedContrasena = password_hash($nuevaContrasena, PASSWORD_DEFAULT);
    $updateQuery = "UPDATE TBL_MS_USUARIO SET contraseña = '$hashedContrasena' WHERE CORREO_ELECTRONICO = '$correo'";
    $mysqli->query($updateQuery);

    // Enviar la nueva contraseña por correo electrónico (debes implementar esta parte)
    // Incluir el código para enviar el correo
    require 'enviar_correo.php';

    // Mostrar un mensaje de éxito
    echo "";
} else {
    echo "El correo electrónico proporcionado no está registrado en nuestro sistema.";
}

// Función para generar una nueva contraseña aleatoria que cumpla con los requisitos
function generarNuevaContrasena() {
    // Definir los caracteres permitidos para la contraseña
    $caracteres = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()-_";

    // Inicializar la nueva contraseña como una cadena vacía
    $nuevaContrasena = "";

    // Definir la longitud mínima de la contraseña
    $longitud_minima = 8;

    // Generar una contraseña hasta que cumpla con los requisitos
    do {
        // Reiniciar la contraseña generada
        $nuevaContrasena = "";

        // Generar una contraseña aleatoria de longitud mínima
        for ($i = 0; $i < $longitud_minima; $i++) {
            $indice = rand(0, strlen($caracteres) - 1);
            $nuevaContrasena .= $caracteres[$indice];
        }

        // Verificar si la contraseña generada cumple con los criterios
        $cumple_longitud = strlen($nuevaContrasena) >= $longitud_minima;
        $cumple_numeros = preg_match('/[0-9]/', $nuevaContrasena);
        $cumple_mayusculas = preg_match('/[A-Z]/', $nuevaContrasena);
        $cumple_signos = preg_match('/[!@#$%^&*()\-_]/', $nuevaContrasena);
        $no_contiene_espacios = !preg_match('/\s/', $nuevaContrasena);

        // La contraseña cumple con todos los criterios
        $cumple_requisitos = $cumple_longitud && $cumple_numeros && $cumple_mayusculas && $cumple_signos && $no_contiene_espacios;
    } while (!$cumple_requisitos); // Repetir hasta que se cumplan todos los requisitos

    return $nuevaContrasena;
}


$mysqli->close();
?>
