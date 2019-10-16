<?php
session_start();
if(!empty($_POST))
{
	if(isset($_POST["tipo_documento_identidad"]) && isset($_POST["documento_identidad"]) && isset($_POST["pasaporte"]) 
	&& isset($_POST["primer_apellido"]) && isset($_POST["segundo_apellido"]) && isset($_POST["primer_nombre"])
	&& isset($_POST["segundo_nombre"]) && isset($_POST["sexo"]) && isset($_POST["nacionalidad"])
	&& isset($_POST["pais_origen_id"]) && isset($_POST["estado_civil"]) 
	&& isset($_POST["etnia_id"]) && isset($_POST["ciudad_id"]))
	{
		if($_POST["tipo_documento_identidad"]!="" && $_POST["documento_identidad"]!="" && $_POST["primer_apellido"]!="" 
		&& $_POST["primer_nombre"]!="" && $_POST["sexo"]!="" && $_POST["nacionalidad"]!="" )
		{
			include "../conexion.php";
			
			$sql = "update persona set tipo_documento_identidad=\"$_POST[tipo_documento_identidad]\", 
					primer_nombre=\"$_POST[primer_nombre]\",segundo_nombre=\"$_POST[segundo_nombre]\",
					primer_apellido=\"$_POST[primer_apellido]\",segundo_apellido=\"$_POST[segundo_apellido]\",
					sexo=\"$_POST[sexo]\",nacionalidad=\"$_POST[nacionalidad]\",pais_origen_id =\"$_POST[pais_origen_id]\",
					pasaporte=\"$_POST[pasaporte]\",fecha_nacimiento=\"$_POST[fecha_nacimiento]\",
					estado_civil=\"$_POST[estado_civil]\", etnia_id =\"$_POST[etnia_id]\",ciudad_id =\"$_POST[ciudad_id]\",
					regimen =\"$_POST[regimen]\",discapacidad =\"$_POST[discapacidad]\",
					fecha_vencimiento_doc_identidad =\"$_POST[fecha_vencimiento_doc_identidad]\",update_at = NOW(),user_update = \"$_SESSION[user_id]\" where id=".$_POST["id"];

			$query = $con->query($sql);
			if($query!=null){
				if($_POST['link'] == 'matricula')
				{
					print "<script>alert(\"Actualizado exitosamente.\");window.location='../../matricula.php?programa_id=".$_POST['programa_id']."';</script>";
				}
				else
				{
					print "<script>alert(\"Actualizado exitosamente.\");window.location='../../personas.php';</script>";
				}
				
			}else{
				print "<script>alert(\"No se pudo actualizar.\");window.location='../../personas.php';</script>";

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