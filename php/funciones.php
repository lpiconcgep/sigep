<?php

function agregar_movimiento($POST = NULL, $tipo = NULL){
    include "conexion.php";

    /* OPCION == 1 -> INSCRIBIR ESTUDIANTE */
    if($tipo == 1){

        $id_sql_insertado = $con->query("SELECT MAX(id) as estudiante_programa_id FROM estudiante_programa WHERE persona_id = ".$_POST['id']);

        if($id_sql_insertado->num_rows>0){
            $resultado_id_insert = array();
            while ($r_id=$id_sql_insertado->fetch_array()){
                $resultado_id_insert[] = $r_id;
            }
        }

        $estudiante_programa_id = $resultado_id_insert[0]['estudiante_programa_id'];    
        $sql_mov = "insert into movimiento_estudiante(estudiante_programa_id, tipo_movimiento_id,created_at,user_create) value (".$estudiante_programa_id.",".$tipo.",NOW(),".$_SESSION['user_id'].")";

        $query_mov = $con->query($sql_mov);
        if($query_mov!=null){
            if($tipo == 1)
            {
                $set = "fecha_ingreso, anio_cohorte, observaciones_expediente";
                $tipo_movimiento = "Nuevo Ingreso";
            }
            else{
                $set = "";
                $tipo_movimiento = "";
            }

            $movimiento_estudiante_id = $con->insert_id;
            
            $sql_desc = "INSERT INTO descripcion_movimiento(movimiento_estudiante_id,descripcion,".$set.", created_at,user_create) VALUES (";

            $sql_desc = $sql_desc.$movimiento_estudiante_id.",'".$tipo_movimiento."','".$_POST['fecha_ingreso']."','".$_POST['anio_cohorte']."','".$_POST['observaciones']."',NOW(),".$_SESSION['user_id'].")";

            $query_desc_mov = $con->query($sql_desc);    
        }
    }
    elseif ($tipo == "2") { /* OPCION == 2 -> EGRESAR ESTUDIANTE */

        $estudiante_programa_id = $_POST['id'];    
        $sql_mov = "insert into movimiento_estudiante(estudiante_programa_id, tipo_movimiento_id,created_at,user_create) value (".$estudiante_programa_id.",".$tipo.",NOW(),".$_SESSION['user_id'].")";

        $query_mov = $con->query($sql_mov);
        if($query_mov!=null){
            $movimiento_estudiante_id = $con->insert_id;
            if($tipo == "2")
            {
                $sql_grado= "select * from grados where id = ".$_POST["grado_id"];
                $query_grado = $con->query($sql_grado);
                $grado=$query_grado->fetch_object();
                    
                $fecha_grado = $grado->fecha_grado;

                $set = "grado_id,fecha_cierre, fecha_grado, observaciones_cierre";
                $tipo_movimiento = "Egreso";

            }
            

            $sql_desc = "INSERT INTO descripcion_movimiento(movimiento_estudiante_id,descripcion,".$set.", created_at,user_create) VALUES (";

            $sql_desc = $sql_desc.$movimiento_estudiante_id.",'".$tipo_movimiento."','".$_POST["grado_id"]."','".$_POST['fecha_cierre']."','".$fecha_grado."','".$_POST['observaciones_cierre']."',NOW(),".$_SESSION['user_id'].")";

            $query_desc_mov = $con->query($sql_desc);
        }

    }
    elseif ($tipo == 3) { /* OPCION == 3 -> RETIRO ESTUDIANTE */

        $estudiante_programa_id = $_POST['id'];    
        $sql_mov = "insert into movimiento_estudiante(estudiante_programa_id, tipo_movimiento_id,created_at,user_create) value (".$estudiante_programa_id.",".$tipo.",NOW(),".$_SESSION['user_id'].")";

        $query_mov = $con->query($sql_mov);
        if($query_mov!=null){
            $movimiento_estudiante_id = $con->insert_id;
            $set = "fecha_retiro, fecha_registro_retiro,motivo_retiro_id,descripcion_motivo_retiro,observaciones_retiro,culmino_escolaridad";
            $tipo_movimiento = "Retiro";

            $sql_desc = "INSERT INTO descripcion_movimiento(movimiento_estudiante_id,descripcion,".$set.", created_at,user_create) VALUES (";

            $sql_desc = $sql_desc.$movimiento_estudiante_id.",'".$tipo_movimiento."','".$_POST['fecha_retiro']."','".$_POST['fecha_registro_retiro']."','".$_POST['motivo_retiro_id']."','".$_POST['descripcion_motivo_retiro']."','".$_POST['observaciones_retiro']."','no',NOW(),".$_SESSION['user_id'].")";

            
            $query_desc_mov = $con->query($sql_desc);
            
            
        }

    }
}
    
function consultar_facultades($facultad_id = '-1'){

    include "conexion.php";

    if($facultad_id == '-1')
    {
        $sql= "select id,nombre from facultad_nucleo ORDER BY nombre ASC";
    }
    else
    {
        $sql= "select id,nombre from facultad_nucleo WHERE id = {$facultad_id}";
    }

    $query = $con->query($sql);
    if($query->num_rows>0){
        $resultado = array();
        while ($r1=$query->fetch_object()){
            if($facultad_id == '-1')
                $resultado[] = $r1;
            else
                $resultado = $r1;
        }
    }
    else
    {
        $resultado = NULL;
    }
    return $resultado;

}

function consultar_postgrados($facultad_id = '-1'){

    include "conexion.php";
    

    if($facultad_id == '-1')
    {
        $sql = "select id,nombre,facultad_nucleo_id from postgrado order by facultad_nucleo_id,nombre ASC";
    }
    else
    {
        $sql = "select id,nombre,facultad_nucleo_id from postgrado WHERE facultad_nucleo_id = {$facultad_id} order by nombre ASC";
    }

    $query = $con->query($sql);
    if($query->num_rows>0){
        $resultado = array();
        while ($r1=$query->fetch_object()){
            $resultado[] = $r1;
        }
    }
    else
    {
        $resultado = NULL;
    }
    
    return $resultado;

}

function consultar_programas($postgrado_id = '-1'){

    include "conexion.php";

    if($postgrado_id == '-1')
    {
        $sql = "select id,nombre,postgrado_id from programa order by nombre ASC";
    }
    else
    {
        $sql = "select id,nombre, postgrado_id from programa WHERE postgrado_id = {$postgrado_id} order by nombre ASC";
    }

    $query = $con->query($sql);
    if($query->num_rows>0){
        $resultado = array();
        while ($r1=$query->fetch_object()){
            $resultado[] = $r1;
        }
    }
    else
    {
        $resultado = NULL;
    }
    
    
    return $resultado;

}

function consultar_programa_x_id($programa_id = '-1'){

    include "conexion.php";

    if($programa_id == '-1')
    {
        $resultado = NULL;
    }
    else
    {
        $sql = "SELECT p.id,p.nombre,g.nombre grado,g.otorga from programa p INNER JOIN grado_academico g ON p.grado_academico_id = g.id WHERE p.id = {$programa_id}";
    }

    $query = $con->query($sql);
    if($query->num_rows>0){
        $resultado = array();
        while ($r1=$query->fetch_object()){
            $resultado = $r1;
        }
    }
    else
    {
        $resultado = NULL;
    }
    
    
    return $resultado;

}

function get_cantidad_programas($valor_id, $opcion)
{
    include "conexion.php";
    
    $cantidad = 0;
    if($opcion == 'facultades')
    {
        $postgrados = consultar_postgrados($valor_id);

        if($postgrados != NULL)
        {
            foreach ($postgrados as $postgrado)
            {
                $postgrado_id = $postgrado->id;
                $sql_p = "select count(*) as cantidad from programa where postgrado_id = ".$postgrado_id;

                $query_p = $con->query($sql_p);
                if($query_p->num_rows>0)
                {
                    $programas = '';
                    while ($r1=$query_p->fetch_object())
                    {
                      $programas=$r1;
                      break;
                    }
                    
                    $cantidad += $programas->cantidad;
                }
            }
        }
        
    }
    elseif($opcion == 'postgrados')
    {
        $programas = consultar_programas($valor_id);

        if($programas != NULL)
        {
            $cantidad = count($programas);
        }
        

    }
    return $cantidad;
}


function get_cantidad_matricula($valor_id, $opcion, $condicion)
{
    include "conexion.php";
    
    $cantidad = 0;
    if($opcion == 'facultades')
    {
        ini_set('display_errors',1);
        $postgrados = consultar_postgrados($valor_id);


        if($postgrados != NULL)
        {
            foreach ($postgrados as $postgrado)
            {
                $postgrado_id = $postgrado->id;
                $sql_p= "select id from programa where postgrado_id = ".$postgrado_id;

                $query_p = $con->query($sql_p);
                if($query_p->num_rows>0)
                {
                    $programas = '';
                    while ($r1=$query_p->fetch_object())
                    {
                          $programas=$r1;
                          $id = $programas->id;
                          $sql_p= "select id from programa where postgrado_id = ".$postgrado_id;

                          $query_p = $con->query($sql_p);
                          if($query_p->num_rows>0)
                          {
                            $programas = '';
                            while ($r1=$query_p->fetch_object())
                            {
                              $programas=$r1;
                              $id = $programas->id;
                                $sql_e = "SELECT count(*) as cantidad FROM estudiante_programa where condicion_estudiante_id = ".$condicion." AND programa_id = ".$id;
                                $query_e = $con->query($sql_e);
                                if($query_e->num_rows>0)
                                {
                                    $matricula = '';
                                    while ($r2=$query_e->fetch_object())
                                    {
                                      $matricula=$r2;
                                      break;
                                    }
                                    
                                    $cantidad += $matricula->cantidad;
                                }

                            }
                        }
                    }
                }
            }
        }
        
    }
    elseif ($opcion == 'postgrados')
    {
        $sql_p= "select id from programa where postgrado_id = ".$valor_id;

        $query_p = $con->query($sql_p);
        if($query_p->num_rows>0)
        {
            $programas = '';
            while ($r1=$query_p->fetch_object())
            {
              $programas=$r1;
              $id = $programas->id;

                $sql_e = "SELECT count(*) as cantidad FROM estudiante_programa where condicion_estudiante_id = ".$condicion." AND programa_id = ".$id;
                $query_e = $con->query($sql_e);
                if($query_e->num_rows>0)
                {
                    $matricula = '';
                    while ($r2=$query_e->fetch_object())
                    {
                      $matricula=$r2;
                      break;
                    }
                    
                    $cantidad += $matricula->cantidad;
                }

            }
        }    

    }
    elseif($opcion == 'programas')
    {
        if($condicion >= 100)
        {
            $condicion = $condicion - 100;
            $sql_e = "SELECT count(*) as cantidad FROM estudiante_programa where estatus_estudiante_id = ".$condicion." AND programa_id = ".$valor_id;
        }
        else
        {
            if($condicion == 3)
                $cond_sql_or = " OR condicion_estudiante_id = 4";
            else
                $cond_sql_or = "";

            $sql_e = "SELECT count(*) as cantidad FROM estudiante_programa where (condicion_estudiante_id = ".$condicion.$cond_sql_or.") AND programa_id = ".$valor_id;
        }
        $query_e = $con->query($sql_e);
        if($query_e->num_rows>0)
        {
            $matricula = '';
            while ($r2=$query_e->fetch_object())
            {
              $matricula=$r2;
              break;
            }
            
            $cantidad += $matricula->cantidad;
        }
    }
    return $cantidad;
}

function get_prorrogas($programa_id,$tipo = 'matricula')
{
    include "conexion.php";
    $resultado = '';
    $query = "SELECT * FROM extension_plazos e  
              INNER JOIN estudiante_programa ep ON e.estudiante_programa_id = ep.id 
              INNER JOIN programa p ON p.id = ep.programa_id 
              WHERE ep.programa_id = ".$programa_id;

    $rs = $con->query($query);
    if($rs->num_rows > 0)
    {
        if($tipo == 'cantidad')
        {
            $resultado = $rs->num_rows;
        }
        elseif($tipo == 'matricula')
        {
            $matricula = '';
            while ($row=$rs->fetch_object())
            {
              $matricula=$row;
              break;
            }
            $resultado = $matricula;
        }
    }
    else
    {
        $resultado = 0;
    }
    return $resultado;
}

function tiene_prorroga($persona_id, $programa_id)
{
    include "conexion.php";
    
    $resultado = '';
    $query = "SELECT * FROM extension_plazos e 
              INNER JOIN estudiante_programa ep ON e.estudiante_programa_id = ep.id
              WHERE ep.programa_id = ".$programa_id." AND ep.persona_id = ".$persona_id;

    $rs = $con->query($query);
    if($rs->num_rows > 0)
        $resultado = true;
    else
        $resultado = false;

    return $resultado;
}

function buscar_persona_x_cedula($cedula)
{
    include "conexion.php";

    $sql1= "select * from persona where documento_identidad = '".$cedula."'";
    $query = $con->query($sql1);
    $person = null;

    if($query->num_rows>0)
    {
        while ($r=$query->fetch_object())
        {
            $person=$r;
            break;
        }
    }

    return $person;
}

function buscar_inscripciones_x_persona_id($persona_id)
{
    include "conexion.php";
    $estudios = array();

    $sql1= "select ep.*,ep.id estudiante_id,p.id persona_id,pr.nombre programa,e.nombre estatus,
            c.nombre condicion, pr.id as programa_id, ep.fecha_ingreso as fecha_i, ep.fecha_grado as fecha_g, ep.fecha_retiro as fecha_r
            from estudiante_programa ep 
            INNER JOIN persona p ON ep.persona_id = p.id
            INNER JOIN programa pr ON ep.programa_id = pr.id
            INNER JOIN estatus_estudiante e ON ep.estatus_estudiante_id = e.id
            INNER JOIN condicion_estudiante c ON ep.condicion_estudiante_id = c.id
            where p.id = ".$persona_id." ORDER BY ep.id ASC";
    
    $query = $con->query($sql1);
    if($query->num_rows>0)
    {
        while ($r=$query->fetch_array()) 
        {
            $estudios[] = $r;
        }
    }

    return $estudios;

}

/************************************************************/
/* funcion tiene_inscripcion_programa_x_persona_id
   Busca si un estudiante ya esta
   inscrito en el programa que lo desean registrar. 
   Recibe: el id de la persona con el id del programa.
   Devuelve: True si esta inscrito en el programa_id
             False si No tiene inscripcion en ese programa 

************************************************************/

function tiene_inscripcion_programa_x_persona_id($persona_id, $programa_id)
{
    include "conexion.php";

    $sql1= "select id from estudiante_programa where persona_id = ".$persona_id." and 
                                                     programa_id = ".$programa_id;
    $query = $con->query($sql1);
    $estudiante_programa = null;

    if($query->num_rows>0)
    {
        return true;
    }

    return false;
}

function get_user_sistema($user_id)
{
    include "conexion.php";

    $sql1= "select * from usuarios where id = ".$user_id;
    $query = $con->query($sql1);

    if($query->num_rows>0)
    {
        $user = '';
        while ($r1=$query->fetch_object())
        {
          $user=$r1;
          break;
        }
    }
    else
    {
        $user = "Usuario No Existe";
    }
    
    return $user;
}

function buscar_usuario($user_id)
{
    include "conexion.php";

    $sql1= "select * from usuarios where id = '".$user_id."'";
    $query = $con->query($sql1);
    $usuario = null;

    if($query->num_rows>0)
    {
        while ($r=$query->fetch_object())
        {
            $usuario=$r;
            $name = $usuario->name;
            break;
        }
    }
    else
    {
        $name = "Usuario no existe";
    }

    return $name;
}

function filtro_anio($anio,$programa)
{
    include "conexion.php";

    
    // 3) Listas para los selectss
    // Consulta para años - Si hay programa selecionado, filtrar por ese programa
    if ($programa !== null) {
        $sqlAnios = "SELECT DISTINCT YEAR(e.fecha_ingreso) AS anio 
                     FROM estudiante_programa e 
                     WHERE e.programa_id = ? 
                     ORDER BY anio ASC";
        $stmtAnios = mysqli_prepare($con, $sqlAnios);
        mysqli_stmt_bind_param($stmtAnios, "i", $programa);
        mysqli_stmt_execute($stmtAnios);
        $resAnios = mysqli_stmt_get_result($stmtAnios);
    } else {
        $sqlAnios = "SELECT DISTINCT YEAR(fecha_ingreso) AS anio FROM estudiante_programa ORDER BY anio ASC";
        $resAnios = mysqli_query($con, $sqlAnios);
    }

    return $resAnios; 
}

// ============================================
// FUNCIÓN CREAR PDF - CORREGIDA CON COLUMNA ESTATUS
// ============================================

function crear_pdf($anio, $programa, $facultad, $estatus)
{
    global $con;
    
    $tcpdf_path = __DIR__ . '/../libs/TCPDF/tcpdf.php';

    if (!file_exists($tcpdf_path)) {
        die("Error: no se encontró TCPDF en la ruta esperada: $tcpdf_path");
    }
    require_once $tcpdf_path;

    if (ob_get_length()) {
        ob_end_clean();
    }


	include "query_filtro.php";
    


    // Crear PDF en formato horizontal
    $pdf = new TCPDF('L', 'mm', 'A4', true, 'UTF-8', false);
    
    // Configuración del documento
    $pdf->SetCreator('SIGEP');
    $pdf->SetAuthor('SIGEP');
    $pdf->SetTitle('Reporte de Estudiantes');
    
    // Configurar márgenes
    $pdf->SetMargins(15, 20, 15);
    $pdf->SetHeaderMargin(5);
    $pdf->SetFooterMargin(10);
    
    // Agregar página
    $pdf->AddPage();
    
    // ============================================
    // HEADER
    // ============================================
    $pdf->SetFont('helvetica', 'B', 18);
    $pdf->SetTextColor(30, 30, 30);
    $pdf->Cell(0, 15, 'REPORTE DE ESTUDIANTES', 0, 1, 'C');
    
    // Línea decorativa
    $pdf->SetDrawColor(91, 192, 190);
    $pdf->SetLineWidth(0.5);
    $pdf->Line(15, 35, 280, 35);
    $pdf->Ln(5);

    // ============================================
    // INFORMACIÓN DE FILTROS
    // ============================================
    $pdf->SetFont('helvetica', 'B', 10);
    $pdf->SetTextColor(60, 60, 60);
    $pdf->Cell(0, 6, 'Filtros aplicados:', 0, 1, 'L');
    
    $pdf->SetFont('helvetica', '', 9);
    $pdf->SetTextColor(80, 80, 80);
    
    $filtros_texto = [];
    if ($facultad) {
        $sql_fac = "SELECT nombre FROM facultad_nucleo WHERE id = $facultad";
        $res_fac = mysqli_query($con, $sql_fac);
        $facultad_nombre = ($res_fac && $row_fac = mysqli_fetch_assoc($res_fac)) ? $row_fac['nombre'] : 'Desconocida';
        $filtros_texto[] = "Facultad: $facultad_nombre";
    }
    if ($programa) {
        $sql_prog = "SELECT nombre FROM programa WHERE id = $programa";
        $res_prog = mysqli_query($con, $sql_prog);
        $programa_nombre = ($res_prog && $row_prog = mysqli_fetch_assoc($res_prog)) ? $row_prog['nombre'] : 'Desconocido';
        $filtros_texto[] = "Programa: $programa_nombre";
    }
    if ($anio) {
        $filtros_texto[] = "Año: $anio";
    }
    if ($estatus) {
        $estatus_texto = '';
        switch($estatus) {
            case 'activo': $estatus_texto = 'Activo'; break;
            case 'egresado': $estatus_texto = 'Egresado'; break;
            case 'inactivo': $estatus_texto = 'Inactivo'; break;
            case 'retirado': $estatus_texto = 'Retirado/Desincorporado'; break;
        }
        $filtros_texto[] = "Estatus: $estatus_texto";
    }
    
    if (!empty($filtros_texto)) {
        $pdf->Cell(0, 5, '• ' . implode(' | ', $filtros_texto), 0, 1, 'L');
    } else {
        $pdf->Cell(0, 5, '• Sin filtros (todos los estudiantes)', 0, 1, 'L');
    }
    
    $pdf->Ln(5);

    // ============================================
    // ESTADÍSTICAS
    // ============================================
    $total_estudiantes = count($rows);
    
    $pdf->SetFont('helvetica', 'B', 11);
    $pdf->SetFillColor(230, 230, 230);
    $pdf->Cell(0, 8, "Total de estudiantes: " . $total_estudiantes, 0, 1, 'L');
    $pdf->Ln(5);

    // ============================================
    // TABLA DE DATOS CON COLUMNA DE ESTATUS
    // ============================================
    
    // Calcular anchos de columna
    $ancho_col1 = 28;   // Documento
    $ancho_col2 = 42;   // Apellidos
    $ancho_col3 = 42;   // Nombres
    $ancho_col4 = 52;   // Programa
    $ancho_col5 = 28;   // Estatus (NUEVA COLUMNA)
    $ancho_col6 = 25;   // Fecha Nac.
    $ancho_col7 = 25;   // Fecha Ingreso
    $ancho_col8 = 25;   // Fecha Registro
    
    // Posición X para centrar la tabla
    $tabla_x = (297 - ($ancho_col1 + $ancho_col2 + $ancho_col3 + $ancho_col4 + $ancho_col5 + $ancho_col6 + $ancho_col7 + $ancho_col8)) / 2;
    $pdf->SetX($tabla_x);
    
    // Encabezado de tabla
    $pdf->SetFillColor(91, 192, 190);
    $pdf->SetTextColor(255, 255, 255);
    $pdf->SetFont('helvetica', 'B', 8);
    $pdf->SetDrawColor(180, 180, 180);
    
    $pdf->Cell($ancho_col1, 8, 'Documento', 1, 0, 'C', true);
    $pdf->Cell($ancho_col2, 8, 'Apellidos', 1, 0, 'C', true);
    $pdf->Cell($ancho_col3, 8, 'Nombres', 1, 0, 'C', true);
    $pdf->Cell($ancho_col4, 8, 'Programa', 1, 0, 'C', true);
    $pdf->Cell($ancho_col5, 8, 'Estatus', 1, 0, 'C', true);
    $pdf->Cell($ancho_col6, 8, 'Fecha Nac.', 1, 0, 'C', true);
    $pdf->Cell($ancho_col7, 8, 'Fecha Ingreso', 1, 0, 'C', true);
    $pdf->Cell($ancho_col8, 8, 'Fecha Registro', 1, 1, 'C', true);
    
    // Restaurar colores para las filas
    $pdf->SetFillColor(245, 245, 245);
    $pdf->SetTextColor(60, 60, 60);
    $pdf->SetFont('helvetica', '', 7.5);
    
    $fill = false;
    
    if ($total_estudiantes > 0) {
        foreach ($rows as $row) {
            $fill = !$fill;
            $pdf->SetX($tabla_x);
            
            // Truncar texto si es muy largo
            $apellidos = strlen($row['apellidos']) > 25 ? substr($row['apellidos'], 0, 23) . '...' : $row['apellidos'];
            $nombres = strlen($row['nombres']) > 25 ? substr($row['nombres'], 0, 23) . '...' : $row['nombres'];
            $programa_txt = strlen($row['programa']) > 30 ? substr($row['programa'], 0, 27) . '...' : $row['programa'];
            
            $pdf->Cell($ancho_col1, 7, htmlspecialchars($row['documento_identidad']), 1, 0, 'C', $fill);
            $pdf->Cell($ancho_col2, 7, htmlspecialchars($apellidos), 1, 0, 'L', $fill);
            $pdf->Cell($ancho_col3, 7, htmlspecialchars($nombres), 1, 0, 'L', $fill);
            $pdf->Cell($ancho_col4, 7, htmlspecialchars($programa_txt), 1, 0, 'L', $fill);
            $pdf->Cell($ancho_col5, 7, htmlspecialchars($row['condicion_estudiante']), 1, 0, 'C', $fill);
            $pdf->Cell($ancho_col6, 7, isset($row['fecha_nacimiento']) ? transforma_fecha($row['fecha_nacimiento']) : '', 1, 0, 'C', $fill);
            $pdf->Cell($ancho_col7, 7, isset($row['fecha_ingreso']) ? transforma_fecha($row['fecha_ingreso']) : '', 1, 0, 'C', $fill);
            $pdf->Cell($ancho_col8, 7, isset($row['fecha_registro']) ? transforma_fecha($row['fecha_registro']) : '', 1, 1, 'C', $fill);
        }
        
        // Fila de total
        $pdf->SetX($tabla_x);
        $pdf->SetFont('helvetica', 'B', 8);
        $pdf->SetFillColor(220, 220, 220);
        $pdf->Cell($ancho_col1 + $ancho_col2 + $ancho_col3 + $ancho_col4 + $ancho_col5, 7, 'TOTAL ESTUDIANTES:', 1, 0, 'R', true);
        $pdf->Cell($ancho_col6 + $ancho_col7 + $ancho_col8, 7, $total_estudiantes, 1, 1, 'C', true);
        
    } else {
        $pdf->SetX($tabla_x);
        $pdf->Cell($ancho_col1 + $ancho_col2 + $ancho_col3 + $ancho_col4 + $ancho_col5 + $ancho_col6 + $ancho_col7 + $ancho_col8, 
                   10, 'No se encontraron estudiantes para los filtros seleccionados', 1, 1, 'C', true);
    }
    
    // ============================================
    // PIE DE PÁGINA
    // ============================================
    $pdf->Ln(5);
    $pdf->SetFont('helvetica', 'I', 7);
    $pdf->SetTextColor(120, 120, 120);
    $pdf->Cell(0, 4, 'Documento generado por SIGEP - ' . date('d/m/Y H:i:s'), 0, 1, 'R');
    $pdf->Cell(0, 4, 'Página ' . $pdf->getAliasNumPage() . ' de ' . $pdf->getAliasNbPages(), 0, 1, 'R');
    
    // ============================================
    // SALIDA DEL PDF
    // ============================================
    $pdf->Output("reporte_estudiantes.pdf", 'I');
    exit;

}

	function getProgramasByFacultad($facultadId, $conn) {
	    $programas = [];
	    
	    if (!empty($facultadId)) {
	        $sql = "SELECT id, nombre FROM programas WHERE facultad_id = ? ORDER BY nombre ASC";
	        $stmt = $conn->prepare($sql);
	        $stmt->bind_param("i", $facultadId);
	        $stmt->execute();
	        $result = $stmt->get_result();
	        
	        while ($row = $result->fetch_assoc()) {
	            $programas[] = $row;
	        }
	        $stmt->close();
	    }
	    
	    return $programas;
	}

/**
 * Obtiene años disponibles según programas filtrados
 */
function getAniosByProgramas($programasIds, $conn) {
    $anios = [];
    
    if (!empty($programasIds)) {
        $placeholders = implode(',', array_fill(0, count($programasIds), '?'));
        $sql = "SELECT DISTINCT anio FROM estudiantes WHERE programa_id IN ($placeholders) ORDER BY anio DESC";
        $stmt = $conn->prepare($sql);
        
        // Crear array de tipos (todos enteros)
        $types = str_repeat('i', count($programasIds));
        $stmt->bind_param($types, ...$programasIds);
        $stmt->execute();
        $result = $stmt->get_result();
        
        while ($row = $result->fetch_assoc()) {
            $anios[] = $row['anio'];
        }
        $stmt->close();
    }
    
    return $anios;
}

/**
 * Obtiene años disponibles para un programa específico
 */
function getAniosByPrograma($programaId, $conn) {
    $anios = [];
    
    if (!empty($programaId)) {
        $sql = "SELECT DISTINCT anio FROM estudiantes WHERE programa_id = ? ORDER BY anio DESC";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $programaId);
        $stmt->execute();
        $result = $stmt->get_result();
        
        while ($row = $result->fetch_assoc()) {
            $anios[] = $row['anio'];
        }
        $stmt->close();
    }
    
    return $anios;
}


function getAllProgramas($conn) {
    $programas = [];
    
    $sql = "SELECT id, nombre FROM programas ORDER BY nombre ASC";
    $result = $conn->query($sql);
    
    while ($row = $result->fetch_assoc()) {
        $programas[] = $row;
    }
    
    return $programas;
}



function getAllAnios($conn) {
    $anios = [];
    
    $sql = "SELECT DISTINCT anio FROM estudiantes ORDER BY anio DESC";
    $result = $conn->query($sql);
    
    while ($row = $result->fetch_assoc()) {
        $anios[] = $row['anio'];
    }
    
    return $anios;
}
?>