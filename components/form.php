<!-- form.php -->

<?php
// Verificar si se envió el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar si los datos del formulario están presentes y no están vacíos
    if (isset($_POST["nombre"]) && isset($_POST["descripcion"]) && isset($_POST["estado"]) &&
        !empty($_POST["nombre"]) && !empty($_POST["descripcion"]) && !empty($_POST["estado"])) {

        // Recuperar los datos del formulario
        $nombre = $_POST["nombre"];
        $descripcion = $_POST["descripcion"];
        $estado = $_POST["estado"];

        // Obtener la fecha y hora actuales
        $fecha_inicio = date("Y-m-d H:i:s");

        // Preparar la consulta SQL para insertar en la tabla 'tarea'
        $sql = "INSERT INTO tarea (nombre, descripcion, estado, fecha_inicio) VALUES ('$nombre', '$descripcion', '$estado', '$fecha_inicio')";

        // Ejecutar la consulta
        if ($conn->query($sql) === TRUE) {
            // Redirigir a la página list.php después de la creación exitosa
            header("Location: index.php");
            exit(); // asegurarse de que el script no continúe ejecutándose después de la redirección
        } else {
            echo "Error al crear la tarea: " . $conn->error;
        }
    } else {
        echo "Por favor, complete todos los campos del formulario.";
    }
}
?>

<div class="card mt-5">
    <div class="card-body">
        <h2 class="card-title text-center">Crear Tarea</h2>
        <form action="" method="post">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre:</label>
                <input type="text" id="nombre" name="nombre" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción:</label>
                <textarea id="descripcion" name="descripcion" class="form-control" required></textarea>
            </div>

            <div class="mb-3">
                <label for="estado" class="form-label">Estado:</label>
                <select id="estado" name="estado" class="form-select" required>
                    <option value="pendiente">Pendiente</option>
                    <option value="en_proceso">En Proceso</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Crear Tarea</button>
        </form>
    </div>
</div>