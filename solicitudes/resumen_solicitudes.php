<?php
// Incluir archivo de conexión a la base de datos
include("../conexion/conexion.php");

// Variables para la paginación
$resultsPerPage = isset($_GET['resultsPerPage']) ? $_GET['resultsPerPage'] : 10;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($page - 1) * $resultsPerPage;

// Consulta para obtener el resumen estadístico con paginación
$sql = "SELECT 
            COUNT(*) AS total_solicitudes,
            s.estado,
            d.nombre_departamento,
            u.nombre_usuario AS solicitante,
            s.fecha_ingreso AS fecha_solicitud
        FROM 
            tbl_solicitudes s
            INNER JOIN tbl_departamentos d ON s.idDepartamento = d.id_departamento
            INNER JOIN tbl_ms_usuario u ON s.usuario_id = u.id_usuario
        GROUP BY 
            s.estado,
            d.nombre_departamento,
            u.nombre_usuario,
            s.fecha_ingreso
        LIMIT $offset, $resultsPerPage";

// Ejecutar consulta
$resultado = $conn->query($sql);

// Contar el total de filas
$totalRows = $conn->query("SELECT COUNT(*) AS count FROM tbl_solicitudes")->fetch_assoc()['count'];
$totalPages = ceil($totalRows / $resultsPerPage);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resumen Estadístico de Solicitudes</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            padding-top: 20px;
        }
        .container {
            margin-bottom: 50px;
        }
        table {
            width: 100%;
            margin-top: 20px;
            font-size: 14px;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .mb-4 {
            margin-bottom: 1.5rem!important;
        }
        .mb-3 {
            margin-bottom: 1rem!important;
        }
        .me-2 {
            margin-right: .5rem!important;
        }
        .select-container {
            display: inline-flex;
            margin-bottom: 1rem;
            margin-right: .5rem;
        }
        .pagination {
            margin-top: 1rem;
            justify-content: flex-end;
        }
        .pagination li {
            display: inline-block;
            margin-right: .3rem;
        }
    </style>
</head>
<body>

<div class="container">
    <h2 class="mb-4">Resumen de Solicitudes</h2>

    <?php if ($resultado->num_rows > 0): ?>
        <div class="mb-3">
            <a href="#" onclick="history.back();" class="btn btn-secondary me-2">Regresar</a>

            <!-- Select para el número de registros por página -->
            <div class="select-container">
                <label for="resultsPerPage" class="me-2">Registros:</label>
                <select class="form-select" id="resultsPerPage" name="resultsPerPage" onchange="changeResultsPerPage()">
                    <option value="5" <?php if($resultsPerPage == 5) echo "selected"; ?>>5</option>
                    <option value="10" <?php if($resultsPerPage == 10) echo "selected"; ?>>10</option>
                    <option value="20" <?php if($resultsPerPage == 20) echo "selected"; ?>>20</option>
                    <option value="50" <?php if($resultsPerPage == 50) echo "selected"; ?>>50</option>
                </select>
            </div>

            <!-- Paginación -->
            <nav aria-label="Page navigation">
                <ul class="pagination">
                    <li class="page-item <?php echo $page <= 1 ? 'disabled' : ''; ?>">
                        <a class="page-link" href="?page=<?php echo ($page - 1); ?>&resultsPerPage=<?php echo $resultsPerPage; ?>" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <li class="page-item <?php echo $i == $page ? 'active' : ''; ?>">
                            <a class="page-link" href="?page=<?php echo $i; ?>&resultsPerPage=<?php echo $resultsPerPage; ?>"><?php echo $i; ?></a>
                        </li>
                    <?php endfor; ?>
                    <li class="page-item <?php echo $page >= $totalPages ? 'disabled' : ''; ?>">
                        <a class="page-link" href="?page=<?php echo ($page + 1); ?>&resultsPerPage=<?php echo $resultsPerPage; ?>" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>

        <div class="input-group mb-3">
            <input type="text" id="searchInput" class="form-control" onkeyup="filterTable()" placeholder="Buscar...">
        </div>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Total de Solicitudes</th>
                    <th>Estado</th>
                    <th>Departamento</th>
                    <th>Solicitante</th>
                    <th>Fecha de Solicitud</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($fila = $resultado->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $fila["total_solicitudes"]; ?></td>
                        <td><?php echo $fila["estado"]; ?></td>
                        <td><?php echo $fila["nombre_departamento"]; ?></td>
                        <td><?php echo $fila["solicitante"]; ?></td>
                        <td><?php echo $fila["fecha_solicitud"]; ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p class="text-danger">No se encontraron resultados.</p>
    <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
<script>
    // Función para cambiar el número de registros por página
    function changeResultsPerPage() {
        var resultsPerPage = document.getElementById("resultsPerPage").value;
        window.location.href = "?page=1&resultsPerPage=" + resultsPerPage;
    }

    // Función para filtrar la tabla
    function filterTable() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("searchInput");
        filter = input.value.toUpperCase();
        table = document.getElementsByTagName("table")[0];
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
</script>
</body>
</html>

