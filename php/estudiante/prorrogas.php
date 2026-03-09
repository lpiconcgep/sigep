<?php
session_start();
include "../../php/conexion.php";

$sql1= "select pg.id as programa_id, pg.nombre as programa, p.*, ep.persona_id from estudiante_programa ep 
		INNER JOIN persona p ON ep.persona_id = p.id 
		INNER JOIN programa pg ON ep.programa_id = pg.id 
		where ep.id = ".$_GET["estudiante_id"];

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
$programa = $person->programa;
$programa_id = $person->programa_id;

?>
<html>
	<head>
		<title>.: SIGEP :.</title>
		<link rel="stylesheet" type="text/css" href="../../bootstrap/css/bootstrap.min.css">
		<script src="/sigep_prototipo/js/jquery.min.js"></script>
	</head>
	<body>
	<?php include "../../php/navbar.php"; ?>
<div class="container">
	
<div class="row">
<div class="col-md-12">
	<h4>
      EXTENSI&Oacute;N DE PLAZOS DE <strong><?php echo strtoupper($nombre); 
      echo " (".$cedula.")"; ?></strong>
      EN EL POSTGRADO <strong> <?php echo strtoupper($programa); ?></strong>
    </h4>
    <div class="col-sm-2">
    	<a data-toggle="modal" href="#myModal" class="btn btn-success">Agregar</a>
    </div>
    <div class="col-sm-2 col-sm-offset-8">
      <?php if($_GET['source'] == '') { ?>
         <a href="../../estudios.php?id=<?php echo $person->persona_id;?>" class="btn btn-warning pull-right">Ir atr&aacute;s</a>
      <?php } else { ?>
         <a href="../../matricula.php?programa_id=<?php echo $programa_id; ?>&tipo=999&source=reportes" class="btn btn-warning pull-right">Ir atr&aacute;s</a>
      <?php } ?>
    </div>

    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title">Agregar Extensi&oacute;n de Plazo </h4>
            </div>
            <div class="modal-body">
                <?php include "prorroga_form.php";?>
            </div>

          </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    
    <br>
    <br>
<?php include "listar_prorroga.php"; ?>
</div>
</div>
</div>

<script src="/sigep_prototipo/bootstrap/js/bootstrap.min.js"></script>
	</body>
</html>