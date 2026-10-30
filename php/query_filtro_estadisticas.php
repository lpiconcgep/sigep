<?php
// query_filtro.php - VERSIÓN LIMPIA (SIN DEPURACIÓN)

// Inicializar rows como array vacío
$rows = [];

// Verificar conexión
if (!$con) {
    die("Error de conexión a la base de datos");
}

// Mapeo de estatus para la consulta
$estatus_map = [
    'activo' => [1,3,4],
    'egresado' => [2],
    'retirado' => [5, 6]
];


// Convertir el filtro a los IDs correspondientes
$estatus_ids = [];

if (isset($estatus) && $estatus !== null && $estatus !== '' && isset($estatus_map[$estatus])) {
    $estatus_ids = $estatus_map[$estatus];
}


// Si hay filtro de facultad, obtenemos los programas de esa facultad
$programas_facultad = [];
if (isset($facultad) && $facultad !== null && $facultad !== '') {

    // Obtener los postgrados de la facultad
    $sql_postgrados = "SELECT id FROM postgrado WHERE facultad_nucleo_id = $facultad";
    $res_postgrados = mysqli_query($con, $sql_postgrados);
    
    if ($res_postgrados && mysqli_num_rows($res_postgrados) > 0) {
        $postgrados_ids = [];
        while ($row = mysqli_fetch_assoc($res_postgrados)) {
            $postgrados_ids[] = $row['id'];
        }
        $postgrados_str = implode(',', $postgrados_ids);

        
        // Obtener los programas de esos postgrados
        $sql_programas = "SELECT id FROM programa WHERE postgrado_id IN ($postgrados_str)";
        $res_programas = mysqli_query($con, $sql_programas);
        
        if ($res_programas) {
            while ($row = mysqli_fetch_assoc($res_programas)) {
                $programas_facultad[] = $row['id'];
            }
        }
    }
}

// Consulta principal con CASE para mostrar el nombre del estatus
$sql = "SELECT 
            pr.nombre AS programa,gr.abreviatura, e.condicion_estudiante_id, f.nombre as facultad, 
            SUM(CASE WHEN e.condicion_estudiante_id IN (1,3,4) THEN 1 ELSE 0 END) AS matricula,
            SUM(CASE WHEN e.condicion_estudiante_id = 2      THEN 1 ELSE 0 END) AS egresados,
            SUM(CASE WHEN e.condicion_estudiante_id IN (5,6) THEN 1 ELSE 0 END) AS retirados
        FROM estudiante_programa e
        INNER JOIN persona p ON p.id = e.persona_id
        INNER JOIN programa pr ON pr.id = e.programa_id
        INNER JOIN grado_academico gr ON gr.id = pr.grado_academico_id
        INNER JOIN postgrado post ON pr.postgrado_id = post.id
        INNER JOIN facultad_nucleo f ON post.facultad_nucleo_id = f.id
        INNER JOIN condicion_estudiante ce ON e.condicion_estudiante_id = ce.id
        
        WHERE 1=1";

$params = [];
$types = "";

if (isset($anio) && $anio !== null) {
    $sql .= " AND YEAR(e.fecha_ingreso) = ?";
    $params[] = $anio;
    $types .= "i";
}

if (isset($programa) && $programa !== null) {
    $sql .= " AND e.programa_id = ?";
    $params[] = $programa;
    $types .= "i";

}

if ($facultad !== null) {
    $sql .= " AND f.id = ?";
    $params[] = $facultad;
    $types .= "i";

}

if ($gradoA !== null) {
    $sql .= " AND pr.grado_academico_id = ?";
    $params[] = $gradoA;
    $types .= "i";

}



// Si hay filtro de facultad y encontramos programas
if (!empty($programas_facultad)) {
    $ids_string = implode(',', $programas_facultad);
    $sql .= " AND e.programa_id IN ($ids_string)";
}


$sql .= " GROUP BY pr.id, pr.nombre, f.nombre";

if(isset($option_report) && $option_report == 'retiros' )
    $sql .= " ORDER BY e.fecha_retiro DESC, p.primer_apellido ASC, p.primer_nombre ASC";
else
    $sql .= " ORDER BY pr.nombre ASC";

// Ejecutar la consulta
if (!empty($params)) {

    $debug_sql = $sql;
    foreach ($params as $param) {
        // Escapamos el valor por seguridad visual y determinamos si lleva comillas
        $value = is_numeric($param) ? $param : "'" . addslashes($param) . "'";
        // Reemplaza el primer '?' que encuentre en la cadena
        $debug_sql = preg_replace('/\?/', $value, $debug_sql, 1);
    }
    // Imprime el query final en el navegador o código fuente
    // O puedes usar: error_log($debug_sql); para enviarlo al log de errores de PHP
    // ----------------------------------------------------

    $stmt = mysqli_prepare($con, $sql);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, $types, ...$params);
        mysqli_stmt_execute($stmt);
 
        $result = mysqli_stmt_get_result($stmt);
        
        if ($result) {
            while ($r = mysqli_fetch_assoc($result)) {
                $rows[] = $r;
            }
        }
    }
} else {

    $result = mysqli_query($con, $sql);
    if ($result) {
        while ($r = mysqli_fetch_assoc($result)) {
            $rows[] = $r;
        }
    }
}

function debug_query($sql, $params, $types) {
    $i = 0;
    return preg_replace_callback('/\?/', function($m) use (&$i, $params, $types) {
        $val  = $params[$i];
        $type = $types[$i];
        $i++;
        if ($val === null) return 'NULL';
        if ($type === 'i') return (int)$val;
        if ($type === 'd') return (float)$val;
        return "'" . addslashes($val) . "'";  // 's' y 'b'
    }, $sql);
}
?>