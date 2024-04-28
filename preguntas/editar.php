<?php
// Archivo: editar.php

include_once('../conexion/conexion.php');

// Establecer la conexión
$conn = new mysqli($server, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Inicializar variables
$idPregunta = '';
$pregunta = '';
$fechaCreacion = '';
$fechaModificacion = '';
$stmtUpdate = null; // Inicializar la variable

// Verificar si se ha proporcionado un ID válido en la URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $idPregunta = $_GET['id'];

    // Consulta SQL para obtener los detalles de la pregunta específica
    $sql = "SELECT ID_PREGUNTA, PREGUNTA, FECHA_CREACION, FECHA_MODIFICACION FROM tbl_preguntas WHERE ID_PREGUNTA = $idPregunta";

    // Ejecutar la consulta
    $resultado = $conn->query($sql);

    // Verificar si hay resultados
    if ($resultado->num_rows == 1) {
        // Obtener los datos de la pregunta
        $fila = $resultado->fetch_assoc();
        $pregunta = $fila['PREGUNTA'];
        $fechaCreacion = $fila['FECHA_CREACION'];
        $fechaModificacion = $fila['FECHA_MODIFICACION'];
    } else {
        echo "Pregunta no encontrada.";
        exit();
    }
} else {
    echo "ID de pregunta no especificado.";
    exit();
}

// Inicializar la variable de mensaje de error
$errorMsg = '';

// Procesar los datos del formulario cuando se envía
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validar y actualizar los datos según sea necesario
    $pregunta = $_POST['pregunta'];

    // Obtener la fecha y hora actuales
    $fechaModificacion = date("Y-m-d H:i:s");

    // Convertir la pregunta a minúsculas
    $preguntaMin = strtolower($pregunta);

    // Consulta SQL para verificar si la pregunta ya existe (excluyendo la pregunta actual)
    $verificarDuplicadoSql = "SELECT ID_PREGUNTA FROM tbl_preguntas WHERE LOWER(PREGUNTA) = ? AND ID_PREGUNTA <> ?";
    $stmtVerificarDuplicado = $conn->prepare($verificarDuplicadoSql);
    $stmtVerificarDuplicado->bind_param("si", $preguntaMin, $idPregunta);
    $stmtVerificarDuplicado->execute();
    $stmtVerificarDuplicado->store_result();

    if ($stmtVerificarDuplicado->num_rows > 0) {
        $errorMsg = "<div class='alert alert-danger' role='alert'>No se puede actualizar la pregunta porque ya existe en la base de datos.</div>";
    } else {
        // La pregunta no existe, proceder con la actualización
        // Consulta SQL para actualizar la pregunta
        $updateSql = "UPDATE tbl_preguntas SET PREGUNTA = ?, FECHA_MODIFICACION = ? WHERE ID_PREGUNTA = ?";
        $stmtUpdate = $conn->prepare($updateSql);
        $stmtUpdate->bind_param("ssi", $pregunta, $fechaModificacion, $idPregunta);

        if ($stmtUpdate->execute()) {
            // Actualización exitosa
            // Redirigir a la página principal después de la actualización
            header("Location: preguntas.php");
            exit();
        } else {
            $errorMsg = "<div class='alert alert-danger' role='alert'>Error al actualizar la pregunta: " . $conn->error . "</div>";
        }
    }

    // Cerrar la declaración
    $stmtVerificarDuplicado->close();
}

// Cerrar la conexión
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Pregunta</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/860e3c70ee.js" crossorigin="anonymous"></script>
    <script src="../Js/estilos.js"></script>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            background-size: 30%; /* Cambiar el tamaño de la imagen de fondo */
            background-repeat: no-repeat;
            background-position: center;
            font-family: Arial, sans-serif;
        }

        .container {
            background-color: #ddd; /* Beige con transparencia */
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.1);
            width: 550px;
            text-align: left; /* Alinea el contenido a la izquierda */
            margin: 0 auto; /* Centra el formulario en la página */
        }

        /* Estilos para el título */
       h2 {
           color: #007BFF; /* Cambiar el color del título a azul */
           font-weight: bold; /* Hacer el título en negrita */
       }

       /* Estilos para el contenedor de los botones */
       .button-container {
           text-align: center; /* Centra los botones horizontalmente */
           margin-top: 20px; /* Espacio arriba de los botones */
       }
    </style>
</head>

<body>
    <div class="container">
        <div class="text-center"> <!-- Nuevo contenedor para centrar -->
            <h2><i class="fas fa-question"></i> PREGUNTA</h2>
        </div>
        <!-- Mostrar mensaje de error aquí -->
        <?php echo $errorMsg; ?>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id=" . $idPregunta); ?>" method="POST">
            <!-- Campos del formulario -->
            <div class="mb-3">
                <label for="pregunta" class="form-label">Pregunta:</label>
                <textarea class="form-control" name="pregunta" required><?php echo $pregunta; ?></textarea>
            </div>

            <!-- Campo de fecha de creación (solo lectura) -->
            <div class="mb-3">
                <label for="fechaCreacion" class="form-label">Fecha de Creación:</label>
                <input class="form-control" type="text" name="fechaCreacion" value="<?php echo date('Y-m-d', strtotime($fechaCreacion)); ?>" readonly>
            </div>

            <!-- Campo de fecha de modificación -->
            <div class="mb-3">
                <label for="fechaModificacion" class="form-label">Fecha de Modificación:</label>
                <input type="text" class="form-control" name="fechaModificacion" value="<?php echo date('Y-m-d', strtotime($fechaModificacion)); ?>" readonly>
            </div>

            <!-- Botones de guardar y cancelar -->
            <div class="button-container"> <!-- Nuevo contenedor para centrar -->
                <button type="submit" class="btn btn-primary">Guardar</button>
                <a href="preguntas.php" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</body>

</html>
