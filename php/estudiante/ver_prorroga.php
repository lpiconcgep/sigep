<?php
session_start();
include "../../php/conexion.php";

$sql1= "select * from estudiante_programa ep INNER JOIN persona p ON ep.persona_id = p.id where ep.id = ".$_GET["estudiante_id"];
$query = $con->query($sql1);
$person = null;

if($query->num_rows>0){
while ($r=$query->fetch_object()){
  $person=$r;
  break;
  }
}

$nombre = $person->primer_apellido." ".$person->primer_nombre;
$cedula = $person->nacionalidad." - ".$person->documento_identidad;
?>
<html>
	<head>
		<title>.: SIGEP :.</title>
		<link rel="stylesheet" type="text/css" href="../../bootstrap/css/bootstrap.min.css">
		<script src="js/jquery.min.js"></script>
	</head>
	<body>
	<?php include "../../php/navbar.php"; ?>
<div class="container">
	<a href="../../matricula.php?programa_id=<?php echo $person->programa_id;?>" class="btn btn-warning pull-right">Ir atr&aacute;s</a>
<div class="row">
<div class="col-md-12">
		<h3>
      EXTENSI&Oacute;N DE PLAZOS DE <?php echo strtoupper($nombre); 
      echo " (".$cedula.")";
      ?>
    </h3>
      
<?php include "prorroga_view.php";?>
</div>
</div>
</div>

<script src="bootstrap/js/bootstrap.min.js"></script>
	</body>
</html>