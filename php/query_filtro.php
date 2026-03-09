<?php

$sql = "SELECT 
            p.documento_identidad,
            CONCAT_WS(' ', p.primer_apellido, p.segundo_apellido) AS apellidos,
            CONCAT_WS(' ', p.primer_nombre, p.segundo_nombre) AS nombres,
            pr.nombre AS programa,
            e.fecha_ingreso, e.created_at as fecha_registro, p.fecha_nacimiento as fecha_nacimiento
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

$stmt = mysqli_prepare($con, $sql);
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

?>