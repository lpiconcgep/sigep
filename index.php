<?php
session_start();
?>
<html>
	<head>

		<title>.: SIGEP V2 - Sistema Integrado de Gesti&oacute;n de Postgrados :.</title>
		<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
		<script src="js/jquery.min.js"></script>
	    <script src="js/utilidades.js"></script>
	    <script src="js/general.js"></script>
	</head>
	<body>
	<?php if(isset($_SESSION['session']) && $_SESSION['session'] == 'true') { ?>
	<?php include "php/navbar.php"; ?>
	<div class="container">
		<div class="row">
			<div class="col-sm-1 col-sm-offset-11" style="display: none" id="btn_atras_index">
			  <a href="/sigep_prototipo/index.php"  class="btn btn-primary">Ir atr&aacute;s</a>
			</div>
			<div class="col-md-12">
					<h2>..:: SIGEP - Sistema Integrado de Gesti&oacute;n de Postgrados ::..</h2>
					<br><br>
					<p class="lead"></p>
					<!--p>Instrucciones:</p>
					<ol>
						<li>Ir a la opci&oacute;n ver.</li>
						<li>Agregar elementos desde el boton agregar.</li>
						<li>Seleccionar el boton Editar de cualquier elemento.</li>
						<li>Seleccionar el boton Eliminar de cualquier elemento.</li>
					</ol>
					<br>
					<ul type="none">
					<li><i class="glyphicon glyphicon-ok"></i> Facil de instalar y modificar</li>
					<li><i class="glyphicon glyphicon-ok"></i> Ideal para tu proximo proyecto web</li>
					</ul-->
			</div>
			
			
		    <div class="row">
		      <div class="col-sm-3 col-sm-offset-1" id="btn-nuevo_ingreso">
		        <a onclick="javacript:mostrar_nuevo_ingreso()" style="cursor: pointer" >
		          <div style="border: 1px solid #E6E6E9; background-color: #e3e3e3; border-radius: 4px; padding: 15px; text-align: center  ">
		            <span style="top: 0px;" class="glyphicon glyphicon-user"></span>
		            <br />
		            Nuevo Ingreso
		          </div>
		        </a>
		      </div>
		      <div class="col-sm-3 col-sm-offset-1" id="btn-retiro">
		        <a onclick="javacript:mostrar_retiro()" style="cursor: pointer">
		          <div style="border: 1px solid #E6E6E9; background-color: #e3e3e3; border-radius: 4px; padding: 15px; text-align: center ">
		            <span style="top: 0px;" class="glyphicon glyphicon-user"></span>
		            <br />
		            Retiro o Desincorporaci&oacute;n
		          </div>
		        </a>
		      </div>
		      <div class="col-sm-3 col-sm-offset-1" id="btn-egreso">
		        <a onclick="javacript:mostrar_egreso()" style="cursor: pointer">

		          <div style="border: 1px solid #E6E6E9; background-color: #e3e3e3; border-radius: 4px; padding: 15px; text-align: center ">
		            <span style="top: 0px;" class="glyphicon glyphicon-user"></span>
		            <br />
		            Egreso
		          </div>
		        </a>
		      </div>
		  </div>
		  <div class="row" id="parcial_cedula" style="display: none">
		  	<br><br>
		  	<p style="text-align: center; font-weight: bold">Escriba el N&uacute;mero de C&eacute;dula</p>
		  	<div class="col-sm-10 col-sm-offset-3">

		  		<form class="navbar-form navbar-left" role="search" action="./buscar_estudiante.php" method="post">
			      <div class="form-group">

			        <input type="text" name="s" id="cedula" onblur="javascript:validarCedula()" size="40" class="form-control" placeholder="Escriba solo numeros, sin puntos ni guiones">
			     	<input type="hidden" name="opcion" id="opcion" value="" />
			      </div>
			      <button type="submit" class="btn btn-default">&nbsp;<i class="glyphicon glyphicon-search"></i>&nbsp;</button>
			    </form>
		  	</div>
		  </div>
		   <div class="row" id="parcial_desarrollo" style="display: none">
		  	<br><br>
		  	<p style="text-align: center; font-weight: bold">Este Modulo se encuentra en desarrollo</p>
		  </div>
			
		</div>
	</div>
	<?php }
		else
		{
			?>
			<?php include "php/navbar2.php"; ?>
				<div class="container">
				<div class="row">
					<h3 style="text-align: center; margin-top:80px;">..:: Sistema Integrado Gestion de Postgrados - Prototipo v.2 ::..</h3>
					<div class="col-sm-4 col-sm-offset-4" style="margin-top:50px; border: 1px solid #333333; padding: 30px; border-radius: 8px; background-color: #e1e1e1;">
						<div class="col-md-12" >
							<form role="form" method="post" action="./php/iniciar.php">
								<div class="row">
								  <div class="form-group">
								    <label for="name">Usuario <span style='color: red'>*</span></label>
					    			<input type="text" placeholder="Escriba su usuario" class="form-control" name="user" required>
								  </div>
							  	</div>
							  	<div class="row">
								  <div class="form-group">
								    <label for="name">Contrase&ntilde;a <span style='color: red'>*</span></label>
					    			<input type="password" placeholder="Escriba su contrase&ntilde;a" class="form-control" name="password" required>
								  </div>
							  	</div>
							  	<button type="submit" class="btn btn-primary pull-right">Ingresar</button>
							</form>
						</div>
					</div>
				</div>
				</div>

			<?php
		}
	 ?>
	</body>
</html>