<?php
  session_start();

//var_dump($_POST);
/*["grado_id"]=> string(1) "2" ["fecha_cierre"]=> string(10) "2024-12-05" ["observaciones_cierre"]=> string(7) "dgdgdfg" ["id"]=> string(4) "6191" ["source"]=> string(8) "integral" ["opcion"]=> string(1) "3"*/

if(!empty($_POST))
{
	if(isset($_POST["id"]) && isset($_POST["grado_id"]) && isset($_POST["fecha_cierre"]) )
	{
		if($_POST["id"]!="" && $_POST["id"]!="0" && $_POST["grado_id"]!="" && $_POST["fecha_cierre"]!="" )
		{
			include "../conexion.php";
			include "../funciones.php";

			$sql_grado= "select * from grados where id = ".$_POST["grado_id"];
  			$query_grado = $con->query($sql_grado);
  			$grado=$query_grado->fetch_object();
				
			$fecha_egreso = isset($_POST['fecha_cierre']) ? $_POST['fecha_cierre'] : "";
			$fecha_cierre = isset($_POST['fecha_cierre']) ? $_POST['fecha_cierre'] : "";
			$fecha_grado = $grado->fecha_grado;
			$persona_id = $_POST['persona_id'];

			$sql = "UPDATE estudiante_programa SET condicion_estudiante_id = 2,estatus_estudiante_id = 4,fecha_egreso='".$fecha_egreso."',fecha_cierre='".$fecha_cierre."',fecha_grado='".$fecha_grado."',observaciones_cierre='".$_POST['observaciones_cierre']."',update_at = NOW(),user_update = ".$_SESSION['user_id']." WHERE id=".$_POST['id'];
		
			$query = $con->query($sql);
			if($query!=null){
				$opc = $_POST['opcion'];
				/*if($_SESSION['user_id'] == 1)
				{*/

				agregar_movimiento($_POST,'2'); 

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
			var_dump($_POST);
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