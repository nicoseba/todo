<?php
include './../conexion.php';

$id_tarea = null;
$nombre_tarea = $descripcion_tarea = $estado_tarea = '';

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id_tarea'])) {
    $id_tarea = $_GET['id_tarea'];

    $sql_info_tarea = "SELECT * FROM tarea WHERE id_tarea = $id_tarea";
    $result_info_tarea = $conn->query($sql_info_tarea);

    if ($result_info_tarea->num_rows > 0) {
        $row_info_tarea = $result_info_tarea->fetch_assoc();
        $nombre_tarea = $row_info_tarea['nombre'];
        $descripcion_tarea = $row_info_tarea['descripcion'];
        $estado_tarea = $row_info_tarea['estado'];
    } else {
        echo "No se encontró la tarea.";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_tarea = $_POST['id_tarea'];
    $nombre_tarea = $_POST['nombre'];
    $descripcion_tarea = $_POST['descripcion'];
    $estado_tarea = $_POST['estado'];

    $sql_actualizar_tarea = "UPDATE tarea SET nombre = '$nombre_tarea', descripcion = '$descripcion_tarea', estado = '$estado_tarea' WHERE id_tarea = $id_tarea";

    if ($conn->query($sql_actualizar_tarea) === TRUE) {
        header('Location: ../index.php');
        exit();
    } else {
        echo "Error al actualizar la tarea: " . $conn->error;
    }
}

$conn->close();
?>

<!-- Formulario para editar la tarea -->
<div class="card mt-5">
    <div class="card-body">
        <h2 class="card-title text-center">Editar Tarea</h2>
        <form action="" method="post">
            <input type="hidden" name="id_tarea" value="<?php echo $id_tarea; ?>">

            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre:</label>
                <input type="text" id="nombre" name="nombre" class="form-control" value="<?php echo $nombre_tarea; ?>" required>
            </div>

            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción:</label>
                <textarea id="descripcion" name="descripcion" class="form-control" required><?php echo $descripcion_tarea; ?></textarea>
            </div>

            <div class="mb-3">
                <label for="estado" class="form-label">Estado:</label>
                <select id="estado" name="estado" class="form-select" required>
                    <option value="pendiente" <?php echo ($estado_tarea === 'pendiente') ? 'selected' : ''; ?>>Pendiente</option>
                    <option value="en_proceso" <?php echo ($estado_tarea === 'en_proceso') ? 'selected' : ''; ?>>En Proceso</option>
                    <option value="completada" <?php echo ($estado_tarea === 'completada') ? 'selected' : ''; ?>>Completada</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Actualizar Tarea</button>
        </form>
    </div>
</div>