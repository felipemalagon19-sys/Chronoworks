<?php 
include "../../modelo/Conexion.php";
include "../../controlador/asignacion/eliminar_asignacion.php";
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Agregar Asignacion </title>
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
                        <a href="../../admin.php" class="botoninicio">Inicio</a>
                    </div>
                </nav>
            </div>
        </div>
    </header>
    <h2 class="text-center py-3 px-4 mx-auto shadow-sm"
        style="color: black; max-width: 400px; margin-top: 2rem; margin-bottom: 2rem; border-radius: 15px; border: solid 2px; border-color: white;">
        Agregar Asignación
    </h2>
    <div class="container">
        <div class="col-12">
            <form method="post">
                <?php
                include "../../controlador/asignacion/registro_asignacion.php";
                ?>
                <div class="row mb-3">
                    <div class="col-6">
                        <label for="idtarea" class="form-label">ID de la tarea:</label>
                        <input type="number" class="form-control" id="idtarea" placeholder="Ingrese ID" name="idtarea">
                    </div>
                    <div class="col-6">
                        <label for="idcampaña" class="form-label">ID de la campaña:</label>
                        <input type="number" class="form-control" id="idcampaña" placeholder="Ingrese ID" name="idcampaña">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="mb-3 col-6">
                        <label for="fechaasignacion" class="form-label">Fecha de Asignación:</label>
                        <input type="date" class="form-control" name="fechaasignacion" id="fechaasignacion">
                    </div>
                    <div class="mb-3 col-6">
                        <label for="observaciones" class="form-label"> Observaciones:</label>
                        <textarea class="form-control" name="observaciones" id="observaciones" placeholder="Observaciones..."></textarea>
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