<?php
// ============================================
// CONFIGURACIÓN DE CONEXIÓN A SUPABASE
// ============================================

$host = "aws-1-us-east-2.pooler.supabase.com";
$port = "6543";
$dbname = "postgres";
$user = "postgres.cvekgtodqwwexjecpgea";
$password = "Cronoworks123456";

$conn_string = "host=$host port=$port dbname=$dbname user=$user password=$password sslmode=require";

$conexion = pg_connect($conn_string);

if (!$conexion) {
    die("❌ Error en la conexión a Supabase: " . pg_last_error());
}

pg_set_client_encoding($conexion, "UTF8");

// ============================================
// FUNCIONES AUXILIARES
// ============================================

function ejecutarQuery($query) {
    global $conexion;
    $result = pg_query($conexion, $query);
    
    if (!$result) {
        error_log("Error en query: " . pg_last_error($conexion));
        return false;
    }
    
    return $result;
}

function ejecutarQueryPreparada($query, $params = array()) {
    global $conexion;
    $stmt_name = "stmt_" . md5($query . microtime());
    
    $prepare_result = pg_prepare($conexion, $stmt_name, $query);
    
    if (!$prepare_result) {
        error_log("Error preparando query: " . pg_last_error($conexion));
        return false;
    }
    
    $result = pg_execute($conexion, $stmt_name, $params);
    
    if (!$result) {
        error_log("Error ejecutando query: " . pg_last_error($conexion));
        return false;
    }
    
    return $result;
}

function obtenerResultado($result) {
    return pg_fetch_assoc($result);
}

function obtenerTodosLosResultados($result) {
    return pg_fetch_all($result);
}

function obtenerNumeroFilas($result) {
    return pg_num_rows($result);
}

function obtenerFilasAfectadas($result) {
    return pg_affected_rows($result);
}

function escaparString($string) {
    global $conexion;
    return pg_escape_string($conexion, $string);
}

function cerrarConexion() {
    global $conexion;
    if ($conexion) {
        pg_close($conexion);
    }
}

// ============================================
// WRAPPER PARA COMPATIBILIDAD CON MYSQLI
// ============================================

class ConexionWrapper {
    private $conexion;
    
    public function __construct($conn) {
        $this->conexion = $conn;
    }
    
    // Simula mysqli->query() para queries seguras con pg_query_params
    public function query($sql) {
        // NO usar directamente - migrar a queries preparadas
        error_log("⚠️ Advertencia: usando query() sin preparar. Migrar a pg_query_params");
        return pg_query($this->conexion, $sql);
    }
}

$conexion_wrapper = new ConexionWrapper($conexion);
?>