<?php
// Incluir el archivo de conexión a la base de datos
require_once('conexion/conexion.php');

// Iniciar sesión para acceder a la variable de sesión
session_start();

// Verificar si el nombre de usuario está definido en la sesión
if(isset($_SESSION['nombre_usuario']) && !empty($_SESSION['nombre_usuario'])) {
    // Obtener el nombre de usuario de la sesión PHP
    $nombre_usuario_php = $_SESSION['nombre_usuario'];

    // Número de registros por página
    $resultsPerPage = isset($_GET['resultsPerPage']) ? $_GET['resultsPerPage'] : 10; // Obtener el número de registros por página desde el parámetro GET o establecerlo en 10 por defecto

    // Calcular la página actual y el índice de inicio
    $page = isset($_GET['page']) ? $_GET['page'] : 1;
    $startIndex = ($page - 1) * $resultsPerPage;

    // Consulta SQL para obtener registros de la bitácora
    $sqlBitacora = "SELECT *, (SELECT nombre_usuario FROM tbl_ms_usuario WHERE id_usuario = auditoria_tbl_ms_usuario.id_usuario_operacion) AS nombre_usuario_operacion FROM auditoria_tbl_ms_usuario ORDER BY fecha_operacion DESC LIMIT $startIndex, $resultsPerPage";

    // Preparar la consulta con el nombre de usuario de PHP
    $stmt = $conn->prepare("SET @usuario_php = ?");
    $stmt->bind_param("s", $nombre_usuario_php);
    $stmt->execute();

    // Ejecutar la consulta para obtener los registros de la bitácora
    $resultBitacora = $conn->query($sqlBitacora);

    // Consulta SQL para obtener el total de registros en la bitácora
    $sqlTotalRecords = "SELECT COUNT(*) as total FROM auditoria_tbl_ms_usuario";
    $resultTotalRecords = $conn->query($sqlTotalRecords);
    $rowTotalRecords = $resultTotalRecords->fetch_assoc();
    $totalRecords = $rowTotalRecords['total'];

    // Calcular el total de páginas
    $totalPages = ceil($totalRecords / $resultsPerPage);
} else {
    // Si el nombre de usuario no está definido en la sesión, redirigir al usuario a la página de inicio de sesión
    header("Location: login.php");
    exit(); // Detener la ejecución del script después de redirigir
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bitácora de Usuarios</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <!-- Agregar Font Awesome para los íconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 50px;
        }
        table {
            width: 100%;
            margin-top: 20px;
            font-size: 14px; /* Tamaño de letra más pequeño */
        }
        th, td {
            padding: 8px; /* Reducir el espacio alrededor del contenido */
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .export-icons {
            margin-bottom: 10px;
        }
        .export-icons a {
            margin-right: 10px;
        }
        .pagination-container, .search-container {
            display: flex;
            justify-content: flex-end; /* Alinea los elementos a la derecha */
            margin-top: 20px;
        }
        .search-container {
            margin-bottom: 20px;
            margin-top: -45px;
        }
        .pagination-container a {
            padding: 6px 12px;
            text-decoration: none;
            color: #007bff;
            border: 1px solid #007bff;
            border-radius: 4px;
        }
        .pagination-container a:hover {
            background-color: #007bff;
            color: #fff;
        }
        .pagination-container a.disabled {
            pointer-events: none;
            color: #6c757d;
            border-color: #6c757d;
        }
        /* Estilo personalizado para el contenedor del select */
        .select-container {
            margin-bottom: 20px;
            display: inline-flex; /* Mostrar en línea */
            border-radius: 0;
            width: 120px; /* Ajustar el ancho según sea necesario */
            height: 35px; /* Ajustar la altura según sea necesario */
        
        }
        

        
        

    </style>
</head>
<body>

<div class="container">
    <h2>Bitácora</h2>

    <div class="export-icons">
        <a href="export_excel.php"><i class="fas fa-file-excel"></i> Exportar a Excel</a>
        <a href="export_pdf.php"><i class="fas fa-file-pdf"></i> Exportar a PDF</a>
    </div>

    <!-- Agregar el select para seleccionar el número de registros por página -->
    <div class="select-container">
        <label for="resultsPerPage">Mostrar:</label>
        <select class="form-control" id="resultsPerPage" name="resultsPerPage" onchange="changeResultsPerPage()">
            <option value="5" <?php if($resultsPerPage == 5) echo "selected"; ?>>5</option>
            <option value="10" <?php if($resultsPerPage == 10) echo "selected"; ?>>10</option>
            <option value="20" <?php if($resultsPerPage == 20) echo "selected"; ?>>20</option>
            <option value="50" <?php if($resultsPerPage == 50) echo "selected"; ?>>50</option>
        </select>
    </div>
    <script>
    // Función para restablecer los cambios en la bitácora
    function resetChanges(auditoriaId) {
        // Confirmar con el usuario antes de restablecer los cambios
        var confirmation = confirm("¿Estás seguro de que deseas restablecer los cambios? Esto revertirá la entrada de la bitácora.");

        if (confirmation) {
            // Realizar la solicitud AJAX al servidor para restablecer los cambios
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        // Actualizar la tabla después de recibir la confirmación del servidor
                        // Puedes implementar esta función según tu lógica específica
                        // Por ejemplo, puedes recargar la página para actualizar la tabla
                        window.location.reload(); // Recargar la página para actualizar la tabla
                    } else {
                        // Manejar errores en la solicitud AJAX
                        console.error('Error en la solicitud AJAX:', xhr.statusText);
                    }
                }
            };

            // Configurar la solicitud AJAX
            xhr.open('GET', 'reset_changes.php?auditoriaId=' + auditoriaId, true);
            xhr.send();
        }
    }
</script>
    <?php if ($resultBitacora->num_rows > 0): ?>
        <div class="search-container">
            <input type="text" id="searchInput" onkeyup="filterTable()" placeholder="Buscar...">
        </div>

        <table class="table table-bordered" id="userLogTable">
            <thead>
                <tr>
                    <th>ID Auditoría</th>
                    <th>Tipo de Operación</th>
                    <th>Fecha de Operación</th>
                    <th>Usuario Operador</th>
                    <th>ID Usuario Afectado</th>
                    <th>Usuario Afectado</th>
                    <th>Tabla Afectada</th>
                    <th>Detalle Anterior</th>
                    <th>Detalle Posterior</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $resultBitacora->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id_auditoria']; ?></td>
                        <td><?php echo $row['tipo_operacion']; ?></td>
                        <td><?php echo $row['fecha_operacion']; ?></td>
                        <td><?php echo $nombre_usuario_php; ?></td> <!-- Reemplazar con $nombre_usuario_php -->
                        <td><?php echo $row['id_usuario_afectado']; ?></td>
                        <td><?php echo $row['nombre_usuario_afectado']; ?></td>
                        <td><?php echo $row['tabla_afectada']; ?></td>
                        <td><?php echo $row['detalle_anterior']; ?></td>
                        <td><?php echo $row['detalle_posterior']; ?></td>
                        
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <div class="pagination-container">
            <?php if ($page > 1): ?>
                <a href="?page=<?php echo ($page - 1); ?>&resultsPerPage=<?php echo $resultsPerPage; ?>">&lt; Anterior</a>
            <?php endif; ?>

            <?php if ($page < $totalPages): ?>
                <a href="?page=<?php echo ($page + 1); ?>&resultsPerPage=<?php echo $resultsPerPage; ?>">Siguiente &gt;</a>
            <?php endif; ?>
        </div>
    <?php else: ?>
        <p>No hay registros en la bitácora.</p>
    <?php endif; ?>

    <button onclick="goBack()">Regresar</button>

    <script>
        // Función para filtrar la tabla
        function filterTable() {
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("searchInput");
            filter = input.value.toUpperCase();
            table = document.getElementById("userLogTable");
            tr = table.getElementsByTagName("tr");
            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td");
                for (var j = 0; j < td.length; j++) {
                    if (td[j]) {
                        txtValue = td[j].textContent || td[j].innerText;
                        if (txtValue.toUpperCase().indexOf(filter) > -1) {
                            tr[i].style.display = "";
                            break;
                        } else {
                            tr[i].style.display = "none";
                        }
                    }
                }
            }
        }

        // Función para regresar a la pantalla anterior
        function goBack() {
            window.history.back();
        }

        // Función para cambiar el número de registros por página
        function changeResultsPerPage() {
            var resultsPerPage = document.getElementById("resultsPerPage").value;
            window.location.href = "?page=1&resultsPerPage=" + resultsPerPage;
        }
    </script>
</div>

</body>
</html>

</html>
