<?php
// query_filtro.php - VERSIÓN DE DEPURACIÓN

// Inicializar rows como array vacío
$rows = [];

// Verificar conexión
if (!$con) {
    die("Error de conexión a la base de datos");
}

// Si hay filtro de facultad, obtenemos los programas de esa facultad
$programas_facultad = [];
if (isset($facultad) && $facultad !== null && $facultad !== '') {
    echo "<!-- DEPURACIÓN: Facultad seleccionada: $facultad -->\n";
    
    // Obtener los postgrados de la facultad
    $sql_postgrados = "SELECT id FROM postgrado WHERE facultad_nucleo_id = $facultad";
    $res_postgrados = mysqli_query($con, $sql_postgrados);
    
    if (!$res_postgrados) {
        echo "<!-- Error en postgrados: " . mysqli_error($con) . " -->\n";
    } elseif (mysqli_num_rows($res_postgrados) > 0) {
        $postgrados_ids = [];
        while ($row = mysqli_fetch_assoc($res_postgrados)) {
            $postgrados_ids[] = $row['id'];
        }
        $postgrados_str = implode(',', $postgrados_ids);
        echo "<!-- Postgrados encontrados: $postgrados_str -->\n";
        
        // Obtener los programas de esos postgrados
        $sql_programas = "SELECT id FROM programa WHERE postgrado_id IN ($postgrados_str)";
        $res_programas = mysqli_query($con, $sql_programas);
        
        if (!$res_programas) {
            echo "<!-- Error en programas: " . mysqli_error($con) . " -->\n";
        } else {
            while ($row = mysqli_fetch_assoc($res_programas)) {
                $programas_facultad[] = $row['id'];
            }
            echo "<!-- Programas encontrados: " . implode(',', $programas_facultad) . " -->\n";
        }
    } else {
        echo "<!-- No se encontraron postgrados para esta facultad -->\n";
    }
}

// Consulta principal
$sql = "SELECT 
            p.documento_identidad,
            CONCAT_WS(' ', p.primer_apellido, p.segundo_apellido) AS apellidos,
            CONCAT_WS(' ', p.primer_nombre, p.segundo_nombre) AS nombres,
            pr.nombre AS programa,
            e.fecha_ingreso, 
            e.created_at as fecha_registro, 
            p.fecha_nacimiento as fecha_nacimiento
        FROM estudiante_programa e
        INNER JOIN persona p ON p.id = e.persona_id
        INNER JOIN programa pr ON pr.id = e.programa_id
        WHERE 1=1";

$params = [];
$types = "";

echo "<!-- Consulta base: $sql -->\n";

if (isset($anio) && $anio !== null) {
    $sql .= " AND YEAR(e.fecha_ingreso) = ?";
    $params[] = $anio;
    $types .= "i";
    echo "<!-- Filtro año: $anio -->\n";
}
if (isset($programa) && $programa !== null) {
    $sql .= " AND e.programa_id = ?";
    $params[] = $programa;
    $types .= "i";
    echo "<!-- Filtro programa: $programa -->\n";
}
// Si hay filtro de facultad y encontramos programas
if (!empty($programas_facultad)) {
    $ids_string = implode(',', $programas_facultad);
    $sql .= " AND e.programa_id IN ($ids_string)";
    echo "<!-- Filtro facultad programas: $ids_string -->\n";
}

$sql .= " ORDER BY e.fecha_ingreso ASC, p.primer_apellido ASC, p.primer_nombre ASC";

echo "<!-- SQL final: $sql -->\n";

// Ejecutar la consulta
if (!empty($params)) {
    $stmt = mysqli_prepare($con, $sql);
    if ($stmt === false) {
        echo "<!-- Error en prepare: " . mysqli_error($con) . " -->\n";
    } else {
        mysqli_stmt_bind_param($stmt, $types, ...$params);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        if ($result) {
            while ($r = mysqli_fetch_assoc($result)) {
                $rows[] = $r;
            }
            echo "<!-- Filas encontradas: " . count($rows) . " -->\n";
        } else {
            echo "<!-- Error en get_result: " . mysqli_error($con) . " -->\n";
        }
    }
} else {
    // Consulta sin parámetros
    $result = mysqli_query($con, $sql);
    if ($result) {
        while ($r = mysqli_fetch_assoc($result)) {
            $rows[] = $r;
        }
        echo "<!-- Filas encontradas (sin parámetros): " . count($rows) . " -->\n";
    } else {
        echo "<!-- Error en query: " . mysqli_error($con) . " -->\n";
    }
}

echo "<!-- Total filas final: " . count($rows) . " -->\n";
?>