<?php 
  include "../../php/conexion.php";

  $sql= "select * from estudiante_programa ep 
         INNER JOIN persona p ON ep.persona_id = p.id
         where ep.id = ".$_GET["estudiante_id"];
  $query = $con->query($sql);
  $person = null;

  if($query->num_rows>0){
    while ($r=$query->fetch_object()){
      $person=$r;
      break;
    }
  }

  $sql1= "select * from programa WHERE id=".$person->programa_id;
  $query1 = $con->query($sql1);
  if($query1->num_rows>0){
  while ($r1=$query1->fetch_object()){
    $programa=$r1;
    break;
  }
  }

  $sql2= "select * from estatus_prorroga";
  $query2 = $con->query($sql2);
/*
  $sql3= "select * from extension_plazos WHERE estudiante_programa_id=".$_GET["estudiante_id"];
  $query3 = $con->query($sql3);

  if($query3->num_rows>0){
  while ($r3=$query3->fetch_object()){
    $plazo=$r3;
    break;
  }
  }*/

?>

<h4>
  <?php echo strtoupper($nombre); ?>
  <br><br>
  <?php echo strtoupper($programa->nombre); ?>
</h4>
<br>
<div class="row">
  <form role="form" method="post" action="./agregar_prorroga.php">
    <div class="form-group col-sm-6">
      <label for="fecha_solicitud">Fecha Solicitud <span style='color: red'>*</span></label>
      <input type="date" class="form-control" name="fecha_solicitud" value="" required>
    </div>
    <div class="form-group col-sm-5">
      <label for="estatus_prorroga_id">Estatus actual de la solicitud <span style='color: red'>*</span></label>
      <select class="form-control" name="estatus_prorroga_id">
        <?php 
          while ($r=$query2->fetch_array()):
            echo "<option value='".$r['id']."' >".$r['nombre']."</option>";
          endwhile;
        ?>
      </select>
    </div>
    <div class="form-group col-sm-11">
      <label for="motivo_estudiante">Motivo por el Estudiante <span style='color: red'>*</span></label>
      <textarea class="form-control" name="motivo_estudiante" required rows="3"></textarea>
    </div>
    <div class="form-group col-sm-11">
      <label for="email">Motivo por el Tutor </label>
      <textarea class="form-control" name="motivo_tutor" rows="3"></textarea>
    </div>
    <div class="form-group col-sm-11">
      <label for="email">Motivo del Postgrado </label>
      <textarea class="form-control" name="motivo_postgrado" rows="3"></textarea>
    </div>
    <div class="form-group col-sm-11">
      <label for="email">Opini&oacute;n Coordinador de Comisi&oacute;n </label>
      <textarea class="form-control" name="opinion_coordinador_comision" rows="3"></textarea>
    </div>
    <div class="form-group col-sm-11">
      <label for="email">Opini&oacute;n UCE </label>
      <textarea class="form-control" name="opinion_uce" rows="3"></textarea>
    </div>
    <div class="form-group col-sm-11">
      <label for="email">Desici&oacute;n CEP</label>
      <textarea class="form-control" name="decision_cep" rows="3"></textarea>
    </div>
    <div class="form-group col-sm-11">
      <label for="email">Observaciones adicionales </label>
      <textarea class="form-control" name="observaciones" rows="3"></textarea>
    </div>
    <div class="form-group col-sm-11">
      <input type="hidden" name="estudiante_programa_id" value="<?php echo $_GET["estudiante_id"]; ?>" >
      <input type="hidden" name="persona_id" value="<?php echo $person->persona_id; ?>" >

      <input type="hidden" name="extension_plazo_id" value=""> 
      <button type="submit" class="btn btn-primary">Guardar</button>
      <a href="prorrogas.php?estudiante_id=<?php echo $_GET["estudiante_id"];?>" class="btn btn-danger">Cancelar</a>
    </div>
  </form>
</div>