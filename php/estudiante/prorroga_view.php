<?php 
  include "../../php/conexion.php";

  $sql2= "select * from estatus_prorroga";
  $query2 = $con->query($sql2);

  $sql3= "select p.nombre as estatus,e.* from extension_plazos e
          INNER JOIN estatus_prorroga p ON e.estatus_prorroga_id = p.id
          WHERE e.id=".$extension_id;
  $query3 = $con->query($sql3);

  if($query3->num_rows>0){
    $plazo=$query3->fetch_object();
?>

<h4>
  <?php 
    echo strtoupper($programa->nombre); ?>
</h4>
<br>
  <div class="row">
    <div class="form-group col-sm-4">
      <label >Fecha Solicitud: </label>
    </div>
    <div class="col-sm-8">
      <?php echo $plazo->fecha_solicitud?> 
    </div>
  </div>
  <div class="row">
    <div class="col-sm-6">
      <label for="estatus_prorroga_id">Estatus actual de la solicitud </label>
    </div>
    <div class="col-sm-4">
        <?php echo $plazo->estatus; ?>
    </div>
  </div>
  <br>
  <div class="row">
    <div class="form-group col-sm-10">
      <label for="motivo_estudiante">Motivo por el Estudiante </label>
      <textarea class="form-control" name="motivo_estudiante" readonly rows="3"><?php echo $plazo->motivo_estudiante ?></textarea>
    </div>
  </div>
  <div class="row">
    <div class="form-group col-sm-10">
      <label for="email">Motivo por el Tutor </label>
      <textarea class="form-control" name="motivo_tutor" readonly rows="3"><?php echo $plazo->motivo_tutor ?></textarea>
    </div>
  </div>
  <div class="row">
    <div class="form-group col-sm-10">
      <label for="email">Motivo del Postgrado </label>
      <textarea class="form-control" name="motivo_postgrado" readonly rows="3"><?php echo $plazo->motivo_postgrado ?></textarea>
    </div>
  </div>
  <div class="row">
    <div class="form-group col-sm-10">
      <label for="email">Opini&oacute;n Coordinador de Comisi&oacute;n </label>
      <textarea class="form-control" name="opinion_coordinador_comision" readonly rows="3"><?php echo $plazo->opinion_coordinador_comision ?></textarea>
    </div>
  </div>
  <div class="row">
    <div class="form-group col-sm-10">
      <label for="email">Opini&oacute;n UCE </label>
      <textarea class="form-control" name="opinion_uce" readonly rows="3"><?php echo $plazo->opinion_uce ?></textarea>
    </div>
  </div>
  <div class="row">
    <div class="form-group col-sm-10">
      <label for="email">Desici&oacute;n CEP</label>
      <textarea class="form-control" name="decision_cep" readonly rows="3"><?php echo $plazo->decision_cep ?></textarea>
    </div>
  </div>
  <div class="row">
    <div class="form-group col-sm-10">
      <label for="email">Observaciones adicionales </label>
      <textarea class="form-control" name="observaciones" readonly rows="3"><?php echo $plazo->observaciones ?></textarea>
    </div>
  </div>
<?php
}
