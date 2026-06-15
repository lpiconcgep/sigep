<?php
// -------------------------------------------------------------
// estudiantes.php :)
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
$estatus = isset($_GET['estatus']) && $_GET['estatus'] !== '' && is_numeric($_GET['estatus']) ? intval($_GET['estatus']) : null;

$resAnios = filtro_anio($anio,$programa);
$anios = [];
while ($r = mysqli_fetch_assoc($resAnios)) {
    $anios[] = $r['anio'];
}

$sqlProgramas = "SELECT id, nombre FROM programa ORDER BY nombre ASC";
$resProgramas = mysqli_query($con, $sqlProgramas);
$programas = [];
while ($p = mysqli_fetch_assoc($resProgramas)) {
    $programas[] = $p;
}


$facultades_obj = consultar_facultades(); 
$facultades = (array) $facultades_obj;


// 4) Consulta principal dinamica
include "../query_filtro.php";

// 5)  PDF con TCPDF
if (isset($_GET['pdf']) && $_GET['pdf'] == '1') {
   crear_pdf($anio,$programa,$facultad,$estatus);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Reporte de estudiantes</title>
<!-- Botstrap 3 -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="../../css/styles.css">


<script>
function cargarAniosPorPrograma() {
    const programaId = document.getElementById('programaSelect').value;
    const anioSelect = document.getElementById('anioSelect');
    const anioActual = '<?php echo $anio; ?>';
    
   
    if (programaId === '') {
        window.location.href = window.location.pathname + '?programa=';
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

// Cargar años cuando  el programa cambia
document.addEventListener('DOMContentLoaded', function() {
    const programaSelect = document.getElementById('programaSelect');
    programaSelect.addEventListener('change', cargarAniosPorPrograma);
    
    // Si hay un programa seleccionado al cargar la pagina, cargar sus años
    if (programaSelect.value !== '') {
        cargarAniosPorPrograma();
    }
});
</script>
</head>
<body>

<?php
//  navbar 
$navbar_path = __DIR__ . '/../navbar.php';
if (file_exists($navbar_path)) {
    include $navbar_path;
} 
   
?>

<div class="container" style="width: 90%;">
<div class="row">
<div class="col-md-12">
<br>

<div class="card">
<div class="card-header text-center">
<h4>Reporte de Estudiantes</h4>
</div>
<div class="card-body">
<form method="get" class="form-inline">
    <div class="row">
        <div class="col-md-12">
        
    
    <div class="form-group col-md-4">
        <label for="facultadSelect"><strong>Facultad:</strong></label>
        <select id="facultadSelect" name="facultad" class="form-control mr-2" style="max-width:200px;">
            <option value="">Todos</option>
            <?php 
                foreach ($facultades as $fact) {
                    $fac = (array) $fact;
                    ?>
                    <option value="<?php echo $fac['id']; ?>" 
                        <?php if ($facultad !== null && $facultad == $fac['id']) echo "selected"; ?>>
                        <?php echo htmlspecialchars($fac['nombre']); ?>
                    </option>

                    <?php
                }
                ?>
        </select>
    </div>
    <div class="form-group col-md-3">
        <label for="programaSelect"><strong>Postgrado</strong></label>
        <select id="programaSelect" name="programa" class="form-control mr-2" style="width:180px;">
            <option value="">Todos</option>
            <?php foreach ($programas as $pr): ?>
                <option value="<?php echo $pr['id']; ?>" <?php if ($programa !== null && $programa == $pr['id']) echo "selected"; ?>>
                    <?php echo htmlspecialchars($pr['nombre']); ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="form-group col-md-2">
        <label for="anioSelect"><strong>Año</strong></label>
            <select id="anioSelect" name="anio" class="form-control" style="width:100px;">
            <option value="">Todos</option>
                <?php foreach ($anios as $a): ?>
                <option value="<?php echo $a; ?>" <?php if ($anio !== null && $a == $anio) echo "selected"; ?>><?php echo $a; ?></option>
                 <?php endforeach; ?>
             </select>
    </div>
     <div class="form-group col-md-2">
        <label for="anioSelect"><strong>Estatus</strong></label>
            <select id="estatusSelect" name="estatus" class="form-control" style="width:100px;">
                <option value="">Todos</option>
                   <?php 
                $estatusOpciones = [
                    1 => 'Activos',
                    2 => 'Egresados',
                    3 => 'Inactivos',
                    5 => 'Retirados'
                ];
                foreach ($estatusOpciones as $valor => $texto): 
                ?>
                <option value="<?php echo $valor; ?>" <?php if (isset($estatusBusqueda) && $estatusBusqueda == $valor) echo "selected"; ?>><?php echo $texto; ?></option>
                <?php endforeach; ?>
            </select>
    </div>



    <button type="submit" class="btn btn-filtrar">Filtrar</button>

    <!-- Boton descarga: -->
    <a href="?<?php
        $qs = [];
        if ($anio !== null) $qs['anio'] = $anio;
        if ($programa !== null) $qs['programa'] = $programa;
        if ($facultad !== null) $qs['facultad'] = $facultad;
        $qs['pdf'] = '1';
        echo http_build_query($qs);
    ?>" class="btn btn-verde" style="margin-left:10px;" target="_blank">📄 Descargar PDF</a>
</div></div>
</form>

<div class="table-responsive">
<table class="table table-hover table-bordered">
<thead class="text-center">
<tr>
<th class="text-center">Documento</th>
<th class="text-center">Apellidos</th>
<th class="text-center">Nombres</th>
<th class="text-center">Programa</th>
<th class="text-center">Estatus</th>
<th class="text-center">Fecha de Nacimiento</th>
<th class="text-center">Fecha de Ingreso</th>
<th class="text-center">Fecha de Registro</th>
</tr>
</thead>
<tbody>
<?php if (count($rows) > 0): ?>
    <?php foreach ($rows as $row): ?>
        <tr>
            <td class="text-center"><?php echo htmlspecialchars($row['documento_identidad']); ?></td>
            <td><?php echo htmlspecialchars($row['apellidos']); ?></td>
            <td><?php echo htmlspecialchars($row['nombres']); ?></td>
            <td><?php echo htmlspecialchars($row['programa']); ?></td>
            <td><?php echo htmlspecialchars($row['condicion_estudiante']); ?></td>
            <td class="text-center"><?php echo transforma_fecha($row['fecha_nacimiento']); ?></td>
            <td class="text-center"><?php echo transforma_fecha($row['fecha_ingreso']); ?></td>
            <td class="text-center"><?php echo transforma_fecha($row['fecha_registro']); ?></td>
        </tr>
    <?php endforeach; ?>
<?php else: ?>
    <tr><td colspan="5" class="text-center">No se encontraron estudiantes para el filtro seleccionado.</td></tr>
<?php endif; ?>
</tbody>
</table>
</div>
</div>
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