
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
$estatus = "retirado";

// Mapeo de estatus para la consulta
$estatus_map = [
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
                 AND e.condicion_estudiante_id IN (5,6)
                 ORDER BY anio ASC";
    $resAnios = mysqli_query($con, $sqlAnios);
} elseif ($facultad !== null) {
    $sqlAnios = "SELECT DISTINCT YEAR(e.fecha_ingreso) AS anio 
                 FROM estudiante_programa e
                 INNER JOIN programa p ON e.programa_id = p.id
                 INNER JOIN postgrado po ON p.postgrado_id = po.id
                 WHERE po.facultad_nucleo_id = " . intval($facultad) . "
                 AND e.condicion_estudiante_id IN (5,6) 
                 ORDER BY anio ASC";
    $resAnios = mysqli_query($con, $sqlAnios);
} else {
    $sqlAnios = "SELECT DISTINCT YEAR(fecha_ingreso) AS anio FROM estudiante_programa WHERE
                condicion_estudiante_id IN (5,6) ORDER BY anio ASC";
    $resAnios = mysqli_query($con, $sqlAnios);

    //var_dump($sqlAnios);
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

$option_report = "retiros";
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
    <title>Reporte de Retirados - SIGEP</title>
    
    <!-- Bootstrap 3 -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../css/sigep.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
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
        
        fetch(`get_programas_por_facultad.php?opt=retirados&facultad_id=${facultadId}`)
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
        
        fetch(`get_anios_por_programa.php?opt=retirados&programa_id=${programaId}`)
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
                    anioSelect.innerHTML = '<option value="">No hay registros</option>';
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
                    <strong>REPORTE DE RETIRADOS</strong>
                </h2>
                <p class="text-muted">
                    <i class="fas fa-info-circle"></i> 
                    Visualice y filtre estudiantes por facultad, programa, año
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
                        <div class="col-md-2 hidden">
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
                        
                        <div class="col-md-4" style="float: right;">
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
                             <a href="../../reportes.php" class="btn btn-warning-filter" style="margin-left: 10px;float: right;">⬅ Volver</a>
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
                                <th class="text-center">Fecha Ingreso</th>
                                <th class="text-center">Fecha Retiro</th>
                                <th class="text-center">Motivo Retiro</th>
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
                                        <td width="30%"><?php echo htmlspecialchars($row['programa']); ?></td>
    
                                        <td class="text-center"><?php echo transforma_fecha($row['fecha_ingreso']); ?></td>
                                        <td class="text-center"><?php echo transforma_fecha($row['fecha_retiro']); ?></td>
                                        <td class="text-center"><?php echo $row['motivo_retiro']; ?></td>
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