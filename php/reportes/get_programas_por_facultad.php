<?php
// get_programas_por_facultad.php
header('Content-Type: application/json');

include "../../php/conexion.php";

$facultad_id = isset($_GET['facultad_id']) && $_GET['facultad_id'] !== '' ? intval($_GET['facultad_id']) : null;

if ($facultad_id) {
    // Obtener programas por facultad (a través de postgrado)
    $sql = "SELECT DISTINCT p.id, p.nombre 
            FROM programa p
            INNER JOIN postgrado pg ON p.postgrado_id = pg.id
            WHERE pg.facultad_nucleo_id = $facultad_id
            ORDER BY p.nombre ASC";
} else {
    // Obtener todos los programas
    $sql = "SELECT id, nombre FROM programa ORDER BY nombre ASC";
}

$result = mysqli_query($con, $sql);

$programas = [];
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $programas[] = [
            'id' => $row['id'],
            'nombre' => $row['nombre']
        ];
    }
}

echo json_encode($programas);
?>