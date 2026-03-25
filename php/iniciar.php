<?php

if(!empty($_POST))
{
	if(isset($_POST["user"]) && isset($_POST["password"]) )
	{
		if($_POST["user"]!="" && $_POST["password"]!="")
		{
			include "conexion.php";
			
			$sql = "SELECT * FROM usuarios WHERE user = '{$_POST["user"]}'";
			$query = $con->query($sql);
			if($query->num_rows>0)
			{
				while($r=$query->fetch_object())
				{
				  $user=$r;
				  break;
				}
				
				session_start();
				if($user->password == $_POST['password'])
				{
					
					$_SESSION['session'] = 'true';
					$_SESSION['user'] = $user->user;
					$_SESSION['name'] = $user->name;
					$_SESSION['user_id'] = $user->id;
					print "<script> window.location='../inicio.php';</script>";
				}
				else
				{
					unset($_SESSION['session']);
					unset($_SESSION['user']);
					unset($_SESSION['name']);
					unset($_SESSION['user_id']);

					print "<script>alert('Contraseña incorrectas.');window.location='../index.php';</script>";
				}
			}
			else
			{
				unset($_SESSION['session']);
				unset($_SESSION['user']);
				unset($_SESSION['name']);
				unset($_SESSION['user_id']);
				print "<script>alert('Usuario y/o Contraseña incorrectas.');window.location='../login.php';</script>";
			}
			
		}
	}
}



?>