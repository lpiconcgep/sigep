<?php
session_start();
include "../../php/conexion.php";
include "../../php/utilidades.php";

$sql_grado= "select * from grados where id = ".$_POST["grado_id"];
$query_grado = $con->query($sql_grado);
$grado=$query_grado->fetch_object();

$fecha_egreso = isset($_POST['fecha_cierre']) ? $_POST['fecha_cierre'] : "";
$fecha_cierre = isset($_POST['fecha_cierre']) ? $_POST['fecha_cierre'] : "";
$fecha_grado = $grado->fecha_grado;
$grado_otorga = $_POST['grado_academico_otorga'];

$sql1= "select pg.id as programa_id, pg.nombre as programa, p.*, ep.persona_id, ep.id as estudiante_programa_id from estudiante_programa ep 
		INNER JOIN persona p ON ep.persona_id = p.id 
		INNER JOIN programa pg ON ep.programa_id = pg.id 
		where ep.id = ".$_POST["id"];

$query = $con->query($sql1);
$person = null;

if($query->num_rows>0){
while ($r=$query->fetch_object()){
  $person=$r;
  break;
  }
}

$apellidos = $person->primer_apellido." ".$person->segundo_apellido;
$nombres = $person->primer_nombre." ".$person->segundo_nombre;
$text_cedula = $person->nacionalidad == "V" ? "CÉDULA" : "PASAPORTE";
$cedula = $person->documento_identidad;
$nacionalidad = $person->nacionalidad == "V" ? "Venezolana" : "Extranjero";

$programa = $person->programa;
$programa_id = $person->programa_id;

?>
<html>
	<head>
		<title>.: SIGEP - Sistema Integrado de Gesti&oacute;n de Postgrados :.</title>
		<link rel="stylesheet" type="text/css" href="../../bootstrap/css/bootstrap.min.css">
		<script src="/sigep_prototipo/js/jquery.min.js"></script>
    <script src="/sigep_prototipo/bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript">
     
        $(".nvo").css("display" , "none");
        
    </script>
	</head>
	<body>
  	<?php include "../../php/navbar.php"; ?>
    <div class="container">
    	
      <div class="row">
        <div class="col-md-12">
          <h3>..:: PRECIERRE DE EXPEDIENTE PARA EL GRADO DEL <?=transforma_fecha($fecha_grado)?> ::..</h3>
          <br>
        	  <h4 style="border: 1px solid #5cb85c; padding: 15px; border-radius: 8px">
              APELLIDOS: <strong><?php echo strtoupper($apellidos)."</strong><br/>NOMBRES: <strong>".strtoupper( $nombres);?></strong>
              
              <?php echo "<br/> ".$text_cedula.": <strong>".$cedula."</strong>"; ?>
              <?php echo "<br/> NACIONALIDAD: <strong>".strtoupper($nacionalidad)."<br/></strong>"; ?>

              TITULO A OTORGAR:<strong> <?php echo strtoupper($grado_otorga); ?></strong>
            </h4>
            <div class="col-sm-2">
            	<a data-toggle="modal" href="#myModal_<?=$_GET["estudiante_programa_id"]?>" class="btn btn-success">Agregar</a>
            </div>
            <div class="col-sm-2 col-sm-offset-8">
              <?php if($_GET['source'] == '') { ?>
                 <a href="../../estudios.php?id=<?php echo $person->persona_id;?>" class="btn btn-danger pull-right">Ir atr&aacute;s</a>
              <?php } else { ?>
                 <a href="../../matricula.php?programa_id=<?php echo $programa_id; ?>&tipo=999&source=reportes" class="btn btn-warning pull-right">Ir atr&aacute;s</a>
              <?php } ?>
            </div>

            <br>
            <br>
          <?php // include "historial_estudiante.php"; ?>
        </div>
      </div>
    </div>

  
    <script src="/sigep_prototipo/js/utilidades.js"></script>
	</body>
</html>