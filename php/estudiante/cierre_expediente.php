<?php 
  include "./php/conexion.php";

  $tabla = 'personas';
  $folder = 'personas';

  
  $sql5= "select * from grados where status = 'active' or status = 'closed'";
  $query5 = $con->query($sql5);

  $today = date("Y-m-d");

  $selected_v = '';
  $selected_e = '';
  if($persona->nacionalidad == 'V')
  {
    $selected_v = 'selected="selected"';
    $selected_e = '';
  }
  else
  {
    $selected_v = '';
    $selected_e = 'selected="selected"';
  }

?>

<form role="form" method="post" action="./php/estudiante/precierre.php"> 
  <div class="col-sm-6" >
    <label for="primer_nombre">Primer Nombre <span style='color: red'>*</span></label>
    <input type="text" value="<?=$persona->primer_nombre?>" class="form-control" name="primer_nombre" required style="position: inherit;z-index: 999;">
  </div>
  <div class="form-group col-sm-6" >
    <label for="segundo_nombre">Segundo Nombre <span style='color: red'>*</span></label>
    <input type="text" value="<?=$persona->segundo_nombre?>" class="form-control" name="segundo_nombre" required style="position: inherit;z-index: 999;">
  </div>
  <div class="form-group col-sm-6" >
    <label for="primer_apellido">Primer Apellido <span style='color: red'>*</span></label>
    <input type="text" value="<?=$persona->primer_apellido?>" class="form-control" name="primer_apellido" required style="position: inherit;z-index: 999;">
  </div>
  <div class="form-group col-sm-6" >
    <label for="segundo_apellido">Segundo Apellido <span style='color: red'>*</span></label>
    <input type="text" value="<?=$persona->segundo_apellido?>" class="form-control" name="segundo_apellido" required style="position: inherit;z-index: 999;">
  </div>

  <div class="form-group col-sm-12" >
    <div class="form-group col-sm-6">
      <label for="name">Nac <span style='color: red'>*</span></label>
      <select class="form-control" name="nacionalidad" style="position: inherit;z-index: 999;">
        <option value="">Seleccione</option>
        <option value="V" <?php echo $selected_v ?> >V</option>
        <option value="E" <?php echo $selected_e ?> >E</option>
      </select>
    </div>
    <div class="form-group col-sm-6" >
      <label for="documento_identidad">Cédula o Pasaporte <span style='color: red'>*</span></label>
      <input type="text" value="<?=$persona->documento_identidad?>" class="form-control" name="documento_identidad" required style="position: inherit;z-index: 999;">
    </div>
  </div>
  <div class="form-group col-sm-12">
    <label for="grado_academico_otorga">Grado académico que otorga <span style='color: red'>*</span></label>
    <input type="text" class="form-control" name="grado_academico_otorga" id="grado_academico_otorga" required>
  </div>
  <div class="form-group col-sm-12">
    <label for="name_programa">Nombre del Programa de Postgrado <span style='color: red'>*</span></label>
    <input type="text" class="form-control" name="name_programa" id="name_programa" required>
  </div>
  <div class="form-group col-sm-12">
    <label for="grado">Grado <span style='color: red'>*</span></label>
    <select class="form-control" name="grado_id" required>
      <option value='' selected>Seleccione...</option>
      <?php 
        while ($r=$query5->fetch_array()):
          //$selected = $r['status'] == 'active' ? 'selected' : '';
          $selected = '';
          echo "<option ".$selected." value='".$r['id']."' >".$r['name']."</option>";
        endwhile;
      ?>
    </select>
  </div>
  <div class="form-group col-sm-12">
    <label for="fecha_cierre">Fecha Cierre Expediente <span style='color: red'>*</span></label>
    <input type="date" value="<?=$today?>" class="form-control" name="fecha_cierre" required>
  </div>
  <div class="form-group col-sm-12">
    <label for="observaciones_cierre">Observaciones</label>
    <textarea class="form-control" name="observaciones_cierre" rows="3"></textarea>
  </div>
  <input type="hidden" name="id" id="estudio_id" > 
  <input type="hidden" name="persona_id" value="<?php echo $persona->id; ?>">
  <input type="hidden" name="source" value="<?php echo $source; ?>">
  <input type="hidden" name="opcion" value="<?php echo $opcio; ?>" >

  <button type="submit" class="btn btn-primary">Agregar</button>
</form>