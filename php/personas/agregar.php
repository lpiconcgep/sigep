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
			
			$sql = "insert into persona(tipo_documento_identidad, documento_identidad,primer_nombre,segundo_nombre,primer_apellido,
				    segundo_apellido,sexo,nacionalidad,pais_origen_id,pasaporte,fecha_nacimiento,estado_civil,etnia_id,ciudad_id,
				    regimen,discapacidad,fecha_vencimiento_doc_identidad,created_at, user_create) 

				    value (\"$_POST[tipo_documento_identidad]\",\"$_POST[documento_identidad]\",\"$_POST[primer_nombre]\",
				    	   \"$_POST[segundo_nombre]\",\"$_POST[primer_apellido]\",\"$_POST[segundo_apellido]\",\"$_POST[sexo]\",
				    	   \"$_POST[nacionalidad]\",\"$_POST[pais_origen_id]\",\"$_POST[pasaporte]\",\"$_POST[fecha_nacimiento]\",
				    	   \"$_POST[estado_civil]\",\"$_POST[etnia_id]\",\"$_POST[ciudad_id]\",\"$_POST[regimen]\",
				    	   \"$_POST[discapacidad]\",\"$_POST[fecha_vencimiento_doc_identidad]\",NOW(),\"$_SESSION[user_id]\")";
		
			$query = $con->query($sql);
			if($query!=null){

				if($_POST['source'] == 'integral')
				{
					
					print "<script>
					var opt;alert('Agregado exitosamente.');window.location='../../buscar_estudiante.php?s=".$_POST['documento_identidad']."&opt=".$_POST['opcion']."';</script>";
					
				}
				else
				{
					print "<script>alert(\"Agregado exitosamente.\");window.location='../../personas.php';</script>";
				}

				
			}else{
				print "<script>alert(\"No se pudo agregar.\");window.location='../../personas.php';</script>";

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

	echo "if post vacio";
}

?>