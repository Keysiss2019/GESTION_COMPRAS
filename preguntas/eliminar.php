<?php
if (isset($_POST['eliminar']) && isset($_POST['ID_PREGUNTA'])) {
    $id_pregunta = $_POST['ID_PREGUNTA'];

    // Conexión a la base de datos
    $servername = "localhost";
    $username = "root";
    $password = ""; 
    $dbname = "gestion_compras2";
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Error de conexión: " . $conn->connect_error);
    }

    // Consulta para eliminar el usuario
    $sql = "DELETE FROM tbl_preguntas WHERE ID_PREGUNTA = $id_pregunta";
    if ($conn->query($sql) === TRUE) {
        // Redireccionar o mostrar un mensaje de éxito
        header("Location: ../preguntas/preguntas.php"); // Cambia "preguntas.php" por la página donde se muestra la lista de preguntas
        exit();
    } else {
        echo "Error al eliminar la pregunta: " . $conn->error;
    }

    $conn->close();
}
?>
