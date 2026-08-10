<?php
// -------------------------------------------------------------
// posgrado.php (Reporte de Posgrados - PDF CON ESTATUS CON DATOS)
// -------------------------------------------------------------

// Iniciar sesion si no esta iniciada
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// 1) Conexion a la base de datos
$possible_paths = [
    __DIR__ . '/conexion.php',
    __DIR__ . '/../conexion.php',
    __DIR__ . '/../../conexion.php',
    __DIR__ . '/../../php/conexion.php'
];
$included = false;
foreach ($possible_paths as $p) {
    if (file_exists($p)) {
        require_once $p;
        $included = true;
        break;
    }
}
if (!$included) {
    die("Error: no se encontró conexion.php");
}
if (isset($con) && $con instanceof mysqli) {
    $conn = $con;
} elseif (isset($conn) && $conn instanceof mysqli) {
    // ya existe
} else {
    die("Error: la conexión no está inicializada.");
}

// Incluir utilidades para la función transforma_fecha
$utilidades_path = __DIR__ . '/../utilidades.php';
if (file_exists($utilidades_path)) {
    include_once $utilidades_path;
}

// 2) Parametros de filtro
$anios_inactividad = isset($_GET['anios']) && is_numeric($_GET['anios']) ? intval($_GET['anios']) : 5;
$tipo_inactivo = isset($_GET['tipo']) ? $_GET['tipo'] : 'todos';
$facultad = isset($_GET['facultad']) && $_GET['facultad'] !== '' && is_numeric($_GET['facultad']) ? intval($_GET['facultad']) : null;

// 3) Obtener lista de facultades
$sql_facultades = "SELECT id, nombre FROM facultad_nucleo ORDER BY nombre ASC";
$res_facultades = mysqli_query($conn, $sql_facultades);
$facultades = [];
if ($res_facultades) {
    while ($f = mysqli_fetch_assoc($res_facultades)) {
        $facultades[] = $f;
    }
}

// 4) Obtener todos los estatus de estudiantes (excepto egresados, retirados y desincorporación)
$sql_estatus = "SELECT id, nombre FROM estatus_estudiante 
                WHERE nombre NOT LIKE '%egresado%' 
                AND nombre NOT LIKE '%retirado%' 
                AND nombre NOT LIKE '%desincorporaci%'
                ORDER BY nombre ASC";
$res_estatus = mysqli_query($conn, $sql_estatus);
$estatus_list = [];
$estatus_ids = [];
if ($res_estatus) {
    while ($e = mysqli_fetch_assoc($res_estatus)) {
        $estatus_list[] = $e;
        $estatus_ids[] = $e['id'];
    }
}

// Construir la parte de la consulta para cada estatus
$estatus_columns = "";
foreach ($estatus_list as $estatus) {
    $nombre_limpio = strtolower(str_replace(' ', '_', $estatus['nombre']));
    $nombre_limpio = str_replace(['á','é','í','ó','ú','ñ'], ['a','e','i','o','u','n'], $nombre_limpio);
    $estatus_columns .= ",
            COUNT(DISTINCT CASE WHEN ep.estatus_estudiante_id = {$estatus['id']} THEN ep.persona_id END) AS `{$nombre_limpio}`";
}

// 5) Consulta principal - Obtener programas con sus estadísticas
$sql = "SELECT 
            p.id,
            p.nombre AS programa,
            COUNT(DISTINCT ep.persona_id) AS total_estudiantes,
            MAX(ep.fecha_ingreso) AS ultimo_ingreso,
            YEAR(MAX(ep.fecha_ingreso)) AS ultimo_anio
            $estatus_columns
        FROM programa p
        LEFT JOIN estudiante_programa ep ON p.id = ep.programa_id
        LEFT JOIN persona per ON ep.persona_id = per.id";

// Aplicar filtro por facultad
if ($facultad !== null) {
    $sql .= " INNER JOIN postgrado pg ON p.postgrado_id = pg.id 
               WHERE pg.facultad_nucleo_id = $facultad";
} else {
    $sql .= " WHERE 1=1";
}

$sql .= " GROUP BY p.id, p.nombre";

// Aplicar filtro por tipo de inactividad basado en los años seleccionados
if ($tipo_inactivo == 'inactivos') {
    // Programas con estudiantes pero cuyo último ingreso es anterior a los años seleccionados
    $sql .= " HAVING MAX(ep.fecha_ingreso) IS NOT NULL 
              AND MAX(ep.fecha_ingreso) < DATE_SUB(CURDATE(), INTERVAL $anios_inactividad YEAR)";
} elseif ($tipo_inactivo == 'sin_estudiantes') {
    // Programas sin ningún estudiante
    $sql .= " HAVING MAX(ep.fecha_ingreso) IS NULL";
} elseif ($tipo_inactivo == 'todos') {
    // Todos los inactivos: programas sin estudiantes O con último ingreso anterior a los años seleccionados
    $sql .= " HAVING MAX(ep.fecha_ingreso) IS NULL 
              OR MAX(ep.fecha_ingreso) < DATE_SUB(CURDATE(), INTERVAL $anios_inactividad YEAR)";
}

// Ordenar por año de última actividad (del más reciente al más antiguo)
$sql .= " ORDER BY ultimo_anio DESC, programa ASC";

// Ejecutar consulta
$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Error en la consulta: " . mysqli_error($conn) . "<br>SQL: " . $sql);
}

$rows = [];
if ($result) {
    while ($r = mysqli_fetch_assoc($result)) {
        $rows[] = $r;
    }
}

// 6) Identificar qué estatus tienen al menos un estudiante en los resultados
$estatus_con_datos = [];
if (count($rows) > 0) {
    foreach ($estatus_list as $index => $estatus) {
        $nombre_limpio = strtolower(str_replace(' ', '_', $estatus['nombre']));
        $nombre_limpio = str_replace(['á','é','í','ó','ú','ñ'], ['a','e','i','o','u','n'], $nombre_limpio);
        
        // Sumar todos los valores de este estatus en todas las filas
        $total_estatus = 0;
        foreach ($rows as $row) {
            $total_estatus += isset($row[$nombre_limpio]) ? $row[$nombre_limpio] : 0;
        }
        
        // Si el total es mayor que cero, incluir este estatus
        if ($total_estatus > 0) {
            $estatus_con_datos[] = [
                'index' => $index,
                'id' => $estatus['id'],
                'nombre' => $estatus['nombre'],
                'nombre_limpio' => $nombre_limpio,
                'total' => $total_estatus
            ];
        }
    }
} else {
    // Si no hay filas, mostrar todos los estatus (para evitar tabla vacía)
    foreach ($estatus_list as $index => $estatus) {
        $nombre_limpio = strtolower(str_replace(' ', '_', $estatus['nombre']));
        $nombre_limpio = str_replace(['á','é','í','ó','ú','ñ'], ['a','e','i','o','u','n'], $nombre_limpio);
        $estatus_con_datos[] = [
            'index' => $index,
            'id' => $estatus['id'],
            'nombre' => $estatus['nombre'],
            'nombre_limpio' => $nombre_limpio,
            'total' => 0
        ];
    }
}

// 7) Obtener años disponibles para el filtro (ordenados del más nuevo al más viejo)
$sql_anios_disponibles = "SELECT DISTINCT YEAR(fecha_ingreso) AS anio FROM estudiante_programa ORDER BY anio DESC";
$res_anios_disponibles = mysqli_query($conn, $sql_anios_disponibles);
$anios_disponibles = [];
if ($res_anios_disponibles) {
    while ($a = mysqli_fetch_assoc($res_anios_disponibles)) {
        $anios_disponibles[] = $a['anio'];
    }
}

// 8) Generacion de PDF MEJORADO - Solo muestra estatus con datos
if (isset($_GET['pdf']) && $_GET['pdf'] == '1') {
    $tcpdf_path = __DIR__ . '/../../libs/TCPDF/tcpdf.php';
    if (!file_exists($tcpdf_path)) {
        die("Error: no se encontró TCPDF");
    }
    require_once $tcpdf_path;

    if (ob_get_length()) {
        ob_end_clean();
    }

    // Crear PDF en formato horizontal con márgenes equilibrados
    $pdf = new TCPDF('L', 'mm', 'A4', true, 'UTF-8', false);
    
    // Configuración del documento
    $pdf->SetCreator('SIGEP');
    $pdf->SetAuthor('SIGEP');
    $pdf->SetTitle('Reporte de Posgrados');
    
    // Configurar márgenes para centrar mejor el contenido
    $pdf->SetMargins(15, 20, 15);
    $pdf->SetHeaderMargin(5);
    $pdf->SetFooterMargin(10);
    
    // Agregar página
    $pdf->AddPage();
    
    // ============================================
    // HEADER - Centrado y ordenado
    // ============================================
    $pdf->SetFont('helvetica', 'B', 20);
    $pdf->SetTextColor(60, 60, 60);
    $pdf->Cell(0, 15, 'REPORTE DE POSGRADOS', 0, 1, 'C');
    
    // Subtítulo
    $pdf->SetFont('helvetica', '', 11);
    $pdf->SetTextColor(100, 100, 100);
    $pdf->Cell(0, 6, 'Análisis de programas y estatus de estudiantes', 0, 1, 'C');
    
    // Línea decorativa centrada
    $pdf->SetDrawColor(150, 150, 150);
    $pdf->SetLineWidth(0.3);
    $pdf->Line(15, 40, 280, 40);
    $pdf->Ln(8);

    // ============================================
    // INFORMACIÓN DE FILTROS - En columnas para mejor orden
    // ============================================
    $pdf->SetFont('helvetica', 'B', 10);
    $pdf->SetTextColor(60, 60, 60);
    $pdf->Cell(0, 6, 'Filtros aplicados:', 0, 1, 'L');
    
    $pdf->SetFont('helvetica', '', 9);
    $pdf->SetTextColor(80, 80, 80);
    
    // Crear una tabla invisible para organizar los filtros
    $pdf->SetFillColor(245, 245, 245);
    
    // Fila 1 de filtros
    $pdf->Cell(90, 6, '• Años de inactividad: ' . $anios_inactividad, 0, 0, 'L');
    if ($facultad) {
        $sql_fac = "SELECT nombre FROM facultad_nucleo WHERE id = $facultad";
        $res_fac = mysqli_query($conn, $sql_fac);
        $fac_nombre = ($res_fac && $row_fac = mysqli_fetch_assoc($res_fac)) ? $row_fac['nombre'] : 'Desconocida';
        $pdf->Cell(90, 6, '• Facultad: ' . $fac_nombre, 0, 0, 'L');
    } else {
        $pdf->Cell(90, 6, '• Facultad: Todas', 0, 0, 'L');
    }
    
    $tipo_texto = '';
    if ($tipo_inactivo == 'inactivos') $tipo_texto = 'Solo con estudiantes inactivos';
    else if ($tipo_inactivo == 'sin_estudiantes') $tipo_texto = 'Sin estudiantes registrados';
    else $tipo_texto = 'Todos los inactivos';
    $pdf->Cell(90, 6, '• Tipo: ' . $tipo_texto, 0, 1, 'L');
    
    $pdf->Ln(8);

    // ============================================
    // ESTADÍSTICAS GENERALES - En cuadros
    // ============================================
    $total_programas = count($rows);
    $total_estudiantes = 0;
    foreach ($rows as $row) {
        $total_estudiantes += $row['total_estudiantes'];
    }
    
    $pdf->SetFillColor(230, 230, 230);
    $pdf->SetFont('helvetica', 'B', 11);
    
    // Cuadro de total programas
    $pdf->SetXY(15, $pdf->GetY());
    $pdf->Cell(85, 10, 'TOTAL PROGRAMAS', 1, 0, 'C', true);
    $pdf->SetFont('helvetica', 'B', 16);
    $pdf->SetTextColor(0, 123, 255);
    $pdf->Cell(85, 10, $total_programas, 1, 0, 'C', true);
    
    // Cuadro de total estudiantes
    $pdf->SetFont('helvetica', 'B', 11);
    $pdf->SetTextColor(60, 60, 60);
    $pdf->Cell(85, 10, 'TOTAL ESTUDIANTES', 1, 0, 'C', true);
    $pdf->SetFont('helvetica', 'B', 16);
    $pdf->SetTextColor(40, 167, 69);
    $pdf->Cell(85, 10, $total_estudiantes, 1, 1, 'C', true);
    
    $pdf->SetTextColor(60, 60, 60);
    $pdf->Ln(10);

    // ============================================
    // TABLA DE RESULTADOS - Solo con estatus que tienen datos
    // ============================================
    
    $num_estatus_con_datos = count($estatus_con_datos);
    
    // Si no hay estatus con datos, mostrar mensaje
    if ($num_estatus_con_datos == 0) {
        $pdf->SetFont('helvetica', 'B', 12);
        $pdf->Cell(0, 10, 'No hay estatus con estudiantes en los resultados', 0, 1, 'C');
    } else {
        // Calcular anchos de columna
        $ancho_total_disponible = 267; // 297mm - márgenes (15+15)
        
        $ancho_programa = 70;
        $ancho_total = 18;
        $ancho_estatus = 18; // Ancho para cada columna de estatus
        $ancho_ingreso = 25;
        $ancho_inactivo = 20;
        
        // Calcular ancho total de las columnas de estatus
        $ancho_total_estatus = $num_estatus_con_datos * $ancho_estatus;
        
        // Verificar que todo quepa
        $ancho_total_columnas = $ancho_programa + $ancho_total + $ancho_total_estatus + $ancho_ingreso + $ancho_inactivo;
        
        // Si no cabe, ajustar proporcionalmente
        if ($ancho_total_columnas > $ancho_total_disponible) {
            $factor = $ancho_total_disponible / $ancho_total_columnas;
            $ancho_programa = round($ancho_programa * $factor);
            $ancho_total = round($ancho_total * $factor);
            $ancho_estatus = round($ancho_estatus * $factor);
            $ancho_ingreso = round($ancho_ingreso * $factor);
            $ancho_inactivo = round($ancho_inactivo * $factor);
        }
        
        // Posición X inicial para centrar la tabla
        $tabla_x = (297 - ($ancho_programa + $ancho_total + ($num_estatus_con_datos * $ancho_estatus) + $ancho_ingreso + $ancho_inactivo)) / 2;
        $pdf->SetX($tabla_x);
        
        // Estilo para el encabezado
        $pdf->SetFillColor(200, 200, 200);
        $pdf->SetTextColor(30, 30, 30);
        $pdf->SetFont('helvetica', 'B', 8);
        $pdf->SetDrawColor(150, 150, 150);
        
        // Encabezado - Programa
        $pdf->Cell($ancho_programa, 8, 'Programa', 1, 0, 'C', true);
        
        // Encabezado - Total
        $pdf->Cell($ancho_total, 8, 'Total', 1, 0, 'C', true);
        
        // Encabezados - Estatus (solo los que tienen datos)
        foreach ($estatus_con_datos as $estatus) {
            $nombre_corto = strlen($estatus['nombre']) > 15 ? substr($estatus['nombre'], 0, 12) . '...' : $estatus['nombre'];
            $pdf->Cell($ancho_estatus, 8, $nombre_corto, 1, 0, 'C', true);
        }
        
        // Encabezado - Último Ingreso
        $pdf->Cell($ancho_ingreso, 8, 'Último Ingreso', 1, 0, 'C', true);
        
        // Encabezado - Años Inactivo
        $pdf->Cell($ancho_inactivo, 8, 'Años Inac.', 1, 1, 'C', true);
        
        // Restaurar colores para las filas
        $pdf->SetFillColor(245, 245, 245);
        $pdf->SetTextColor(50, 50, 50);
        $pdf->SetFont('helvetica', '', 7.5);
        
        $fill = false;
        $año_actual = date('Y');
        
        // Totales por estatus
        $totales_estatus = array_fill(0, $num_estatus_con_datos, 0);
        
        if (count($rows) > 0) {
            foreach ($rows as $row) {
                $fill = !$fill;
                
                // Calcular años inactivo
                $ultimo_anio = $row['ultimo_anio'] ? $row['ultimo_anio'] : 'N/A';
                $años_inactivo = ($row['ultimo_anio']) ? ($año_actual - $row['ultimo_anio']) : 'N/A';
                $ultimo_ingreso = $row['ultimo_ingreso'] ? date('d/m/Y', strtotime($row['ultimo_ingreso'])) : 'Nunca';
                
                // Truncar texto si es muy largo
                $programa_txt = strlen($row['programa']) > 40 ? substr($row['programa'], 0, 37) . '...' : $row['programa'];
                
                $pdf->SetX($tabla_x);
                
                // Programa
                $pdf->Cell($ancho_programa, 7, htmlspecialchars($programa_txt), 1, 0, 'L', $fill);
                
                // Total
                $pdf->Cell($ancho_total, 7, $row['total_estudiantes'], 1, 0, 'C', $fill);
                
                // Estatus (solo los que tienen datos)
                $idx = 0;
                foreach ($estatus_con_datos as $estatus) {
                    $valor = isset($row[$estatus['nombre_limpio']]) ? $row[$estatus['nombre_limpio']] : 0;
                    $totales_estatus[$idx] += $valor;
                    
                    $pdf->Cell($ancho_estatus, 7, $valor, 1, 0, 'C', $fill);
                    $idx++;
                }
                
                // Último Ingreso
                $pdf->Cell($ancho_ingreso, 7, $ultimo_ingreso, 1, 0, 'C', $fill);
                
                // Años Inactivo
                $pdf->Cell($ancho_inactivo, 7, $años_inactivo, 1, 1, 'C', $fill);
            }
            
            // Fila de totales
            $pdf->SetFillColor(210, 210, 210);
            $pdf->SetFont('helvetica', 'B', 8);
            $pdf->SetX($tabla_x);
            
            $pdf->Cell($ancho_programa, 7, 'TOTALES', 1, 0, 'R', true);
            $pdf->Cell($ancho_total, 7, $total_estudiantes, 1, 0, 'C', true);
            
            foreach ($totales_estatus as $total) {
                $pdf->Cell($ancho_estatus, 7, $total, 1, 0, 'C', true);
            }
            
            $pdf->Cell($ancho_ingreso, 7, '', 1, 0, 'C', true);
            $pdf->Cell($ancho_inactivo, 7, '', 1, 1, 'C', true);
            
        } else {
            $pdf->SetX($tabla_x);
            $colspan = 3 + $num_estatus_con_datos;
            $pdf->Cell($ancho_programa + $ancho_total + ($num_estatus_con_datos * $ancho_estatus) + $ancho_ingreso + $ancho_inactivo, 
                       10, 'No se encontraron resultados para los filtros seleccionados', 1, 1, 'C', true);
        }
    }
    
    // ============================================
    // PIE DE PÁGINA - Centrado
    // ============================================
    $pdf->Ln(8);
    $pdf->SetFont('helvetica', 'I', 7);
    $pdf->SetTextColor(120, 120, 120);
    
    // Línea decorativa final
    $pdf->Line(15, $pdf->GetY() - 2, 280, $pdf->GetY() - 2);
    $pdf->Ln(2);
    
    // Fecha y número de página alineados a la derecha
    $pdf->Cell(0, 4, 'Documento generado por SIGEP - ' . date('d/m/Y H:i:s'), 0, 1, 'R');
    $pdf->Cell(0, 4, 'Página ' . $pdf->getAliasNumPage() . ' de ' . $pdf->getAliasNbPages(), 0, 1, 'R');
    
    // ============================================
    // SALIDA DEL PDF
    // ============================================
    $pdf->Output("reporte_posgrados_" . date('Ymd_His') . ".pdf", 'I');
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Reporte de Posgrados</title>
<!-- Bootstrap 3 -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<style>
body { 
    background-color: #f8f9fa; 
    font-family: Arial, sans-serif; 
    padding-bottom: 60px; 
}
.card { 
    border-radius: 12px; 
    box-shadow: 0 4px 10px rgba(0,0,0,0.08); 
    background-color: #fff;
    margin-bottom: 20px;
    border: 1px solid #ddd;
}
.card-header { 
    background-color: #d3d3d3; 
    color: #000; 
    border-top-left-radius: 12px; 
    border-top-right-radius: 12px; 
    padding: 15px;
    border-bottom: 1px solid #ddd;
}
.card-body { 
    padding: 20px; 
}
.table thead th { 
    background: #f1f3f5; 
    color: #212529; 
    text-align: center;
    vertical-align: middle;
    font-size: 12px;
}
.table tbody tr:hover { 
    background: rgba(47,141,70,0.04); 
}
.table td {
    font-size: 12px;
}
.btn-primary { 
    background-color: #007BFF; 
    border-color: #007BFF; 
    color: #fff; 
}
.btn-primary:hover { 
    background-color: #0056b3; 
    border-color: #0056b3; 
    color: #fff;
}
.btn-success { 
    background-color: #28a745; 
    border-color: #28a745; 
    color: #fff; 
}
.btn-success:hover { 
    background-color: #218838; 
    border-color: #1e7e34; 
    color: #fff; 
}
.btn-default {
    background-color: #6c757d;
    border-color: #6c757d;
    color: #fff;
}
.btn-default:hover {
    background-color: #5a6268;
    border-color: #545b62;
    color: #fff;
}
.container { 
    margin-top: 20px; 
    width: 98%;
}
h3 { 
    margin-bottom: 20px; 
    color: #333; 
}
.navbar { 
    margin-bottom: 20px; 
}
.form-group {
    margin-right: 15px;
    margin-bottom: 10px;
}
.table-responsive {
    margin-top: 20px;
    overflow-x: auto;
}
.text-muted {
    margin-bottom: 20px;
}
.table-striped > tbody > tr:nth-of-type(odd) {
    background-color: #f9f9f9;
}
</style>
</head>
<body>

<?php
// Incluir navbar 
$navbar_path = __DIR__ . '/../navbar.php';
if (file_exists($navbar_path)) {
    include $navbar_path;
}
?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h3>REPORTE DE POSGRADOS</h3>
            <p class="text-muted">Análisis de programas y estatus de estudiantes</p>
        </div>
    </div>

    <!-- Filtros -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Filtros</h4>
                </div>
                <div class="card-body">
                    <form method="get" class="form-inline">
                        <!-- Filtro por Facultad -->
                        <div class="form-group">
                            <label for="facultad" style="margin-right: 10px;"><strong>Facultad:</strong></label>
                            <select id="facultad" name="facultad" class="form-control" style="width: 180px;">
                                <option value="">Todas</option>
                                <?php foreach ($facultades as $f): ?>
                                    <option value="<?php echo $f['id']; ?>" <?php echo ($facultad == $f['id']) ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($f['nombre']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Filtro de años de inactividad -->
                        <div class="form-group">
                            <label for="anios" style="margin-right: 10px;"><strong>Años inactividad:</strong></label>
                            <select id="anios" name="anios" class="form-control" style="width: 100px;">
                                <?php for ($i = 1; $i <= 10; $i++): ?>
                                    <option value="<?php echo $i; ?>" <?php echo ($anios_inactividad == $i) ? 'selected' : ''; ?>><?php echo $i; ?> años</option>
                                <?php endfor; ?>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="tipo" style="margin-right: 10px;"><strong>Tipo:</strong></label>
                            <select id="tipo" name="tipo" class="form-control" style="width: 180px;">
                                <option value="todos" <?php echo ($tipo_inactivo == 'todos') ? 'selected' : ''; ?>>Todos los inactivos</option>
                                <option value="inactivos" <?php echo ($tipo_inactivo == 'inactivos') ? 'selected' : ''; ?>>Solo con estudiantes inactivos</option>
                                <option value="sin_estudiantes" <?php echo ($tipo_inactivo == 'sin_estudiantes') ? 'selected' : ''; ?>>Sin estudiantes registrados</option>
                            </select>
                        </div>
                        
                        <button type="submit" class="btn btn-primary">Aplicar Filtros</button>
                        
                        <a href="?<?php 
                            $qs = [];
                            if ($facultad) $qs['facultad'] = $facultad;
                            $qs['anios'] = $anios_inactividad;
                            $qs['tipo'] = $tipo_inactivo;
                            $qs['pdf'] = '1';
                            echo http_build_query($qs);
                        ?>" class="btn btn-success" style="margin-left: 10px;" target="_blank">📄 Descargar PDF</a>
                        
                        <a href="../../reportes.php" class="btn btn-default" style="margin-left: 10px;">⬅ Volver</a>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Resultados -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Listado de Posgrados</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center">Programa</th>
                                    <th class="text-center">Total</th>
                                    <?php foreach ($estatus_list as $estatus): ?>
                                        <th class="text-center" title="<?php echo htmlspecialchars($estatus['nombre']); ?>">
                                            <?php 
                                            $nombre_corto = strlen($estatus['nombre']) > 20 ? substr($estatus['nombre'], 0, 18) . '...' : $estatus['nombre'];
                                            echo htmlspecialchars($nombre_corto); 
                                            ?>
                                        </th>
                                    <?php endforeach; ?>
                                    <th class="text-center">Último Ingreso</th>
                                    <th class="text-center">Años Inactivo</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (count($rows) > 0): ?>
                                    <?php 
                                    $año_actual = date('Y');
                                    $total_general_estudiantes = 0;
                                    $totales_estatus = array_fill(0, count($estatus_list), 0);
                                    
                                    // Los rows ya vienen ordenados por año DESC desde la consulta SQL
                                    foreach ($rows as $row): 
                                        $ultimo_anio = $row['ultimo_anio'] ? $row['ultimo_anio'] : 'N/A';
                                        $años_inactivo = ($row['ultimo_anio']) ? ($año_actual - $row['ultimo_anio']) : 'N/A';
                                        $ultimo_ingreso = $row['ultimo_ingreso'] ? date('d/m/Y', strtotime($row['ultimo_ingreso'])) : 'Nunca';
                                        
                                        $total_general_estudiantes += $row['total_estudiantes'];
                                    ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($row['programa']); ?></td>
                                        <td class="text-center"><strong><?php echo $row['total_estudiantes']; ?></strong></td>
                                        
                                        <?php 
                                        $idx = 0;
                                        foreach ($estatus_list as $estatus): 
                                            $nombre_limpio = strtolower(str_replace(' ', '_', $estatus['nombre']));
                                            $nombre_limpio = str_replace(['á','é','í','ó','ú','ñ'], ['a','e','i','o','u','n'], $nombre_limpio);
                                            $valor = isset($row[$nombre_limpio]) ? $row[$nombre_limpio] : 0;
                                            $totales_estatus[$idx] += $valor;
                                        ?>
                                            <td class="text-center"><?php echo $valor; ?></td>
                                        <?php 
                                            $idx++;
                                        endforeach; 
                                        ?>
                                        
                                        <td class="text-center"><?php echo $ultimo_ingreso; ?></td>
                                        <td class="text-center"><?php echo $años_inactivo; ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr style="background-color: #e9ecef; font-weight: bold;">
                                        <td class="text-right">TOTALES:</td>
                                        <td class="text-center"><?php echo $total_general_estudiantes; ?></td>
                                        <?php foreach ($totales_estatus as $total): ?>
                                            <td class="text-center"><?php echo $total; ?></td>
                                        <?php endforeach; ?>
                                        <td class="text-center" colspan="2"></td>
                                    </tr>
                                </tfoot>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="<?php echo 3 + count($estatus_list); ?>" class="text-center">
                                            No se encontraron resultados para los filtros seleccionados.
                                        </td>
                                    </tr>
                                <?php endif; ?>
                        </table>
                    </div>
                    
                    <?php if (count($rows) > 0): ?>
                    <div class="row" style="margin-top: 20px;">
                        <div class="col-md-12">
                            <div class="alert alert-info">
                                <strong>Nota:</strong> Se muestran todos los estatus excepto Egresados, Retirados y Desincorporación.
                                Total de programas mostrados: <?php echo count($rows); ?> | 
                                Ordenados por año de última actividad: <strong>del más reciente al más antiguo</strong><br>
                                <strong>PDF:</strong> Solo se muestran los estatus que tienen al menos un estudiante.
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- jQuery y Bootstrap JS -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html>