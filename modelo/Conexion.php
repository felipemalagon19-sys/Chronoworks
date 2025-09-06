<?php
$servidor = "localhost";
$usuario = "root";
$contrasena = "";
$db = "chronoworks";
$puerto = 3306;

$conexion = new mysqli($servidor, $usuario, $contrasena, $db, $puerto);
$conexion->set_charset("utf8");

if ($conexion->connect_error) {
    die("Falla en la conexión: " . $conexion->connect_error);
}


    