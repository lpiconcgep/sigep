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

		/*{ ["grado_id"]=> string(1) "2" ["fecha_cierre"]=> string(10) "2025-03-10" ["observaciones_cierre"]=> string(11) "prueba lery" ["id"]=> string(2) "18" ["persona_id"]=> string(2) "17" ["source"]=> string(8) "personal" ["opcion"]=> string(1) "3" } 

		INSERT INTO `descripcion_movimiento`(`id`, `movimiento_estudiante_id`, `descripcion`, `comunicacion_solicitud`, `fecha_solicitud`, `fecha_respuesta`, `comunicacion_respuesta`, `fecha_ingreso`, `anio_cohorte`, `observaciones_expediente`, `fecha_cierre`, `fecha_grado`, `num_pergamino`, `observaciones_cierre`, `fecha_retiro`, `motivo_retiro_id`, `descripcion_motivo_retiro`, `culmino_escolaridad`, `fecha_ingreso_reincorporacion`, `fecha_reunion_equivalencia`, `num_comision_equivalencia`, `observaciones_equivalencia`, `observaciones`, `created_at`, `user_create`, `update_at`, `user_update`) */


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

	function crear_pdf($anio,$programa)
	{
		include "conexion.php";
		  $tcpdf_path = __DIR__ . '/../libs/TCPDF/tcpdf.php';
    if (!file_exists($tcpdf_path)) {
        die("Error: no se encontró TCPDF en la ruta esperada: $tcpdf_path");
    }
    require_once $tcpdf_path;

    if (ob_get_length()) {
        ob_end_clean();
    }

	/*$sql = "SELECT 
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
		}*/

		include "query_filtro.php";




    $pdf = new TCPDF();
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('SIGEP');
    $pdf->SetTitle('Reporte de Estudiantes de Postgrado');
    $pdf->SetMargins(15, 20, 15);
    $pdf->AddPage();

    $pdf->SetFont('helvetica', 'B', 14);
    $pdf->Cell(0, 10, "Reporte de Estudiantes de Postgrado", 0, 1, 'C');
    $pdf->Ln(5);
    $pdf->SetFont('helvetica', '', 10);

    $html = '<table border="1" cellpadding="4" cellspacing="0" style="border-collapse:collapse; width:100%;">';
    $html .= '<thead><tr style="background-color:#d3d3d3; color:#000;">';
    $html .= '<th align="center"><b>Documento</b></th>';
    $html .= '<th align="center"><b>Apellidos</b></th>';
    $html .= '<th align="center"><b>Nombres</b></th>';
    $html .= '<th align="center"><b>Programa</b></th>';
    $html .= '<th align="center"><b>Estatus</b></th>';
    $html .= '<th align="center">Fecha de Nacimiento</th>';
    $html .= '<th align="center"><b>Fecha de Ingreso</b></th>';
    $html .= '<th align="center"><b>Fecha de Registro</b></th>';
    $html .= '</tr></thead><tbody>';

    if (count($rows) > 0) {
        foreach ($rows as $row) {
            $html .= '<tr>';
            $html .= '<td align="center">' . htmlspecialchars($row['documento_identidad']) . '</td>';
            $html .= '<td>' . htmlspecialchars($row['apellidos']) . '</td>';
            $html .= '<td>' . htmlspecialchars($row['nombres']) . '</td>';
            $html .= '<td>' . htmlspecialchars($row['programa']) . '</td>';
            $html .= '<td>' . htmlspecialchars($row['condicion_estudiante']) . '</td>';
            $html .= '<td align="center">' . transforma_fecha($row['fecha_nacimiento']) . '</td>';
            $html .= '<td align="center">' . transforma_fecha($row['fecha_ingreso']) . '</td>';
            $html .= '<td align="center">' . transforma_fecha($row['fecha_registro']) . '</td>';
            $html .= '</tr>';
        }
    } else {
        $html .= '<tr><td colspan="5" align="center">No se encontraron estudiantes.</td></tr>';
    }

    $html .= '</tbody></table>';
    $html .= '<br/><div style="font-size:10px;color:#666;">Generado el: ' . date('d/m/Y') . '</div>';

    $pdf->writeHTML($html, true, false, true, false, '');
    $filename = "reporte_postgrados.pdf";
    $pdf->Output($filename, 'I');
    exit;
	}
?>