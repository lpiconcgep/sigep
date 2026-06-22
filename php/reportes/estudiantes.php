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

// Convertir el filtro a los IDs correspondientes
$estatus_ids = [];
if ($estatus && isset($estatus_map[$estatus])) {
    $estatus_ids = $estatus_map[$estatus];
}


$resAnios = filtro_anio($anio,$programa);
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

// 5) PDF con TCPDF (CORREGIDO - se pasan todos los filtros)
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
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script>
// Función para cargar programas según la facultad seleccionada
function cargarProgramasPorFacultad() {
    const facultadId = document.getElementById('facultadSelect').value;
    const programaSelect = document.getElementById('programaSelect');
    const anioSelect = document.getElementById('anioSelect');
    const programaActual = '<?php echo $programa; ?>';
    const anioActual = '<?php echo $anio; ?>';
    
    if (facultadId === '') {
        // Si selecciona "Todos", recargar la página para resetear filtros
        window.location.href = window.location.pathname;
        return;
    }
    
    // Llamar al backend para obtener programas de esa facultad
    fetch(`get_programas_por_facultad.php?facultad_id=${facultadId}`)
        .then(response => response.json())
        .then(data => {
            // Limpiar y llenar select de programas
            programaSelect.innerHTML = '<option value="">Todos</option>';
            
            data.programas.forEach(programa => {
                const option = document.createElement('option');
                option.value = programa.id;
                option.textContent = programa.nombre;
                if (programa.id == programaActual) {
                    option.selected = true;
                }
                programaSelect.appendChild(option);
            });
            
            // Actualizar años según los programas de esa facultad
            anioSelect.innerHTML = '<option value="">Todos</option>';
            data.anios.forEach(anio => {
                const option = document.createElement('option');
                option.value = anio;
                option.textContent = anio;
                if (anio == anioActual) {
                    option.selected = true;
                }
                anioSelect.appendChild(option);
            });
        })
        .catch(error => console.error('Error:', error));
}

// Función para cargar años según el programa seleccionado
function cargarAniosPorPrograma() {
    const programaId = document.getElementById('programaSelect').value;
    const anioSelect = document.getElementById('anioSelect');
    const anioActual = '<?php echo $anio; ?>';
    
    if (programaId === '') {
        // Si no hay programa, recargar la página para resetear
        window.location.href = window.location.pathname;
        return;
    }
    
    fetch(`get_anios_por_programa.php?programa_id=${programaId}`)
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
        .catch(error => console.error('Error:', error));
}

// Eventos cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', function() {
    const facultadSelect = document.getElementById('facultadSelect');
    const programaSelect = document.getElementById('programaSelect');
    
    // Evento cambio de facultad
    facultadSelect.addEventListener('change', cargarProgramasPorFacultad);
    
    // Evento cambio de programa
    programaSelect.addEventListener('change', cargarAniosPorPrograma);
});
</script>
</body>
</html>