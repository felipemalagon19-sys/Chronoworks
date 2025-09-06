<?php
ob_start();

// Incluir Dompdf
require_once '../dompdf/autoload.inc.php';
use Dompdf\Dompdf;
use Dompdf\Options;

// Incluir conexión
require_once '../modelo/conexion.php';

// Configuración de Dompdf
$options = new Options();
$options->set('isHtml5ParserEnabled', true);
$options->set('isPhpEnabled', true);
$dompdf = new Dompdf($options);

// Procedimiento almacenado
$sql = "CALL ObtenerReporteTareasCampaña()";
$result = $conexion->query($sql);

// Generar HTML
$html = '<h1 style="text-align: center;">Reporte de Clientes</h1>';
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

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
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
$conexion->close();

// Cargar HTML en Dompdf
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();

// Enviar el PDF
header("Content-Type: application/pdf");
ob_end_clean();
$dompdf->stream("reporte_clientes.pdf", array("Attachment" => 0));
?>
