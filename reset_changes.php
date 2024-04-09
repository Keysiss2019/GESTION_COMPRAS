function resetChanges(auditoriaId) {
    if (confirm('¿Estás seguro de restablecer los cambios para esta entrada de la bitácora?')) {
        // Realiza una solicitud AJAX al servidor para restablecer los cambios
        // Puedes enviar el ID de auditoría como parámetro en la solicitud
        // Después de recibir la confirmación del servidor, actualiza la tabla según sea necesario
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "reset_changes.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                // Aquí puedes manejar la respuesta del servidor, por ejemplo, actualizar la tabla si es necesario
                location.reload(); // Recargar la página después de restablecer los cambios
            }
        };
        xhr.send("auditoria_id=" + auditoriaId);
    }
}
