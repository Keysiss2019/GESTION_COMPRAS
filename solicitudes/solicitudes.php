<?php
session_start();

include("../conexion/conexion.php");

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION["usuarioId"])) {
    // El usuario no ha iniciado sesión, redirige a la página de inicio de sesión
    header("Location: index.php");
    exit();
}

$usuariosId = $_SESSION["usuarioId"];

// Obtén el rol del usuario desde la base de datos
$sql = "SELECT rol FROM tbl_ms_usuario WHERE id_usuario = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $usuariosId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $usuariosRol = $row["rol"];
} else {
    // Manejar el caso en que no se encuentra el rol del usuario
    $usuariosRol = null; // Puedes establecer un valor por defecto o manejarlo según tu lógica
}

// Funciones para verificar los permisos
function tienePermisos($usuariosRol, $conn, $permisosId, $objetosId) {
    // Consulta la tabla tbl_roles_permisos para verificar si el rol tiene el permiso
    // para el objeto específico
    $sql = "SELECT rp.id_permiso FROM tbl_roles_permisos rp
            JOIN tbl_objetos o ON rp.id_objeto = o.ID_OBJETO
            WHERE rp.id_rol = ? AND rp.id_permiso = ? AND o.ID_OBJETO = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iii", $usuariosRol, $permisosId, $objetosId);
    $stmt->execute();
    $result = $stmt->get_result();

    return $result->num_rows > 0;
}






$permisosVerId = 1; // Cambia esto al ID del permiso de "Ver" en tu sistema
$objetosIdVer = 3;

$permisosCrearId = 2; // Cambia esto al ID del permiso de "Crear" en tu sistema

$permisosEditarId = 3; // Cambia esto al ID del permiso de "Editar" en tu sistema
//$objetosIdEditar = 3;

$permisosEliminarId = 4; // Cambia esto al ID del permiso de "Eliminar" en tu sistema
//$objetosIdEliminar = 3;



if (isset($_SESSION["usuarioId"])) {
    $usuarioId = $_SESSION["usuarioId"];
    $rolUsuario = $_SESSION["rol"];
} else {
    header("Location: login.php");
    exit();
}

// Consulta para obtener el nombre del rol del usuario desde la base de datos
$sqlRolUsuario = "SELECT r.NOMBRE_ROL
                  FROM tbl_ms_usuario u
                  JOIN tbl_ms_roles r ON u.rol = r.ID_ROL
                  WHERE u.id_usuario = ?";
$stmtRolUsuario = $conn->prepare($sqlRolUsuario);
$stmtRolUsuario->bind_param("i", $usuarioId);
$stmtRolUsuario->execute();
$resultRolUsuario = $stmtRolUsuario->get_result();

if ($resultRolUsuario->num_rows > 0) {
    $rowRolUsuario = $resultRolUsuario->fetch_assoc();
    $rolUsuario = $rowRolUsuario["NOMBRE_ROL"];
} else {
    // Manejar el caso en que no se encuentra el nombre del rol del usuario
    $rolUsuario = null; // Puedes establecer un valor por defecto o manejarlo según tu lógica
}

if ($rolUsuario === "Administrador" || $rolUsuario === "Aprobador") {
    $sql = "SELECT s.id, s.codigo, d.nombre_departamento, u.nombre_usuario, s.estado, s.fecha_ingreso 
            FROM tbl_solicitudes s
            JOIN tbl_departamentos d ON s.idDepartamento = d.id_departamento
            JOIN tbl_ms_usuario u ON s.usuario_id = u.id_usuario";
} else {
    $sql = "SELECT s.id, s.codigo, d.nombre_departamento, u.nombre_usuario, s.estado, s.fecha_ingreso 
            FROM tbl_solicitudes s
            JOIN tbl_departamentos d ON s.idDepartamento = d.id_departamento
            JOIN tbl_ms_usuario u ON s.usuario_id = u.id_usuario
            WHERE s.usuario_id = ?";
}

if (isset($_GET["buscar"])) {
    // Obtener el valor de búsqueda desde el campo de búsqueda general
    $busquedaGeneral = $_GET["busqueda_general"];

    // Validar que el valor de búsqueda no esté vacío
    if (!empty($busquedaGeneral)) {
        // Consulta SQL para buscar en varios campos
        $sql = "SELECT s.id, s.codigo, d.nombre_departamento, u.nombre_usuario, s.estado 
                FROM tbl_solicitudes s
                JOIN tbl_departamentos d ON s.idDepartamento = d.id_departamento
                JOIN tbl_ms_usuario u ON s.usuario_id = u.id_usuario
                WHERE s.codigo LIKE ? 
                OR u.nombre_usuario LIKE ?
                OR d.nombre_departamento LIKE ?";
        
        // Preparar la consulta con el valor de búsqueda
        $stmt = $conn->prepare($sql);
        $busquedaGeneral = "%" . $busquedaGeneral . "%";
        $stmt->bind_param("sss", $busquedaGeneral, $busquedaGeneral, $busquedaGeneral);
    } else {
        // Si el campo de búsqueda general está vacío, mostrar mensaje de error o realizar otra acción
        echo "El campo de búsqueda no puede estar vacío.";
        exit();
    }
} else {
    // Consulta original sin filtro
    $stmt = $conn->prepare($sql);
    if ($rolUsuario !== "Administrador" && $rolUsuario !== "Aprobador") {
        $stmt->bind_param("i", $usuarioId); // Filtro por ID de usuario para usuarios normales
    }
}

// Ejecutar la consulta
$stmt->execute();
$result = $stmt->get_result();

// Calcular el número total de páginas
$totalSolicitudes = $result->num_rows;
$resultadosPorPagina = 10;
$totalPaginas = ceil($totalSolicitudes / $resultadosPorPagina);

// Obtener la página actual desde la URL (si no se proporciona, asumir la página 1)
$paginaActual = isset($_GET['page']) ? $_GET['page'] : 1;





?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MVC IHCI</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/860e3c70ee.js" crossorigin="anonymous"></script>
    <script src="../estilos.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.min.js"></script>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
    <style>
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
        .menu li {
            margin-bottom: -1px;
        }

        .menu li a {
            padding: 0px 0px;
        }
    </style>
    
    <title>Solicitudes</title>
    
    <style>
   .plus-button {
    float: left; /* Mueve el botón hacia la derecha */
    position: relative; /* Establece la posición relativa */
    top: 45px; /* Ajusta el valor según sea necesario para mover el botón hacia abajo */
    left: 680px;
    text-decoration: none;
    padding: 8px 8px;
    border-radius: 4px;
    color: #fff;
    z-index: 1; /* Asegura que el botón esté por encima de la tabla */
    background-color: blue; /* Ajusta según sea necesario */
}

form {
    margin-top: 20px; /* Ajusta el valor según sea necesario */
}

.solicitud-table {
    border-collapse: collapse;
    width: 100%;
    border: 1px solid #ddd !important;
}

.solicitud-table th,
.solicitud-table td {
    border: 1px solid #ddd !important;
    border-bottom: none !important;
    padding: 8px;
    text-align: left;
}



        /* Estilos para el botón de inicio */
        .boton-inicio {
            background-color: #007bff; /* Color de fondo azul */
            border: none;
            color: white; /* Color del texto en blanco */
            padding: 10px 20px; /* Espaciado interno */
            border-radius: 5px; /* Borde redondeado */
            cursor: pointer;
        }

        .boton-inicio:hover {
            background-color: #0056b3; /* Color de fondo azul más oscuro al pasar el mouse */
        }

        .button-container {
          display: flex;  /* Mostrar en línea horizontal */
          align-items: center; /* Centrar verticalmente los botones si tienen diferentes alturas */
          gap: 10px; /* Espacio entre los botones */
        }


        /* Estilos para alinear a la derecha */
        .pagination-container {
            text-align: right; /* Alinea el contenido a la derecha */
        }

        /* Estilos para la lista de páginas */
        .pagination-container ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        .pagination-container ul li {
            display: inline-block;
            margin-right: 10px; /* Espacio entre las páginas */
        }

        /* Estilos para el enlace de página activa */
        .pagination-container ul li.active {
            font-weight: bold; /* Opcional: resaltar la página activa */
        }

        /* Estilo para enlaces "Ver" (verde) */
        .green-link {
          background-color: green; /* Color de fondo azul */
            border: none;
            color: white; /* Color del texto en blanco */
            padding: 10px 10px; /* Espaciado interno */
            border-radius: 5px; /* Borde redondeado */
            cursor: pointer;
         text-decoration: none; /* Quita el subrayado del enlace, si es necesario */
        }

/* Estilo para enlaces "Editar" (amarillo) */
.yellow-link {
    background-color: yellowgreen; /* Color de fondo azul */
            border: none;
            color: white; /* Color del texto en blanco */
            padding: 10px 10px; /* Espaciado interno */
            border-radius: 5px; /* Borde redondeado */
            cursor: pointer;
    text-decoration: none; /* Quita el subrayado del enlace, si es necesario */
}

/* Estilo para enlaces "Eliminar" (naranja) */
.orange-link {
    background-color: orange; /* Color de fondo azul */
            border: none;
            color: white; /* Color del texto en blanco */
            padding: 10px 10px; /* Espaciado interno */
            border-radius: 5px; /* Borde redondeado */
            cursor: pointer;
    text-decoration: none; /* Quita el subrayado del enlace, si es necesario */
}





    </style>
</head>
<body>
<div class="content">
<h2><i class="fas fa-book"></i>solicitudes</h2>
   
    <?php
// Obtén el ID del objeto específico asociado a la creación de solicitudes desde la base de datos
// Reemplaza 'tbl_objetos' y 'nombre_objeto_crear_solicitud' con los nombres reales de tu tabla y campo respectivamente
$sqlObjetoCrearSolicitud = "SELECT ID_OBJETO FROM tbl_objetos WHERE NOMBRE_OBJETO = 'Solicitudes'";

$stmtObjetoCrearSolicitud = $conn->prepare($sqlObjetoCrearSolicitud);
$stmtObjetoCrearSolicitud->execute();
$resultObjetoCrearSolicitud = $stmtObjetoCrearSolicitud->get_result();

if ($resultObjetoCrearSolicitud->num_rows > 0) {
    $rowObjetoCrearSolicitud = $resultObjetoCrearSolicitud->fetch_assoc();
    $objetosIdCrearSolicitud = $rowObjetoCrearSolicitud["ID_OBJETO"];

    // Ahora puedes utilizar tienePermisos con el ID del objeto obtenido
    if (isset($usuariosRol) && tienePermisos($usuariosRol, $conn, $permisosCrearId, $objetosIdCrearSolicitud)) {
        // El usuario tiene permiso para "Crear" el objeto específico
        echo "<a href='../solicitudes/crear_solicitudes.php' class='plus-button' onclick='toggleFloatingForm()'><i class='fas fa-plus'></i></a>";

    }
} else {
    // Manejar el caso en que no se encuentra el ID del objeto
    echo "No se pudo obtener el ID del objeto para la creación de solicitudes.";
}



?>

    
    

 
</form>
    
    <br>
    <?php if ($result->num_rows > 0) : ?>
    <table id="solicitudesTable" class="solicitud-table">
        <thead>
            <tr>
                <th>Código</th>
                <th>Departamento</th>
                <th>Usuario</th>
                <th>Fecha
                    <span class="filter-icon" id="filterIcon"><i class="fas fa-filter"></i></span>
                    <div id="filterContainer" style="display: none;">
                        <input type="text" id="filterFecha" placeholder="YYYY-MM" />
                    </div>
                </th>
                <th>Estado</th>
                <th>Acciones</th>
                <!-- Agrega más columnas si es necesario -->
            </tr>
        </thead>

        <tbody>
            <?php while ($row = $result->fetch_assoc()) : ?>
                <tr>
                    <td><?php echo $row["codigo"]; ?></td>
                    <td><?php echo $row["nombre_departamento"]; ?></td>
                    <td><?php echo $row["nombre_usuario"]; ?></td>
                    <td class="fecha-ingreso" data-fecha="<?php echo date("Y-m-d", strtotime($row['fecha_ingreso'])); ?>">
                        <?php echo date("Y-m-d", strtotime($row['fecha_ingreso'])); ?>
                    </td>
                    <td><?php echo $row["estado"]; ?></td>
                    <td>
                        <div class="button-container">

                            <?php
                            echo "<a href='../cotizaciones/view_solicitud.php?id=" . $row["id"] . "' class='green-link'><i class='fas fa-eye'></i></a>";

                            // Convertir el estado a minúsculas para comparación insensible a mayúsculas/minúsculas
                            $estado = strtolower($row["estado"]);

                            // Verificar el estado de la solicitud para habilitar/deshabilitar botones
                            if (strcasecmp($estado, "nueva") === 0) {
                                // Habilitar el botón de agregar cotización
                                echo "<a href='../cotizaciones/add_cotizacion.php?id=" . $row["id"] . "' class='yellow-link'><i class='fas fa-shopping-cart'></i></a>";
                                // Deshabilitar el botón de detalle de solicitud
                                echo "<a href='#' class='orange-link disabled'><i class='fas fa-file-alt'></i></a>";
                            } elseif (strcasecmp($estado, "proceso") === 0) {
                                // Deshabilitar el botón de agregar cotización
                                echo "<a href='#' class='yellow-link disabled'><i class='fas fa-shopping-cart'></i></a>";
                                // Habilitar el botón de detalle de solicitud
                                echo "<a href='../cotizaciones/detalle_solicitud.php?id=" . $row["id"] . "' class='orange-link'><i class='fas fa-file-alt'></i></a>";
                            } else {
                                // Otros estados, deshabilitar ambos botones
                                echo "<a href='#' class='yellow-link disabled'><i class='fas fa-shopping-cart'></i></a>";
                                echo "<a href='#' class='orange-link disabled'><i class='fas fa-file-alt'></i></a>";
                            }

                            // Botón de editar
                            echo '<button class="btn btn-primary" onclick="editarSolicitud(' . $row["id"] . ')"><i class="fas fa-edit"></i></button>';
                            // Botón de eliminar
                            echo '<button class="btn btn-danger" onclick="eliminarSolicitud(' . $row["id"] . ')"><i class="fas fa-trash"></i></button>';
                            ?>

                        </div>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <!-- Numeración de páginas -->
    <div class="pagination-container">
        <ul>
            <?php for ($i = 1; $i <= $totalPaginas; $i++) : ?>
                <li <?php if ($i === $paginaActual) echo 'class="active"'; ?>>
                    <a href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                </li>
            <?php endfor; ?>
        </ul>
    </div>

<?php else : ?>
    <p>No se encontraron solicitudes.</p>
<?php endif; ?>








    <!-- Agrega más contenido de la página aquí -->

    <button class="boton-inicio" onclick="salirDeLaVista();"> Regresar</button>
    </div>
    <script>
        function salirDeLaVista() {
            window.top.location.href = '../pantallas/admin.php'; // Redirige la página principal, no la vista dentro del iframe
        }
    </script>

    <script>
        function editarSolicitud(id) {
            // Redirige a la página editar_solicitud.php con el ID de la solicitud como parámetro
            window.location.href = `../solicitudes/editar_solicitud.php?id=${id}`;
        }

        function eliminarSolicitud(id) {
            var confirmarEliminar = confirm("¿Estás seguro de que deseas eliminar la solicitud con ID " + id + "?");

            if (confirmarEliminar) {
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "../solicitudes/eliminar.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

                xhr.onreadystatechange = function () {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        var respuesta = xhr.responseText;
                        if (respuesta === "Solicitud eliminada exitosamente") {
                            location.reload();
                        } else {
                            alert(respuesta);
                        }
                    } else if (xhr.readyState === 4 && xhr.status !== 200) {
                        alert("Error al eliminar la solicitud");
                    }
                };

                xhr.send("id=" + id);
            }
        }
    </script>

<script>
       $(document).ready(function () {
           var table = $('#solicitudesTable').DataTable({
              "dom": 'lBfrtip',
              "buttons": ['copy', 'excel', 'pdf', 'print'],
              "ordering": false,
               "paging": false,
              "info": false,
              "language": {
                  "search": "Buscar",
                  "zeroRecords": "No se encontraron registros",
                  "infoEmpty": "Mostrando 0 de 0 registros",
                  "infoFiltered": "(filtrado de un total de _MAX_ registros)",
                  "emptyTable": "No hay datos disponibles en la tabla",
                  "infoPostFix": "",
                  "thousands": ",",
                  "lengthMenu": "Mostrar _MENU_ registros por página",
                  "loadingRecords": "Cargando...",
                  "processing": "Procesando...",
                  "sEmptyTable": "No hay datos disponibles en la tabla",
                  "sInfo": "Mostrando _START_ a _END_ de _TOTAL_ registros",
                  "sInfoEmpty": "Mostrando 0 a 0 de 0 registros",
                   "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                  "sInfoPostFix": "",
                  "sInfoThousands": ",",
                  "sLengthMenu": "Mostrar _MENU_ registros",
                  "sLoadingRecords": "Cargando...",
                  "sProcessing": "Procesando...",
                  "sSearch": "Buscar:",
                  "sZeroRecords": "No se encontraron registros",
                  "paginate": {
                      "first": "Primero",
                      "last": "Último",
                      "next": "Siguiente",
                       "previous": "Anterior"
                    }
                },
               "columnDefs": [
                   {
                      "targets": 'thead th',
                      "className": 'header-background'
                    }
                ]
            });

           $('#filterIcon').on('click', function () {
              $('#filterContainer').toggle();
            });

            $('#filterFecha').on('keyup', function () {
               var filterValue = $(this).val();
               table.column(3).search(filterValue).draw();
            });
       
        });
    </script>

    <script>
        $(document).ready(function() {
            setTimeout(function() {
                $('div.dataTables_filter').css({
                    'text-align': 'left',
                    'margin-top': '10px',
                    'margin-right': '1px'
                });

                $('.search-bar .print-button').css({
                    'position': 'absolute',
                    'right': '1px',
                    'top': '65px'
                });
            }, 100);
        });
    </script>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>