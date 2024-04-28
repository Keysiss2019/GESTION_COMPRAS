<?php
session_start();
    include('db.php');

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $nombre = $_POST['NOMBRE'];
        $direccion = $_POST['DIRECCION'];
        $telefono = $_POST['TELEFONO'];
        $correo = $_POST['CORREO_ELECTRONICO'];
        $estado_proveedor = $_POST['ESTADO_PROVEEDOR'];

        // Establecer el valor "ADMIN" para el campo que debe llenarse automáticamente
         $creado_por = "ADMIN";
    
        $query = "INSERT INTO tbl_proveedores (NOMBRE, DIRECCION, TELEFONO, CORREO_ELECTRONICO, ESTADO_PROVEEDOR, CREADO_POR) VALUES (?, ?, ?, ?, ?,?)";
        $stmt = $conexion->prepare($query);
        $stmt->bind_param("ssssss", $nombre, $direccion, $telefono, $correo, $estado_proveedor, $creado_por);
    
        if ($stmt->execute()) {
            // Obtener el ID del proveedor recién insertado
            $id_proveedor = $conexion->insert_id;
    
            // Almacenar el nombre y el ID del proveedor en la sesión
            $_SESSION['NOMBRE'] = $nombre;
            $_SESSION['ID_PROVEEDOR'] = $id_proveedor;
    
            header("Location: crear_cuenta.php");
            exit;
        } else {
            echo "Error al guardar el proveedor: " . $stmt->error;
        }
        
        
    
        $stmt->close();
    }
    
    ?>
<!DOCTYPE html>
<html>
<head>
    <title>Crear Nuevo Proveedor</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: rgba(255, 255, 255, 0.10); /* Cambia el valor de "0.7" para ajustar la transparencia */
           /* background-image: url('../imagen/background.jpg'); /* Reemplaza con la ruta de tu imagen de fondo */
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            margin: 0;
            padding: 0;
           
        
        }

        /* Estilos para centrar el título */
h2 {
    text-align: center; /* Centrar el texto horizontalmente */
    color: #007BFF; /* Cambiar el color del título a azul */
           font-weight: bold; /* Hacer el título en negrita */
}

   /* Estilos para el contenedor del formulario */
   .form-container {
            width: 50%;
            margin: 5% auto; /* Ajusta el margen para centrar vertical y horizontalmente */
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #ddd;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            opacity: 0.9;
            border-radius: 5px;
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
    border-radius: 5px;
}

/* Estilos para los botones */
button, .custom-button {
    padding: 10px 20px; /* Espaciado dentro de los botones */
    background-color: #007bff; /* Color de fondo del botón principal */
    color: #fff; /* Color de texto para el botón principal */
    border: none; /* Sin borde */
    cursor: pointer;
    border-radius: 5px;
    font-size: 16px; /* Aumenta ligeramente el tamaño de la letra del botón "Guardar" */
}

.cancel-button {
    background-color: gray; /* Color de fondo para el botón de cancelar */
    text-decoration: none; /* Quita el subrayado */
}



    </style>
</head>
<body>
<br><br>
<div class="form-container">
    <h2 style="text-align: center;">PROVEEDOR</h2>

    <form method="POST" action="crear_proveedor.php">
        <div class="form-column">
          <label>Nombre:</label>
          <input type="text" name="NOMBRE" required><br>
          <label>Dirección:</label>
          <input type="text" name="DIRECCION"><br>
          <label>Teléfono:</label>
          <input type="text" name="TELEFONO"><br>
        </div>
        
        <div class="form-column">
        <label>Correo Electrónico:</label>
        <input type="email" name="CORREO_ELECTRONICO"><br>

        <label>Estado:</label>
        <select name="ESTADO_PROVEEDOR" required>
          <option value="">--Seleccione--</option>
          <option value="A">ACTIVO</option>
          <option value="I">INACTIVO</option>
          <option value="B">BLOQUEADO</option>
        </select><br>
        </div>

        
        <div class="button-section">
         <button type="submit">Guardar</button>
         <a href="listar_proveedores.php" class="custom-button cancel-button">Cancelar</a>
        </div>
        
    </form>
</div>
</body>
</html>
