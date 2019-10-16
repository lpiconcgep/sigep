<?php
	
	function consultar_facultades(){

		include "conexion.php";
	
		$sql= "select id,nombre from facultad_nucleo";
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

	function consultar_postgrados($facultad_id = '-1'){

		include "conexion.php";
		
	
		if($facultad_id == '-1')
		{
			$sql = "select id,nombre,facultad_nucleo_id from postgrado order by nombre ASC";
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
			$sql_e = "SELECT count(*) as cantidad FROM estudiante_programa where condicion_estudiante_id = ".$condicion." AND programa_id = ".$valor_id;
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

		$sql1= "select * from persona where documento_identidad = ".$cedula;
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
				c.nombre condicion, pr.id as programa_id, ep.fecha_ingreso as fecha_i
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

?>