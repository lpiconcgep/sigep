<?php
/*INSERT INTO  `sigep_recoleccion`.`personal` (
`id` ,
`apellidos` ,
`nombres` ,
`tipo_cargo_id` ,
`fecha_inicio_cargo` ,
`fecha_fin_cargo` ,
`activo` ,
`postgrado_id` ,
`created_at` ,
`update_at` ,
`user_create` ,
`user_update`
) */
session_start();


//Array ( [apellidos] => picion [nombres] => lery [tipo_cargo_id] => 1 
//  	  [fecha_inicio_cargo] => 2001-10-11 [fecha_fin_cargo] => [programa_id] => 9 )
if(!empty($_POST))
{
	if(isset($_POST["apellidos"]) && isset($_POST["nombres"]) && isset($_POST["tipo_cargo_id"]) 
	&& isset($_POST["programa_id"]))
	{
		if($_POST["apellidos"]!="" && $_POST["nombres"]!="" && $_POST["tipo_cargo_id"]!="" && $_POST["programa_id"]!="" )
		{
			include "../conexion.php";
			
			$sql = "insert into personal(apellidos,nombres,tipo_cargo_id,fecha_inicio_cargo,fecha_fin_cargo,activo,programa_id,created_at,user_create) 

				    value (\"$_POST[apellidos]\",\"$_POST[nombres]\",\"$_POST[tipo_cargo_id]\",\"$_POST[fecha_inicio_cargo]\",
				    	   \"$_POST[fecha_fin_cargo]\",\"1\",\"$_POST[programa_id]\",NOW(),\"$_SESSION[user_id]\")";
		
			$query = $con->query($sql);
			if($query!=null){												
				print "<script>alert(\"Agregado exitosamente.\");window.location='datos_contactos.php?programa_id=".$_POST['programa_id']."';</script>";
			}else{
				print "<script>alert(\"No se pudo agregar.\");window.location='datos_contactos.php?programa_id=".$_POST['programa_id']."';</script>";

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