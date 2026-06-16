<?php
// php/personas/server_side.php
include "../conexion.php";

// Variables de DataTables
$search = isset($_POST['search']['value']) ? $_POST['search']['value'] : '';
$order_column = isset($_POST['order'][0]['column']) ? intval($_POST['order'][0]['column']) : 0;
$order_dir = isset($_POST['order'][0]['dir']) ? $_POST['order'][0]['dir'] : 'DESC';
$start = isset($_POST['start']) ? intval($_POST['start']) : 0;
$length = isset($_POST['length']) ? intval($_POST['length']) : 10;

// Columnas permitidas para ordenar
$columns = ['documento_identidad', 'primer_apellido', 'primer_nombre', 'sexo'];

// Construir consulta WHERE
$where = "1=1";
if (!empty($search)) {
    $search = mysqli_real_escape_string($con, $search);
    $where .= " AND (documento_identidad LIKE '%$search%' 
                     OR primer_apellido LIKE '%$search%' 
                     OR segundo_apellido LIKE '%$search%' 
                     OR primer_nombre LIKE '%$search%' 
                     OR segundo_nombre LIKE '%$search%')";
}

// Contar total de registros (sin filtro)
$sql_total = "SELECT COUNT(*) as total FROM persona";
$result_total = $con->query($sql_total);
$total_registros = $result_total->fetch_assoc()['total'];

// Contar registros filtrados
$sql_filtered = "SELECT COUNT(*) as total FROM persona WHERE $where";
$result_filtered = $con->query($sql_filtered);
$total_filtrados = $result_filtered->fetch_assoc()['total'];

// Obtener datos con orden y límite
$order_by = isset($columns[$order_column]) ? $columns[$order_column] : 'id';
$sql = "SELECT id, nacionalidad, documento_identidad, primer_apellido, segundo_apellido, 
               primer_nombre, segundo_nombre, sexo 
        FROM persona 
        WHERE $where 
        ORDER BY $order_by $order_dir 
        LIMIT $start, $length";

$result = $con->query($sql);

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = [
        'documento' => $row['nacionalidad'] . ' - ' . $row['documento_identidad'],
        'apellidos' => strtoupper($row['primer_apellido'] . ' ' . $row['segundo_apellido']),
        'nombres' => strtoupper($row['primer_nombre'] . ' ' . $row['segundo_nombre']),
        'sexo' => $row['sexo'],
        'acciones' => '<a href="./php/personas/editar.php?sour=list&id=' . $row['id'] . '" class="btn btn-warning btn-sm">Editar</a> 
                       <a href="estudios.php?sour=list&id=' . $row['id'] . '" class="btn btn-primary btn-sm">Estudios</a>'
    ];
}

// Devolver respuesta JSON
echo json_encode([
    'draw' => isset($_POST['draw']) ? intval($_POST['draw']) : 1,
    'recordsTotal' => $total_registros,
    'recordsFiltered' => $total_filtrados,
    'data' => $data
]);
?>