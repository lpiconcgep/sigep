<?php
// -------------------------------------------------------------
// estudiantes.php - CON ESTILOS SIGEP MEJORADOS
// -------------------------------------------------------------

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include "../utilidades.php";
include "../funciones.php";
include "../conexion.php";

// ============================================
// FUNCIÓN PARA GENERAR PDF MEJORADO
// ============================================
function generar_pdf_estudiantes($anio, $programa, $facultad, $rows) {
    global $con;
    
    // Incluir TCPDF
    $tcpdf_path = __DIR__ . '/../../libs/TCPDF/tcpdf.php';
    if (!file_exists($tcpdf_path)) {
        die("Error: no se encontró TCPDF");
    }
    require_once $tcpdf_path;

    if (ob_get_length()) {
        ob_end_clean();
    }

    // Crear PDF en formato horizontal
    $pdf = new TCPDF('L', 'mm', 'A4', true, 'UTF-8', false);
    
    // Configuración del documento
    $pdf->SetCreator('SIGEP');
    $pdf->SetAuthor('SIGEP');
    $pdf->SetTitle('Reporte de Estudiantes');
    
    // Configurar márgenes
    $pdf->SetMargins(15, 20, 15);
    $pdf->SetHeaderMargin(5);
    $pdf->SetFooterMargin(10);
    
    // Agregar página
    $pdf->AddPage();
    
    // ============================================
    // HEADER
    // ============================================
    $pdf->SetFont('helvetica', 'B', 18);
    $pdf->SetTextColor(30, 30, 30);
    $pdf->Cell(0, 15, 'REPORTE DE ESTUDIANTES', 0, 1, 'C');
    
    // Línea decorativa
    $pdf->SetDrawColor(76, 175, 80); // Verde SIGEP
    $pdf->SetLineWidth(0.5);
    $pdf->Line(15, 35, 280, 35);
    $pdf->Ln(5);
    
    // ============================================
    // INFORMACIÓN DE FILTROS
    // ============================================
    $pdf->SetFont('helvetica', 'B', 10);
    $pdf->SetTextColor(60, 60, 60);
    $pdf->Cell(0, 6, 'Filtros aplicados:', 0, 1, 'L');
    
    $pdf->SetFont('helvetica', '', 9);
    $pdf->SetTextColor(80, 80, 80);
    
    if ($facultad) {
        $sql_fac = "SELECT nombre FROM facultad_nucleo WHERE id = $facultad";
        $res_fac = mysqli_query($con, $sql_fac);
        $facultad_nombre = ($res_fac && $row_fac = mysqli_fetch_assoc($res_fac)) ? $row_fac['nombre'] : 'Desconocida';
        $pdf->Cell(0, 5, '• Facultad: ' . $facultad_nombre, 0, 1, 'L');
    }
    
    if ($programa) {
        $sql_prog = "SELECT nombre FROM programa WHERE id = $programa";
        $res_prog = mysqli_query($con, $sql_prog);
        $programa_nombre = ($res_prog && $row_prog = mysqli_fetch_assoc($res_prog)) ? $row_prog['nombre'] : 'Desconocido';
        $pdf->Cell(0, 5, '• Programa: ' . $programa_nombre, 0, 1, 'L');
    }
    
    if ($anio) {
        $pdf->Cell(0, 5, '• Año: ' . $anio, 0, 1, 'L');
    }
    
    if (!$facultad && !$programa && !$anio) {
        $pdf->Cell(0, 5, '• Sin filtros (todos los estudiantes)', 0, 1, 'L');
    }
    
    $pdf->Ln(5);
    
    // ============================================
    // TABLA DE DATOS
    // ============================================
    
    // Calcular anchos
    $ancho_total = 265;
    $ancho_col1 = 30;   // Documento
    $ancho_col2 = 50;   // Apellidos
    $ancho_col3 = 50;   // Nombres
    $ancho_col4 = 70;   // Programa
    $ancho_col5 = 30;   // Fecha Nac.
    $ancho_col6 = 35;   // Fecha Ingreso
    
    // Verificar que la suma no exceda el ancho total
    $suma_anchos = $ancho_col1 + $ancho_col2 + $ancho_col3 + $ancho_col4 + $ancho_col5 + $ancho_col6;
    if ($suma_anchos > $ancho_total) {
        $factor = $ancho_total / $suma_anchos;
        $ancho_col1 = round($ancho_col1 * $factor);
        $ancho_col2 = round($ancho_col2 * $factor);
        $ancho_col3 = round($ancho_col3 * $factor);
        $ancho_col4 = round($ancho_col4 * $factor);
        $ancho_col5 = round($ancho_col5 * $factor);
        $ancho_col6 = round($ancho_col6 * $factor);
    }
    
    // Posición X para centrar la tabla
    $tabla_x = (297 - ($ancho_col1 + $ancho_col2 + $ancho_col3 + $ancho_col4 + $ancho_col5 + $ancho_col6)) / 2;
    $pdf->SetX($tabla_x);
    
    // Encabezado de tabla
    $pdf->SetFillColor(76, 175, 80); // Verde SIGEP
    $pdf->SetTextColor(255, 255, 255);
    $pdf->SetFont('helvetica', 'B', 9);
    $pdf->SetDrawColor(200, 200, 200);
    
    $pdf->Cell($ancho_col1, 8, 'Documento', 1, 0, 'C', true);
    $pdf->Cell($ancho_col2, 8, 'Apellidos', 1, 0, 'C', true);
    $pdf->Cell($ancho_col3, 8, 'Nombres', 1, 0, 'C', true);
    $pdf->Cell($ancho_col4, 8, 'Programa', 1, 0, 'C', true);
    $pdf->Cell($ancho_col5, 8, 'Fecha Nac.', 1, 0, 'C', true);
    $pdf->Cell($ancho_col6, 8, 'Fecha Ingreso', 1, 1, 'C', true);
    
    // Restaurar colores para las filas
    $pdf->SetFillColor(245, 245, 245);
    $pdf->SetTextColor(60, 60, 60);
    $pdf->SetFont('helvetica', '', 8);
    
    $fill = false;
    $total_estudiantes = count($rows);
    
    if ($total_estudiantes > 0) {
        foreach ($rows as $row) {
            $fill = !$fill;
            $pdf->SetX($tabla_x);
            
            // Formatear fechas
            $fecha_nac = isset($row['fecha_nacimiento']) ? transforma_fecha($row['fecha_nacimiento']) : '';
            $fecha_ing = isset($row['fecha_ingreso']) ? transforma_fecha($row['fecha_ingreso']) : '';
            
            // Truncar texto si es muy largo
            $apellidos = strlen($row['apellidos']) > 25 ? substr($row['apellidos'], 0, 23) . '...' : $row['apellidos'];
            $nombres = strlen($row['nombres']) > 25 ? substr($row['nombres'], 0, 23) . '...' : $row['nombres'];
            $programa_txt = strlen($row['programa']) > 45 ? substr($row['programa'], 0, 42) . '...' : $row['programa'];
            
            $pdf->Cell($ancho_col1, 7, htmlspecialchars($row['documento_identidad']), 1, 0, 'C', $fill);
            $pdf->Cell($ancho_col2, 7, htmlspecialchars($apellidos), 1, 0, 'L', $fill);
            $pdf->Cell($ancho_col3, 7, htmlspecialchars($nombres), 1, 0, 'L', $fill);
            $pdf->Cell($ancho_col4, 7, htmlspecialchars($programa_txt), 1, 0, 'L', $fill);
            $pdf->Cell($ancho_col5, 7, $fecha_nac, 1, 0, 'C', $fill);
            $pdf->Cell($ancho_col6, 7, $fecha_ing, 1, 1, 'C', $fill);
        }
        
        // Fila de total
        $pdf->SetX($tabla_x);
        $pdf->SetFont('helvetica', 'B', 9);
        $pdf->SetFillColor(220, 220, 220);
        $pdf->Cell($ancho_col1 + $ancho_col2 + $ancho_col3 + $ancho_col4, 7, 'TOTAL ESTUDIANTES:', 1, 0, 'R', true);
        $pdf->Cell($ancho_col5 + $ancho_col6, 7, $total_estudiantes, 1, 1, 'C', true);
        
    } else {
        $pdf->SetX($tabla_x);
        $pdf->Cell($ancho_total, 10, 'No se encontraron estudiantes para los filtros seleccionados', 1, 1, 'C', true);
    }
    
    // ============================================
    // PIE DE PÁGINA
    // ============================================
    $pdf->Ln(5);
    $pdf->SetFont('helvetica', 'I', 7);
    $pdf->SetTextColor(120, 120, 120);
    $pdf->Cell(0, 4, 'Documento generado por SIGEP - ' . date('d/m/Y H:i:s'), 0, 1, 'R');
    $pdf->Cell(0, 4, 'Página ' . $pdf->getAliasNumPage() . ' de ' . $pdf->getAliasNbPages(), 0, 1, 'R');
    
    // ============================================
    // SALIDA DEL PDF
    // ============================================
    $pdf->Output("reporte_estudiantes.pdf", 'I');
    exit;
}

// ============================================
// FIN DE LA FUNCIÓN PDF
// ============================================

// Filtros seleccionados
$anio = isset($_GET['anio']) && $_GET['anio'] !== '' && is_numeric($_GET['anio']) ? intval($_GET['anio']) : null;
$programa = isset($_GET['programa']) && $_GET['programa'] !== '' && is_numeric($_GET['programa']) ? intval($_GET['programa']) : null;
$facultad = isset($_GET['facultad']) && $_GET['facultad'] !== '' && is_numeric($_GET['facultad']) ? intval($_GET['facultad']) : null;

// Obtener lista de facultades
$facultades_obj = consultar_facultades();
$facultades = is_array($facultades_obj) ? $facultades_obj : [];

// Obtener lista de programas FILTRADA POR FACULTAD
$sqlProgramas = "SELECT p.id, p.nombre 
                 FROM programa p
                 INNER JOIN postgrado pg ON p.postgrado_id = pg.id";

if ($facultad !== null && $facultad !== '') {
    $sqlProgramas .= " WHERE pg.facultad_nucleo_id = $facultad";
}

$sqlProgramas .= " ORDER BY p.nombre ASC";

$resProgramas = mysqli_query($con, $sqlProgramas);
if (!$resProgramas) {
    // Si hay error, intentamos sin filtro
    $sqlProgramas = "SELECT id, nombre FROM programa ORDER BY nombre ASC";
    $resProgramas = mysqli_query($con, $sqlProgramas);
}
$programas = [];
while ($p = mysqli_fetch_assoc($resProgramas)) {
    $programas[] = $p;
}

// Obtener años disponibles (filtrados por programa o facultad)
$sqlAnios = "SELECT DISTINCT YEAR(e.fecha_ingreso) AS anio 
             FROM estudiante_programa e
             INNER JOIN programa p ON e.programa_id = p.id";

if ($programa !== null) {
    $sqlAnios .= " WHERE e.programa_id = $programa";
} elseif ($facultad !== null && $facultad !== '') {
    $sqlAnios .= " INNER JOIN postgrado pg ON p.postgrado_id = pg.id 
                   WHERE pg.facultad_nucleo_id = $facultad";
}

$sqlAnios .= " ORDER BY anio DESC"; // Orden descendente (más reciente primero)

$resAnios = mysqli_query($con, $sqlAnios);
if (!$resAnios) {
    // Si hay error, obtenemos todos los años
    $resAnios = mysqli_query($con, "SELECT DISTINCT YEAR(fecha_ingreso) AS anio FROM estudiante_programa ORDER BY anio DESC");
}
$anios = [];
while ($r = mysqli_fetch_assoc($resAnios)) {
    $anios[] = $r['anio'];
}

// ============================================
// CONSULTA PRINCIPAL
// ============================================
$programas_facultad = [];
if (isset($facultad) && $facultad !== null && $facultad !== '') {
    // Obtener los postgrados de la facultad
    $sql_postgrados = "SELECT id FROM postgrado WHERE facultad_nucleo_id = $facultad";
    $res_postgrados = mysqli_query($con, $sql_postgrados);
    
    if ($res_postgrados && mysqli_num_rows($res_postgrados) > 0) {
        $postgrados_ids = [];
        while ($row = mysqli_fetch_assoc($res_postgrados)) {
            $postgrados_ids[] = $row['id'];
        }
        $postgrados_str = implode(',', $postgrados_ids);
        
        // Obtener los programas de esos postgrados
        $sql_programas2 = "SELECT id FROM programa WHERE postgrado_id IN ($postgrados_str)";
        $res_programas2 = mysqli_query($con, $sql_programas2);
        
        if ($res_programas2) {
            while ($row = mysqli_fetch_assoc($res_programas2)) {
                $programas_facultad[] = $row['id'];
            }
        }
    }
}

// Consulta principal
$sql = "SELECT 
            p.documento_identidad,
            CONCAT_WS(' ', p.primer_apellido, p.segundo_apellido) AS apellidos,
            CONCAT_WS(' ', p.primer_nombre, p.segundo_nombre) AS nombres,
            pr.nombre AS programa,
            e.fecha_ingreso, 
            p.fecha_nacimiento as fecha_nacimiento
        FROM estudiante_programa e
        INNER JOIN persona p ON p.id = e.persona_id
        INNER JOIN programa pr ON pr.id = e.programa_id
        WHERE 1=1";

$params = [];
$types = "";

if (isset($anio) && $anio !== null) {
    $sql .= " AND YEAR(e.fecha_ingreso) = ?";
    $params[] = $anio;
    $types .= "i";
}
if (isset($programa) && $programa !== null) {
    $sql .= " AND e.programa_id = ?";
    $params[] = $programa;
    $types .= "i";
}
// Si hay filtro de facultad y encontramos programas
if (!empty($programas_facultad)) {
    $ids_string = implode(',', $programas_facultad);
    $sql .= " AND e.programa_id IN ($ids_string)";
}

$sql .= " ORDER BY e.fecha_ingreso DESC, p.primer_apellido ASC, p.primer_nombre ASC"; // Orden descendente por fecha

// Ejecutar consulta
if (!empty($params)) {
    $stmt = mysqli_prepare($con, $sql);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, $types, ...$params);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
    } else {
        $result = false;
    }
} else {
    $result = mysqli_query($con, $sql);
}

$rows = [];
if ($result) {
    while ($r = mysqli_fetch_assoc($result)) {
        $rows[] = $r;
    }
}
// ============================================
// FIN DE CONSULTA PRINCIPAL
// ============================================

// Si se solicita PDF, generar y salir
if (isset($_GET['pdf']) && $_GET['pdf'] == '1') {
    generar_pdf_estudiantes($anio, $programa, $facultad, $rows);
}

// RUTA CORREGIDA - Subimos dos niveles desde php/reportes/
$base_path = '../../';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Estudiantes - SIGEP</title>
    
    <!-- Bootstrap 3 -->
    <link rel="stylesheet" href="<?php echo $base_path; ?>bootstrap/css/bootstrap.min.css">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Estilos personalizados SIGEP -->
    <link rel="stylesheet" href="<?php echo $base_path; ?>css/sigep.css">
    
    <style>
        /* Estilos adicionales específicos */
        .table thead th { 
            background: var(--primary-blue); 
            color: white; 
            text-align: center;
        }
        .table tbody tr:hover { 
            background: rgba(76, 175, 80, 0.1); 
        }
        .badge-doc {
            background-color: var(--primary-blue);
            color: white;
            padding: 5px 10px;
            border-radius: 20px;
        }
    </style>
</head>
<body>

<?php
$navbar_path = __DIR__ . '/../navbar.php';
if (file_exists($navbar_path)) {
    include $navbar_path;
}
?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <!-- Encabezado de la página -->
            <div class="page-header fade-in-up">
                <h2>
                    <i class="fas fa-users" style="color: var(--accent-green); margin-right: 15px;"></i>
                    <strong>REPORTE DE ESTUDIANTES</strong>
                </h2>
                <p class="text-muted">
                    <i class="fas fa-info-circle"></i> 
                    Visualice y filtre estudiantes por facultad, programa y año de ingreso
                </p>
            </div>
            
            <!-- Botón volver a reportes -->
            <div class="pull-right" style="margin-bottom: 20px;">
                <a href="../reportes.php" class="btn-custom btn-primary-custom">
                    <i class="fas fa-arrow-left"></i> Volver a Reportes
                </a>
            </div>
        </div>
    </div>
    
    <!-- Filtros en tarjeta -->
    <div class="content-card fade-in-up" style="padding: 15px;">
        <form method="get" class="form-horizontal">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="facultadSelect" class="control-label" style="font-weight: 600; color: var(--primary-blue);">
                            <i class="fas fa-university"></i> Facultad:
                        </label>
                        <select id="facultadSelect" name="facultad" class="form-control">
                            <option value="">Todas las facultades</option>
                            <?php 
                            if (!empty($facultades)):
                                foreach ($facultades as $fact):
                                    $fact_id = is_object($fact) ? $fact->id : $fact['id'];
                                    $fact_nombre = is_object($fact) ? $fact->nombre : $fact['nombre'];
                            ?>
                                <option value="<?php echo $fact_id; ?>" 
                                    <?php if ($facultad == $fact_id) echo "selected"; ?>>
                                    <?php echo htmlspecialchars($fact_nombre); ?>
                                </option>
                            <?php 
                                endforeach;
                            endif; 
                            ?>
                        </select>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="programaSelect" class="control-label" style="font-weight: 600; color: var(--primary-blue);">
                            <i class="fas fa-graduation-cap"></i> Programa:
                        </label>
                        <select id="programaSelect" name="programa" class="form-control">
                            <option value="">Todos los programas</option>
                            <?php foreach ($programas as $pr): ?>
                                <option value="<?php echo $pr['id']; ?>" <?php if ($programa == $pr['id']) echo "selected"; ?>>
                                    <?php echo htmlspecialchars($pr['nombre']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="anioSelect" class="control-label" style="font-weight: 600; color: var(--primary-blue);">
                            <i class="fas fa-calendar-alt"></i> Año:
                        </label>
                        <select id="anioSelect" name="anio" class="form-control">
                            <option value="">Todos los años</option>
                            <?php foreach ($anios as $a): ?>
                                <option value="<?php echo $a; ?>" <?php if ($anio == $a) echo "selected"; ?>><?php echo $a; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                
                <div class="col-md-2">
                    <div class="form-group" style="margin-top: 25px;">
                        <button type="submit" class="btn-custom btn-success-custom" style="width: 100%;">
                            <i class="fas fa-search"></i> Filtrar
                        </button>
                    </div>
                </div>
            </div>
            
            <div class="row" style="margin-top: 10px;">
                <div class="col-md-12">
                    <a href="?<?php
                        $qs = [];
                        if ($anio !== null) $qs['anio'] = $anio;
                        if ($programa !== null) $qs['programa'] = $programa;
                        if ($facultad !== null && $facultad !== '') $qs['facultad'] = $facultad;
                        $qs['pdf'] = '1';
                        echo http_build_query($qs);
                    ?>" class="btn-custom btn-primary-custom" target="_blank">
                        <i class="fas fa-file-pdf"></i> Descargar PDF
                    </a>
                    
                    <a href="estudiantes.php" class="btn-custom" style="background: var(--gray-500); color: white; margin-left: 10px;">
                        <i class="fas fa-redo-alt"></i> Limpiar Filtros
                    </a>
                </div>
            </div>
        </form>
    </div>
    
    <!-- Resultados -->
    <div class="content-card fade-in-up">
        <h4 class="section-title" style="margin-top: 0;">
            <i class="fas fa-list" style="color: var(--accent-green);"></i>
            Listado de Estudiantes
            <?php if (isset($rows) && count($rows) > 0): ?>
                <span class="badge" style="background-color: var(--primary-blue); color: white; margin-left: 10px;">
                    Total: <?php echo count($rows); ?>
                </span>
            <?php endif; ?>
        </h4>
        
        <div class="table-responsive">
            <table class="table table-hover table-bordered table-striped">
                <thead>
                    <tr>
                        <th class="text-center">Documento</th>
                        <th class="text-center">Apellidos</th>
                        <th class="text-center">Nombres</th>
                        <th class="text-center">Programa</th>
                        <th class="text-center">Fecha Nacimiento</th>
                        <th class="text-center">Fecha Ingreso</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (isset($rows) && count($rows) > 0): ?>
                        <?php foreach ($rows as $row): ?>
                            <tr>
                                <td class="text-center">
                                    <span class="badge-doc">
                                        <i class="fas fa-id-card"></i> <?php echo htmlspecialchars($row['documento_identidad']); ?>
                                    </span>
                                </td>
                                <td><i class="fas fa-user" style="color: var(--accent-green); margin-right: 5px;"></i><?php echo htmlspecialchars($row['apellidos']); ?></td>
                                <td><i class="fas fa-user" style="color: var(--primary-blue); margin-right: 5px;"></i><?php echo htmlspecialchars($row['nombres']); ?></td>
                                <td><i class="fas fa-graduation-cap" style="color: var(--accent-green); margin-right: 5px;"></i><?php echo htmlspecialchars($row['programa']); ?></td>
                                <td class="text-center"><?php echo isset($row['fecha_nacimiento']) ? transforma_fecha($row['fecha_nacimiento']) : ''; ?></td>
                                <td class="text-center"><?php echo isset($row['fecha_ingreso']) ? transforma_fecha($row['fecha_ingreso']) : ''; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center" style="padding: 30px;">
                                <i class="fas fa-info-circle" style="font-size: 2rem; color: var(--primary-blue); display: block; margin-bottom: 10px;"></i>
                                No se encontraron estudiantes para los filtros seleccionados.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    
    <!-- Resumen rápido -->
    <div class="row" style="margin-top: 20px; margin-bottom: 30px;">
        <div class="col-md-12">
            <div class="alert alert-info" style="background: var(--gradient-silver); border-left: 4px solid var(--primary-blue);">
                <i class="fas fa-info-circle"></i>
                <strong>Resumen:</strong> 
                <?php if (isset($rows) && count($rows) > 0): ?>
                    Mostrando <?php echo count($rows); ?> estudiantes.
                <?php else: ?>
                    No hay estudiantes para mostrar.
                <?php endif; ?>
                Use los filtros para refinar la búsqueda.
            </div>
        </div>
    </div>
    
</div>

<!-- jQuery y Bootstrap -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="<?php echo $base_path; ?>bootstrap/js/bootstrap.min.js"></script>

<!-- Scripts personalizados SIGEP -->
<script src="<?php echo $base_path; ?>js/sigep.js"></script>
<script src="<?php echo $base_path; ?>js/sigep-ui.js"></script>

<script>
// Recargar automáticamente al cambiar cualquier filtro
document.addEventListener('DOMContentLoaded', function() {
    const facultadSelect = document.getElementById('facultadSelect');
    const programaSelect = document.getElementById('programaSelect');
    const anioSelect = document.getElementById('anioSelect');
    
    if (facultadSelect) {
        facultadSelect.addEventListener('change', function() {
            this.form.submit();
        });
    }
    
    if (programaSelect) {
        programaSelect.addEventListener('change', function() {
            this.form.submit();
        });
    }
    
    if (anioSelect) {
        anioSelect.addEventListener('change', function() {
            this.form.submit();
        });
    }
});
</script>

</body>
</html>