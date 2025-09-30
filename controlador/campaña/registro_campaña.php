<?php
// NO usar session_start() aquí si ya se inicia en la vista

if (!empty($_POST["btnregistrar"]) && $_POST["btnregistrar"] === "ok") {
    if (!empty($_POST["idempresa"]) && !empty($_POST["campaña"]) && 
        !empty($_POST["descripcion"]) && !empty($_POST["fechainicio"]) && 
        !empty($_POST["fechafin"])) {

        $id_empresa = $_POST["idempresa"];
        $nombre_campania = $_POST["campaña"];
        $descripcion = $_POST["descripcion"];
        $fecha_inicio = $_POST["fechainicio"];
        $fecha_fin = $_POST["fechafin"];

        // CORREGIDO: Usar pg_query_params en lugar de $conexion->query()
        $sql = pg_query_params(
            $conexion,
            "INSERT INTO campania (id_empresa, nombre_campania, descripcion, fecha_inicio, fecha_fin) 
             VALUES ($1, $2, $3, $4, $5)",
            array($id_empresa, $nombre_campania, $descripcion, $fecha_inicio, $fecha_fin)
        );

        if ($sql && pg_affected_rows($sql) > 0) {
            $_SESSION['mensaje'] = '<div class="alert-message alert-registro">¡Campaña registrada correctamente!</div>';
            header("Location: listacampaña.php");
            exit();
        } else {
            $_SESSION['mensaje'] = '<div class="alert alert-danger">Error al registrar campaña: ' . pg_last_error($conexion) . '</div>';
            header("Location: listacampaña.php");
            exit();
        }
    } else {
        echo '<div class="alert alert-warning">Alguno de los campos está vacío, por favor diligencie todos los datos.</div>';
    }
}
?>