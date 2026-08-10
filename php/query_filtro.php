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
    'inactivo' => [3, 4],
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
            p.documento_identidad,
            CONCAT_WS(' ', p.primer_apellido, p.segundo_apellido) AS apellidos,
            CONCAT_WS(' ', p.primer_nombre, p.segundo_nombre) AS nombres,
            pr.nombre AS programa,
            e.fecha_ingreso, 
            e.created_at as fecha_registro, 
            p.fecha_nacimiento as fecha_nacimiento,
            CASE 
                WHEN e.condicion_estudiante_id = 1 THEN 'Activo'
                WHEN e.condicion_estudiante_id = 2 THEN 'Egresado'
                WHEN e.condicion_estudiante_id IN (3,4) THEN 'Inactivo'
                WHEN e.condicion_estudiante_id IN (5,6) THEN 'Retirado/Desincorporado'
                ELSE 'Desconocido'
            END AS condicion_estudiante,
            f.nombre as facultad
        FROM estudiante_programa e
        INNER JOIN persona p ON p.id = e.persona_id
        INNER JOIN programa pr ON pr.id = e.programa_id
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
if ($estatus !== null) {
    //var_dump($estatus);
    //var_dump($estatus_ids);
    if ($estatus == 'activo' || $estatus == 'retirado'){
      
      if ($estatus == 'activo') {
            $params_1 = [1, 3, 4];
            $types .= "iii";
            $sql .= " AND ce.id IN (?,?,?)";
        }
        if ($estatus == 'retirado'){
            $params_1 = [5, 6];
            $types .= "ii";
            $sql .= " AND ce.id IN (?,?)";
        }
        if (empty($params))
            $params = $params_1;
        else
            $params = array_merge($params, $params_1);
        
    }
    else {
        $sql .= " AND ce.id = ?";
        $params[] = $estatus_ids[0];
        $types .= "i";
    }
      
}


// Filtro por estatus (agrupado)
if (!empty($estatus_ids)) {
    $placeholders = implode(',', array_fill(0, count($estatus_ids), '?'));
    $sql .= " AND e.condicion_estudiante_id IN ($placeholders)";
    foreach ($estatus_ids as $id) {
        $params[] = $id;
        $types .= "i";
    }
}


// Si hay filtro de facultad y encontramos programas
if (!empty($programas_facultad)) {
    $ids_string = implode(',', $programas_facultad);
    $sql .= " AND e.programa_id IN ($ids_string)";
}


$sql .= " ORDER BY e.fecha_ingreso DESC, p.primer_apellido ASC, p.primer_nombre ASC";



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
   // var_dump($debug_sql); 
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
?>