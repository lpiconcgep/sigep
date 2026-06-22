
<?php
// estudiantes.php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// RUTA CORRECTA: subir un nivel a php/
$base_path = __DIR__ . '/../';

include $base_path . "conexion.php";
include $base_path . "utilidades.php";
include $base_path . "funciones.php";

// ... resto del código
// 2) Filtros seleccionados
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

$estatus_ids = [];
if ($estatus && isset($estatus_map[$estatus])) {
    $estatus_ids = $estatus_map[$estatus];
}

// ============================================
// CONSULTAS PARA FILTROS - CORREGIDAS
// ============================================

// Obtener años según filtros
if ($programa !== null) {
    $sqlAnios = "SELECT DISTINCT YEAR(e.fecha_ingreso) AS anio 
                 FROM estudiante_programa e 
                 WHERE e.programa_id = " . intval($programa) . " 
                 ORDER BY anio ASC";
    $resAnios = mysqli_query($con, $sqlAnios);
} elseif ($facultad !== null) {
    $sqlAnios = "SELECT DISTINCT YEAR(e.fecha_ingreso) AS anio 
                 FROM estudiante_programa e
                 INNER JOIN programa p ON e.programa_id = p.id
                 INNER JOIN postgrado po ON p.postgrado_id = po.id
                 WHERE po.facultad_nucleo_id = " . intval($facultad) . " 
                 ORDER BY anio ASC";
    $resAnios = mysqli_query($con, $sqlAnios);
} else {
    $sqlAnios = "SELECT DISTINCT YEAR(fecha_ingreso) AS anio FROM estudiante_programa ORDER BY anio ASC";
    $resAnios = mysqli_query($con, $sqlAnios);
}

$anios = [];
if ($resAnios) {
    while ($r = mysqli_fetch_assoc($resAnios)) {
        $anios[] = $r['anio'];
    }
}

// Obtener todos los programas (para el selector)
$sqlProgramas = "SELECT id, nombre FROM programa ORDER BY nombre ASC";
$resProgramas = mysqli_query($con, $sqlProgramas);
$programas = [];
if ($resProgramas) {
    while ($p = mysqli_fetch_assoc($resProgramas)) {
        $programas[] = $p;
    }
}

// Obtener facultades
$sqlFacultades = "SELECT id, nombre FROM facultad_nucleo ORDER BY nombre ASC";
$resFacultades = mysqli_query($con, $sqlFacultades);
$facultades = [];
if ($resFacultades) {
    while ($f = mysqli_fetch_assoc($resFacultades)) {
        $facultades[] = $f;
    }
}

// ============================================
// CONSULTA PRINCIPAL - CORREGIDA
// ============================================

include "../query_filtro.php";

// ============================================
// FUNCIÓN PARA FORMATEAR FECHAS
// ============================================
if (!function_exists('transforma_fecha')) {
    function transforma_fecha($fecha) {
        if (empty($fecha) || $fecha == '0000-00-00') {
            return '-';
        }
        $timestamp = strtotime($fecha);
        if ($timestamp === false) {
            return $fecha;
        }
        return date('d/m/Y', $timestamp);
    }
}

// ============================================
// PDF CON TCPDF
// ============================================
if (isset($_GET['pdf']) && $_GET['pdf'] == '1') {
    crear_pdf($anio, $programa, $facultad, $estatus);
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
    <link rel="stylesheet" href="../../css/sigep.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
    

        /* Estilos generales */
       /* :root {
            --white: #ffffff;
            --blue-soft: #2B5F8A;
            --blue-soft-dark: #1E4A6E;
            --turquoise-soft: #5BC0BE;
            --silver-soft: #E8ECEF;
            --silver-soft-dark: #D0D6DC;
            --gradient-blue: linear-gradient(135deg, #2B5F8A 0%, #3B7AA8 100%);
            --shadow-sm: 0 2px 8px rgba(43, 95, 138, 0.08);
        }
        
        body {
            background: #f0f4f8;
            font-family: 'Segoe UI', Arial, sans-serif;
            padding-top: 70px;
        }
        
        .page-header {
            background: var(--gradient-blue);
            padding: 25px 30px;
            border-radius: 20px;
            margin-bottom: 25px;
            color: white;
            box-shadow: 0 4px 15px rgba(43,95,138,0.2);
        }
        
        .page-header h2 {
            margin: 0;
            font-size: 1.8rem;
            font-weight: 300;
        }
        
        .page-header h2 strong {
            font-weight: 700;
        }
        
        .page-header .text-muted {
            color: rgba(255,255,255,0.8) !important;
            margin-top: 5px;
            font-size: 1rem;
        }
        
        .filter-card {
            background: var(--white);
            border-radius: 20px;
            padding: 20px 25px;
            margin-bottom: 25px;
            box-shadow: var(--shadow-sm);
            border: 1px solid rgba(0,0,0,0.03);
        }
        
        .filter-card .form-group {
            margin-bottom: 15px;
        }
        
        .filter-card label {
            color: var(--blue-soft-dark);
            font-weight: 600;
            margin-bottom: 5px;
            display: block;
            font-size: 0.9rem;
        }
        
        .filter-card .form-control {
            border-radius: 20px;
            border: 1px solid var(--silver-soft-dark);
            transition: all 0.3s;
            height: 38px;
        }
        
        .filter-card .form-control:focus {
            border-color: var(--turquoise-soft);
            box-shadow: 0 0 0 3px rgba(91,192,190,0.2);
        }
        
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
            cursor: pointer;
        }
        
        .btn-filtrar:hover {
            background: linear-gradient(135deg, #34ce57 0%, #28a745 100%);
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(40,167,69,0.4);
            color: white;
        }
        
        .btn-filtrar i {
            margin-right: 8px;
        }
        
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
        
        .content-card {
            background: var(--white);
            border-radius: 20px;
            padding: 25px;
            box-shadow: var(--shadow-sm);
            border: 1px solid rgba(0,0,0,0.03);
        }
        
        .section-title {
            color: var(--blue-soft-dark);
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 18px;
            padding-bottom: 12px;
            border-bottom: 2px solid var(--silver-soft);
            position: relative;
        }
        
        .section-title::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 60px;
            height: 2px;
            background: var(--turquoise-soft);
            border-radius: 2px;
        }
        
        .section-title .badge {
            background: var(--gradient-blue);
            color: white;
            margin-left: 10px;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
        }
        
        .table thead th {
            background: var(--gradient-blue);
            color: white;
            font-weight: 600;
            font-size: 0.8rem;
            text-transform: uppercase;
            padding: 10px 12px;
            border: none;
        }
        
        .table tbody tr:hover {
            background: rgba(91,192,190,0.08);
        }
        
        .table td {
            padding: 8px 12px;
            vertical-align: middle;
            font-size: 0.9rem;
        }
        
        .badge-doc {
            background: var(--gradient-blue);
            color: white;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 0.85rem;
        }
        
        .fade-in-up {
            animation: fadeInUp 0.5s ease-out forwards;
        }
        
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        @media (max-width: 768px) {
            .btn-filtrar, .btn-pdf {
                width: 100%;
                margin-top: 10px;
                margin-left: 0;
                text-align: center;
            }
        }*/
    </style>
    
    <script>
    // Función para cargar programas por facultad
    function cargarProgramasPorFacultad() {
        const facultadId = document.getElementById('facultadSelect').value;
        const programaSelect = document.getElementById('programaSelect');
        const anioSelect = document.getElementById('anioSelect');
        const programaActual = '<?php echo $programa; ?>';
        const anioActual = '<?php echo $anio; ?>';
        
        if (facultadId === '') {
            // Recargar página sin filtros
            window.location.href = window.location.pathname;
            return;
        }
        
        // Mostrar loading
        programaSelect.innerHTML = '<option value="">Cargando programas...</option>';
        anioSelect.innerHTML = '<option value="">Cargando años...</option>';
        
        fetch(`get_programas_por_facultad.php?facultad_id=${facultadId}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Error en la respuesta del servidor');
                }
                return response.json();
            })
            .then(data => {
                // Llenar programas
                programaSelect.innerHTML = '<option value="">Todos</option>';
                if (data.programas && data.programas.length > 0) {
                    data.programas.forEach(programa => {
                        const option = document.createElement('option');
                        option.value = programa.id;
                        option.textContent = programa.nombre;
                        if (programa.id == programaActual) {
                            option.selected = true;
                        }
                        programaSelect.appendChild(option);
                    });
                } else {
                    programaSelect.innerHTML = '<option value="">No hay programas</option>';
                }
                
                // Llenar años
                anioSelect.innerHTML = '<option value="">Todos</option>';
                if (data.anios && data.anios.length > 0) {
                    data.anios.forEach(anio => {
                        const option = document.createElement('option');
                        option.value = anio;
                        option.textContent = anio;
                        if (anio == anioActual) {
                            option.selected = true;
                        }
                        anioSelect.appendChild(option);
                    });
                } else {
                    anioSelect.innerHTML = '<option value="">No hay años</option>';
                }
            })
            .catch(error => {
                console.error('Error cargando programas:', error);
                programaSelect.innerHTML = '<option value="">Error al cargar</option>';
                anioSelect.innerHTML = '<option value="">Error al cargar</option>';
                alert('Error al cargar los datos. Verifica que los archivos existan.');
            });
    }
    
    // Función para cargar años según programa
    function cargarAniosPorPrograma() {
        const programaId = document.getElementById('programaSelect').value;
        const anioSelect = document.getElementById('anioSelect');
        const anioActual = '<?php echo $anio; ?>';
        
        if (programaId === '') {
            // Si no hay programa seleccionado, recargar la página
            window.location.href = window.location.pathname;
            return;
        }
        
        // Mostrar loading
        anioSelect.innerHTML = '<option value="">Cargando años...</option>';
        
        fetch(`get_anios_por_programa.php?programa_id=${programaId}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Error en la respuesta del servidor');
                }
                return response.json();
            })
            .then(data => {
                anioSelect.innerHTML = '<option value="">Todos</option>';
                if (data && data.length > 0) {
                    data.forEach(anio => {
                        const option = document.createElement('option');
                        option.value = anio;
                        option.textContent = anio;
                        if (anio == anioActual) {
                            option.selected = true;
                        }
                        anioSelect.appendChild(option);
                    });
                } else {
                    anioSelect.innerHTML = '<option value="">No hay años</option>';
                }
            })
            .catch(error => {
                console.error('Error cargando años:', error);
                anioSelect.innerHTML = '<option value="">Error al cargar</option>';
                alert('Error al cargar los años. Verifica que el archivo exista.');
            });
    }
    
    // Eventos
    document.addEventListener('DOMContentLoaded', function() {
        const facultadSelect = document.getElementById('facultadSelect');
        const programaSelect = document.getElementById('programaSelect');
        
        // Evento cambio de facultad
        facultadSelect.addEventListener('change', cargarProgramasPorFacultad);
        
        // Evento cambio de programa
        programaSelect.addEventListener('change', cargarAniosPorPrograma);
        
        // Si hay facultad seleccionada, cargar programas automáticamente
        if (facultadSelect.value !== '') {
            cargarProgramasPorFacultad();
        }
    });
    </script>
</head>
<body>

<?php
// Incluir navbar
$navbar_path = __DIR__ . '/../navbar.php';
if (file_exists($navbar_path)) {
    include $navbar_path;
}
?>

<div class="container" style="width: 95%; margin-top: 20px;">
    <div class="row">
        <div class="col-md-12">
            
            <!-- Encabezado -->
            <div class="page-header fade-in-up">
                <h2>
                    <i class="fas fa-chart-line" style="color: #5BC0BE; margin-right: 15px;"></i>
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
                                    <?php foreach ($facultades as $fact): ?>
                                        <option value="<?php echo $fact['id']; ?>" 
                                            <?php if ($facultad !== null && $facultad == $fact['id']) echo "selected"; ?>>
                                            <?php echo htmlspecialchars($fact['nombre']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="programaSelect"><i class="fas fa-graduation-cap"></i> Postgrado</label>
                                <select id="programaSelect" name="programa" class="form-control">
                                    <option value="">Todos</option>
                                    <?php foreach ($programas as $pr): ?>
                                        <option value="<?php echo $pr['id']; ?>" 
                                            <?php if ($programa !== null && $programa == $pr['id']) echo "selected"; ?>>
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
                                        <option value="<?php echo $a; ?>" 
                                            <?php if ($anio !== null && $a == $anio) echo "selected"; ?>>
                                            <?php echo $a; ?>
                                        </option>
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
                                    <option value="retirado" <?php if ($estatus == 'retirado') echo "selected"; ?>>Retirado</option>
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
                <h4 class="section-title">
                    <i class="fas fa-list"></i> Listado de Estudiantes
                    <?php if (count($rows) > 0): ?>
                        <span class="badge">
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
                                            <span class="badge-doc">
                                                <?php echo htmlspecialchars($row['documento_identidad']); ?>
                                            </span>
                                        </td>
                                        <td><?php echo htmlspecialchars($row['apellidos']); ?></td>
                                        <td><?php echo htmlspecialchars($row['nombres']); ?></td>
                                        <td><?php echo htmlspecialchars($row['programa']); ?></td>
                                        <td class="text-center">
                                            <?php 
                                            $estatus_clase = 'default';
                                            if ($row['condicion_estudiante'] == 'Activo') $estatus_clase = 'success';
                                            elseif ($row['condicion_estudiante'] == 'Egresado') $estatus_clase = 'info';
                                            elseif ($row['condicion_estudiante'] == 'Inactivo') $estatus_clase = 'warning';
                                            elseif ($row['condicion_estudiante'] == 'Retirado') $estatus_clase = 'danger';
                                            ?>
                                            <span class="label label-<?php echo $estatus_clase; ?>">
                                                <?php echo htmlspecialchars($row['condicion_estudiante']); ?>
                                            </span>
                                        </td>
                                        <td class="text-center"><?php echo transforma_fecha($row['fecha_nacimiento']); ?></td>
                                        <td class="text-center"><?php echo transforma_fecha($row['fecha_ingreso']); ?></td>
                                        <td class="text-center"><?php echo transforma_fecha($row['fecha_registro']); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="8" class="text-center" style="padding: 40px 0;">
                                        <i class="fas fa-info-circle" style="font-size: 2.5rem; color: var(--blue-soft); display: block; margin-bottom: 15px;"></i>
                                        <h4 style="color: var(--blue-soft);">No se encontraron estudiantes</h4>
                                        <p style="color: #999;">Para los filtros seleccionados no hay resultados.</p>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            
            <!-- Resumen -->
            <div class="alert alert-info fade-in-up" style="border-radius: 15px; border: none; background: rgba(43,95,138,0.08);">
                <i class="fas fa-chart-bar" style="color: var(--blue-soft);"></i>
                <strong style="color: var(--blue-soft);">Resumen:</strong> 
                <span style="color: var(--blue-soft-dark);">Mostrando <?php echo count($rows); ?> estudiantes. Use los filtros para refinar la búsqueda.</span>
            </div>
            
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

</body>
</html>