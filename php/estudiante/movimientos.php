<?php
session_start();
include "../../php/conexion.php";


if(isset($_SESSION['session']) && $_SESSION['session'] == 'true') { 
    
    // Incluir configuración
    require_once "../../includes/config.php";
    
    // Título de la página
    $page_title = "Gestión de Movimientos estudiantiles";
    
    // Ruta base
    $base = '../../';
    
    // Incluir header
    include $base."includes/header.php";
    include $base."php/navbar.php"; 

    $sql1= "select pg.id as programa_id, pg.nombre as programa, p.*, ep.persona_id, ep.id as estudiante_programa_id from estudiante_programa ep 
    		INNER JOIN persona p ON ep.persona_id = p.id 
    		INNER JOIN programa pg ON ep.programa_id = pg.id 
    		where ep.id = ".$_GET["estudiante_programa_id"];

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

    <div class="container">
    	
      <div class="row">
        <div class="col-md-12">
          <div class="page-header">
        	  <h4 >
              ESTUDIANTE:  <strong><?php echo strtoupper($nombre);?></strong>
              <?php echo "<br/> CÉDULA: <strong>".$cedula."<br/></strong>"; ?>
              POSTGRADO:<strong> <?php echo strtoupper($programa); ?></strong>
            </h4>
          </div>
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


            <div class="modal fade" id="myModal_<?=$_GET["estudiante_programa_id"]?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                      <h4 class="modal-title">Agregar Movimiento </h4>
                    </div>
                    <div class="modal-body">
                      <?php include "form_new_movimiento.php";?>
                    </div>

                  </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->
            
            <br>
            <br>
          <?php include "historial_estudiante.php"; ?>
        </div>
      </div>
    </div>
<?php include "../../includes/footer.php"; 
} else { 
    print "<script>alert('Debe iniciar sesión.'); window.location='index.php';</script>";
} 
?>
