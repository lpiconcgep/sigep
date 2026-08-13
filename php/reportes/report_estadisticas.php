
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



$anios = ['2025','2026'];


$sqlGradoA = "SELECT * FROM grado_academico ";
$resGradoA = mysqli_query($con, $sqlGradoA);

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

//$option_report = "estadisticas";
include "../query_filtro_estadisticas.php";




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
        
        fetch(`get_programas_por_facultad.php?opt=estadisticas&facultad_id=${facultadId}`)
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
                
            })
            .catch(error => {
                console.error('Error cargando programas:', error);
                programaSelect.innerHTML = '<option value="">Error al cargar</option>';
                anioSelect.innerHTML = '<option value="">Error al cargar</option>';
                alert('Error al cargar los datos. Verifica que los archivos existan.');
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
                    <strong>REPORTE DE ESTADISTICAS</strong>
                </h2>
                <p class="text-muted">
                    <i class="fas fa-info-circle"></i> 
                    Visualice y filtre postgrados por facultad, programa, año
                </p>

            </div>
           
            <!-- Filtros -->
            <div class="filter-card fade-in-up">
                <form method="get" class="form-horizontal">
                    <div class="row">
                        <div class="col-md-2">
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
                        <div class="col-md-2">
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
                                <label for="anioSelect"><i class="fas fa-calendar"></i>Grado académico</label>
                                <select id="gradoSelect" name="anio" class="form-control">
                                    <option value="">Todos</option>
                                    <?php foreach ($resGradoA as $g): ?>
                                        <option value="<?php echo $g['id']; ?>" 
                                            <?php if ($gradoA !== null && $g == $gradoA) echo "selected"; ?>>
                                            <?php echo $g['nombre']; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
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
                    <i class="fas fa-list"></i> Listado de Postgrados
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
                                <th class="text-center">Num</th>
                                <th class="text-center">Nombre Programa</th>
                            
                                <th class="text-center">Cantidad Matricula</th>
                                <th class="text-center">Cantidad Ingresos</th>
                                <th class="text-center">Cantidad Egresados</th>
                                <th class="text-center">Cantidad Retirados</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (count($rows) > 0): ?>
                                <?php foreach ($rows as $row): ?>
                                    <tr>
                                        <td width="10%"></td>
                                        <td width="30%"><?php echo htmlspecialchars($row['programa']); ?></td>
    
                                        <td class="text-center">10</td>
                                        <td class="text-center">0</td>
                                        <td class="text-center">1</td>
                                        <td class="text-center">2</td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="8" class="text-center" style="padding: 40px 0;">
                                        <i class="fas fa-info-circle" style="font-size: 2.5rem; color: var(--blue-soft); display: block; margin-bottom: 15px;"></i>
                                        <h4 style="color: var(--blue-soft);">No se encontraron registros</h4>
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