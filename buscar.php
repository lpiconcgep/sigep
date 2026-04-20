
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
		<h3>Buscar todo lo que coincida con <strong >*<?php echo $_GET['s']?>*</strong></h3>


<?php include "php/personas/busqueda.php"; ?>
</div>
</div>
</div>

<script src="bootstrap/js/bootstrap.min.js"></script>
	</body>
</html>