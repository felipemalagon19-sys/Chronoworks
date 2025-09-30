<?php
// ============================================
// ARCHIVO: vista/controlacceso/listacontrol.php
// ============================================
?>
<?php
include "../../modelo/Conexion.php";
include "../../controlador/control_acceso/registro_controlacceso.php";
include "../../controlador/control_acceso/eliminar_controlacceso.php";
$rol = $_SESSION['id_rol'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Lista Accesos </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../css/listacontrol_acceso.css">
    <link rel="stylesheet" href="../../css/header.css">
    <script src="https://kit.fontawesome.com/8eb65f8551.js" crossorigin="anonymous"></script>
</head>
<body class="fondo <?php echo ($_SESSION['id_rol'] === 3) ? 'agente' : ''; ?>" id="listacontrol-vista">
    <header>
        <div class="fondo_menu">
            <div class="container-fluid">
                <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
                    <div class="container-fluid">
                        <a class="navbar-brand">
                            <img src="../../img/logo.png" alt="Logo" style="width:50px;" class="rounded-pill border border-2">
                        </a>
                        <a class="navbar-brand fw-semibold text-light">Chronoworks</a>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <?php if ($_SESSION['id_rol'] != 3) : ?>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle text-light fw-semibold" href="#" id="campanasDropdown" role="button" data-bs-toggle="dropdown">
                                        <?php echo ($_SESSION['id_rol'] === 2) ? 'Servicios' : 'Servicios 1'; ?>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="../campaña/listacampaña.php">Campañas</a></li>
                                        <li><a class="dropdown-item" href="../asignacion/listaasignacion.php">Asignación</a></li>
                                    </ul>
                                </li>
                            <?php endif; ?>
                            <?php if ($_SESSION['id_rol'] === 1) : ?>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle text-light fw-semibold" href="#" role="button" data-bs-toggle="dropdown">
                                        Servicios 2
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="../empleados/listaempleados.php">Empleados</a></li>
                                        <li><a class="dropdown-item" href="../empresa/listaempresa.php">Empresa</a></li>
                                        <li><a class="dropdown-item" href="../roles/listaroles.php">Roles</a></li>
                                    </ul>
                                </li>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle text-light fw-semibold" href="#" role="button" data-bs-toggle="dropdown">
                                        Servicios 3
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="../turno/listaturno.php">Turnos</a></li>
                                        <li><a class="dropdown-item" href="../tarea/listatarea.php">Tareas</a></li>
                                        <li><a class="dropdown-item" href="../credenciales/listacredenciales.php">Credenciales</a></li>
                                    </ul>
                                </li>
                            <?php endif; ?>
                            <?php if ($_SESSION['id_rol'] === 3) : ?>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle text-light fw-semibold" href="#" role="button" data-bs-toggle="dropdown">
                                        Servicios 1
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="../turno/listaturno.php">Mis Turnos</a></li>
                                        <li><a class="dropdown-item" href="../campaña/listacampaña.php">Campañas Activas</a></li>
                                        <li><a class="dropdown-item" href="../tarea/listatarea.php">Mis Tareas</a></li>
                                    </ul>
                                </li>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle text-light fw-semibold" href="#" role="button" data-bs-toggle="dropdown">
                                        Servicios 2
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="../credenciales/listacredenciales.php">Mi Cuenta</a></li>
                                        <li><a class="dropdown-item" href="../roles/listaroles.php">Mi Rol</a></li>
                                    </ul>
                                </li>
                            <?php endif; ?>
                        </ul>
                        <a href="<?php
                            if ($_SESSION['id_rol'] == 3) echo "../../agente.php";
                            elseif ($_SESSION['id_rol'] == 1) echo "../../admin.php";
                            elseif ($_SESSION['id_rol'] == 2) echo "../../lider.php";
                        ?>" class="botoninicio me-2">Inicio</a>
                        <a href="../../logout.php" class="botonsesion">Cerrar Sesión</a>
                    </div>
                </nav>
            </div>
        </div>
    </header>
    
    <div class="container mt-3 border border-2 p-3" style="border-radius: 15px; max-height: 150px; max-width: 50%; background: linear-gradient(180deg,rgb(185, 178, 178) 70%, #878c8d 100%);">
        <?php if ($_SESSION['id_rol'] === 3) { ?>
            <div class="col-md-6">
                <h3 class="py-2 px-4 mx-2 shadow-sm text-center" style="background: linear-gradient(180deg, #4caed4 0%, #5d8ea1 100%);color: black; max-width: 300px; border-radius: 15px; border: 2px solid white; font-size: 1.2rem;">
                    Agregar Acceso
                </h3>
                <a href="agregaracceso.php" class="boton d-flex justify-content-center align-items-center mx-auto mt-3" style="width: 150px; height: 40px; border-radius: 10px; font-size: 1rem;"> Agregar</a>
            </div>
        <?php } ?>
        <?php if ($_SESSION['id_rol'] != 3) { ?>
            <div class="col-md-6">
                <h3 class="py-2 px-3 mx-2 shadow-sm text-center" style="background: linear-gradient(180deg, #4caed4 0%, #5d8ea1 100%);color: black; max-width: 300px; border-radius: 15px; border: 2px solid white; font-size: 1.2rem;">
                    Generar Reporte
                </h3>
                <a class="boton d-flex justify-content-center align-items-center mx-auto mt-3" href="../../dompdf/reporte_pdf_acceso.php" style="width: 150px; height: 40px; border-radius: 10px; font-size: 1rem;">Generar</a>
            </div>
        <?php } ?>
    </div>

    <h2 class="text-center py-3 px-4 mx-auto mt-3 shadow-sm" style="background-color:rgb(185, 178, 178);color: black; max-width: 400px; margin-top: 2rem; margin-bottom: 1rem; border-radius: 15px; border: solid 2px; border-color: white;">
        <?php echo ($_SESSION['id_rol'] === 3) ? 'Tus Accesos' : 'Lista de Accesos'; ?>
    </h2>
    
    <script>
        function eliminar() {
            return confirm("¿Desea eliminar el acceso?")
        }
    </script>
    
    <?php
    if (isset($_SESSION['mensaje'])) {
        echo $_SESSION['mensaje'];
        unset($_SESSION['mensaje']);
    }
    ?>
    
    <div class="container mt-3">
        <div class="estilo-tabla">
            <table>
                <thead>
                    <tr>
                        <?php if ($_SESSION['id_rol'] != 3) { ?>
                            <th>ID Acceso</th>
                            <th>ID Empleado</th>
                            <th>Fecha</th>
                            <th>Hora Ingreso</th>
                            <th>Hora Salida</th>
                            <th>Observaciones</th>
                        <?php } else { ?>
                            <th>Fecha</th>
                            <th>Hora Ingreso</th>
                            <th>Hora Salida</th>
                            <th>Observaciones</th>
                        <?php } ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // ✅ CORREGIDO: Usar pg_query
                    if ($_SESSION['id_rol'] == 3) {
                        $idempleado = $_SESSION['id_empleado'];
                        $sql = pg_query($conexion, "SELECT fecha, hora_entrada, hora_salida, observacion FROM control_acceso WHERE id_empleado = $idempleado ORDER BY fecha DESC");
                    } else {
                        $sql = pg_query($conexion, "SELECT * FROM control_acceso ORDER BY id_control DESC");
                    }

                    // ✅ CORREGIDO: Usar pg_fetch_object
                    if ($sql && pg_num_rows($sql) > 0) {
                        while ($datos = pg_fetch_object($sql)) { ?>
                            <tr>
                                <?php if ($_SESSION['id_rol'] != 3) { ?>
                                    <td><?= htmlspecialchars($datos->id_control) ?></td>
                                    <td><?= htmlspecialchars($datos->id_empleado) ?></td>
                                    <td><?= date('d/m/Y', strtotime($datos->fecha)) ?></td>
                                    <td><?= htmlspecialchars($datos->hora_entrada) ?></td>
                                    <td><?= htmlspecialchars($datos->hora_salida) ?></td>
                                    <td><?= htmlspecialchars($datos->observacion) ?></td>
                                <?php } else { ?>
                                    <td><?= date('d/m/Y', strtotime($datos->fecha)) ?></td>
                                    <td><?= htmlspecialchars($datos->hora_entrada) ?></td>
                                    <td><?= htmlspecialchars($datos->hora_salida) ?></td>
                                    <td><?= htmlspecialchars($datos->observacion) ?></td>
                                <?php } ?>
                            </tr>
                        <?php }
                    } else {
                        $colspan = ($_SESSION['id_rol'] != 3) ? 6 : 4;
                        echo '<tr><td colspan="' . $colspan . '" class="text-center">No hay registros de acceso</td></tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../../js/main.js"></script>
</body>
</html>

<?php
// ============================================
// ARCHIVO: vista/controlacceso/modificarControlacceso.php
// ============================================
?>
<?php
include "../../modelo/Conexion.php";
$id = $_GET['id'];
// ✅ CORREGIDO: Usar pg_query_params para seguridad
$sql = pg_query_params($conexion, "SELECT * FROM control_acceso WHERE id_control = $1", array($id));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Modificar Acceso </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../css/modificar.css">
    <link rel="stylesheet" href="../../css/header.css">
    <script src="https://kit.fontawesome.com/8eb65f8551.js" crossorigin="anonymous"></script>
</head>
<body class="fondo">
    <header>
        <div class="fondo_menu">
            <div class="container-fluid">
                <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
                    <div class="container-fluid">
                        <a class="navbar-brand" href="#">
                            <img src="../../img/logo.png" alt="Logo" style="width:50px;" class="rounded-pill border border-2">
                        </a>
                        <a class="navbar-brand fw-semibold text-light" href="index.php">Chronoworks</a>
                        <a href="../../admin.php" class="botoninicio">Inicio</a>
                    </div>
                </nav>
            </div>
        </div>
    </header>
    <h2 class="text-center py-3 px-4 mx-auto shadow-sm" style="color: black; max-width: 400px; margin-top: 2rem; margin-bottom: 2rem; border-radius: 15px; border: solid 2px; border-color: white;">
        Modificar Acceso
    </h2>
    <div class="container">
        <div class="col-12">
            <form method="post">
                <input type="hidden" name="id" value="<?= $_GET['id'] ?>">
                <?php
                include "../../controlador/control_acceso/modificar_controlacceso.php";
                // ✅ CORREGIDO: Usar pg_fetch_object
                while ($datos = pg_fetch_object($sql)) { ?>
                    <div class="row mb-3">
                        <div class="col-6">
                            <label for="idempleado" class="form-label">ID Empleado:</label>
                            <input type="number" class="form-control" id="idempleado" name="idempleado" value="<?= htmlspecialchars($datos->id_empleado) ?>">
                        </div>
                        <div class="mb-3 col-6">
                            <label for="fechaacceso" class="form-label">Fecha del Acceso:</label>
                            <input type="date" class="form-control" name="fechaacceso" id="fechaacceso" value="<?= htmlspecialchars($datos->fecha) ?>">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="mb-3 col-6">
                            <label for="horaentrada" class="form-label">Hora de Entrada:</label>
                            <input type="time" class="form-control" name="horaentrada" id="horaentrada" value="<?= htmlspecialchars($datos->hora_entrada) ?>">
                        </div>
                        <div class="mb-3 col-6">
                            <label for="horasalida" class="form-label"> Hora de Salida:</label>
                            <input type="time" class="form-control" name="horasalida" id="horasalida" value="<?= htmlspecialchars($datos->hora_salida) ?>">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="mb-3 col-6 m-auto">
                            <label for="observaciones" class="form-label"> Observaciones:</label>
                            <textarea class="form-control" name="observaciones" id="observaciones"><?= htmlspecialchars($datos->observacion) ?></textarea>
                        </div>
                    </div>
                <?php } ?>
                <div class="d-flex justify-content-center">
                    <button type="submit" class="btn btn-primary shadow py-2 px-4 fw-bold col-5" name="btnregistrar" value="ok"> Actualizar </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>