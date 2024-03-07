<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bitácora de Usuarios</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
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
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .pagination-container {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Bitácora</h2>

    <?php
    // Incluir el archivo de conexión a la base de datos
    require_once('../conexion/conexion.php');

    // Número de registros por página
    $resultsPerPage = 10;

    // Calcular la página actual y el índice de inicio
    $page = isset($_GET['page']) ? $_GET['page'] : 1;
    $startIndex = ($page - 1) * $resultsPerPage;

    // Consulta SQL para obtener registros de la bitácora
    $sqlBitacora = "SELECT * FROM auditoria_tbl_ms_usuario ORDER BY fecha_operacion ASC LIMIT $startIndex, $resultsPerPage";
    $resultBitacora = $conn->query($sqlBitacora);

    // Consulta SQL para obtener el total de registros en la bitácora
    $sqlTotalRecords = "SELECT COUNT(*) as total FROM auditoria_tbl_ms_usuario";
    $resultTotalRecords = $conn->query($sqlTotalRecords);
    $rowTotalRecords = $resultTotalRecords->fetch_assoc();
    $totalRecords = $rowTotalRecords['total'];

    // Calcular el total de páginas
    $totalPages = ceil($totalRecords / $resultsPerPage);
    ?>

    <!-- Mostrar el número de registros -->
    <div>Total de Registros: <?php echo $totalRecords; ?></div>

    <?php if ($resultBitacora->num_rows > 0): ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID de Auditoría</th>
                    <th>Tipo de Operación</th>
                    <th>Fecha de Operación</th>
                    <th>ID de Usuario Afectado</th>
                    <th>Detalle del Cambio</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $resultBitacora->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id_auditoria']; ?></td>
                        <td><?php echo $row['tipo_operacion']; ?></td>
                        <td><?php echo $row['fecha_operacion']; ?></td>
                        <td><?php echo $row['id_usuario_afectado']; ?></td>
                        <td><?php echo $row['detalle_cambio']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <!-- Paginación -->
        <div class="pagination-container">
            <?php if ($page > 1): ?>
                <a href="?page=<?php echo ($page - 1); ?>">&lt; Anterior</a>
            <?php endif; ?>

            <?php if ($page < $totalPages): ?>
                <a href="?page=<?php echo ($page + 1); ?>">Siguiente &gt;</a>
            <?php endif; ?>
        </div>
    <?php else: ?>
        <p>No hay registros en la bitácora.</p>
    <?php endif; ?>

    <?php
    // Cerrar la conexión a la base de datos
    $conn->close();
    ?>

</div>

</body>
</html>