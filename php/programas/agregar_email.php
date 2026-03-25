<?php
 // Array ( [nombre] => Cohorte II [numero] => 2 [anio] => 2011 [fecha_inicio] => 2001-12-12 
 //[fecha_fin] => 2010-10-10 [id] => 1 )
session_start();
if(!empty($_POST))
{
	if(isset($_POST["programa_id"]) && isset($_POST["email"]))
	{
		if($_POST["programa_id"]!="" && $_POST["email"]!="" )
		{
			include "../conexion.php";
			$sql = "insert into emails(email,personal_id,created_at,user_create) 
				    value (\"$_POST[email]\",\"$_POST[personal_id]\",NOW(),\"$_SESSION[user_id]\")";
		
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