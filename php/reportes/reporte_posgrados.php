<?php
// -------------------------------------------------------------
// reporte_posgrados.php
// -------------------------------------------------------------

// Iniciar sesión si no está iniciada
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// 1) Conexión a la base de datos
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
    die("Error: no se encontró conexion.php. Rutas buscadas: " . implode(", ", $possible_paths));
}
if (isset($con) && $con instanceof mysqli) {
    $conn = $con;
} elseif (isset($conn) && $conn instanceof mysqli) {
    // ya existe
} else {
    die("Error: la conexión a la base de datos no está inicializada.");
}
  
// 2) Filtros seleccionados
$anio = isset($_GET['anio']) && $_GET['anio'] !== '' && is_numeric($_GET['anio']) ? intval($_GET['anio']) : null;
$programa = isset($_GET['programa']) && $_GET['programa'] !== '' && is_numeric($_GET['programa']) ? intval($_GET['programa']) : null;

// 3) Listas para los selects
// Consulta para años - Si hay programa seleccionado, filtrar por ese programa
if ($programa !== null) {
    $sqlAnios = "SELECT DISTINCT YEAR(e.fecha_ingreso) AS anio 
                 FROM estudiante_programa e 
                 WHERE e.programa_id = ? 
                 ORDER BY anio ASC";
    $stmtAnios = mysqli_prepare($conn, $sqlAnios);
    mysqli_stmt_bind_param($stmtAnios, "i", $programa);
    mysqli_stmt_execute($stmtAnios);
    $resAnios = mysqli_stmt_get_result($stmtAnios);
} else {
    $sqlAnios = "SELECT DISTINCT YEAR(fecha_ingreso) AS anio FROM estudiante_programa ORDER BY anio ASC";
    $resAnios = mysqli_query($conn, $sqlAnios);
}

$anios = [];
while ($r = mysqli_fetch_assoc($resAnios)) {
    $anios[] = $r['anio'];
}

$sqlProgramas = "SELECT id, nombre FROM programa ORDER BY nombre ASC";
$resProgramas = mysqli_query($conn, $sqlProgramas);
$programas = [];
while ($p = mysqli_fetch_assoc($resProgramas)) {
    $programas[] = $p;
}

// 4) Consulta principal dinámica
$sql = "SELECT 
            p.documento_identidad,
            CONCAT_WS(' ', p.primer_apellido, p.segundo_apellido) AS apellidos,
            CONCAT_WS(' ', p.primer_nombre, p.segundo_nombre) AS nombres,
            pr.nombre AS programa,
            e.fecha_ingreso
        FROM estudiante_programa e
        INNER JOIN persona p ON p.id = e.persona_id
        INNER JOIN programa pr ON pr.id = e.programa_id
        WHERE 1=1";

$params = [];
$types = "";

if ($anio !== null) {
    $sql .= " AND YEAR(e.fecha_ingreso) = ?";
    $params[] = $anio;
    $types .= "i";
}
if ($programa !== null) {
    $sql .= " AND e.programa_id = ?";
    $params[] = $programa;
    $types .= "i";
}

$sql .= " ORDER BY e.fecha_ingreso ASC, p.primer_apellido ASC, p.primer_nombre ASC";

$stmt = mysqli_prepare($conn, $sql);
if (!empty($params)) {
    mysqli_stmt_bind_param($stmt, $types, ...$params);
}
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

// Guardar filas en array
$rows = [];
if ($result) {
    while ($r = mysqli_fetch_assoc($result)) {
        $rows[] = $r;
    }
}

// 5) Generación de PDF con TCPDF
if (isset($_GET['pdf']) && $_GET['pdf'] == '1') {
    $tcpdf_path = __DIR__ . '/../../libs/TCPDF/tcpdf.php';
    if (!file_exists($tcpdf_path)) {
        die("Error: no se encontró TCPDF en la ruta esperada: $tcpdf_path");
    }
    require_once $tcpdf_path;

    if (ob_get_length()) {
        ob_end_clean();
    }

    $pdf = new TCPDF();
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('SIGEP');
    $pdf->SetTitle('Reporte de Estudiantes de Postgrado');
    $pdf->SetMargins(15, 20, 15);
    $pdf->AddPage();

    $pdf->SetFont('helvetica', 'B', 14);
    $pdf->Cell(0, 10, "Reporte de Estudiantes de Postgrado", 0, 1, 'C');
    $pdf->Ln(5);
    $pdf->SetFont('helvetica', '', 10);

    $html = '<table border="1" cellpadding="4" cellspacing="0" style="border-collapse:collapse; width:100%;">';
    $html .= '<thead><tr style="background-color:#d3d3d3; color:#000;">';
    $html .= '<th align="center"><b>Documento</b></th>';
    $html .= '<th align="center"><b>Apellidos</b></th>';
    $html .= '<th align="center"><b>Nombres</b></th>';
    $html .= '<th align="center"><b>Programa</b></th>';
    $html .= '<th align="center"><b>Fecha de Ingreso</b></th>';
    $html .= '</tr></thead><tbody>';

    if (count($rows) > 0) {
        foreach ($rows as $row) {
            $html .= '<tr>';
            $html .= '<td align="center">' . htmlspecialchars($row['documento_identidad']) . '</td>';
            $html .= '<td>' . htmlspecialchars($row['apellidos']) . '</td>';
            $html .= '<td>' . htmlspecialchars($row['nombres']) . '</td>';
            $html .= '<td>' . htmlspecialchars($row['programa']) . '</td>';
            $html .= '<td align="center">' . htmlspecialchars($row['fecha_ingreso']) . '</td>';
            $html .= '</tr>';
        }
    } else {
        $html .= '<tr><td colspan="5" align="center">No se encontraron estudiantes.</td></tr>';
    }

    $html .= '</tbody></table>';
    $html .= '<br/><div style="font-size:10px;color:#666;">Generado el: ' . date('d/m/Y') . '</div>';

    $pdf->writeHTML($html, true, false, true, false, '');
    $filename = "reporte_postgrados.pdf";
    $pdf->Output($filename, 'I');
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Reporte de estudiantes</title>
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
}
.table tbody tr:hover { 
    background: rgba(47,141,70,0.04); 
}
.btn-filtrar { 
    background-color: #007BFF; 
    border-color: #007BFF; 
    color: #fff; 
}
.btn-filtrar:hover { 
    background-color: #0056b3; 
    border-color: #0056b3; 
    color: #fff;
}
.btn-verde { 
    background-color: #28a745; 
    border-color: #28a745; 
    color: #fff; 
}
.btn-verde:hover { 
    background-color: #218838; 
    border-color: #1e7e34; 
    color: #fff; 
}
.container { 
    margin-top: 20px; 
}
h3 { 
    margin-bottom: 20px; 
    color: #333; 
}
/* Ajustes para Bootstrap 3 */
.navbar { 
    margin-bottom: 20px; 
}
.name-user { 
    color: #333; 
    padding: 15px 0;
}
.name-user a { 
    color: #333; 
    text-decoration: underline; 
}
.form-group {
    margin-right: 10px;
}
.table-responsive {
    margin-top: 20px;
}
</style>

<script>
function cargarAniosPorPrograma() {
    const programaId = document.getElementById('programaSelect').value;
    const anioSelect = document.getElementById('anioSelect');
    const anioActual = '<?php echo $anio; ?>';
    
    // Si no hay programa seleccionado, recargar la página sin filtro de año
    if (programaId === '') {
        window.location.href = window.location.pathname + '?programa=';
        return;
    }
    
    // Hacer una petición AJAX para obtener los años del programa seleccionado
    fetch(`get_anios_por_programa.php?programa_id=${programaId}`)
        .then(response => response.json())
        .then(data => {
            // Limpiar el select de años
            anioSelect.innerHTML = '<option value="">Todos</option>';
            
            // Agregar los nuevos años
            data.forEach(anio => {
                const option = document.createElement('option');
                option.value = anio;
                option.textContent = anio;
                // Si el año coincide con el que estaba seleccionado, seleccionarlo
                if (anio == anioActual) {
                    option.selected = true;
                }
                anioSelect.appendChild(option);
            });
        })
        .catch(error => console.error('Error:', error));
}

// Cargar años cuando cambia el programa
document.addEventListener('DOMContentLoaded', function() {
    const programaSelect = document.getElementById('programaSelect');
    programaSelect.addEventListener('change', cargarAniosPorPrograma);
    
    // Si hay un programa seleccionado al cargar la página, cargar sus años
    if (programaSelect.value !== '') {
        cargarAniosPorPrograma();
    }
});
</script>
</head>
<body>

<?php
// Incluir el navbar con ruta corregida
$navbar_path = __DIR__ . '/../navbar.php';
if (file_exists($navbar_path)) {
    include $navbar_path;
} else {
    // Si no encuentra el navbar, mostrar uno básico con Bootstrap 3
    ?>
    <nav class="navbar navbar-default" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/sigep_prototipo/inicio.php"><b>SIGEP</b></a>
            </div>
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav">
                    <li><a href="/sigep_prototipo/personas.php">PERSONAS</a></li>
                    <li><a href="/sigep_prototipo/postgrados.php">POSTGRADOS</a></li>
                    <li><a href="/sigep_prototipo/index.php">REGISTRO NUEVO INGRESO</a></li>
                    <li><a href="/sigep_prototipo/reportes.php">REPORTES</a></li>
                    <?php if(isset($_SESSION['user_id']) && $_SESSION['user_id'] == 1) { ?>
                        <li><a href="/sigep_prototipo/cierre_expediente.php">CIERRE</a></li>
                    <?php } ?>
                </ul>
                <form class="navbar-form navbar-left" role="search" action="/sigep_prototipo/buscar.php">
                    <div class="form-group">
                        <input type="search" maxlength="10" name="s" class="form-control" placeholder="Buscar">
                    </div>
                    <button type="submit" class="btn btn-default">
                        <i class="glyphicon glyphicon-search"></i>
                    </button>
                </form>
                <div class="pull-right name-user">
                    <i class="glyphicon glyphicon-user"></i> 
                    <?php echo isset($_SESSION['name']) ? $_SESSION['name'] : 'Usuario'; ?> | 
                    <a href="/sigep_prototipo/php/logout.php" onclick="return confirm('¿Está seguro que desea cerrar sesión?');">
                        Cerrar Sesión <i class="glyphicon glyphicon-log-out"></i>
                    </a>
                </div>
            </div>
        </div>
    </nav>
    <?php
}
?>

<div class="container">
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

    <!-- Botón descarga: redirige a la misma página con pdf=1 conservando filtros -->
    <a href="?<?php
        $qs = [];
        if ($anio !== null) $qs['anio'] = $anio;
        if ($programa !== null) $qs['programa'] = $programa;
        $qs['pdf'] = '1';
        echo http_build_query($qs);
    ?>" class="btn btn-verde" style="margin-left:10px;">📄 Descargar PDF</a>

    <!-- <a href="../../reportes.php" class="btn btn-verde" style="margin-left:10px;">⬅ Ir atrás</a>-->
</form>

<div class="table-responsive">
<table class="table table-hover table-bordered">
<thead class="text-center">
<tr>
<th class="text-center">Documento</th>
<th class="text-center">Apellidos</th>
<th class="text-center">Nombres</th>
<th class="text-center">Programa</th>
<th class="text-center">Fecha de Ingreso</th>
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
            <td class="text-center"><?php echo htmlspecialchars($row['fecha_ingreso']); ?></td>
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

<!-- jQuery y Bootstrap JS para Bootstrap 3 -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html>