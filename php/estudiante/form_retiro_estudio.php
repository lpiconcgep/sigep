<?php 
  include "./php/conexion.php";

  $tabla = 'personas';
  $folder = 'personas';

  

  $sql5= "select * from motivo_retiro where activo = '1'";
  $query5 = $con->query($sql5);

  $today = date("Y-m-d");
?>
<h4>REGISTRO DE RETIRADO</h4>
<form role="form" method="post" action="./php/estudiante/retirar.php"> 
  <div class="form-group col-sm-12">
    <label for="grado">Motivo <span style='color: red'>*</span></label>
    <select class="form-control" name="motivo_retiro_id" required>
      <option value='' selected>Seleccione...</option>
      <?php 
        while ($r=$query5->fetch_array()):
          //$selected = $r['status'] == 'active' ? 'selected' : '';
          $selected = '';
          echo "<option ".$selected." value='".$r['id']."' >".$r['nombre']."</option>";
        endwhile;
      ?>
    </select>
  </div>
  <div class="form-group col-sm-12">
    <label for="fecha_cierre">Fecha Retiro <span style='color: red'>*</span></label>
    <input type="date" value="<?=$today?>" class="form-control" name="fecha_retiro" required>
  </div>
  <div class="form-group col-sm-12">
    <label for="descripcion_motivo_retiro">Descripción motivo retiro</label>
    <textarea class="form-control" name="descripcion_motivo_retiro" rows="3">Retiro desincorporaciones masivas</textarea>
  </div>
  
  <div class="form-group col-sm-12">
    <label for="observaciones_retiro">Observaciones</label>
    <textarea class="form-control" name="observaciones_retiro" rows="3"></textarea>
  </div>
  <input type="hidden" name="id" id="estudio_id" > 
  <input type="hidden" name="persona_id" value="<?php echo $persona->id; ?>">
  <input type="hidden" name="fecha_registro_retiro" value="<?=$today?>">
  <input type="hidden" name="source" value="<?php echo $source; ?>">
  <input type="hidden" name="opcion" value="<?php echo $opcio; ?>" >

  <button type="submit" class="btn btn-primary">Agregar</button>
</form>