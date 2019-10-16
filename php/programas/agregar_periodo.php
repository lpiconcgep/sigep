<?php
 // Array ( [nombre] => Cohorte II [numero] => 2 [anio] => 2011 [fecha_inicio] => 2001-12-12 
 //[fecha_fin] => 2010-10-10 [id] => 1 )
session_start();
if(!empty($_POST))
{
	if(isset($_POST["cohorte_id"]) && isset($_POST["nombre"]) && isset($_POST["numero"]) 
	&& isset($_POST["anio"]) && isset($_POST["fecha_inicio"]) && isset($_POST["fecha_fin"]))
	{
		if($_POST["cohorte_id"]!="" && $_POST["nombre"]!="" && $_POST["numero"]!="" && $_POST["anio"]!=""
		&& $_POST["fecha_inicio"]!="" && $_POST["fecha_fin"]!="" )
		{
			include "../conexion.php";
			
			$sql = "insert into periodo_academico(nombre,numero,anio,fecha_inicio,fecha_fin,cohorte_id,created_at) 

				    value (\"$_POST[nombre]\",\"$_POST[numero]\",\"$_POST[anio]\",
				    	   \"$_POST[fecha_inicio]\",\"$_POST[fecha_fin]\",\"$_POST[cohorte_id]\",NOW())";
		
			$query = $con->query($sql);
			if($query!=null){
				print "<script>alert(\"Agregado exitosamente.\");window.location='cohortes.php?programa_id=".$_POST['programa_id']."';</script>";
			}else{
				print "<script>alert(\"No se pudo agregar.\");window.location='cohortes.php?programa_id=".$_POST['programa_id']."';</script>";

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