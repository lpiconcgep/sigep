<?php
  session_start();

//var_dump($_POST);
/*["motivo_retiro_id"]=> string(1) "1" ["fecha_cierre"]=> string(10) "2025-06-02" ["observaciones_retiro"]=> string(13) "observaciones" ["id"]=> string(4) "4024" ["persona_id"]=> string(4) "3877" ["source"]=> string(8) "personal" ["opcion"]=> string(1) "2"*/

if(!empty($_POST))
{
	if(isset($_POST["id"]) && isset($_POST["motivo_retiro_id"]) && isset($_POST["fecha_retiro"]) )
	{
		if($_POST["id"]!="" && $_POST["id"]!="0" && $_POST["motivo_retiro_id"]!="" && $_POST["fecha_retiro"]!="" )
		{
			include "../conexion.php";
			include "../funciones.php";
	
			$fecha_retiro = isset($_POST['fecha_retiro']) ? $_POST['fecha_retiro'] : "";
			$fecha_registro_retiro = isset($_POST['fecha_registro_retiro']) ? $_POST['fecha_registro_retiro'] : "";
			$fecha_grado = '';
			
			$persona_id = $_POST['persona_id'];

			$sql = "UPDATE estudiante_programa SET condicion_estudiante_id = 5,estatus_estudiante_id = 5,fecha_grado='".$fecha_grado."',fecha_retiro='".$fecha_retiro."',fecha_registro_retiro='".$fecha_registro_retiro."',observaciones_retiro='".$_POST['observaciones_retiro']."',update_at = NOW(),user_update = ".$_SESSION['user_id']." WHERE id=".$_POST['id'];
		
			$query = $con->query($sql);
			if($query!=null){
				$opc = $_POST['opcion'];
				/*if($_SESSION['user_id'] == 1)
				{*/
				agregar_movimiento($_POST,'3'); 
				//}
				if($_POST['source'] == 'integral')
				{
					
					print "<script>alert(\"Registrado exitosamente.\");window.location='../../buscar_estudiante.php?s=".$_POST['documento_identidad']."&opt=".$opc."';</script>";
				}
				else
				{
					print "<script>alert(\"Registrado exitosamente.\");window.location='../../estudios.php?id=".$persona_id."';</script>";
				}
				
			}
			else
			{
				//print_r($sql);
				print "<script>alert(\"No se pudo registrar.\");window.location='../../estudios.php?id=".$persona_id."';</script>";

			}
			
		}
		else
		{
			//var_dump($_POST);
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