<?php
// php/personas/server_side.php - VERSIÓN SIMPLIFICADA

session_start();

if (!isset($_SESSION['session']) || $_SESSION['session'] != 'true') {
    header('Content-Type: application/json');
    echo json_encode(['error' => 'No autorizado']);
    exit;
}

$base_path = __DIR__ . '/../';
include $base_path . "conexion.php";

if (!isset($con) || !$con) {
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Error de conexión']);
    exit;
}

// Parámetros
$draw = isset($_POST['draw']) ? intval($_POST['draw']) : 1;
$start = isset($_POST['start']) ? intval($_POST['start']) : 0;
$length = isset($_POST['length']) ? intval($_POST['length']) : 10;
$search = isset($_POST['search']['value']) ? trim($_POST['search']['value']) : '';

// Construir WHERE
$where = "";
if (!empty($search)) {
    $s = mysqli_real_escape_string($con, $search);
    $where = "WHERE (
        documento_identidad LIKE '%$s%' OR
        primer_apellido LIKE '%$s%' OR
        segundo_apellido LIKE '%$s%' OR
        primer_nombre LIKE '%$s%' OR
        segundo_nombre LIKE '%$s%'
    )";
}

// Total
$count_sql = "SELECT COUNT(*) as total FROM persona $where";
$count_result = mysqli_query($con, $count_sql);
$total = 0;
if ($count_result) {
    $row = mysqli_fetch_assoc($count_result);
    $total = $row['total'];
}

// Datos
$sql = "SELECT id, documento_identidad, primer_apellido, segundo_apellido, primer_nombre, segundo_nombre, sexo, nacionalidad 
        FROM persona $where 
        ORDER BY id DESC 
        LIMIT $start, $length";
$result = mysqli_query($con, $sql);

$data = [];
while ($row = mysqli_fetch_assoc($result)) {
    $sexo = 'No especificado';
    if ($row['sexo'] == 'M') $sexo = 'Masculino';
    elseif ($row['sexo'] == 'F') $sexo = 'Femenino';
    
    $data[] = [
        'documento_identidad' => $row['nacionalidad'] . ' - ' . $row['documento_identidad'],
        'apellidos' => strtoupper($row['primer_apellido']) . ' ' . strtoupper($row['segundo_apellido']),
        'nombres' => strtoupper($row['primer_nombre']) . ' ' . strtoupper($row['segundo_nombre']),
        'sexo' => $sexo,
        'acciones' => '
            <a href="./php/personas/editar.php?sour=list&id=' . $row['id'] . '" class="btn btn-warning btn-sm">Editar</a>
            <a href="estudios.php?sour=list&id=' . $row['id'] . '" class="btn btn-primary btn-sm">Estudios</a>
        '
    ];
}

header('Content-Type: application/json');
echo json_encode([
    'draw' => $draw,
    'recordsTotal' => $total,
    'recordsFiltered' => $total,
    'data' => $data
]);
exit;
?>