<?php
// ============================================
// ARCHIVO: vista/roles/modificarroles.php
// ============================================
include "../../modelo/Conexion.php";

// Verificar que existe el parámetro ID
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: listaroles.php");
    exit();
}

$id = $_GET['id'];

// ✅ CORREGIDO: Usar pg_query_params en lugar de $conexion->query()
$sql = pg_query_params($conexion, "SELECT * FROM roles WHERE id_rol = $1", array($id));

// Verificar si la consulta fue exitosa
if (!$sql) {
    die("Error en la consulta: " . pg_last_error($conexion));
}

// Verificar si existe el rol
if (pg_num_rows($sql) == 0) {
    header("Location: listaroles.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Rol</title>
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
        Modificar Rol
    </h2>
    
    <div class="container">
        <div class="col-12">
            <form method="post">
                <input type="hidden" name="id" value="<?= htmlspecialchars($id) ?>">
                <?php
                include "../../controlador/roles/modificar_roles.php";
                
                // ✅ CORREGIDO: Usar pg_fetch_object
                $datos = pg_fetch_object($sql);
                if ($datos) { ?>
                    <div class="row mb-3 justify-content-center">
                        <div class="col-6">
                            <label for="nombre" class="form-label">Nombre del Rol:</label>
                            <input type="text" 
                                   class="form-control" 
                                   id="nombre" 
                                   placeholder="Nombre del Rol" 
                                   name="nombre" 
                                   value="<?= htmlspecialchars($datos->nombre) ?>" 
                                   required>
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-center gap-2">
                        <a href="listaroles.php" class="btn btn-secondary shadow py-2 px-4 fw-bold">Cancelar</a>
                        <button type="submit" class="btn btn-primary shadow py-2 px-4 fw-bold" name="btnregistrar" value="ok">Actualizar</button>
                    </div>
                <?php } else { ?>
                    <div class="alert alert-danger">
                        No se encontró el rol solicitado.
                    </div>
                    <div class="d-flex justify-content-center">
                        <a href="listaroles.php" class="btn btn-secondary">Volver a la lista</a>
                    </div>
                <?php } ?>
            </form>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../../js/main.js"></script>
</body>
</html>