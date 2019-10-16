<?php
session_start();
include "php/conexion.php";

$user_id=null;
$sql1= "select * from persona where id = ".$_GET["id"];
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
		<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
		<script src="js/jquery.min.js"></script>
	</head>
	<body>
	<?php include "php/navbar.php"; ?>
<div class="container">
<div class="row">
<div class="col-md-12">
		<h3>
      ESTUDIOS REALIZADOS DE <?php echo strtoupper($nombre); 
      echo " (".$cedula.")";
      ?>
    </h3>
<!-- Button trigger modal -->
<div class="col-sm-1">
  <a data-toggle="modal" href="#myModal" class="btn btn-primary">Agregar Estudios</a>
  
</div>  
<div class="col-sm-1 col-sm-offset-10">
  <a href="personas.php" class="btn btn-danger">Ir atr&aacute;s</a>
</div>

  
<br><br>
  <!-- Modal -->
  <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Agregar Estudios</h4>
        </div>
        <div class="modal-body">
            <?php include "php/estudiante/form.php";?>
        </div>

      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->


<?php include "php/estudiante/listar.php"; ?>
</div>
</div>
</div>

<script src="bootstrap/js/bootstrap.min.js"></script>
<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
<script src="js/jquery.min.js"></script>
<script src="js/utilidades.js"></script>
	</body>
</html>