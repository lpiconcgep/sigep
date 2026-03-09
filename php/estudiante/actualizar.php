<?php
session_start();
if(!empty($_POST))
{
	if(isset($_POST["programa_id"]) && isset($_POST["condicion_estudiante_id"]) && isset($_POST["estatus_estudiante_id"]) 
	&& isset($_POST["fecha_ingreso"]))
	{
		if($_POST["programa_id"]!="" && $_POST["condicion_estudiante_id"]!="" && $_POST["estatus_estudiante_id"]!="" 
		&& $_POST["fecha_ingreso"]!="" )
		{
			include "../conexion.php";
			
			$sql = "update estudiante_programa set programa_id=\"$_POST[programa_id]\", 
					condicion_estudiante_id=\"$_POST[condicion_estudiante_id]\",
					estatus_estudiante_id=\"$_POST[estatus_estudiante_id]\",
					fecha_ingreso=\"$_POST[fecha_ingreso]\",anio_cohorte=\"$_POST[anio_cohorte]\",
					fecha_egreso=\"$_POST[fecha_egreso]\",fecha_grado=\"$_POST[fecha_grado]\",
					fecha_retiro =\"$_POST[fecha_retiro]\",
					fecha_desincorporacion =\"$_POST[fecha_desincorporacion]\",observaciones =\"$_POST[observaciones]\",
					estatus_matriculacion_id = 5,update_at = NOW(),user_update = \"$_SESSION[user_id]\" where id=".$_POST["id"];

			$query = $con->query($sql);
			if($query!=null){
				print "<script>alert(\"Actualizado exitosamente.\");window.location='../../estudios.php?id=".$_POST['persona_id']."';</script>";
			}else{
				print "<script>alert(\"No se pudo actualizar.\");window.location='../../estudios.php?id=".$_POST['persona_id']."';</script>";

			}
		}
		else
			echo "if vacio";
	}
	else
	{
		echo "if isset";
	}
}
else
{
	echo "empty";
}



?>