<?php
// -------------------------------------------------------------
// estudiantes.php - Reporte de Estudiantes con estilos SIGEP
// -------------------------------------------------------------

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include "../utilidades.php";
include "../funciones.php";
include "../conexion.php";

<<<<<<< Updated upstream

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
=======
// 2) Filtros seleccionados
>>>>>>> Stashed changes
$anio = isset($_GET['anio']) && $_GET['anio'] !== '' && is_numeric($_GET['anio']) ? intval($_GET['anio']) : null;
$programa = isset($_GET['programa']) && $_GET['programa'] !== '' && is_numeric($_GET['programa']) ? intval($_GET['programa']) : null;
$facultad = isset($_GET['facultad']) && $_GET['facultad'] !== '' && is_numeric($_GET['facultad']) ? intval($_GET['facultad']) : null;
$estatus = isset($_GET['estatus']) && $_GET['estatus'] !== '' ? $_GET['estatus'] : null;

// Mapeo de estatus para la consulta
$estatus_map = [
    'activo' => [1],
    'egresado' => [2],
    'inactivo' => [3, 4],
    'retirado' => [5, 6]
];

// Convertir el filtro a los IDs correspondientes
$estatus_ids = [];
if ($estatus && isset($estatus_map[$estatus])) {
    $estatus_ids = $estatus_map[$estatus];
}

<<<<<<< Updated upstream
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
=======
$resAnios = filtro_anio($anio,$programa);
>>>>>>> Stashed changes
$anios = [];
while ($r = mysqli_fetch_assoc($resAnios)) {
    $anios[] = $r['anio'];
}

// Obtener todos los programas (para el selector)
$sqlProgramas = "SELECT id, nombre FROM programa ORDER BY nombre ASC";
$resProgramas = mysqli_query($con, $sqlProgramas);
$programas = [];
while ($p = mysqli_fetch_assoc($resProgramas)) {
    $programas[] = $p;
}

// Obtener facultades
$facultades_obj = consultar_facultades(); 
$facultades = (array) $facultades_obj;

// 4) Consulta principal dinamica
include "../query_filtro.php";

// 5) PDF con TCPDF
if (isset($_GET['pdf']) && $_GET['pdf'] == '1') {
   crear_pdf($anio,$programa);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Estudiantes - SIGEP</title>
    
    <!-- Bootstrap 3 -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Estilos SIGEP -->
    <link rel="stylesheet" href="../../css/sigep.css">
    
    <style>
        /* Estilos adicionales específicos para este reporte */
        .filter-card {
            background: var(--white);
            border-radius: 20px;
            padding: 20px;
            margin-bottom: 25px;
            box-shadow: var(--shadow-sm);
        }
        
        .filter-card .form-group {
            margin-bottom: 15px;
        }
        
        .filter-card label {
            color: var(--blue-soft-dark);
            font-weight: 600;
            margin-bottom: 5px;
            display: block;
        }
        
        .filter-card .form-control {
            border-radius: 20px;
            border: 1px solid var(--silver-soft-dark);
            transition: all 0.3s;
        }
        
        .filter-card .form-control:focus {
            border-color: var(--turquoise-soft);
            box-shadow: 0 0 0 3px rgba(91,192,190,0.2);
        }
        
        /* Botón Filtrar - VERDE */
        .btn-filtrar {
            background: linear-gradient(135deg, #28a745 0%, #1e7e34 100%);
            border: none;
            border-radius: 30px;
            padding: 10px 28px;
            color: white;
            font-weight: 600;
            transition: all 0.3s ease;
            margin-top: 25px;
            box-shadow: 0 2px 8px rgba(40,167,69,0.3);
        }
        
        .btn-filtrar:hover {
            background: linear-gradient(135deg, #34ce57 0%, #28a745 100%);
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(40,167,69,0.4);
        }
        
        .btn-filtrar i {
            margin-right: 8px;
        }
        
        /* Botón PDF - ROJO */
        .btn-pdf {
            background: linear-gradient(135deg, #dc3545 0%, #b02a37 100%);
            border: none;
            border-radius: 30px;
            padding: 10px 28px;
            color: white;
            font-weight: 600;
            transition: all 0.3s ease;
            margin-top: 25px;
            margin-left: 10px;
            box-shadow: 0 2px 8px rgba(220,53,69,0.3);
            display: inline-block;
            text-decoration: none;
        }
        
        .btn-pdf:hover {
            background: linear-gradient(135deg, #e4606d 0%, #dc3545 100%);
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(220,53,69,0.4);
            color: white;
            text-decoration: none;
        }
        
        .btn-pdf i {
            margin-right: 8px;
        }
        
        .table thead th {
            background: var(--gradient-blue);
            color: white;
            font-weight: 600;
            font-size: 0.85rem;
            text-transform: uppercase;
            padding: 12px;
            border: none;
        }
        
        .table tbody tr:hover {
            background: rgba(91,192,190,0.08);
        }
        
        .table td {
            padding: 10px;
            vertical-align: middle;
        }
        
        @media (max-width: 768px) {
            .filter-card .form-group {
                width: 100%;
            }
            .btn-filtrar, .btn-pdf {
                width: 100%;
                margin-top: 10px;
                margin-left: 0;
                text-align: center;
            }
        }
    </style>
    
    <script>
    // Función para cargar programas por facultad
    function cargarProgramasPorFacultad() {
        const facultadId = document.getElementById('facultadSelect').value;
        const programaSelect = document.getElementById('programaSelect');
        const programaActual = '<?php echo $programa; ?>';
        
        let url = 'get_programas_por_facultad.php';
        if (facultadId !== '') {
            url += `?facultad_id=${facultadId}`;
        }
        
        fetch(url)
            .then(response => response.json())
            .then(data => {
                programaSelect.innerHTML = '<option value="">Todos</option>';
                data.forEach(programa => {
                    const option = document.createElement('option');
                    option.value = programa.id;
                    option.textContent = programa.nombre;
                    if (programa.id == programaActual) {
                        option.selected = true;
                    }
                    programaSelect.appendChild(option);
                });
                cargarAniosPorPrograma();
            })
            .catch(error => console.error('Error cargando programas:', error));
    }
    
    // Función para cargar años según programa o facultad
    function cargarAniosPorPrograma() {
        const programaId = document.getElementById('programaSelect').value;
        const facultadId = document.getElementById('facultadSelect').value;
        const anioSelect = document.getElementById('anioSelect');
        const anioActual = '<?php echo $anio; ?>';
        
        let url = 'get_anios_filtrados.php?';
        if (programaId !== '') {
            url += `programa_id=${programaId}`;
        } else if (facultadId !== '') {
            url += `facultad_id=${facultadId}`;
        } else {
            url = 'get_anios_filtrados.php';
        }
        
        fetch(url)
            .then(response => response.json())
            .then(data => {
                anioSelect.innerHTML = '<option value="">Todos</option>';
                data.forEach(anio => {
                    const option = document.createElement('option');
                    option.value = anio;
                    option.textContent = anio;
                    if (anio == anioActual) {
                        option.selected = true;
                    }
                    anioSelect.appendChild(option);
                });
            })
            .catch(error => console.error('Error cargando años:', error));
    }
    
    // Eventos
    document.addEventListener('DOMContentLoaded', function() {
        const facultadSelect = document.getElementById('facultadSelect');
        const programaSelect = document.getElementById('programaSelect');
        
        facultadSelect.addEventListener('change', function() {
            cargarProgramasPorFacultad();
        });
        
        programaSelect.addEventListener('change', function() {
            cargarAniosPorPrograma();
        });
        
        if (facultadSelect.value !== '') {
            cargarProgramasPorFacultad();
        } else {
            cargarAniosPorPrograma();
        }
    });
    </script>
</head>
<body>

<?php
$navbar_path = __DIR__ . '/../navbar.php';
if (file_exists($navbar_path)) {
    include $navbar_path;
} 
?>

<div class="container" style="width: 95%; margin-top: 20px;">
    <div class="row">
        <div class="col-md-12">
            
            <!-- Encabezado de la página -->
            <div class="page-header fade-in-up">
                <h2>
                    <i class="fas fa-chart-line" style="color: var(--accent-green); margin-right: 15px;"></i>
                    <strong>REPORTE DE ESTUDIANTES</strong>
                </h2>
                <p class="text-muted">
                    <i class="fas fa-info-circle"></i> 
                    Visualice y filtre estudiantes por facultad, programa, año y estatus
                </p>
            </div>
            
            <!-- Filtros -->
            <div class="filter-card fade-in-up">
                <form method="get" class="form-horizontal">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="facultadSelect"><i class="fas fa-university"></i> Facultad</label>
                                <select id="facultadSelect" name="facultad" class="form-control">
                                    <option value="">Todas</option>
                                    <?php 
                                    foreach ($facultades as $fact) {
                                        $fac = (array) $fact;
                                    ?>
                                        <option value="<?php echo $fac['id']; ?>" 
                                            <?php if ($facultad !== null && $facultad == $fac['id']) echo "selected"; ?>>
                                            <?php echo htmlspecialchars($fac['nombre']); ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="programaSelect"><i class="fas fa-graduation-cap"></i> Postgrado</label>
                                <select id="programaSelect" name="programa" class="form-control">
                                    <option value="">Todos</option>
                                    <?php foreach ($programas as $pr): ?>
                                        <option value="<?php echo $pr['id']; ?>" <?php if ($programa !== null && $programa == $pr['id']) echo "selected"; ?>>
                                            <?php echo htmlspecialchars($pr['nombre']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="anioSelect"><i class="fas fa-calendar"></i> Año</label>
                                <select id="anioSelect" name="anio" class="form-control">
                                    <option value="">Todos</option>
                                    <?php foreach ($anios as $a): ?>
                                        <option value="<?php echo $a; ?>" <?php if ($anio !== null && $a == $anio) echo "selected"; ?>><?php echo $a; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="estatusSelect"><i class="fas fa-tag"></i> Estatus</label>
                                <select id="estatusSelect" name="estatus" class="form-control">
                                    <option value="">Todos</option>
                                    <option value="activo" <?php if ($estatus == 'activo') echo "selected"; ?>>Activo</option>
                                    <option value="egresado" <?php if ($estatus == 'egresado') echo "selected"; ?>>Egresado</option>
                                    <option value="inactivo" <?php if ($estatus == 'inactivo') echo "selected"; ?>>Inactivo</option>
                                    <option value="retirado" <?php if ($estatus == 'retirado') echo "selected"; ?>>Retirado/Desincorporado</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn-filtrar">
                                <i class="fas fa-search"></i> Filtrar
                            </button>
                            <a href="?<?php
                                $qs = [];
                                if ($anio !== null) $qs['anio'] = $anio;
                                if ($programa !== null) $qs['programa'] = $programa;
                                if ($facultad !== null) $qs['facultad'] = $facultad;
                                if ($estatus !== null) $qs['estatus'] = $estatus;
                                $qs['pdf'] = '1';
                                echo http_build_query($qs);
                            ?>" class="btn-pdf" target="_blank">
                                <i class="fas fa-file-pdf"></i> PDF
                            </a>
                        </div>
                    </div>
                </form>
            </div>
            
            <!-- Tabla de resultados -->
            <div class="content-card fade-in-up">
                <h4 class="section-title" style="margin-top: 0;">
                    <i class="fas fa-list"></i> Listado de Estudiantes
                    <?php if (count($rows) > 0): ?>
                        <span class="badge" style="background: var(--gradient-blue); color: white; margin-left: 10px;">
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
                                <th class="text-center">Estatus</th>
                                <th class="text-center">Fecha Nac.</th>
                                <th class="text-center">Fecha Ingreso</th>
                                <th class="text-center">Fecha Registro</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (count($rows) > 0): ?>
                                <?php foreach ($rows as $row): ?>
                                    <tr>
                                        <td class="text-center">
                                            <span class="badge" style="background: var(--gradient-blue); color: white; padding: 5px 10px; border-radius: 20px;">
                                                <?php echo htmlspecialchars($row['documento_identidad']); ?>
                                            </span>
                                        </td>
                                        <td><?php echo htmlspecialchars($row['apellidos']); ?></td>
                                        <td><?php echo htmlspecialchars($row['nombres']); ?></td>
                                        <td><?php echo htmlspecialchars($row['programa']); ?></td>
                                        <td class="text-center"><?php echo htmlspecialchars($row['condicion_estudiante']); ?></td>
                                        <td class="text-center"><?php echo transforma_fecha($row['fecha_nacimiento']); ?></td>
                                        <td class="text-center"><?php echo transforma_fecha($row['fecha_ingreso']); ?></td>
                                        <td class="text-center"><?php echo transforma_fecha($row['fecha_registro']); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="8" class="text-center">
                                        <i class="fas fa-info-circle" style="font-size: 2rem; color: var(--blue-soft); display: block; margin-bottom: 10px;"></i>
                                        No se encontraron estudiantes para los filtros seleccionados.
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            
            <!-- Resumen -->
            <div class="alert alert-info fade-in-up" style="border-radius: 15px;">
                <i class="fas fa-chart-bar"></i>
                <strong>Resumen:</strong> Mostrando <?php echo count($rows); ?> estudiantes. Use los filtros para refinar la búsqueda.
            </div>
            
        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<<<<<<< Updated upstream
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
=======
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
>>>>>>> Stashed changes
</body>
</html>