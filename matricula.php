<?php 
  session_start();
  ini_set('display_errors',0);

  include "./php/conexion.php";
  $user_id=null;

  $sql= "select * from programa where id = ".$_GET["programa_id"];
  $query = $con->query($sql);

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
		<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
		<script src="js/jquery.min.js"></script>
	</head>
	<body>
	<?php include "php/navbar.php"; ?>
<div class="container">
<div class="row">
<div class="col-sm-1 col-sm-offset-11">
  <?php if(!(isset($_GET) && (isset($_GET['source'])) && ($_GET['source'] == 'reportes'))) { 
    $source = '';
    ?>
    <a href="php/postgrados/programas.php?postgrado_id=<?php echo $programa->postgrado_id;?>" class="btn btn-danger">Ir atr&aacute;s</a>
  <?php } else { 
    
    $source = $_GET['source'];
    ?>
    <a href="php/reportes/matricula.php" class="btn btn-danger">Ir atr&aacute;s</a>
    <?php } ?>
</div>
<div class="col-md-12">
		<h4>VER MATRICULA DE <?php echo strtoupper($programa->nombre); ?></h4>
<br>


<?php include "php/estudiante/matricula_listar.php"; ?>
</div>
</div>
</div>

<script src="bootstrap/js/bootstrap.min.js"></script>
	</body>
</html>