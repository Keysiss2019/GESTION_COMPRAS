<?php
include '../conexion/conexion.php'; // Asegúrate de incluir correctamente el archivo de conexión

// Definir la función mostrarMensaje()
function mostrarMensaje($mensaje, $tipo) {
    // Aquí puedes implementar la lógica para mostrar el mensaje, por ejemplo, imprimir un mensaje HTML
    echo '<div class="alert alert-' . $tipo . '">' . $mensaje . '</div>';
}

// Comprobar si se envió un ID válido
if (isset($_GET['id'])) {
    $idcotizacion = $_GET['id'];
    
    // Comprobar si se ha confirmado la eliminación
    if (isset($_GET['confirmar']) && $_GET['confirmar'] === 'true') {

        // Realizar la eliminación en la base de datos
        $sql = "DELETE FROM tbl_cotizacion WHERE ID_COTIZACION='$idcotizacion'";

        if (mysqli_query($conn, $sql)) {
            // Respuesta JSON indicando que la eliminación fue exitosa
            header('Content-Type: application/json');
            echo json_encode(array('success' => true, 'message' => 'Registro eliminado exitosamente.'));
            exit(); // Terminar la ejecución del script después de la respuesta JSON
        } else {
            // Respuesta JSON indicando que hubo un error en la eliminación
            header('Content-Type: application/json');
            echo json_encode(array('success' => false, 'message' => 'Error al eliminar el registro: ' . mysqli_error($conn)));
            exit(); // Terminar la ejecución del script después de la respuesta JSON
        }
    }
}

// Cerrar la conexión (opcional si no se realiza ninguna operación adicional)
mysqli_close($conn);
?>