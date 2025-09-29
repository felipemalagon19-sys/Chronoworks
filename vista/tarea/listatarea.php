<?php
session_start();

// Verificar permisos (admin o líder pueden ver esta página)
if (!isset($_SESSION['id_rol']) || ($_SESSION['id_rol'] != 1 && $_SESSION['id_rol'] != 2)) {
    header("Location: ../../login.php");
    exit();
}

include "../../modelo/Conexion.php";

// Incluir controladores
include "../../controlador/asignacion/eliminar_asignacion.php";
include "../../controlador/asignacion/registro_asignacion.php";
include "../../controlador/asignacion/modificar_asignacion.php";

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../css/listaasignacion.css">
    <script src="https://kit.fontawesome.com/8eb65f8551.js" crossorigin="anonymous"></script>
    <title>Lista de Asignaciones</title>
</head>
<body id="listaasignacion-vista">
    <div class="fondo">
        <header>
            <!-- Tu header aquí -->
        </header>

        <div class="container mt-4">
            <h2 class="text-center mb-4">Gestión de Asignaciones</h2>
            
            <?php
            // Mostrar mensajes de sesión
            if (isset($_SESSION['mensaje'])) {
                echo $_SESSION['mensaje'];
                unset($_SESSION['mensaje']);
            }
            ?>

            <!-- Botón para nueva asignación -->
            <div class="mb-3">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalNuevaAsignacion">
                    <i class="fa-solid fa-plus"></i> Nueva Asignación
                </button>
            </div>

            <!-- Tabla de asignaciones -->
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Tarea</th>
                            <th>Campaña</th>
                            <th>Fecha</th>
                            <th>Observaciones</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Consulta adaptada para PostgreSQL
                        $sql = "SELECT 
                                a.id_asignacion,
                                a.id_tarea,
                                a.id_campania,
                                a.fecha,
                                a.observaciones,
                                t.nombre_tarea,
                                c.nombre_campania
                            FROM asignacion a
                            INNER JOIN tarea t ON a.id_tarea = t.id_tarea
                            INNER JOIN campania c ON a.id_campania = c.id_campania
                            ORDER BY a.fecha DESC";
                        
                        // Usar pg_query en lugar de $conexion->query()
                        $result = pg_query($conexion, $sql);
                        
                        if ($result && pg_num_rows($result) > 0) {
                            // Usar pg_fetch_assoc en lugar de fetch_object()
                            while ($row = pg_fetch_assoc($result)) {
                        ?>
                                <tr>
                                    <td><?php echo $row['id_asignacion']; ?></td>
                                    <td><?php echo htmlspecialchars($row['nombre_tarea']); ?></td>
                                    <td><?php echo htmlspecialchars($row['nombre_campania']); ?></td>
                                    <td><?php echo date('d/m/Y', strtotime($row['fecha'])); ?></td>
                                    <td class="celdaobservaciones">
                                        <span class="cell-text" data-collapsed="true">
                                            <?php echo htmlspecialchars($row['observaciones']); ?>
                                        </span>
                                        <button class="btn btn-sm btn-link ver-mas">Ver más</button>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-warning" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#modalEditarAsignacion"
                                                onclick="cargarDatosEditar(<?php echo $row['id_asignacion']; ?>, 
                                                                          <?php echo $row['id_tarea']; ?>, 
                                                                          <?php echo $row['id_campania']; ?>, 
                                                                          '<?php echo $row['fecha']; ?>', 
                                                                          '<?php echo addslashes($row['observaciones']); ?>')">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </button>
                                        <a href="?id=<?php echo $row['id_asignacion']; ?>" 
                                           class="btn btn-sm btn-danger"
                                           onclick="return confirm('¿Está seguro de eliminar esta asignación?')">
                                            <i class="fa-solid fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                        <?php
                            }
                        } else {
                            echo '<tr><td colspan="6" class="text-center">No hay asignaciones registradas</td></tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Modal Nueva Asignación -->
        <div class="modal fade" id="modalNuevaAsignacion" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Nueva Asignación</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form method="post">
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="idtarea" class="form-label">Tarea:</label>
                                <select class="form-control" name="idtarea" required>
                                    <option value="">Seleccione una tarea</option>
                                    <?php
                                    $sql_tareas = "SELECT id_tarea, nombre_tarea FROM tarea ORDER BY nombre_tarea";
                                    $result_tareas = pg_query($conexion, $sql_tareas);
                                    while ($tarea = pg_fetch_assoc($result_tareas)) {
                                        echo "<option value='{$tarea['id_tarea']}'>{$tarea['nombre_tarea']}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="idcampaña" class="form-label">Campaña:</label>
                                <select class="form-control" name="idcampaña" required>
                                    <option value="">Seleccione una campaña</option>
                                    <?php
                                    $sql_campanias = "SELECT id_campania, nombre_campania FROM campania ORDER BY nombre_campania";
                                    $result_campanias = pg_query($conexion, $sql_campanias);
                                    while ($campania = pg_fetch_assoc($result_campanias)) {
                                        echo "<option value='{$campania['id_campania']}'>{$campania['nombre_campania']}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="fechaasignacion" class="form-label">Fecha:</label>
                                <input type="datetime-local" class="form-control" name="fechaasignacion" required>
                            </div>
                            <div class="mb-3">
                                <label for="observaciones" class="form-label">Observaciones:</label>
                                <textarea class="form-control" name="observaciones" rows="3" required></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary" name="btnregistrar" value="ok">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal Editar Asignación -->
        <div class="modal fade" id="modalEditarAsignacion" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Editar Asignación</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form method="post">
                        <input type="hidden" name="id" id="edit_id">
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="edit_idtarea" class="form-label">Tarea:</label>
                                <select class="form-control" name="idtarea" id="edit_idtarea" required>
                                    <?php
                                    $result_tareas = pg_query($conexion, $sql_tareas);
                                    while ($tarea = pg_fetch_assoc($result_tareas)) {
                                        echo "<option value='{$tarea['id_tarea']}'>{$tarea['nombre_tarea']}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="edit_idcampaña" class="form-label">Campaña:</label>
                                <select class="form-control" name="idcampaña" id="edit_idcampaña" required>
                                    <?php
                                    $result_campanias = pg_query($conexion, $sql_campanias);
                                    while ($campania = pg_fetch_assoc($result_campanias)) {
                                        echo "<option value='{$campania['id_campania']}'>{$campania['nombre_campania']}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="edit_fechaasignacion" class="form-label">Fecha:</label>
                                <input type="datetime-local" class="form-control" name="fechaasignacion" id="edit_fechaasignacion" required>
                            </div>
                            <div class="mb-3">
                                <label for="edit_observaciones" class="form-label">Observaciones:</label>
                                <textarea class="form-control" name="observaciones" id="edit_observaciones" rows="3" required></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-warning" name="btnregistrar" value="ok">Actualizar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../../js/main.js"></script>
    <script>
        function cargarDatosEditar(id, idTarea, idCampania, fecha, observaciones) {
            document.getElementById('edit_id').value = id;
            document.getElementById('edit_idtarea').value = idTarea;
            document.getElementById('edit_idcampaña').value = idCampania;
            document.getElementById('edit_fechaasignacion').value = fecha.replace(' ', 'T');
            document.getElementById('edit_observaciones').value = observaciones;
        }
    </script>
</body>
</html>