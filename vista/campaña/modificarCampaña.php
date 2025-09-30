<?php
// ============================================
// ARCHIVO: vista/campaña/modificarCampaña.php (CORRECCIÓN COMPLETA)
// ============================================
session_start();
include_once "../../modelo/Conexion.php";

$id = (int)$_GET['id'];
$sql = pg_query_params($conexion, "SELECT * FROM campania WHERE id_campania = $1", array($id));
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Campaña</title>
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
                        <a href="<?php echo ($_SESSION['id_rol'] === 1) ? '../../admin.php' : '../../lider.php'; ?>" class="botoninicio">Inicio</a>
                    </div>
                </nav>
            </div>
        </div>
    </header>
    <h2 class="text-center py-3 px-4 mx-auto shadow-sm"
        style="color: black; max-width: 400px; margin-top: 2rem; margin-bottom: 2rem; border-radius: 15px; border: solid 2px; border-color: white;">
        Modificar Campaña
    </h2>
    <div class="container">
        <div class="col-12">
            <form method="post">
                <input type="hidden" name="id" value="<?= $_GET['id'] ?>">
                <?php
                include "../../controlador/campaña/modificar_campaña.php";
                
                if ($sql && pg_num_rows($sql) > 0) {
                    $datos = pg_fetch_object($sql);
                ?>
                    <div class="row mb-3">
                        <div class="col-6">
                            <label for="idempresa" class="form-label">Empresa:</label>
                            <select class="form-control" name="idempresa" id="idempresa" required>
                                <option value="">Seleccione una empresa</option>
                                <?php
                                $sql_empresas = pg_query($conexion, "SELECT id_empresa, nombre_empresa FROM empresa ORDER BY nombre_empresa");
                                while ($empresa = pg_fetch_assoc($sql_empresas)) {
                                    $selected = ($empresa['id_empresa'] == $datos->id_empresa) ? 'selected' : '';
                                    echo "<option value='{$empresa['id_empresa']}' $selected>{$empresa['nombre_empresa']}</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-6">
                            <label for="campaña" class="form-label">Nombre Campaña:</label>
                            <input type="text" class="form-control" id="campaña" placeholder="Nombre de la campaña" name="campaña" value="<?= htmlspecialchars($datos->nombre_campania) ?>" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="mb-3 col-6">
                            <label for="descripcion" class="form-label">Descripción:</label>
                            <textarea class="form-control" name="descripcion" id="descripcion" placeholder="Descripción..." rows="4" required><?= htmlspecialchars($datos->descripcion) ?></textarea>
                        </div>
                        <div class="mb-3 col-6">
                            <label for="fechainicio" class="form-label">Fecha Inicio:</label>
                            <input type="date" class="form-control" name="fechainicio" id="fechainicio" value="<?= $datos->fecha_inicio ?>" required>
                            
                            <label for="fechafin" class="form-label mt-3">Fecha Fin:</label>
                            <input type="date" class="form-control" name="fechafin" id="fechafin" value="<?= $datos->fecha_fin ?>" required>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center">
                        <button type="submit" class="btn btn-primary shadow py-2 px-4 fw-bold col-5" name="btnregistrar" value="ok">Actualizar</button>
                    </div>
                <?php
                } else {
                    echo '<div class="alert alert-danger">No se encontró la campaña</div>';
                }
                ?>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
// ============================================
// ARCHIVO: controlador/agente/registro_agente.php (CORREGIDO)
// ============================================
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!empty($_POST['btnregistrar']) && $_POST['btnregistrar'] === 'ok') {
    if (!empty($_POST['id_empleado']) && !empty($_POST['fecha']) && 
        !empty($_POST['entrada']) && !empty($_POST['salida']) && 
        !empty($_POST['observaciones'])) {

        $id_empleado = (int)$_POST['id_empleado'];
        $v_fecha = $_POST['fecha'];
        $v_entrada = $_POST['entrada'];
        $v_salida = $_POST['salida'];
        $v_observaciones = $_POST['observaciones'];
        
        $query = "INSERT INTO control_acceso (id_empleado, fecha, hora_entrada, hora_salida, observacion) 
                  VALUES ($1, $2, $3, $4, $5)";
        
        $result = pg_query_params($conexion, $query, 
            array($id_empleado, $v_fecha, $v_entrada, $v_salida, $v_observaciones));

        if ($result) {
            $_SESSION['mensaje'] = '<div class="alert-message alert-registro">¡Acceso registrado correctamente!</div>';
            echo '<div class="alert alert-success">Se guardó correctamente</div>';
        } else {
            $_SESSION['mensaje'] = '<div class="alert alert-danger">Error al registrar</div>';
            echo '<div class="alert alert-danger">Error al registrar: ' . pg_last_error($conexion) . '</div>';
        }
    } else {
        echo '<div class="alert alert-warning">Alguno de los campos está vacío</div>';
    }
}
?>