<?php
include "../../modelo/Conexion.php";
include "../../controlador/credenciales/registro_credenciales.php";
include "../../controlador/credenciales/eliminar_credenciales.php";
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Lista Cuentas </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../css/listacredenciales.css">
    <link rel="stylesheet" href="../../css/header.css">
    <script src="https://kit.fontawesome.com/8eb65f8551.js" crossorigin="anonymous"></script>
</head>

<body class="fondo <?php echo ($_SESSION['id_rol'] === 3) ? 'agente' : ''; ?>">
    <header>
        <div class="fondo_menu">
            <div class="container-fluid">
                <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
                    <div class="container-fluid">
                        <a class="navbar-brand">
                            <img src="../../img/logo.png" alt="Logo" style="width:50px;" class="rounded-pill border border-2">
                        </a>
                        <a class="navbar-brand fw-semibold text-light">Chronoworks</a>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <?php if ($_SESSION['id_rol'] != 3) : ?>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle text-light fw-semibold" href="#" id="campanasDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        Servicios 1
                                    </a>
                                    <ul class="dropdown-menu" aria-labelledby="campanasDropdown">
                                        <li><a class="dropdown-item" href="../asignacion/listaasignacion.php">Asignación</a></li>
                                        <li><a class="dropdown-item" href="../controlacceso/listacontrol.php">Control Acceso</a></li>
                                    </ul>
                                </li>
                            <?php endif; ?>
                            <?php if ($_SESSION['id_rol'] === 1) : ?>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle text-light fw-semibold" href="#" id="empleadosDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        Servicios 2
                                    </a>
                                    <ul class="dropdown-menu" aria-labelledby="empleadosDropdown">
                                        <li><a class="dropdown-item" href="../empleados/listaempleados.php">Empleados</a></li>
                                        <li><a class="dropdown-item" href="../empresa/listaempresa.php">Empresa</a></li>
                                        <li><a class="dropdown-item" href="../roles/listaroles.php">Roles</a></li>
                                    </ul>
                                </li>
                            <?php endif; ?>
                            <?php if ($_SESSION['id_rol'] === 1) : ?>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle text-light fw-semibold" href="#" id="contactoDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        Servicios 3
                                    </a>
                                    <ul class="dropdown-menu" aria-labelledby="contactoDropdown">
                                        <li><a class="dropdown-item" href="../turno/listaturno.php">Turnos</a></li>
                                        <li><a class="dropdown-item" href="../tarea/listatarea.php">Tareas</a></li>
                                        <li><a class="dropdown-item" href="../credenciales/listacredenciales.php">Credenciales</a></li>
                                    </ul>
                                </li>
                            <?php endif; ?>
                            <?php if ($_SESSION['id_rol'] === 3) : ?>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle text-light fw-semibold" href="#" id="servicios1AgenteDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        Servicios 1
                                    </a>
                                    <ul class="dropdown-menu" aria-labelledby="servicios1AgenteDropdown">
                                        <li><a class="dropdown-item" href="../turno/listaturno.php">Mis Turnos</a></li>
                                        <li><a class="dropdown-item" href="../campaña/listacampaña.php">Campañas Activas</a></li>
                                        <li><a class="dropdown-item" href="../tarea/listatarea.php">Mis Tareas</a></li>
                                    </ul>
                                </li>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle text-light fw-semibold" href="#" id="servicios2AgenteDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        Servicios 2
                                    </a>
                                    <ul class="dropdown-menu" aria-labelledby="servicios2AgenteDropdown">
                                        <li><a class="dropdown-item" href="../roles/listaroles.php">Mi Rol</a></li>
                                        <li><a class="dropdown-item" href="../controlacceso/listacontrol.php">Mis Accesos</a></li>
                                    </ul>
                                </li>
                            <?php endif; ?>
                        </ul>
                        <a href="<?php
                                    if ($_SESSION['id_rol'] == 3) {
                                        echo "../../agente.php"; // Para Agente
                                    } elseif ($_SESSION['id_rol'] == 1) {
                                        echo "../../admin.php"; // Para Admin
                                    } elseif ($_SESSION['id_rol'] == 2) {
                                        echo "../../lider.php"; // Para Líder
                                    }
                                    ?>" class="botoninicio me-2">Inicio</a>
                        <a href="../../logout.php" class="botonsesion">Cerrar Sesión</a>
                    </div>
                </nav>
            </div>
        </div>
    </header>
    <?php if ($_SESSION['id_rol'] != 3): ?>
        <div class="container mt-3 border border-2 p-3" style="border-radius: 15px; max-height: 150px; max-width: 50%;   background: linear-gradient(180deg,rgb(185, 178, 178) 70%, #878c8d 100%);">
            <div class="col-md-6">
                <h3 class="py-2 px-4 mx-2 shadow-sm text-center"
                    style=" background: linear-gradient(180deg, #4caed4 0%, #5d8ea1 100%);color: black; max-width: 300px; border-radius: 15px; border: 2px solid white; font-size: 1.2rem;">
                    Agregar Cuenta
                </h3>
                <a href="agregarcredenciales.php" class="boton d-flex justify-content-center align-items-center mx-auto mt-3"
                    style="width: 150px; height: 40px; border-radius: 10px; font-size: 1rem;"> Agregar
                </a>

            </div>
            <div class="col-md-6">
                <h3 class="py-2 px-3 mx-2 shadow-sm text-center"
                    style=" background: linear-gradient(180deg, #4caed4 0%, #5d8ea1 100%);color: black; max-width: 300px; border-radius: 15px; border: 2px solid white; font-size: 1.2rem;">
                    Generar Reporte
                </h3>
                <button class="boton d-flex justify-content-center align-items-center mx-auto mt-3"
                    style="width: 150px; height: 40px; border-radius: 10px; font-size: 1rem;">
                    Generar
                </button>
            </div>
        </div>
    <?php endif; ?>
    <h2 class="text-center py-3 px-4 mx-auto mt-3 shadow-sm"
        style="background-color:rgb(185, 178, 178);color: black; max-width: 400px; margin-top: 2rem; margin-bottom: 1rem; border-radius: 15px; border: solid 2px; border-color: white;">
        <?php echo ($_SESSION['id_rol'] === 3) ? 'Tu Cuenta' : 'Lista de Cuentas'; ?>
    </h2>
    <script>
        function eliminar() {
            var respuesta = confirm("¿Desea eliminar la cuenta?")
            return respuesta
        }
    </script>
    <?php
    // Mostrar mensaje si existe
    if (isset($_SESSION['mensaje'])) { ?>
        <?php
        echo $_SESSION['mensaje'];
        unset($_SESSION['mensaje']); // Elimina el mensaje tras mostrarlo
        ?>
    <?php } ?>
    <div class="container mt-3">
        <div class="estilo-tabla">
            <table>
                <thead>
                    <tr>
                        <?php if ($_SESSION['id_rol'] != 3) { // Mostrar encabezados completos solo si no es agente 
                        ?>
                            <th>Usuario</th>
                            <th>Contraseña</th>
                            <th>Empleado</th>
                            <th>Rol</th>
                            <th>Acciones</th>
                        <?php } else { ?>
                            <th>Usuario</th>
                            <th>Contraseña</th>
                        <?php } ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($_SESSION['id_rol'] == 3) {
                        $idempleado = $_SESSION['id_empleado'];
                        $sql = $conexion->query("SELECT Usuario, Contraseña FROM credenciales WHERE ID_Empleado = $idempleado");
                    } else {
                        // Consulta completa para otros roles
                        $sql = $conexion->query(
                            "SELECT c.ID_Credencial, c.Usuario, c.Contraseña, e.Nombre AS Empleado, r.nombre AS Rol
                         FROM credenciales c
                         JOIN empleados e ON e.ID_Empleado = c.ID_Empleado
                         JOIN roles r ON r.ID_Rol = c.id_rol"
                        );
                    }

                    while ($datos = $sql->fetch_object()) { ?>
                        <tr>
                            <?php if ($_SESSION['id_rol'] != 3) { ?>
                                <td><?= $datos->Usuario ?></td>
                                <td><?= $datos->Contraseña ?></td>
                                <td><?= $datos->Empleado ?></td>
                                <td><?= $datos->Rol ?></td>
                                <td>
                                    <div class="botones-acciones">
                                        <a href="modificarcredenciales.php?id=<?= $datos->ID_Credencial ?>" class="botoneditar">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>
                                        <a onclick="return eliminar()" href="listacredenciales.php?id=<?= $datos->ID_Credencial ?>" class="botoneliminar">
                                            <i class="fa-solid fa-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            <?php } else { ?>
                                <td><?= $datos->Usuario ?></td>
                                <td><?= $datos->Contraseña ?></td>
                            <?php } ?>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../../js/main.js"></script>
</body>