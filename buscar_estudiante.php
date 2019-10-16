<?php
session_start();

include "./php/conexion.php";
include "./php/funciones.php";
include "./php/utilidades.php";

if (isset($_POST['opcion']) && $_POST['opcion'] != '')
{
	$opcio = $_POST['opcion'];
}
elseif (isset($_GET['opt']) && $_GET['opt'] != '')
{
	$opcio = $_GET['opt'];
}
else
{
	$opcio = '';
}

if(isset($opcio) && $opcio != '')
{
	$opcion = " REGISTRO DE INFORMACION PARA ";
	if($opcio == '1')
		$opcion .= "NUEVO INGRESO";
	else if($opcio == '2')
		$opcion .= "RETIRO O DESINCORPORACION";
	else 
		$opcion .= "EGRESO DE ESTUDIANTE";
}

if(isset($_POST['s'])) { $s = $_POST['s']; } else { $s = $_GET['s']; }

$persona = buscar_persona_x_cedula($s);
if($persona != NULL)
{
	$estudios_persona = buscar_inscripciones_x_persona_id($persona->id);
	//print_r($estudios_persona);
}

?>
<html>
	<head>
		<title>.: SIGEP - Sistema Integrado de Gesti&oacute;n de Postgrados :.</title>
		<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
		<script src="js/jquery.min.js"></script>
	    <script src="js/utilidades.js"></script>
	    <script src="js/general.js"></script>
	</head>
	<body>
		<?php if(isset($_SESSION['session']) && $_SESSION['session'] == 'true') { ?>
		<?php include "php/navbar.php"; ?>
		<div class="container">
			<div class="col-sm-1 col-sm-offset-10">
			  <a href="./" class="btn btn-primary">Ir atr&aacute;s</a>
			</div>
			<br />
			<div class="row">
				<div class="col-md-12">
						<h3>..:: <?php echo $opcion; ?> ::..</h3>
						<br><br>
						<div class="row">
							<div class="col-sm-3 col-sm-offset-1">
								<h4>C&eacute;dula: <em><?php if(isset($_POST['s'])) { echo $_POST['s']; } else { echo $_GET['s']; }?></em></h4>
								
								<?php if($persona == NULL) { ?>
									<em>C&eacute;dula no registrada.</em>
								<?php } ?>
							</div>

							<?php if($persona == NULL) { ?>
							<div class="col-sm-2">
								<br>
								<!-- Button trigger modal -->
								<a data-toggle="modal" href="#myModal" class="btn btn-primary">Agregar</a>
							</div>
							<?php } ?>

						</div>
						<?php if($persona != NULL) { ?>
							<div class="col-sm-5" style="">
								<div class="row" id="datos_personales" >
									<div class="col-sm-9" style="border: 1px solid #e6e6e6; border-radius: 4px">
										<h4>Datos Personales: </h4>
										<p><strong>Nombres: </strong><?php echo $persona->primer_nombre." ".$persona->segundo_nombre; ?></p>
										<p><strong>Apellidos: </strong><?php echo $persona->primer_apellido." ".$persona->segundo_apellido; ?></p>
									</div>
								</div>
								<br>
								
								<?php
								if($opcio == '1') {
									include "parcial_datos_academicos.php"; 
								}
								?>
								
							</div>
							<?php if($opcio == '1') { ?>
							<div class="col-sm-6" style=""> 
								<?php
								$source = 'integral';
								$documento_identidad = $persona->documento_identidad;
								include "php/estudiante/form_new_estudiante.php"; ?>
							</div>
						<?php }
						elseif($opcio == '2')
						{
							include "parcial_datos_academicos.php";
						}

						 } ?>
						
	
						  <!-- Modal -->
						  <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						    <div class="modal-dialog">
						      <div class="modal-content">
						        <div class="modal-header">
						          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						          <h4 class="modal-title">Agregar</h4>
						        </div>
						        <div class="modal-body">
						            <?php
						            $source = "integral";
						            include "php/personas/form.php";?>
						        </div>

						      </div><!-- /.modal-content -->
						    </div><!-- /.modal-dialog -->
						  </div><!-- /.modal -->
							
				</div>
			</div>
		</div>
		<?php } ?>

	<script src="bootstrap/js/bootstrap.min.js"></script>
	</body>
</html>
