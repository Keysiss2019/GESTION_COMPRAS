<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<style>
    /* Estilos CSS */
    body {
        text-align: center;
        font-family: Arial, sans-serif;
        background: rgba(255, 255, 255, 0.10);
        background-image: url('../imagen/background.jpg');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        margin: 0;
        padding: 0;
        display: flex;
        justify-content: center; /* Centra horizontalmente */
        align-items: center; /* Centra verticalmente */
        min-height: 100vh;
    }

    .container {
        width: 90%; /* Ajusta el ancho del contenedor principal */
        text-align: center;
        border: 1px solid #ccc;
        padding: 20px;
        background-color: powderblue;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        opacity: 0.9;
        max-width: 800px; /* Ajusta el ancho máximo según tus necesidades */
        margin: 0 auto; /* Centra horizontalmente */
    }

    .table-container {
        width: 100%; /* Ajusta el ancho del contenedor de la tabla */
    }

    .table {
        width: 100%;
        border-collapse: collapse; /* Fusiona los bordes de la tabla */
        background-color: cornsilk;
        border: 1px solid #ddd !important;
    }

    .table th,
    .table td {
        padding: 10px;
        border: 1px solid #ddd !important; /* Borde para todas las celdas */
    }

    /* Ancho de los campos de entrada, áreas de texto y listas desplegables dentro de la tabla */
    .table input,
    .table select,
    .table textarea {
        width: 100%; /* Ancho al 100% del contenedor */
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 5px;
        box-sizing: border-box;
    }

    /* CSS para el área de texto */
    .table textarea {
        resize: vertical; /* Permitir redimensionar verticalmente */
        min-height: 100px; /* Altura mínima */
    }


    .btn-container {
        display: flex;
        justify-content: space-around; /* Ajusta el espacio entre los botones */
        margin-top: 10px;
    }

    .btn {
        flex: 1; /* Ocupa el espacio disponible de manera equitativa */
        background-color: #007bff;
        color: #fff;
        padding: 15px; /* Ajusta el padding para hacer los botones más altos */
        border: none;
        border-radius: 5px;
        cursor: pointer;
        margin: 0 5px; /* Espacio entre botones */
        box-sizing: border-box; /* Asegura que el padding no afecte el ancho total */
        text-decoration: none; /* Elimina el subrayado del texto */
    }
    .form-group {
        display: flex;
        align-items: center;
        justify-content: flex-start; /* Alinea los elementos a la izquierda */
        margin-bottom: 5px;
    }
    .form-group label {
    display: inline-block; /* Alinea los elementos label */
    text-align: right;
    margin-left: 20px; /* Ajusta el margen izquierdo para la distancia uniforme */
    font-weight: bold;
}

.form-group input {
    width: 200px; /* Ancho fijo para los elementos input */
    margin-left: 40px; /* Ajusta el margen izquierdo para alinear con los labels */
} 
.form-group select{
    width: 200px; /* Ancho fijo para los elementos input */
    margin-left: 40px; /* Ajusta el margen izquierdo para alinear con los labels */
} 
</style>
</head>
<body>
<div class="container">
    <div class="table-container">
        <div class="table">
        <?php
// Incluir archivo de conexión a la base de datos
include("../conexion/conexion.php");

// Función para obtener el nombre de usuario
function obtenerNombreUsuario($conn, $usuario_id) {
    $sql = "SELECT nombre_usuario FROM tbl_ms_usuario WHERE id_usuario = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $usuario_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    return $row["nombre_usuario"];
}

// Verificar si se proporcionó el ID de la solicitud por el método GET
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {
    $solicitud_id = $_GET["id"];

    // Verificar conexión a la base de datos
    if ($conn->connect_error) {
        die("Error de conexión: " . $conn->connect_error);
    }

    // Obtener los datos de la solicitud a editar
    $sql = "SELECT * FROM tbl_solicitudes WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $solicitud_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Verificar si se encontró la solicitud
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();

        // Obtener los datos de la solicitud
        $idDepartamento = $row["idDepartamento"];
        $usuario_id = $row["usuario_id"];
        $codigo = $row["codigo"];
        $estado = strtoupper($row["estado"]); // Convertir estado a mayúsculas

        // Consultas para obtener información de departamentos y categorías
        $sql_departamentos = "SELECT id_departamento, nombre_departamento FROM tbl_departamentos";
        $result_departamentos = $conn->query($sql_departamentos);

        $sql_categorias = "SELECT id, categoria FROM tbl_categorias";
        $result_categorias = $conn->query($sql_categorias);

        // Generar el formulario para editar la solicitud
        echo "<form method='post' action='guardar_edicion_solicitud.php'>";
        echo "<h2>SOLICITUD</h2>";
        echo "<input type='hidden' name='solicitud_id' value='$solicitud_id'>";
        
        echo "<div class='form-group'><label for='codigo'>Código:</label><input type='text' name='codigo' value='$codigo' style='width: 100px; height: 40px; margin-left: 60px;'required></div>";
        echo "<div class='form-group'><label for='idDepartamento'>Departamento:</label><select id='idDepartamento' name='idDepartamento' style='width: 200px; height: 40px; margin-left: 10px;'required>";

        while ($row_departamento = $result_departamentos->fetch_assoc()) {
            $selected = ($row_departamento["id_departamento"] == $idDepartamento) ? "selected" : "";
            echo "<option value='" . $row_departamento["id_departamento"] . "' $selected>" . $row_departamento["nombre_departamento"] . " </option>";
        }

        echo "</select></div>";

        $usuario_nombre = obtenerNombreUsuario($conn, $usuario_id);
        echo "<div class='form-group'><label for='usuario_nombre'>Usuario:</label><input type='text' id='usuario_nombre' name='usuario_nombre' value='$usuario_nombre' style='width: 200px; height: 40px; margin-left: 60px;'required></div>";

        echo "<div class='form-group'><label for='estado'>Estado:</label>";
        echo "<select name='estado' style='width: 200px; height: 40px; margin-left: 65px;'required>";
        echo "<option value='NUEVA'" . ($estado === "NUEVA" ? " selected" : "") . ">NUEVA</option>";
        echo "<option value='PENDIENTE'" . ($estado === "PENDIENTE" ? " selected" : "") . ">PENDIENTE</option>";
        echo "<option value='PROCESO'" . ($estado === "PROCESO" ? " selected" : "") . ">PROCESO</option>";
        echo "<option value='APROBADA'" . ($estado === "APROBADA" ? " selected" : "") . ">APROBADA</option>";
        echo "<option value='PAGADO'" . ($estado === "PAGADO" ? " selected" : "") . ">PAGADO</option>";
        echo "</select></div>";

        

        // Mostrar la tabla de detalles del producto
        echo "<h2>Detalles del Producto</h2>";
        echo "<table class='table'>"; // Aplicamos la clase "table" aquí
        echo "<thead>";
        echo "<tr>";
        echo "<th style='width: 10%;'>Cantidad</th>";
        echo "<th>Descripción</th>";
        echo "<th style='width: 20%;'>Categoría</th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";

        // Obtener las categorías de la base de datos
        $categorias = [];
        while ($row_categoria = $result_categorias->fetch_assoc()) {
            $categorias[$row_categoria['id']] = $row_categoria['categoria'];
        }

        // Obtener los detalles del producto para esta solicitud
        $sql_detalles_producto = "SELECT cantidad, descripcion, categoria 
                                  FROM tbl_productos 
                                  WHERE id_solicitud = ?";
        $stmt_detalles_producto = $conn->prepare($sql_detalles_producto);
        $stmt_detalles_producto->bind_param("i", $solicitud_id);
        $stmt_detalles_producto->execute();
        $result_detalles_producto = $stmt_detalles_producto->get_result();

        // Verificar si se encontraron detalles del producto
        if ($result_detalles_producto->num_rows > 0) {
            // Iterar sobre los detalles del producto y mostrarlos en la tabla
            while ($row_detalles_producto = $result_detalles_producto->fetch_assoc()) {
                echo "<tr>";
                echo "<td><input type='number' name='cantidad[]' value='" . $row_detalles_producto["cantidad"] . "'style='width: 60px; height: 50px;'</td>";
                echo "<td><textarea name='descripcion[]'>" . $row_detalles_producto["descripcion"] . "</textarea></td>";
                echo "<td>";
                echo "<select name='categoria[]' style='width: 140px; height: 70px;'>"; // Ajusta el ancho del campo de selección
                // Mostrar opciones de categoría
                foreach ($categorias as $id_categoria => $categoria) {
                    $selected = ($row_detalles_producto["categoria"] == $id_categoria) ? "selected" : "";
                    echo "<option value='$id_categoria' $selected>$categoria</option>";
                }
                echo "</select>";
                echo "</td>";
                echo "</tr>";
            }
        } else {
            // Si no se encontraron detalles del producto, mostrar un mensaje en una fila de la tabla
            echo "<tr><td colspan='3'>No se encontraron detalles del producto para esta solicitud.</td></tr>";
        }

        echo "</tbody>";
        echo "</table>";

        // Botones de guardar y cancelar
        echo '<div class="btn-container">';
        echo '<input type="submit" value="Guardar" class="btn btn-primary" style="width: 20%;" >';
        echo '<a href="solicitudes.php" class="btn btn-secondary" style="width: 20%; background-color: gray; color: white;">Cancelar</a>';
        echo '</div>';

        echo "</form>";

    } else {
        echo "Solicitud no encontrada.";
    }

    // Cerrar la conexión
    $conn->close();
} else {
    echo "ID de solicitud no proporcionado.";
}
?>

        </div>
    </div>
</div>
</body>
</html>

