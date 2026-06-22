<?php
// get_anios_por_programa.php

header('Content-Type: application/json');

// Ruta CORRECTA: subir un nivel a php/
$base_path = __DIR__ . '/../';
include $base_path . "conexion.php";

if (!isset($con) || !$con) {
    echo json_encode([]);
    exit;
}

$programa_id = isset($_GET['programa_id']) ? intval($_GET['programa_id']) : 0;

$anios = [];

if ($programa_id > 0) {
    $sql = "SELECT DISTINCT YEAR(fecha_ingreso) AS anio 
            FROM estudiante_programa 
            WHERE programa_id = $programa_id 
            AND fecha_ingreso IS NOT NULL
            AND YEAR(fecha_ingreso) IS NOT NULL
            ORDER BY anio ASC";
    
    $result = mysqli_query($con, $sql);
    
    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $anios[] = $row['anio'];
        }
    }
}

echo json_encode($anios);
?>