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

        #preguntasTable {
            border-collapse: collapse;
            width: 100%;
        }

        #preguntasTable th,
        #preguntasTable td {
            border: 1px solid #f2f2f2;
            padding: 8px;
            text-align: left;
            background-color: white; /* Fondo blanco en todas las celdas */
        }

        #preguntasTable th {
            background-color: #f2f2f2;
        }

        #preguntasTable tr:nth-child(even) {
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
        include '../categorias/db_connect.php';

        // Procesar la búsqueda
        if (isset($_GET['busqueda'])) {
            $busqueda = $_GET['busqueda'];
            $stmt = $conn->prepare("SELECT * FROM tbl_preguntas WHERE ID_PREGUNTA = :busqueda OR PREGUNTA LIKE :busqueda
            ");
            $stmt->bindValue(':busqueda', $busqueda);
            $stmt->execute();
            $preguntas = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            // Si no se ha realizado una búsqueda, muestra todas las preguntas
            $stmt = $conn->query("SELECT * FROM tbl_preguntas");
            $preguntas = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        ?>

<h1 style="display: flex; align-items: center;">
    <span class="fas fa-question"></span> Preguntas
    <a href="crear.php" class="print-button" style="margin-left: 10px; padding: 5px 10px; border-radius: 5px; background-color: #3b2ad3; color: #fff; font-size: 14px;"><i class="fas fa-plus"></i> </a>
</h1>

        <!-- Tu tabla HTML -->
        <table id="preguntasTable" class="display">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Pregunta</th>
                    <th>
                        Fecha de Creación
                        <span class="filter-icon" id="filterIcon"><i class="fas fa-filter"></i></span>
                        <div id="filterContainer" style="display: none;">
                            <input type="text" id="filterFecha" placeholder="YYYY-MM" />
                        </div>
                    </th>
                    <th>Fecha de Modificación</th>
                    <th>Creado</th>
                    <th>Modificado</th>
                    <th>Acciones</th>
                </
                </tr>
            </thead>
            <tbody>
                <?php foreach ($preguntas as $pregunta) { ?>
                    <tr>
                        <td><?php echo $pregunta['ID_PREGUNTA']; ?></td>
                        <td><?php echo strtoupper($pregunta['PREGUNTA']); ?></td>
                        <td class="fecha-creacion" data-fecha="<?php echo date("Y-m-d", strtotime($pregunta['FECHA_CREACION'])); ?>">
                            <?php echo date("Y-m-d", strtotime($pregunta['FECHA_CREACION'])); ?>
                        </td>
                        <td><?php echo date("Y-m-d", strtotime($pregunta['FECHA_MODIFICACION'])); ?></td>
                        <td><?php echo strtoupper($pregunta['CREADO_POR']); ?></td>
                        <td><?php echo $pregunta['MODIFICADO_POR']; ?></td>
                        <td>
                            <div class="action-buttons">
                                <a href="editar.php?id=<?php echo $pregunta['ID_PREGUNTA']; ?>" class="edit-link"><i class="fas fa-edit"></i> </a>
                                <!-- Formulario de confirmación para eliminar -->
                                <form action="eliminar.php" method="post" style="display: inline;">
                                    <input type="hidden" name="ID_PREGUNTA" value="<?php echo $pregunta['ID_PREGUNTA']; ?>">
                                    <button type="submit" name="eliminar" class="delete-link"><i class="fas fa-trash-alt"></i> </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        
   <!-- Botón de regreso -->
   <div style="position: absolute; bottom: 20px; left: 10px;">
        <a href="../pantallas/admin.php" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Regresar</a>
    </div>
</div>


       <!-- Script para inicializar DataTables y agregar la funcionalidad de filtrado -->
<script>
    $(document).ready(function () {
        var table = $('#preguntasTable').DataTable({
            "dom": 'lBfrtip',
            "buttons": ['copy', 'excel', 'pdf', 'print'],
            "ordering": false, // Deshabilitar la ordenación inicial
            "language": {
                "search": "Buscar", // Cambiar el texto del cuadro de búsqueda
                "paginate": {
                    "first": "",
                    "last": "",
                    "next": "Siguiente",
                    "previous": "Anterior"
                },
                "info": "", // Eliminar el texto "Showing 1 to 4 of 4 entries"
                // Cambiar el texto del resumen de entradas mostradas
                "lengthMenu": "Mostrar _MENU_ ", // Cambiar el texto del menú desplegable de cantidad de entradas
            },
            "columnDefs": [
                {
                    "targets": 'thead th', // Aplicar a todas las celdas del encabezado
                    "className": 'header-background' // Clase de estilo para el fondo
                }
            ],
            "pagingType": "full_numbers", // Tipo de paginación
            "pageLength": 5 // Cantidad de registros por página
        });

        // Mostrar/ocultar el campo de filtro al hacer clic en el icono
        $('#filterIcon').on('click', function () {
            $('#filterContainer').toggle();
        });

        // Aplicar el filtro al cambiar el valor del campo de entrada
        $('#filterFecha').on('keyup', function () {
            var filterValue = $(this).val();
            table.column(3).search(filterValue).draw();
        });
    });
</script>
