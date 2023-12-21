<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MVC IHCI</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/860e3c70ee.js" crossorigin="anonymous"></script>
    <script src="../Js/estilos.js"></script>

    <style>
        
        .styled-button {
          padding: 5px 8px;
          border: none;
          color: #d7dee1;
          cursor: pointer;
          transition: background-color 0.3s ease;
          border-radius: 3px;
          text-decoration: none;
          float: right; /* Alinea los elementos a la derecha */
        }

        .create-button { background-color:  blue; }
       .delete-button { background-color:  #dc3545; }

       .edit-button { background-color: #15aa2e; }

       .print-button {
    margin-left: 10px;
    text-decoration: none;
    padding: 5px 10px;
    background-color: #007bff;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

/* Agrega la clase float-right al enlace del botón de agregar */
.plus-button {
            float: right;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2><i class="fas fa-question"></i> Preguntas</h2>
        <a href="../preguntas/crear.php" class="print-button plus-button" onclick="toggleFloatingForm()"><i class="fas fa-plus"></i></a>
        <?php
        // Archivo: mostrar_preguntas.php

        // Incluir el archivo de conexión a la base de datos
        include_once('../conexion/conexion.php');

        // Establecer la conexión
        $conn = new mysqli($server, $username, $password, $dbname);

        // Verificar la conexión
        if ($conn->connect_error) {
            die("Error de conexión: " . $conn->connect_error);
        }

        // Consulta SQL para obtener las preguntas
        $sql = "SELECT ID_PREGUNTA, PREGUNTA, DATE_FORMAT(FECHA_CREACION, '%Y-%m-%d') AS FECHA_CREACION, DATE_FORMAT(FECHA_MODIFICACION, '%Y-%m-%d') AS FECHA_MODIFICACION FROM tbl_preguntas";

        // Ejecutar la consulta
        $resultado = $conn->query($sql);

        // Verificar si hay resultados
        if ($resultado->num_rows > 0) {
            // Crear una tabla HTML con estilos
            echo "<style>
                    table {
                        border-collapse: collapse;
                        width: 100%;
                    }
                    th, td {
                        border: 1px solid #dddddd;
                        text-align: left;
                        padding: 8px;
                    }
                    th {
                        background-color: #f2f2f2;
                    }
                  </style>";

            echo "<table>";
            echo "<tr><th>ID</th><th>Pregunta</th><th>Fecha de Creación</th><th>Fecha de Modificación</th><th>Acciones</th></tr>";

            // Mostrar los datos de cada pregunta en la tabla
            while ($fila = $resultado->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $fila['ID_PREGUNTA'] . "</td>";
                echo "<td>" . $fila['PREGUNTA'] . "</td>";
                echo "<td>" . $fila['FECHA_CREACION'] . "</td>"; 
                echo "<td>" . $fila['FECHA_MODIFICACION'] . "</td>";
                echo "<td>
                  <a href='../preguntas/editar.php?id=" . $fila['ID_PREGUNTA'] . "' class='styled-button edit-button me-2'><i class='fas fa-edit'></i></a>
                 <form method='post' action='eliminar.php' onsubmit='return confirm(\"¿Estás seguro de que deseas eliminar esta pregunta?\");'>
                 <input type='hidden' name='ID_PREGUNTA' value='" . $fila['ID_PREGUNTA'] . "'>
                 <button type='submit' name='eliminar' class='styled-button delete-button'><i class='fas fa-trash'></i></button>
                 </form>
                </td>";

                echo "</tr>";
            }

            echo "</table>";
        } else {
            echo "No hay preguntas en la base de datos.";
        }

        // Cerrar la conexión
        $conn->close();
        ?>
        <button class="styled-button" onclick="window.location.href='../setting/ajustes.php'" style="background-color: #007bff; color: #fff; padding: 5px 10px; border: none; border-radius: 5px; cursor: pointer;">Regresar</button>
    </div>
</body>

</html>

