<?php
// get_programas_por_facultad.php

header('Content-Type: application/json');

// Ruta CORRECTA: subir un nivel a php/
$base_path = __DIR__ . '/../';
include $base_path . "conexion.php";

if (!isset($con) || !$con) {
    echo json_encode(['error' => 'Error de conexión']);
    exit;
}

$facultad_id = isset($_GET['facultad_id']) ? intval($_GET['facultad_id']) : 0;

$response = [
    'programas' => [],
    'anios' => []
];

if ($facultad_id > 0) {
    $sql_programas = "SELECT p.id, p.nombre 
                      FROM programa p
                      INNER JOIN postgrado po ON p.postgrado_id = po.id
                      WHERE po.facultad_nucleo_id = $facultad_id
                      ORDER BY p.nombre ASC";
    
    $result_programas = mysqli_query($con, $sql_programas);
    
    if ($result_programas) {
        while ($row = mysqli_fetch_assoc($result_programas)) {
            $response['programas'][] = $row;
        }
    }
    
    $sql_anios = "SELECT DISTINCT YEAR(e.fecha_ingreso) AS anio 
                  FROM estudiante_programa e
                  INNER JOIN programa p ON e.programa_id = p.id
                  INNER JOIN postgrado po ON p.postgrado_id = po.id
                  WHERE po.facultad_nucleo_id = $facultad_id
                  AND e.fecha_ingreso IS NOT NULL
                  AND YEAR(e.fecha_ingreso) IS NOT NULL
                  ORDER BY anio ASC";
    
    $result_anios = mysqli_query($con, $sql_anios);
    
    if ($result_anios) {
        while ($row = mysqli_fetch_assoc($result_anios)) {
            $response['anios'][] = $row['anio'];
        }
    }
}

echo json_encode($response);
?>