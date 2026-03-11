<?php
session_start();

include "./php/conexion.php";
include "./php/funciones.php";
include "./php/utilidades.php";

<<<<<<< HEAD
if (isset($_POST['opcion']) && $_POST['opcion'] != '')
=======
if(isset($_POST['opcion']) && $_POST['opcion'] != '')
>>>>>>> 24861cc2950c10fe5a8d8e9a1af9bbdbeff45c07
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

<<<<<<< HEAD
=======
if(isset($_GET) && isset($_GET['opt']) == '' && $opcio == '')
{
	$opcio = 1;
}

>>>>>>> 24861cc2950c10fe5a8d8e9a1af9bbdbeff45c07
if(isset($opcio) && $opcio != '')
{
	$opcion = " REGISTRO DE INFORMACION PARA ";
	if($opcio == '1')
		$opcion .= "NUEVO INGRESO";
	else if($opcio == '2')
		$opcion .= "RETIRO O DESINCORPORACION";
<<<<<<< HEAD
=======
	else if($opcio == '4') 
		$opcion .= "CIERRE DE EXPEDIENTE";
>>>>>>> 24861cc2950c10fe5a8d8e9a1af9bbdbeff45c07
	else 
		$opcion .= "EGRESO DE ESTUDIANTE";
}

if(isset($_POST['s'])) { $s = $_POST['s']; } else { $s = $_GET['s']; }

<<<<<<< HEAD
$persona = buscar_persona_x_cedula($s);
=======

$persona = buscar_persona_x_cedula($s);

>>>>>>> 24861cc2950c10fe5a8d8e9a1af9bbdbeff45c07
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
									<br />
									<?php if($opcio == '4') {
										echo "<em style='color: red'>Para proceder con el proceso del cierre de expediente debe hacer el registro del estudiante como nuevo ingreso. </em>";

									} ?>
								<?php } ?>
							</div>

							<?php if($persona == NULL && $opcio != '4') { ?>
							<div class="col-sm-2">
								<br>
								<!-- Button trigger modal -->
								<a data-toggle="modal" href="#myModal" class="btn btn-primary">Agregar</a>
							</div>
							<?php } ?>

						</div>

						<?php if($persona != NULL) { 
							$cols = $opcio != '4' ? "col-sm-5" : "col-sm-6";
							?>
							<div class="<?=$cols?>" style="">
								<div class="row" id="datos_personales" >
									<div class="col-sm-9" style="border: 1px solid #e6e6e6; border-radius: 4px">
										<h4>Datos Personales: </h4>
										<p><strong>Nombres: </strong><?php echo strtoupper($persona->primer_nombre." ".$persona->segundo_nombre); ?></p>
										<p><strong>Apellidos: </strong><?php echo strtoupper($persona->primer_apellido." ".$persona->segundo_apellido); ?></p>

									</div>
								</div>
								<br>
								
								<?php
								if(($opcio == '1')  || ($opcio == '2') || ($opcio == '3')) {
									include "parcial_datos_academicos.php"; 
								}
								else if($opcio == '4'){
									include "parcial_datos_cierre.php"; 
								}
								?>
								
							</div>
							<?php if($opcio == '1') { ?>
							<div class="col-sm-6" style=""> 
								<?php
								$source = 'integral';
								$opcio = $opcio;

								$documento_identidad = $persona->documento_identidad;
								include "php/estudiante/form_new_estudiante.php"; ?>
							</div>
						<?php }
						elseif($opcio == '2')
						{
							
							$source = 'personal';
							$opcio = $opcio;
							$documento_identidad = $persona->documento_identidad;
							?>
							<div class="col-sm-6" id="form_registro_retiro" style="display:none"> 
							<?php
								include "php/estudiante/form_retiro_estudio.php";
							?>
							</div>
						<?php
						}
						elseif($opcio == '3')
						{
							$source = 'personal';
							$opcio = $opcio;
							$documento_identidad = $persona->documento_identidad;
							?>
							<div class="col-sm-6" id="form_registro_egreso" style="display:none"> 
							<?php
								include "php/estudiante/form_egreso_estudio.php";
							?>
							</div>
						<?php
						}
						elseif($opcio == '4')
						{
							$source = 'personal';
							$opcio = $opcio;
							$documento_identidad = $persona->documento_identidad;
							?>
							<div class="col-sm-6" id="form_registro_cierre" style="display:none"> 
							<?php
								include "php/estudiante/cierre_expediente.php";
							?>
							</div>
						<?php
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
