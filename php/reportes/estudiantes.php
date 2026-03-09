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

// 4) Consulta principal dinamica
include "../query_filtro.php";

// 5)  PDF con TCPDF
if (isset($_GET['pdf']) && $_GET['pdf'] == '1') {
   crear_pdf($anio,$programa);
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
    <div class="form-group">
        <label for="anioSelect"><strong>Año</strong></label>
            <select id="anioSelect" name="anio" class="form-control" style="width:200px; margin-left:10px; margin-right:20px;">
            <option value="">Todos</option>
                <?php foreach ($anios as $a): ?>
                <option value="<?php echo $a; ?>" <?php if ($anio !== null && $a == $anio) echo "selected"; ?>><?php echo $a; ?></option>
                 <?php endforeach; ?>
             </select>
    </div>

    <div class="form-group">
        <label for="programaSelect"><strong>Postgrado</strong></label>
        <select id="programaSelect" name="programa" class="form-control" style="width:250px; margin-left:10px; margin-right:20px;">
            <option value="">Todos</option>
            <?php foreach ($programas as $pr): ?>
                <option value="<?php echo $pr['id']; ?>" <?php if ($programa !== null && $programa == $pr['id']) echo "selected"; ?>>
                    <?php echo htmlspecialchars($pr['nombre']); ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <button type="submit" class="btn btn-filtrar">Filtrar</button>

    <!-- Boton descarga: -->
    <a href="?<?php
        $qs = [];
        if ($anio !== null) $qs['anio'] = $anio;
        if ($programa !== null) $qs['programa'] = $programa;
        $qs['pdf'] = '1';
        echo http_build_query($qs);
    ?>" class="btn btn-verde" style="margin-left:10px;" target="_blank">📄 Descargar PDF</a>

</form>

<div class="table-responsive">
<table class="table table-hover table-bordered">
<thead class="text-center">
<tr>
<th class="text-center">Documento</th>
<th class="text-center">Apellidos</th>
<th class="text-center">Nombres</th>
<th class="text-center">Programa</th>
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
</body>
</html>