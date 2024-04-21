<?php
include('db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Manejar datos del proveedor
    $id = $_POST['ID_PROVEEDOR'];
    $nombre = $_POST['NOMBRE'];
    $direccion = $_POST['DIRECCION'];
    $telefono = $_POST['TELEFONO'];
    $correo = $_POST['CORREO_ELECTRONICO'];
    $estadoSeleccionado = $_POST['ESTADO_PROVEEDOR'];

    // Asignar la letra correspondiente al estado
    $estado = '';
    switch ($estadoSeleccionado) {
        case 'Sin estado':
            $estado = 'S';
            break;
        case 'Activo':
            $estado = 'A';
            break;
        case 'Inactivo':
            $estado = 'I';
            break;
    }
    
    // Verificar si el estado es "Sin estado" y establecer el valor en NULL si es así
    if ($estado == "Sin estado") {
        $estado = NULL;
    }
    
    // Establecer el valor "ADMIN" para el campo que debe llenarse automáticamente
    $modificado_por = "ADMIN";

    // Actualizar los datos del proveedor
    $query_proveedor = "UPDATE tbl_proveedores SET NOMBRE = ?, DIRECCION = ?, TELEFONO = ?, CORREO_ELECTRONICO = ?, ESTADO_PROVEEDOR = ?, MODIFICADO_POR = ? WHERE ID_PROVEEDOR = ?";
    $stmt_proveedor = $conexion->prepare($query_proveedor);
    $stmt_proveedor->bind_param("ssssssi", $nombre, $direccion, $telefono, $correo, $estado, $modificado_por, $id);

    // Manejar datos de la cuenta del proveedor
    $numero_cuenta = $_POST['NUMERO_CUENTA'];
    $banco = $_POST['BANCO'];
    $descripcion_cuenta = $_POST['DESCRIPCION_CUENTA'];

    // Actualizar los datos de la cuenta del proveedor
    $query_cuenta = "UPDATE tbl_cuenta_proveedor SET NUMERO_CUENTA = ?, BANCO = ?, DESCRIPCION_CUENTA = ? WHERE ID_PROVEEDOR = ?";
    $stmt_cuenta = $conexion->prepare($query_cuenta);
    $stmt_cuenta->bind_param("sssi", $numero_cuenta, $banco, $descripcion_cuenta, $id);

    // Ejecutar ambas consultas
    if ($stmt_proveedor->execute() && $stmt_cuenta->execute()) {
        header('Location: listar_proveedores.php');
        exit;
    } else {
        echo "Error al actualizar el proveedor: " . $stmt_proveedor->error;
        echo "Error al actualizar la cuenta del proveedor: " . $stmt_cuenta->error;
    }

    $stmt_proveedor->close();
    $stmt_cuenta->close();
}

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM tbl_proveedores WHERE ID_PROVEEDOR = $id";
    $result = $conexion->query($query);
    $row = $result->fetch_assoc();
    // También necesitas obtener los datos de la cuenta del proveedor
    $query_cuenta = "SELECT * FROM tbl_cuenta_proveedor WHERE ID_PROVEEDOR = $id";
    $result_cuenta = $conexion->query($query_cuenta);
    $row_cuenta = $result_cuenta->fetch_assoc();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Actualizar Proveedor</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: rgba(255, 255, 255, 0.10); /* Cambia el valor de "0.7" para ajustar la transparencia */
            background-image: url('../imagen/background.jpg'); /* Reemplaza con la ruta de tu imagen de fondo */
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            margin: 0;
            padding: 0;
           
        
        }

        /* Estilos para centrar el título */
h2 {
    text-align: center; /* Centrar el texto horizontalmente */
}

        /* Estilos para el contenedor del formulario (el cuadro) */
.form-container {
    width: 80%; /* Ancho del contenedor */
    margin: 0 auto; /* Centrar horizontalmente en la página */
    padding: 20px; /* Espacio interno alrededor del formulario */
    border: 1px solid #ccc; /* Borde del cuadro */
    border-radius: 5px; /* Bordes redondeados */
    background-color: powderblue; /* Color de fondo del cuadro */
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Sombra ligera */
    opacity: 0.9; /* Valor de opacidad (menos transparente) */
}


       

/* Estilos para la columna del formulario */
.form-column {
    float: left; /* Flotar las columnas a la izquierda */
    width: 50%; /* Ancho del 50% para ambas columnas */
    box-sizing: border-box; /* Incluir el relleno y el borde en el ancho */
    padding: 10px; /* Espacio interno entre elementos dentro de la columna */
}

/* Estilos para los campos de entrada (input) en la columna */
.form-column input {
    width: 90%; /* Ancho del 100% para llenar la columna completa */
    padding: 10px; /* Espaciado dentro de los campos de entrada */
    margin-bottom: 10px; /* Espacio inferior entre campos de entrada */
}

/* Estilos para las etiquetas (label) en la columna */
.form-column label {
    display: block; /* Mostrar las etiquetas en una nueva línea */
    margin-bottom: 5px; /* Espacio inferior entre etiquetas */
}

select{
            width: 95%;
            padding: 10px;
            margin-top: 1px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

/* Estilos para la sección de botones */
.button-section {
    clear: both; /* Limpiar el flotado para que los elementos debajo no floten */
    text-align: right; /* Alinear los botones a la izquierda */
    margin-top: 20px; /* Espacio superior para separar de las columnas */
}

/* Estilos para los botones */
button, .custom-button {
    padding: 10px 20px; /* Espaciado dentro de los botones */
    background-color: #007bff; /* Color de fondo del botón principal */
    color: #fff; /* Color de texto para el botón principal */
    border: none; /* Sin borde */
    cursor: pointer;
}

.cancel-button {
    background-color: gray; /* Color de fondo para el botón de cancelar */
    text-decoration: none; /* Quita el subrayado */
}






    </style>
</head>
<body>
    <div class="form-container">
        <h2 style="text-align: center;">Proveedor</h2>

        <form method="POST" action="actualizar_proveedor.php">
            <input type="hidden" name="ID_PROVEEDOR" value="<?php echo $row['ID_PROVEEDOR']; ?>">
            
            <div class="form-row">
                <div class="form-column">
                    <!-- Datos del proveedor -->
                    <label>Nombre:</label>
                    <input type="text" name="NOMBRE" value="<?php echo strtoupper($row['NOMBRE']); ?>" required><br>
                    <label>Dirección:</label>
                    <input type="text" name="DIRECCION" value="<?php echo $row['DIRECCION']; ?>"><br>
                    <label>Teléfono:</label>
                    <input type="text" name="TELEFONO" value="<?php echo $row['TELEFONO']; ?>"><br>
                    <label>Correo Electrónico:</label>
                    <input type="email" name="CORREO_ELECTRONICO" value="<?php echo $row['CORREO_ELECTRONICO']; ?>"><br>
                    <label>Estado:</label>
                    <select name="ESTADO_PROVEEDOR">
                    <option value="" <?php echo empty($row['ESTADO_PROVEEDOR']) ? "selected" : ""; ?>>Seleccionar estado</option>
                        <option value="Activo" <?php echo ($row['ESTADO_PROVEEDOR'] === "A") ? "selected" : ""; ?>>ACTIVO</option>
                        <option value="Inactivo" <?php echo ($row['ESTADO_PROVEEDOR'] === "I") ? "selected" : ""; ?>>INACTIVO</option>
                        <!-- Puedes agregar más opciones según sea necesario -->
                    </select>
                </div>
                
                <div class="form-column">
                    <!-- Datos de la cuenta del proveedor -->
                    <label>Número de Cuenta:</label>
                    <input type="text" name="NUMERO_CUENTA" value="<?php echo $row_cuenta['NUMERO_CUENTA']; ?>"><br>
                    <label>Banco:</label>
                    <input type="text" name="BANCO" value="<?php echo $row_cuenta['BANCO']; ?>"><br>
                    <label>Descripción de la Cuenta:</label>
                    <select name="DESCRIPCION_CUENTA">
                      <option value="Cheques" <?php echo ($row_cuenta['DESCRIPCION_CUENTA'] === "Cheques") ? "selected" : ""; ?>>CHEQUE</option>
                       <option value="Ahorros" <?php echo ($row_cuenta['DESCRIPCION_CUENTA'] === "Ahorros") ? "selected" : ""; ?>>AHORRO</option>
                    </select><br>

                </div>
            </div>
            
            <div class="button-section">
                <button type="submit">Guardar</button>
                <a href="listar_proveedores.php" class="custom-button cancel-button">Cancelar</a>
            </div>
        </form>
    </div>
</body>
</html>





