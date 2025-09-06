<?php
session_start();
if (!isset($_SESSION['id_rol']) || $_SESSION['id_rol'] != 2) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/lider.css">
    <link rel="stylesheet" href="css/header.css">
    <script src="https://kit.fontawesome.com/8eb65f8551.js" crossorigin="anonymous"></script>
    <title>Lider</title>
</head>

<body>
    <div class="fondo">
        <header>
            <div class="fondo_menu">
                <div class="container-fluid">
                    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
                        <div class="container-fluid">
                            <a class="navbar-brand">
                                <img src="img/logo.png" alt="Logo" style="width:50px;" class="rounded-pill border border-2">
                            </a>
                            <a class="navbar-brand fw-semibold text-light">Chronoworks</a>
                            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                                <span class="navbar-toggler-icon"></span>
                            </button>
                            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                                    <li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle text-light fw-semibold" href="#" id="campanasDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            Servicios
                                        </a>
                                        <ul class="dropdown-menu" aria-labelledby="campanasDropdown">
                                            <li><a class="dropdown-item" href="vista/asignacion/listaasignacion.php">Asignación</a></li>
                                            <li><a class="dropdown-item" href="vista/campaña/listacampaña.php">Campaña</a></li>
                                            <li><a class="dropdown-item" href="vista/controlacceso/listacontrol.php">Control Acceso</a></li>
                                        </ul>
                                    </li>
                                </ul>
                                <a href="logout.php" class="botonsesion">Cerrar Sesion</a>
                            </div>
                        </div>
                    </nav>
                </div>
            </div>
        </header>
        <h2 class="text-center py-3 px-3 mx-auto mt-3 shadow-sm"
            style="background: linear-gradient(180deg, #cbe5f0 0%, #a09090 100%);color: black; max-width: 400px; margin-top: 2rem; margin-bottom: 1rem; border-radius: 15px; border: solid 3px; border-color: white;">
            ¡Bienvenido, Líder <?php echo $_SESSION['nombre_empleado']; ?>!
        </h2>
        <div class="fondo-cards">
            <div class="container mt-5">
                <div class="row">
                    <div class="col-12 col-md-4 mb-4 d-flex justify-content-center align-items-center">
                        <div class="card tarjeta">
                            <img class="card-img-top" src="img/asignacion.png" alt="Card image">
                            <div class="card-body">
                                <h4 class="card-title">ASIGNACIÓN</h4>
                                <p class="card-text">Gestiona las tareas asignadas a cada campaña.</p>
                                <a href="vista/asignacion/listaasignacion.php" class="boton">GESTIÓN</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-4 mb-4 d-flex justify-content-center align-items-center">
                        <div class="card tarjeta">
                            <img class="card-img-top" src="img/campaña.png" alt="Card image">
                            <div class="card-body">
                                <h4 class="card-title">CAMPAÑA</h4>
                                <p class="card-text">Gestiona las campañas asociadas a las empresas.</p>
                                <a href="vista/campaña/listacampaña.php" class="boton">GESTIÓN</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-4 mb-4 d-flex justify-content-center align-items-center">
                        <div class="card tarjeta">
                            <img class="card-img-top" src="img/control_acceso.png" alt="Card image">
                            <div class="card-body">
                                <h4 class="card-title">CONTROL DE ACCESO</h4>
                                <p class="card-text">Gestiona el acceso de los empleados.</p>
                                <a href="vista/controlacceso/listacontrol.php" class="boton">GESTIÓN</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/main.js"></script>
</body>

</html>