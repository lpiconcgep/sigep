<?php
	include "../conexion.php";
	include "../funciones.php";

	$accion = $_GET['accion'];
	$data = array();

	if($accion == '1')
	{
		$data['success'] = true;
		$resultado = array();
		
		$elementos = consultar_postgrados($_GET['valor']);
		
		if($elementos != NULL)
		{
			foreach ($elementos as $valor) {
				$elemento = array();
	        	$elemento['id'] = $valor->id;
	        	$elemento['nombre'] = $valor->nombre;
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
        	$elemento['nombre'] = $valor->nombre;
        	$resultado[] = $elemento;
        } 

		$data['resultado'] = $resultado;
	}

	if($accion == '3')
	{
		$data['success'] = true;
		$resultado = array();
		
		$elementos = consultar_programa_x_id($_GET['valor']);
		$name_program = trim(preg_replace('/\s*\(.*$/', '', $elementos->nombre));

		$data['resultado'] = $elementos;
		$data['name'] = $name_program;
	}

	if($accion == '4')
	{
		$data['success'] = true;
		$resultado = array();
		
		$elementos = consultar_programas_x_facultad($_GET['valor']);

		foreach ($elementos as $valor) {
			$elemento = array();
        	$elemento['id'] = $valor->id;
        	$elemento['nombre'] = $valor->nombre;
        	$resultado[] = $elemento;
        } 

		$data['resultado'] = $resultado;
	}





	echo json_encode($data);
?>