<?php
// Verificar si se ha enviado el formulario de finalizar
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['finalizar'])) {
        // Obtener el ID de la tarea a finalizar desde el formulario
        $id_tarea = $_POST["id_tarea"];

        // Obtener la fecha y hora actuales
        $fecha_fin = date("Y-m-d H:i:s");

        // Actualizar la tarea con la fecha de finalización y cambiar el estado a "Completado"
        $sql_finalizar = "UPDATE tarea SET fecha_fin = '$fecha_fin', estado = 'Completado' WHERE id_tarea = $id_tarea";
        if ($conn->query($sql_finalizar) === TRUE) {
            echo "Tarea finalizada con éxito.";
        } else {
            echo "Error al finalizar la tarea: " . $conn->error;
        }
    } elseif (isset($_POST['eliminar'])) {
        // Obtener el ID de la tarea a eliminar desde el formulario
        $id_tarea = $_POST["id_tarea"];

        // Eliminar la tarea
        $sql_eliminar = "DELETE FROM tarea WHERE id_tarea = $id_tarea";
        if ($conn->query($sql_eliminar) === TRUE) {
            echo "Tarea eliminada con éxito.";
        } else {
            echo "Error al eliminar la tarea: " . $conn->error;
        }
    }
}

$sql_tareas = "SELECT * FROM tarea ORDER BY fecha_inicio DESC";
$result_tareas = $conn->query($sql_tareas);

// Cerrar la conexión
$conn->close();
?>

<div class="card mt-5">
    <div class="card-body">
        <h2 class="card-title text-center">Lista de Tareas</h2>

        <?php
        // Verificar si hay tareas para mostrar
        if ($result_tareas->num_rows > 0) {
            echo "<table class='table'>";
            echo "<thead>";
            echo "<tr>";
            echo "<th scope='col'>Nombre</th>";
            echo "<th scope='col'>Descripción</th>";
            echo "<th scope='col'>Estado</th>";
            echo "<th scope='col'>Fecha de Inicio</th>";
            echo "<th scope='col'>Fecha de Finalización</th>";
            echo "<th scope='col'>Finalizar</th>"; // Nueva columna para el botón "Finalizar"
            echo "<th scope='col'>Editar</th>";    // Nueva columna para el botón "Editar"
            echo "<th scope='col'>Eliminar</th>";  // Nueva columna para el botón "Eliminar"
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";

            // Mostrar cada tarea en una fila de la tabla
            while ($row = $result_tareas->fetch_assoc()) {
                echo "<tr>";
                echo "<td>{$row['nombre']}</td>";
                echo "<td>{$row['descripcion']}</td>";
                echo "<td>{$row['estado']}</td>";
                echo "<td>{$row['fecha_inicio']}</td>";
                echo "<td>{$row['fecha_fin']}</td>";

                // Nueva columna para el botón "Finalizar"
                echo "<td>";
                // Mostrar botón de finalizar solo si la tarea no ha sido finalizada
                if (empty($row['fecha_fin'])) {
                    echo "<form action='' method='post'>";
                    echo "<input type='hidden' name='id_tarea' value='{$row['id_tarea']}'>";
                    echo "<button type='submit' name='finalizar' class='btn btn-success'>Finalizar</button>";
                    echo "</form>";
                }
                echo "</td>";

                // Nueva columna para el botón "Editar"
                echo "<td>";
                // Agregar botón de editar solo si la tarea no ha sido finalizada
                if (empty($row['fecha_fin'])) {
                    echo "<form action='components/editar_tarea.php' method='get'>";
                    echo "<input type='hidden' name='id_tarea' value='{$row['id_tarea']}'>";
                    echo "<button type='submit' class='btn btn-primary'>Editar</button>";
                    echo "</form>";
                }
                echo "</td>";

                // Nueva columna para el botón "Eliminar"
                echo "<td>";
                echo "<form action='' method='post'>";
                echo "<input type='hidden' name='id_tarea' value='{$row['id_tarea']}'>";
                echo "<button type='submit' name='eliminar' class='btn btn-danger'>Eliminar</button>";
                echo "</form>";
                echo "</td>";

                echo "</tr>";
            }

            echo "</tbody>";
            echo "</table>";
        } else {
            echo "<p class='mt-4'>No hay tareas disponibles.</p>";
        }
        ?>
    </div>
</div>