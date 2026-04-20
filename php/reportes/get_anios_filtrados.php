<?php
// get_anios_filtrados.php
header('Content-Type: application/json');

include "../../php/conexion.php";

$programa_id = isset($_GET['programa_id']) && $_GET['programa_id'] !== '' ? intval($_GET['programa_id']) : null;
$facultad_id = isset($_GET['facultad_id']) && $_GET['facultad_id'] !== '' ? intval($_GET['facultad_id']) : null;

$sql = "SELECT DISTINCT YEAR(e.fecha_ingreso) AS anio
        FROM estudiante_programa e
        INNER JOIN programa p ON e.programa_id = p.id";

if ($programa_id) {
    $sql .= " WHERE e.programa_id = $programa_id";
} elseif ($facultad_id) {
    $sql .= " INNER JOIN postgrado pg ON p.postgrado_id = pg.id
              WHERE pg.facultad_nucleo_id = $facultad_id";
}

$sql .= " ORDER BY anio DESC";

$result = mysqli_query($con, $sql);

$anios = [];
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $anios[] = $row['anio'];
    }
}

echo json_encode($anios);
?>