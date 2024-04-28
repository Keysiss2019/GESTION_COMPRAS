<?php
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idObjeto = $_POST['id_objeto'];
    $nombreObjeto = $_POST['nombre_objeto'];
    $descripcion = $_POST['descripcion'];

    // Actualizar datos en la base de datos
    $stmt = $conn->prepare("UPDATE tbl_objetos SET NOMBRE_OBJETO = :nombreObjeto, DESCRIPCION = :descripcion WHERE ID_OBJETO = :idObjeto");
    $stmt->bindParam(':nombreObjeto', $nombreObjeto);
    $stmt->bindParam(':descripcion', $descripcion);
    $stmt->bindParam(':idObjeto', $idObjeto);

    if ($stmt->execute()) {
        header('Location: listar_objetos.php'); // Redirige a la lista de objetos después de la actualización
        exit;
    } else {
        echo 'Error al actualizar el objeto.';
    }
}

// Obtener el ID del objeto de la URL
if (isset($_GET['id'])) {
    $idObjeto = $_GET['id'];

    // Consulta SQL para obtener los datos del objeto por su ID
    $stmt = $conn->prepare("SELECT * FROM tbl_objetos WHERE ID_OBJETO = :idObjeto");
    $stmt->bindParam(':idObjeto', $idObjeto);
    $stmt->execute();
    $objeto = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>

<!-- Formulario HTML para editar un objeto -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    
    <style>
        body {
            font-family: Arial, sans-serif;
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            margin: 0;
            padding: 0;
        }

        form {
            max-width: 550px;
            margin: 50px auto;
            padding: 20px;
            background-color: #ddd;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-bottom: 10px; 
        }

        h1 {
            text-align: center;
            color: #007BFF; 
            font-weight: bold; 
        }

        label {
            display: block;
            margin-top: 10px;
        }

        textarea {
            width: 100%;
            height: 150px;
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 5px;
            font-size: 14px;
        }

        input {
            width: 95%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ddd;
            border-radius: 3px;
        }

        .button-container {
            text-align: center;
        }

        .custom-button {
            display: inline-block;
            padding: 10px 20px; 
            margin: 10px auto; 
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
            font-size: 16px; 
            font-family: Arial, sans-serif; 
            background-color: #007BFF; 
            color: white; 
        }

        .custom-button.cancel-button {
            background-color: gray; 
            color: #fff; 
        }
    </style>

    <title>EDITAR OBJETO</title>
</head>
<body>
   <div class="container">
   <br><br>
    <form action="editar_objeto.php" method="POST">
    <h1>EDITAR OBJETO</h1>
        <input type="hidden" name="id_objeto" value="<?php echo $objeto['ID_OBJETO']; ?>">
        <label for="nombre_objeto">Nombre del Objeto:</label>
        <input type="text" name="nombre_objeto" value="<?php echo $objeto['NOMBRE_OBJETO']; ?>" required>
        <br>
        <label for="descripcion">Descripción:</label>
        <textarea name="descripcion"><?php echo $objeto['DESCRIPCION']; ?></textarea>
        <br>
        <div class="button-container">
            <button type="submit" class="custom-button">Guardar</button>
            <a href="listar_objetos.php" class="custom-button cancel-button">Cancelar</a>
        </div>
    </form>
   </div>
</body>
</html>
