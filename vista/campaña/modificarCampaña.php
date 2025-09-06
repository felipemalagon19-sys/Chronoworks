<?php
include "../../modelo/Conexion.php";

$id = $_GET["id"];
$sql = $conexion->query("select * from campaña where ID_Campaña=$id ")
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Modificar Asignacion </title>
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
    <h2 class="text-center py-3 px-4 mx-auto shadow-sm"
        style="color: black; max-width: 400px; margin-top: 2rem; margin-bottom: 2rem; border-radius: 15px; border: solid 2px; border-color: white;">
        Modificar Campaña
    </h2>
    <div class="container">
        <div class="col-12">
            <form method="post">
                <input type="hidden" name="id" value="<?= $_GET["id"] ?>">
                <?php
                include "../../controlador/campaña/modificar_campaña.php";
                while ($datos = $sql->fetch_object()) { ?>
                    <div class="row mb-3">
                        <div class="col-5">
                            <label for="idempresa" class="form-label">ID empresa:</label>
                            <input type="number" class="form-control" id="idempresa" placeholder="ID de empresa" name="idempresa" value="<?= $datos->ID_Empresa ?>">
                        </div>
                        <div class="col-7">
                            <label for="campaña" class="form-label">Nombre de Campaña:</label>
                            <input type="text" class="form-control" id="campaña" placeholder="Nombre de la campaña" name="campaña" value="<?= $datos->Nombre_Campaña ?>">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-5">
                            <label for="descripcion" class="form-label">Descripción:</label>
                            <textarea class="form-control" name="descripcion" id="descripcion" placeholder="Descripción" rows="4"><?= $datos->Descripción ?></textarea>
                        </div>
                        <div class="col-7">
                            <div class="mb-3">
                                <label for="fechainicio" class="form-label">Fecha de Inicio:</label>
                                <input type="date" class="form-control" name="fechainicio" id="fechainicio" value="<?= $datos->Fecha_Inicio ?>">
                            </div>
                            <div class="mb-3">
                                <label for="fechafin" class="form-label">Fecha de Fin:</label>
                                <input type="date" class="form-control" name="fechafin" id="fechafin" value="<?= $datos->Fecha_Fin ?>">
                            </div>
                        </div>
                    </div>
                <?php } ?>
                <div class="d-flex justify-content-center">
                    <button type="submit" class="btn btn-warning shadow py-2 px-4 fw-bold opacity-75" name="btnregistrar" value="ok">Actualizar</button>
                </div>
            </form>
        </div>
    </div>

</body>

</html>