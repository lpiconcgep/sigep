<?php 
session_start();
  if(isset($_SESSION['session']) && $_SESSION['session'] == 'true') { ?>
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
				<h3>CIERRE DE EXPEDIENTE</h3>
			</div>
			<div class="row" id="parcial_cedula" >
		  	<br><br>
		  	<p style="text-align: center; font-weight: bold">Escriba el N&uacute;mero de C&eacute;dula</p>
		  	<div class="col-sm-10 col-sm-offset-3">

		  		<form class="navbar-form navbar-left" role="search" action="./buscar_estudiante.php" method="post">
			      <div class="form-group">
			        <input type="text" name="s" id="cedula" onblur="javascript:validarCedula()" size="40" class="form-control" placeholder="Escriba solo numeros, sin puntos ni guiones">
			     	<input type="hidden" name="opcion" id="opcion" value="4" />
			      </div>
			      <button type="submit" class="btn btn-default">&nbsp;<i class="glyphicon glyphicon-search"></i>&nbsp;</button>
			    </form>
		  	</div>
		  </div>
		</div>
	</div>

	<script src="bootstrap/js/bootstrap.min.js"></script>
	</body>
</html>
<?php } 
  else 
    print "<script>alert('Debe iniciar sesion.'); window.location='index.php';</script>";
?>