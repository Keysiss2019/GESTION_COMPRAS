<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado del Envío</title>
    <style>
        /* Estilos generales */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        /* Estilos del modal */
        .modal {
            display: flex;
            justify-content: center;
            align-items: center;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.4);
        }

        .modal-content {
            background-color: #fefefe;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
            padding: 20px;
            max-width: 400px;
            width: 100%;
            text-align: center;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
        }

        p {
            margin-bottom: 20px;
        }

        button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <p><?php echo isset($mensaje) ? $mensaje : ""; ?></p>
            <button onclick="redirect()">Ir al Login</button>
        </div>
    </div>

    <script>
        // Mostrar el modal al cargar la página
        window.onload = function() {
            var modal = document.getElementById("myModal");
            modal.style.display = "flex"; // Cambiado a flex para centrar verticalmente en dispositivos pequeños
        }

        // Cerrar el modal cuando se hace clic en la "X" y redirigir al index.php
        function closeModal() {
            window.location.href = "../index.php";
        }

        // Redirigir al login
        function redirect() {
            window.location.href = "../index.php"; // Reemplaza "../index.php" con la URL correcta de tu página de login
        }
    </script>
</body>
</html>

