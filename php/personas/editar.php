
<html>
	<head>
		<title>.: Editar Persona :.</title>
		<link rel="stylesheet" type="text/css" href="../../bootstrap/css/bootstrap.min.css">
		<script src="./../../js/jquery.min.js"></script>
	</head>
	<body>
	<?php include "../navbar.php"; ?>
<div class="container">
<div class="row">
<div class="col-sm-1 col-sm-offset-11">
	<?php $back = $_GET['sour']; 
		if($back == 'list')
		{
			$url_back = "/sigep_prototipo/personas.php";
		}
		else{
			$url_back = "/sigep_prototipo/buscar.php?s=".$_GET['s'];
		}
	?>
  <a href="<?=$url_back?>" class="btn btn-danger">Ir atr&aacute;s</a>
</div>
<div class="col-md-12">
		<h2>EDITAR</h2>

<?php 
	include "../personas/formulario.php";
?>

</div>
</div>
</div>

<script src="./../../bootstrap/js/bootstrap.min.js"></script>
	</body>
</html>