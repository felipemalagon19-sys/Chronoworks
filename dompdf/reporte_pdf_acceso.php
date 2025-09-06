<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generar Reporte</title>
</head>
<body>
    <h1>Generar Reporte de Control de Acceso</h1>
    <form action="reporte_pdf_acceso.php" method="POST">
        <label for="fecha">Ingrese la fecha:</label>
        <input type="date" id="fecha" name="fecha" required>
        <button type="submit">Generar PDF</button>
    </form>
</body>
</html>


<?php
// Incluir conexión a la base de datos y la librería Dompdf
require_once '../modelo/conexion.php'; // Ajusta la ruta si es necesario
require_once '../dompdf/autoload.inc.php';

use Dompdf\Dompdf;
use Dompdf\Options;

// Verificar si se recibió el parámetro "fecha"
if (isset($_POST['fecha'])) {
    $fechaEspecifica = $_POST['fecha']; // Obtener la fecha desde el formulario
    
    // Crear el objeto Dompdf
    $options = new Options();
    $options->set('isHtml5ParserEnabled', true);
    $options->set('isPhpEnabled', true);
    $dompdf = new Dompdf($options);

    // Llamar al procedimiento almacenado
    $sql = "CALL ObtenerControlAccesoPorFecha(?)";
    $stmt = $conexion->prepare($sql);
    if (!$stmt) {
        die("Error al preparar la consulta: " . $conexion->error);
    }
    $stmt->bind_param('s', $fechaEspecifica);
    $stmt->execute();
    $result = $stmt->get_result();

    // Generar el contenido HTML para el PDF
    $html = '<h1 style="text-align: center;">Reporte de Control de Acceso</h1>';
    $html .= '<p>Fecha: ' . $fechaEspecifica . '</p>';
    $html .= '<table border="1" cellspacing="0" cellpadding="5" style="width: 100%; margin-top: 20px;">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Campaña</th>
                        <th>Tarea</th>
                        <th>Empresa</th>
                        <th>Fecha de Control</th>
                        <th>Hora Entrada</th>
                        <th>Hora Salida</th>
                        <th>Observacion</th>
                        
                    </tr>
                </thead>
                <tbody>';

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $html .= '<tr>
                        <td>' . $row['Nombre_Empleado'] . '</td>
                        <td>' . $row['Apellido_Empleado'] . '</td>
                        <td>' . $row['Campaña'] . '</td>
                        <td>' . $row['Tarea'] . '</td>
                        <td>' . $row['Empresa'] . '</td>
                        <td>' . $row['Fecha_Control'] . '</td>
                        <td>' . $row['Hora_Entrada'] . '</td>
                        <td>' . $row['Hora_Salida'] . '</td>
                        <td>' . $row['Observacion'] . '</td>
                      </tr>';
        }
    } else {
        $html .= '<tr><td colspan="6">No se encontraron datos para la fecha proporcionada.</td></tr>';
    }

    $html .= '</tbody></table>';

    // Cargar el HTML en Dompdf
    $dompdf->loadHtml($html);

    // Configurar tamaño y orientación del PDF
    $dompdf->setPaper('A4', 'landscape');

    // Renderizar el PDF
    $dompdf->render();

    // Enviar el PDF al navegador
    ob_end_clean();
    $dompdf->stream("reporte_control_acceso.pdf", array("Attachment" => 0));

    // Cerrar statement y conexión
    $stmt->close();
    $conexion->close();
} else {
    echo "No se proporcionó una fecha.";
}
?>
