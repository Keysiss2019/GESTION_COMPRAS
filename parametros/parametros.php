<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Preguntas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/860e3c70ee.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="../estilos.js"></script>
    <!-- Incluye jQuery desde un CDN (Content Delivery Network) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Incluye la librería DataTables -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        /* Estilo para el contenido principal */
        .content {
            margin-left: 10%;
            transition: margin-left 0.5s;
            padding: 0px;
            width: 80%;
            position: absolute;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
        }

        .action-buttons {
            display: flex;
            gap: 5px; /* Espacio entre los botones */
        }

        .edit-link,
        .delete-link {
            padding: 5px 10px; /* Espaciado interno */
            text-decoration: none; /* Quitar subrayado */
            border: none; /* Quitar borde */
            border-radius: 5px; /* Borde redondeado */
        }

        .edit-link {
            background-color: #28a745; /* Color de fondo verde */
            color: #fff; /* Color del texto */
        }

        .delete-link {
            background-color: #dc3545; /* Color de fondo rojo */
            color: #fff; /* Color del texto */
        }

        .edit-link:hover {
            background-color: #218838; /* Color de fondo al pasar el ratón */
        }

        .delete-link:hover {
            background-color: #c82333; /* Color de fondo al pasar el ratón */
        }

        .delete-link {
            cursor: pointer; /* Cambiar el cursor al pasar por encima */
        }

        /* Estilo para el contenedor de búsqueda y botones */
        .search-bar {
            display: flex;
            align-items: center;
            justify-content: space-between; /* Alinea los elementos al espacio entre ellos */
            margin-top: -25px;
            margin-bottom: -10px;
        }

        .search-bar a.print-button {
            background-color: #3b2ad3; /* Color verde para "Agregar" */
            color: #fff;
            padding: 3px 8px; /* Ajustar el padding para reducir el tamaño del botón */
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px; /* Ajustar el tamaño del texto */
        }

        /* Estilo para el fondo de los encabezados */
        .header-background {
            background-color: #f2f2f2 !important; /* !important para forzar el estilo */
        }

        #parametroTable {
            border-collapse: collapse;
            width: 100%;
        }

        #parametroTable th,
        #parametroTable td {
            border: 1px solid #f2f2f2;
            padding: 8px;
            text-align: left;
            background-color: white; /* Fondo blanco en todas las celdas */
        }

        #parametroTable th {
            background-color: #f2f2f2;
        }

        #parametroTable tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        /* Estilo para la paginación */
        .dataTables_paginate {
            text-align: center;
        }

        .dataTables_paginate .paginate_button {
            display: inline-block;
            padding: 5px 10px;
            margin: 0 2px;
            border: 1px solid #ccc;
            border-radius: 3px;
            cursor: pointer;
        }

        .dataTables_paginate .paginate_button.current {
            background-color: #3b2ad3;
            color: white;
        }
    </style>
</head>
<body>
    <div class="content">
        <?php
        // Incluye el archivo de conexión a la base de datos
        include('../conexion/conexion.php');

        // Consulta SQL para obtener todos los parámetros
        $sql = "SELECT * FROM tbl_ms_parametros";
        $result = $conn->query($sql);
        ?>

        <h1 style="display: flex; align-items: center;">
            <span class="fas fa-question"></span> Parámetros
            <a href="crear.php" class="print-button" style="margin-left: 10px; padding: 5px 10px; border-radius: 5px; background-color: #3b2ad3; color: #fff; font-size: 14px;"><i class="fas fa-plus"></i> </a>
        </h1>
        

        <?php
        if ($result->num_rows > 0) {
            echo '<table id="parametroTable">';
            echo '<thead><tr><th>PARAMETRO</th><th>VALOR</th><th>FECHA_CREACION</th><th>FECHA_MODIFICACION</th><th>ACCIONES</th></tr></thead>';
            echo '<tbody>';

            while ($row = $result->fetch_assoc()) {
                echo '<tr>';
                echo '<td>' . $row['PARAMETRO'] . '</td>';
                echo '<td>' . $row['VALOR'] . '</td>';
                echo '<td>' . date('Y-m-d', strtotime($row['FECHA_CREACION'])) . '</td>';
                echo '<td>' . date('Y-m-d', strtotime($row['FECHA_MODIFICACION'])) . '</td>';
                // Agregar la columna de acciones con los botones de editar y eliminar
                echo '<td>';
                echo '<a href="editar.php?id=' . $row['ID_PARAMETRO'] . '" class="edit-link"><i class="fas fa-edit"></i></a>';
                // Agregar el botón de eliminar con el evento onclick
                echo '<button class="delete-link" onclick="eliminarParametro(' . $row['ID_PARAMETRO'] . ')"><i class="fas fa-trash"></i></button>';
                echo '</td>';
                echo '</tr>';
            }

            echo '</tbody>';
            echo '</table>';
        } else {
            echo 'No hay parámetros registrados.';
        }

        // Cierra la conexión
        $conn->close();
        ?>

<!-- Botón de regreso -->
<div style="position: absolute; bottom: 20px; left: 10px;">
        <a href="../setting/ajustes.php" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Regresar</a>
    </div>
</div>

    </div>

    <script>
        // Función para confirmar la eliminación y llamar a la función eliminarParametroAjax
        function eliminarParametro(idParametro) {
            if (confirm('¿Estás seguro de que deseas eliminar este parámetro?')) {
                eliminarParametroAjax(idParametro);
            }
        }

        // Función para realizar la eliminación mediante Ajax
        function eliminarParametroAjax(idParametro) {
            // Crear una instancia de XMLHttpRequest
            var xhr = new XMLHttpRequest();

            // Configurar la solicitud
            xhr.open("POST", "eliminar.php", true);

            // Configurar la función de retorno de llamada
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    // La solicitud fue exitosa, puedes realizar acciones adicionales si es necesario
                    console.log('El parámetro fue eliminado exitosamente');
                    // Actualizar la página para reflejar los cambios
                    location.reload();
                }
            };

            // Configurar las cabeceras de la solicitud
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

            // Enviar la solicitud con el ID del parámetro a eliminar
            xhr.send("idParametro=" + idParametro);
        }
    </script>

    <script>
        // Inicializar DataTable
        $(document).ready(function() {
            $('#parametroTable').DataTable({
                "language": {
                    "decimal":        "",
                    "emptyTable":     "No hay datos disponibles en la tabla",
                    "info":           "",
                    "infoEmpty":      "",
                    "infoFiltered":   "",
                    "infoPostFix":    "",
                    "thousands":      ",",
                    "lengthMenu":     "Mostrar _MENU_ ",
                    "loadingRecords": "Cargando...",
                    "processing":     "Procesando...",
                    "search":         "Buscar:",
                    "zeroRecords":    "No se encontraron registros",
                    "paginate": {
                        "first":      "Primero",
                        "last":       "Último",
                        "next":       "Siguiente",
                        "previous":   "Anterior"
                    },
                    "aria": {
                        "sortAscending":  ": activar para ordenar la columna en orden ascendente",
                        "sortDescending": ": activar para ordenar la columna en orden descendente"
                    }
                }
            });
        });
    </script>
</body>
</html>
