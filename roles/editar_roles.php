<?php
include "../conexion/conexion.php"; // Agrega el punto y coma al final de esta línea

if (isset($_GET['id'])) {
    $rolId = $_GET['id'];
    
    // Obtener los detalles del rol
    $consultaRol = mysqli_query($conn, "SELECT * FROM tbl_ms_roles WHERE ID_ROL = '$rolId'");
    
    // Verificar si se encontró el rol
    if (mysqli_num_rows($consultaRol) === 1) {
        $rol = mysqli_fetch_assoc($consultaRol);
    } else {
        echo "Rol no encontrado.";
        exit();
    }
} else {
    echo "ID de rol no especificado.";
    exit();
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener el nuevo nombre del rol desde el formulario
    $nuevoNombreRol = $_POST['nombre'];
    
    // Verificar si el nuevo nombre del rol ya existe en la base de datos para otro rol
    $consultaExistenciaRol = mysqli_query($conexion, "SELECT * FROM tbl_ms_roles WHERE NOMBRE_ROL = '$nuevoNombreRol' AND ID_ROL != '$rolId'");
    
    if (mysqli_num_rows($consultaExistenciaRol) > 0) {
        $message = "Ya existe un rol con ese nombre.";
    } else {
        // Continuar con la actualización del rol
        
        // Actualizar el rol en la base de datos
        $queryActualizarRol = "UPDATE tbl_ms_roles SET NOMBRE_ROL = '$nuevoNombreRol' WHERE ID_ROL = '$rolId'";
        if (mysqli_query($conexion, $queryActualizarRol)) {
            $message = "Rol actualizado exitosamente.";
        } else {
            $message = "Error al actualizar el rol: " . mysqli_error($conexion);
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MVC IHCI</title>
    <link rel="stylesheet" href="../css/estilos.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/860e3c70ee.js" crossorigin="anonymous"></script>
    <script src="../estilos.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.min.js"></script>
    
    <style>
    .menu li {
        margin-bottom: -1px;
    }

    .menu li a {
        padding: 0px 0px;
    }
</style>
<style>
        body {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    margin: 0;
    background-image: url('.../imagen/background.jpg');
    background-size: 30%; /* Cambiar el tamaño de la imagen de fondo */
    background-repeat: no-repeat;
    background-position: center;
    font-family: Arial, sans-serif;
}

        .form-container {
            background-color: rgba(245, 245, 220, 0.9); /* Beige con transparencia */
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.1);
            width: 400px;
            text-align: center; /* Centro el contenido horizontalmente */
        }

        .form-row {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }

        .form-label {
            flex: 1;
            padding-right: 10px;
            text-align: right;
            font-weight: bold;
        }

        .form-input {
            flex: 2;
            padding: 5px;
        }

        button[type="submit"] {
            margin-left: auto;
            display: block;
            padding: 8px 20px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        /* Otros estilos de tu elección */
    </style>
</head>
<body>

    <div class="form-container">
    <h1>Rol</h1>
    
    <p><?php echo $message; ?></p>
    
    <form action="" method="POST">
        <input type="hidden" name="rol_id" value="<?php echo $rol['ID_ROL']; ?>">
        <div class="form-row">
            <label class="form-label" for="nombre">Rol:</label>
            <input class="form-input" type="text" name="nombre" value="<?php echo $rol['NOMBRE_ROL']; ?>">
        </div>

        <!-- Deshabilitar el campo de fecha de creación -->
        <div class="form-row">
            <label class="form-label" for="fecha_creacion">Fecha de Creación:</label>
            <input class="form-input" type="text" name="fecha_creacion" value="<?php echo date('Y-m-d', strtotime($rol['FECHA_CREACION'])); ?>" disabled>
        </div>

        <!-- Mostrar y permitir editar la fecha de modificación -->
        <div class="form-row">
            <label class="form-label" for="fecha_modificacion">Fecha de Modificación:</label>
            <input class="form-input" type="text" name="fecha_modificacion" value="<?php echo date('Y-m-d', strtotime($rol['FECHA_MODIFICACION'])); ?>">
        </div>

        <!-- Mostrar y permitir editar el estado del rol -->
        <div class="form-row">
            <label class="form-label" for="estado">Estado:</label>
            <select class="form-input" name="estado">
                <option value="" <?php if ($rol['ESTADO_ROL'] === '') echo 'selected'; ?>>Sin Estado</option>
                <option value="A" <?php if ($rol['ESTADO_ROL'] === 'A') echo 'selected'; ?>>Activo</option>
                <option value="I" <?php if ($rol['ESTADO_ROL'] === 'I') echo 'selected'; ?>>Inactivo</option>
                <option value="B" <?php if ($rol['ESTADO_ROL'] === 'B') echo 'selected'; ?>>Bloqueado</option>
            </select>
        </div>

        <!-- Otros campos para editar -->

        <div class="form-row">
            <button type="submit">Guardar</button>
            <a href="roles.php" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
    </div>
    <!-- Otro contenido de la página -->
</body>
</html>

