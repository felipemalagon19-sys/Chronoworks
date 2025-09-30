<?php
// ============================================
// ARCHIVO: dompdf/reporte_pdf_acceso.php (VERSIÓN CORREGIDA)
// ============================================

// Verificar si se recibió el parámetro "fecha"
if (isset($_POST['fecha'])) 
    {
        ob_start(); // Importante: iniciar buffer antes de incluir archivos
        
        require_once __DIR__ . '/../modelo/Conexion.php';
        require_once __DIR__ . '/autoload.inc.php';

        use Dompdf\Dompdf;
        use Dompdf\Options;

        $fechaEspecifica = $_POST['fecha'];
        
        // Crear el objeto Dompdf
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', true);
        $dompdf = new Dompdf($options);

        // ✅ Query para PostgreSQL
        $sql = "SELECT 
            e.nombre as nombre_empleado,
            e.apellido as apellido_empleado,
            COALESCE(c.nombre_campania, 'Sin campaña') as campania,
            COALESCE(t.nombre_tarea, 'Sin tarea') as tarea,
            COALESCE(emp.nombre_empresa, 'Sin empresa') as empresa,
            ca.fecha as fecha_control,
            ca.hora_entrada,
            ca.hora_salida,
            ca.observacion
        FROM control_acceso ca
        JOIN empleados e ON ca.id_empleado = e.id_empleado
        LEFT JOIN tarea t ON e.id_empleado = t.id_empleado
        LEFT JOIN asignacion a ON t.id_tarea = a.id_tarea
        LEFT JOIN campania c ON a.id_campania = c.id_campania
        LEFT JOIN empresa emp ON c.id_empresa = emp.id_empresa
        WHERE ca.fecha = $1
        ORDER BY ca.hora_entrada";

        $result = pg_query_params($conexion, $sql, array($fechaEspecifica));

        if (!$result) {
            die("Error en la consulta: " . pg_last_error($conexion));
        }

        // Generar el contenido HTML para el PDF
        $html = '
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="UTF-8">
            <style>
                body { font-family: Arial, sans-serif; font-size: 10px; }
                h1 { text-align: center; color: #333; margin-bottom: 10px; }
                .info { text-align: center; margin-bottom: 20px; font-size: 11px; }
                table { width: 100%; border-collapse: collapse; margin-top: 20px; }
                th { background-color: #4CAF50; color: white; padding: 8px; text-align: left; font-size: 9px; }
                td { padding: 6px; border: 1px solid #ddd; font-size: 8px; }
                tr:nth-child(even) { background-color: #f2f2f2; }
                .no-data { text-align: center; padding: 20px; color: #666; }
            </style>
        </head>
        <body>
            <h1>Reporte de Control de Acceso</h1>
            <div class="info">
                <strong>Fecha:</strong> ' . htmlspecialchars(date('d/m/Y', strtotime($fechaEspecifica))) . '
            </div>
            <table>
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Campaña</th>
                        <th>Tarea</th>
                        <th>Empresa</th>
                        <th>H. Entrada</th>
                        <th>H. Salida</th>
                        <th>Observación</th>
                    </tr>
                </thead>
                <tbody>';

        if (pg_num_rows($result) > 0) {
            while ($row = pg_fetch_assoc($result)) {
                $html .= '<tr>
                            <td>' . htmlspecialchars($row['nombre_empleado']) . '</td>
                            <td>' . htmlspecialchars($row['apellido_empleado']) . '</td>
                            <td>' . htmlspecialchars($row['campania']) . '</td>
                            <td>' . htmlspecialchars($row['tarea']) . '</td>
                            <td>' . htmlspecialchars($row['empresa']) . '</td>
                            <td>' . htmlspecialchars($row['hora_entrada']) . '</td>
                            <td>' . htmlspecialchars($row['hora_salida']) . '</td>
                            <td>' . htmlspecialchars($row['observacion']) . '</td>
                        </tr>';
            }
        } else {
            $html .= '<tr><td colspan="8" class="no-data">No se encontraron registros para la fecha seleccionada.</td></tr>';
        }

        $html .= '</tbody>
            </table>
        </body>
        </html>';

        // Cargar el HTML en Dompdf
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        // Limpiar buffer y enviar el PDF
        ob_end_clean();
        $dompdf->stream("reporte_control_acceso_" . $fechaEspecifica . ".pdf", array("Attachment" => 0));
        exit();
        
    }else
 {
    // Mostrar formulario si no hay fecha
    ?>
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Generar Reporte de Control de Acceso</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
        <style>
            body {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                min-height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
            }
            .card {
                border-radius: 15px;
                box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            }
            .card-header {
                border-radius: 15px 15px 0 0 !important;
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header text-white py-4">
                            <h3 class="mb-0 text-center">
                                <i class="fas fa-file-pdf me-2"></i>
                                Generar Reporte de Control de Acceso
                            </h3>
                        </div>
                        <div class="card-body p-4">
                            <form action="" method="POST">
                                <div class="mb-4">
                                    <label for="fecha" class="form-label fw-bold">
                                        <i class="fas fa-calendar-alt me-2"></i>
                                        Seleccione la fecha:
                                    </label>
                                    <input type="date" 
                                           class="form-control form-control-lg" 
                                           id="fecha" 
                                           name="fecha" 
                                           required 
                                           max="<?= date('Y-m-d') ?>"
                                           value="<?= date('Y-m-d') ?>">
                                    <small class="text-muted">
                                        <i class="fas fa-info-circle"></i>
                                        Seleccione la fecha para generar el reporte
                                    </small>
                                </div>
                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-primary btn-lg">
                                        <i class="fas fa-file-pdf me-2"></i>
                                        Generar Reporte PDF
                                    </button>
                                    <a href="../vista/controlacceso/listacontrol.php" class="btn btn-outline-secondary">
                                        <i class="fas fa-arrow-left me-2"></i>
                                        Volver a Control de Acceso
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>
    </html>
    <?php
}
?>