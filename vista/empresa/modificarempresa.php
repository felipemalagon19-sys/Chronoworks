<?php
include "../../modelo/Conexion.php";
$id = $_GET['id'];
$sql = $conexion->query("select * from Empresa where ID_Empresa=$id")

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Modificar Empresa </title>
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
        Modificar Empresa
    </h2>
    <div class="container">
        <div class="col-12">
            <form method="post">
                <input type="hidden" name="id" value="<?= $_GET["id"] ?>">
                <?php

                include "../../controlador/empresa/modificar_empresa.php";
                while ($datos = $sql->fetch_object()) { ?>

                    <div class="row mb-3">
                        <div class="mb-3 col-6">
                            <label for="idtarea" class="form-label">ID de Empresa:</label>
                            <input type="number" class="form-control" id="idempresa" placeholder="Ingrese ID" name="ID_Empresa" value="<?= $datos->ID_Empresa ?>">
                        </div>
                        <div class="mb-3 col-6">
                            <label for="idcampaña" class="form-label">Nombre de la Empresa:</label>
                            <input type="TEXT" class="form-control" id="nombreempresa" placeholder="Ingrese nombre de empresa" name="Nombre_Empresa" value="<?= $datos->Nombre_Empresa ?>">
                        </div>
                        <div class="mb-3 col-6">
                            <label for="fechaasignacion" class="form-label">Nit de Empresa:</label>
                            <input type="number" class="form-control" name="Nit_Empresa" id="Nit_Empresa" value="<?= $datos->Nit_Empresa ?>">
                        </div>
                        <div class="mb-3 col-6">
                            <label for="observaciones" class="form-label"> Direccion:</label>
                            <input class="form-control" name="Direccion" id="Direccion" placeholder="Direccion de empresa" value="<?= $datos->Dirección ?>"></input>
                        </div>
                        <div class="mb-3 col-6">
                            <label for="observaciones" class="form-label"> Telefono:</label>
                            <input type="text" class="form-control" name="Telefono" id="Telefono" placeholder="Telefono de la empresa" value="<?= $datos->Teléfono ?>"></input>
                        </div>
                        <div class="mb-3 col-6">
                            <label for="observaciones" class="form-label"> Sector:</label>
                            <input type="text" class="form-control" name="Sector" id="Sector" placeholder="Sector" value="<?= $datos->Sector ?>"></input>
                        </div>
                        <div class="mb-3 col-6 m-auto">
                            <label for="observaciones" class="form-label"> Encargado:</label>
                            <input type="Text" class="form-control" name="Encargado" id="Encargado" placeholder="Encargado de la empresa" value="<?= $datos->Encargado ?>"></input>
                        </div>
                    </div>
                <?php }
                ?>
                <div class="d-flex justify-content-center">
                    <button type="submit" class="btn btn-primary shadow py-2 px-4 fw-bold col-5" name="btnregistrar" value="ok">Modificar Empresa </button>
                </div>
            </form>
        </div>
    </div>
</body>