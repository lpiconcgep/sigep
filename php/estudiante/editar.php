<?php
session_start();
include "../../php/conexion.php";
$user_id=null;

$sql1= "select * from estudiante_programa ep INNER JOIN persona p ON ep.persona_id = p.id where ep.id = ".$_GET["estudiante_id"];
$query1 = $con->query($sql1);
$person = null;

if($query1->num_rows>0){
while ($r=$query1->fetch_object()){
  $person=$r;
  break;
  }
}

$nombre = $person->primer_apellido." ".$person->primer_nombre;
$cedula = $person->nacionalidad." - ".$person->documento_identidad;
?>
<html>
	<head>
		<title>.: Editar Estudio Realizado :.</title>
		<link rel="stylesheet" type="text/css" href="../../bootstrap/css/bootstrap.min.css">
		<script src="js/jquery.min.js"></script>
	</head>
	<body>
	<?php include "../navbar.php"; ?>
<div class="container">
<div class="row">
<div class="col-md-12">
		<h3>Editar Estudio Realizado de <?php echo strtoupper($nombre); 
      echo " (".$cedula.")";
      ?></h3>

<?php 
	include "../estudiante/formulario.php";
?>

</div>
</div>
</div>

<script src="bootstrap/js/bootstrap.min.js"></script>
	</body>
</html>