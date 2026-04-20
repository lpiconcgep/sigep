<?php
  session_start(); 
  ini_set('display_errors',0);
  include "../../php/conexion.php";

  $sql1= "select * from postgrado where id = ".$_GET["postgrado_id"];
  $query = $con->query($sql1);
  $person = null;

  if($query->num_rows>0){
  while ($r=$query->fetch_object()){
    $programa=$r;
    break;
    }
  }



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
<div class="row">
<div class="col-sm-1 col-sm-offset-11">
  <a href="../../postgrados.php" class="btn btn-danger">Ir atr&aacute;s</a>
</div>
<div class="col-md-12">
		<h3>VER PROGRAMAS DE <?php echo strtoupper($programa->nombre); ?></h3>
<!-- Button trigger modal -->
  <!--a data-toggle="modal" href="#myModal" class="btn btn-default">Agregar</a-->
<br><br>

<?php include "../programas/listar.php"; ?>
</div>
</div>
</div>

<script src="bootstrap/js/bootstrap.min.js"></script>
	</body>
</html>