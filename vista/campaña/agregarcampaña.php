<?php
session_start();
include_once "../../modelo/Conexion.php";
include "../../controlador/campaña/eliminar_campaña.php";
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Campaña</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../css/agregar.css">
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
        Agregar Campaña
    </h2>
    <div class="container">
        <div class="col-12">
            <form method="post">
                <?php
                include "../../controlador/campaña/registro_campaña.php";
                ?>
                <div class="row mb-3">
                    <div class="col-6">
                        <label for="idempresa" class="form-label">Empresa:</label>
                        <select class="form-control" name="idempresa" id="idempresa" required>
                            <option value="">Seleccione una empresa</option>
                            <?php
                            // CORREGIDO: Usar pg_query
                            $sql_empresas = pg_query($conexion, "SELECT id_empresa, nombre_empresa FROM empresa ORDER BY nombre_empresa");
                            while ($empresa = pg_fetch_assoc($sql_empresas)) {
                                echo "<option value='{$empresa['id_empresa']}'>{$empresa['nombre_empresa']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-6">
                        <label for="campaña" class="form-label">Nombre Campaña:</label>
                        <input type="text" class="form-control" id="campaña" placeholder="Nombre de la campaña" name="campaña" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="mb-3 col-6">
                        <label for="descripcion" class="form-label">Descripción:</label>
                        <textarea class="form-control" name="descripcion" id="descripcion" placeholder="Descripción..." required></textarea>
                    </div>
                    <div class="mb-3 col-6">
                        <label for="fechainicio" class="form-label">Fecha Inicio:</label>
                        <input type="date" class="form-control" name="fechainicio" id="fechainicio" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="mb-3 col-6">
                        <label for="fechafin" class="form-label">Fecha Fin:</label>
                        <input type="date" class="form-control" name="fechafin" id="fechafin" required>
                    </div>
                </div>
                <div class="d-flex justify-content-center">
                    <button type="submit" class="btn btn-light fw-semibold w-100 mt-4 shadow-sm mb-4" name="btnregistrar" value="ok">Registrar</button>
                </div>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/main.js"></script>
</body>

</html>