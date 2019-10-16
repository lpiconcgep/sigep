<?php
  session_start();
 // Array ( [programa_id] => 1 [condicion_estudiante_id] => 1 [estatus_estudiante_id] => 1 [fecha_ingreso] => 2002-12-12 [anio_cohorte] => 210 [fecha_egreso] => [fecha_grado] => [fecha_matriculacion] => 2003-02-12 [estatus_matriculacion_id] => 1 [id] => 3 ) 

if(!empty($_POST))
{
	if(isset($_POST["programa_id"]) && isset($_POST["condicion_estudiante_id"]) && isset($_POST["estatus_estudiante_id"]) 
	&& isset($_POST["fecha_ingreso"]))
	{
		if($_POST["programa_id"]!="" && $_POST["condicion_estudiante_id"]!="" && $_POST["estatus_estudiante_id"]!="" 
		&& $_POST["fecha_ingreso"]!="" )
		{
			include "../conexion.php";
			
			$sql = "insert into estudiante_programa(programa_id, condicion_estudiante_id,estatus_estudiante_id,fecha_ingreso,anio_cohorte,
				    fecha_egreso,fecha_grado,fecha_retiro, fecha_desincorporacion,estatus_matriculacion_id,persona_id,observaciones,created_at, user_create) 

				    value (\"$_POST[programa_id]\",\"$_POST[condicion_estudiante_id]\",\"$_POST[estatus_estudiante_id]\",
				    	   \"$_POST[fecha_ingreso]\",\"$_POST[anio_cohorte]\",\"$_POST[fecha_egreso]\",\"$_POST[fecha_grado]\",
				    	   \"$_POST[fecha_retiro]\",\"$_POST[fecha_desincorporacion]\",5,
				    	   \"$_POST[id]\",\"$_POST[observaciones]\",NOW(),\"$_SESSION[user_id]\")";
		
			$query = $con->query($sql);
			if($query!=null){

				if($_POST['source'] == 'integral')
				{
					print "<script>alert(\"Agregado exitosamente.\");window.location='../../buscar_estudiante.php?s=".$_POST[documento_identidad]."&opt=".$_POST['opcion']."';</script>";
				}
				else
				{
					print "<script>alert(\"Agregado exitosamente.\");window.location='../../estudios.php?id=".$_POST['id']."';</script>";
				}
				
			}
			else
			{
				print_r($sql);
				print "<script>alert(\"No se pudo agregar.\");window.location='../../estudios.php?id=".$_POST['id']."';</script>";

			}
		}
		else
		{
			echo "if vacios";
		}
	}
	else
	{
		echo "if isset";
	}
}
else
{
	echo "if post";
}

?>