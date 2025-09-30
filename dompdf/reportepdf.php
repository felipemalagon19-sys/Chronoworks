<?php
// ============================================
// ARCHIVO: dompdf/reportepdf.php (CORREGIDO PARA POSTGRESQL)
// ============================================
ob_start();

// Incluir Dompdf
require_once '../dompdf/autoload.inc.php';
use Dompdf\Dompdf;
use Dompdf\Options;

// Incluir conexión
require_once '../modelo/Conexion.php';

// Configuración de Dompdf
$options = new Options();
$options->set('isHtml5ParserEnabled', true);
$options->set('isPhpEnabled', true);
$dompdf = new Dompdf($options);

// ✅ CORREGIDO: Consulta adaptada para PostgreSQL
// Nota: En PostgreSQL no hay CALL para procedimientos, usamos funciones o queries directas
$sql = "SELECT 
    c.nombre_campania as \"Campaña\",
    t.nombre_tarea as \"Tarea\",
    a.fecha as \"Fecha_Asignacion\",
    a.observaciones as \"Observaciones\",
    e.nombre_empresa as \"Empresa\"
FROM asignacion a
JOIN tarea t ON a.id_tarea = t.id_tarea
JOIN campania c ON a.id_campania = c.id_campania
JOIN empresa e ON c.id_empresa = e.id_empresa
ORDER BY a.fecha DESC";

$result = pg_query($conexion, $sql);

// Generar HTML
$html = '<h1 style="text-align: center;">Reporte de Asignaciones</h1>';
$html .= '<table border="1" cellspacing="0" cellpadding="5" style="width: 100%; margin-top: 20px;">';
$html .= '<thead>
            <tr>
                <th>Campaña</th>
                <th>Tarea</th>
                <th>Fecha Asignación</th>
                <th>Observaciones</th>
                <th>Empresa</th>
            </tr>
          </thead>
          <tbody>';

if ($result && pg_num_rows($result) > 0) {
    while ($row = pg_fetch_assoc($result)) {
        $html .= '<tr>
                    <td>' . htmlspecialchars($row['Campaña']) . '</td>
                    <td>' . htmlspecialchars($row['Tarea']) . '</td>
                    <td>' . htmlspecialchars($row['Fecha_Asignacion']) . '</td>
                    <td>' . htmlspecialchars($row['Observaciones']) . '</td>
                    <td>' . htmlspecialchars($row['Empresa']) . '</td>
                  </tr>';
    }
} else {
    $html .= '<tr><td colspan="5">No hay datos disponibles</td></tr>';
}

$html .= '</tbody></table>';

// Cargar HTML en Dompdf
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();

// Enviar el PDF
header("Content-Type: application/pdf");
ob_end_clean();
$dompdf->stream("reporte_asignaciones.pdf", array("Attachment" => 0));
?>