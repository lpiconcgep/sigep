<?php

/*INSERT INTO  `sigep_recoleccion`.`extension_plazos` (

`id` ,`fecha_solicitud` ,`motivo_estudiante` ,`motivo_tutor` ,`motivo_postgrado` ,`opinion_coordinador_comision` ,
`opinion_uce` ,`decision_cep` ,`observaciones` ,`estatus_prorroga_id` ,`estudiante_programa_id`)*/

if(!empty($_POST))
{
	if(isset($_POST["fecha_solicitud"]) && isset($_POST["motivo_estudiante"]))
	{
		if($_POST["fecha_solicitud"]!="" && $_POST["motivo_estudiante"]!="" )
		{

			if(isset($_POST["extension_plazo_id"]) && $_POST["extension_plazo_id"]=="")
			{
				include "../conexion.php";
				$sql = "insert into extension_plazos(fecha_solicitud, motivo_estudiante,motivo_tutor,motivo_postgrado,
						opinion_coordinador_comision,opinion_uce,decision_cep,observaciones,estatus_prorroga_id,
						estudiante_programa_id,created_at) 

					    value (\"$_POST[fecha_solicitud]\",\"$_POST[motivo_estudiante]\",\"$_POST[motivo_tutor]\",
					    	   \"$_POST[motivo_postgrado]\",\"$_POST[opinion_coordinador_comision]\",\"$_POST[opinion_uce]\",
					    	   \"$_POST[decision_cep]\",\"$_POST[observaciones]\",\"$_POST[estatus_prorroga_id]\",
					    	   \"$_POST[estudiante_programa_id]\",NOW())";
			
				$query = $con->query($sql);
				if($query!=null){
					print "<script>alert(\"Agregado exitosamente.\");window.location='../estudiante/prorrogas.php?estudiante_id=".$_POST['estudiante_programa_id']."';</script>";
				}else{
					print "<script>alert(\"No se pudo agregar.\");window.location='../php/estudiante/prorrogas.php?estudiante_id=".$_POST['estudiante_programa_id']."';</script>";

				}
			}
			else
			{
				include "../conexion.php";
				$sql = "update extension_plazos set fecha_solicitud=\"$_POST[fecha_solicitud]\", 
					motivo_estudiante=\"$_POST[motivo_estudiante]\",
					motivo_tutor=\"$_POST[motivo_tutor]\", motivo_postgrado=\"$_POST[motivo_postgrado]\",
					opinion_coordinador_comision=\"$_POST[opinion_coordinador_comision]\",
					opinion_uce=\"$_POST[opinion_uce]\",decision_cep=\"$_POST[decision_cep]\",
					observaciones =\"$_POST[observaciones]\",
					estatus_prorroga_id = \"$_POST[estatus_prorroga_id]\" where id=".$_POST["extension_plazo_id"];

				$query = $con->query($sql);
				if($query!=null){
					print "<script>alert(\"Actualizado exitosamente.\");window.location='../../estudios.php?id=".$_POST['persona_id']."';</script>";
				}else{
					print "<script>alert(\"No se pudo actualizar.\");window.location='../../estudios.php?id=".$_POST['persona_id']."';</script>";

				}
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