<?php
// ============================================
// CONFIGURACIÓN DE CONEXIÓN A SUPABASE
// ============================================

$host = "aws-1-us-east-2.pooler.supabase.com";
$port = "6543";
$dbname = "postgres";
$user = "postgres.cvekgtodqwwexjecpgea";
$password = "Cronoworks123456"; // ⚠️ REEMPLAZA con tu contraseña real de Supabase

// Cadena de conexión para PostgreSQL con SSL requerido
$conn_string = "host=$host port=$port dbname=$dbname user=$user password=$password sslmode=require";

// Crear conexión
$conexion = pg_connect($conn_string);

// Verificar conexión
if (!$conexion) {
    die("❌ Error en la conexión a Supabase: " . pg_last_error());
}

// Configurar codificación UTF-8
pg_set_client_encoding($conexion, "UTF8");

// ============================================
// FUNCIONES AUXILIARES PARA TRABAJAR CON PostgreSQL
// ============================================

/**
 * Ejecuta una query simple
 */
function ejecutarQuery($query) {
    global $conexion;
    $result = pg_query($conexion, $query);
    
    if (!$result) {
        error_log("Error en query: " . pg_last_error($conexion));
        return false;
    }
    
    return $result;
}

/**
 * Ejecuta una query preparada (más segura)
 * Ejemplo: ejecutarQueryPreparada("SELECT * FROM usuarios WHERE email = $1", array($email))
 */
function ejecutarQueryPreparada($query, $params = array()) {
    global $conexion;
    
    // Generar nombre único para la consulta preparada
    $stmt_name = "stmt_" . md5($query . microtime());
    
    // Preparar la consulta
    $prepare_result = pg_prepare($conexion, $stmt_name, $query);
    
    if (!$prepare_result) {
        error_log("Error preparando query: " . pg_last_error($conexion));
        return false;
    }
    
    // Ejecutar la consulta preparada
    $result = pg_execute($conexion, $stmt_name, $params);
    
    if (!$result) {
        error_log("Error ejecutando query: " . pg_last_error($conexion));
        return false;
    }
    
    return $result;
}

/**
 * Obtiene un resultado (similar a fetch_assoc de mysqli)
 */
function obtenerResultado($result) {
    return pg_fetch_assoc($result);
}

/**
 * Obtiene todos los resultados
 */
function obtenerTodosLosResultados($result) {
    return pg_fetch_all($result);
}

/**
 * Obtiene el número de filas de un resultado
 */
function obtenerNumeroFilas($result) {
    return pg_num_rows($result);
}

/**
 * Obtiene el número de filas afectadas por un INSERT, UPDATE o DELETE
 */
function obtenerFilasAfectadas($result) {
    return pg_affected_rows($result);
}

/**
 * Escapa un string para seguridad (previene SQL injection)
 */
function escaparString($string) {
    global $conexion;
    return pg_escape_string($conexion, $string);
}

/**
 * Cierra la conexión
 */
function cerrarConexion() {
    global $conexion;
    if ($conexion) {
        pg_close($conexion);
    }
}

/**
 * Clase auxiliar para simular el comportamiento de mysqli
 * (facilita la migración de tu código existente)
 */
class ConexionWrapper {
    private $conexion;
    
    public function __construct($conn) {
        $this->conexion = $conn;
    }
    
    public function query($sql) {
        return pg_query($this->conexion, $sql);
    }
    
    public function prepare($sql) {
        // Convertir ? a $1, $2, $3, etc.
        $count = 0;
        $sql_converted = preg_replace_callback('/\?/', function($matches) use (&$count) {
            $count++;
            return '$' . $count;
        }, $sql);
        
        return new PreparedStatementWrapper($this->conexion, $sql_converted);
    }
}

class PreparedStatementWrapper {
    private $conexion;
    private $query;
    private $stmt_name;
    private $params = array();
    
    public function __construct($conn, $query) {
        $this->conexion = $conn;
        $this->query = $query;
        $this->stmt_name = "stmt_" . md5($query . microtime());
        pg_prepare($this->conexion, $this->stmt_name, $query);
    }
    
    public function bind_param($types, ...$vars) {
        $this->params = $vars;
    }
    
    public function execute() {
        return pg_execute($this->conexion, $this->stmt_name, $this->params);
    }
    
    public function get_result() {
        $result = pg_execute($this->conexion, $this->stmt_name, $this->params);
        return new ResultWrapper($result);
    }
    
    public function close() {
        // PostgreSQL maneja esto automáticamente
    }
}

class ResultWrapper {
    private $result;
    
    public function __construct($result) {
        $this->result = $result;
    }
    
    public function num_rows() {
        return pg_num_rows($this->result);
    }
    
    public function fetch_assoc() {
        return pg_fetch_assoc($this->result);
    }
    
    public function fetch_row() {
        return pg_fetch_row($this->result);
    }
}

// Crear wrapper para compatibilidad con código mysqli existente
$conexion_wrapper = new ConexionWrapper($conexion);
?>