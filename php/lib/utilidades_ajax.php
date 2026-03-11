<?php
	include "../conexion.php";
	include "../funciones.php";

	$accion = $_GET['accion'];
	$data = array();

	if($accion == '1')
	{
		$data['success'] = true;
		$resultado = array();
		
		$sql = "select id,nombre from postgrado WHERE facultad_nucleo_id = {$_GET['valor']} order by nombre ASC";

		$query = $con->query($sql);
		if($query->num_rows>0)
		{
			$elementos = array();
			while ($r1=$query->fetch_object()){
				$elementos[] = $r1;
			}
		}
		else
		{
			$elementos = NULL;
		}

		if($elementos != NULL)
		{
			foreach ($elementos as $valor) {
				$elemento = array();
	        	$elemento['id'] = $valor->id;
<<<<<<< HEAD
	        	$elemento['nombre'] = utf8_encode($valor->nombre);
=======
	        	$elemento['nombre'] = $valor->nombre;
>>>>>>> 24861cc2950c10fe5a8d8e9a1af9bbdbeff45c07
	        	$resultado[] = $elemento;
	        } 

			$data['resultado'] = $resultado;
		}
		
	}

	if($accion == '2')
	{
		$data['success'] = true;
		$resultado = array();
		
		$elementos = consultar_programas($_GET['valor']);

		foreach ($elementos as $valor) {
			$elemento = array();
        	$elemento['id'] = $valor->id;
        	$elemento['nombre'] = utf8_encode($valor->nombre);
        	$resultado[] = $elemento;
        } 

		$data['resultado'] = $resultado;
	}

<<<<<<< HEAD
=======
	if($accion == '3')
	{
		$data['success'] = true;
		$resultado = array();
		
		$elementos = consultar_programa_x_id($_GET['valor']);
		$name_program = trim(preg_replace('/\s*\(.*$/', '', $elementos->nombre));

		$data['resultado'] = $elementos;
		$data['name'] = $name_program;
	}


>>>>>>> 24861cc2950c10fe5a8d8e9a1af9bbdbeff45c07
	echo json_encode($data);

?>