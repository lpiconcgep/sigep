<?php 
  include "./php/conexion.php";

  $tabla = 'personas';
  $folder = 'personas';

  

  $sql5= "select * from motivo_retiro where activo = '1' order by id DESC";
  $query5 = $con->query($sql5);

  $sql6 = "select em.id as emid, e.* from estadisticas_movimiento em INNER JOIN estadisticas e ON em.estadistica_id = e.id WHERE em.status = 'active' AND tipo_movimiento_id = 3 order by id DESC";
  $query6 = $con->query($sql6);

  $today = date("Y-m-d");
?>
<h4>REGISTRO DE RETIRADO</h4>
<form role="form" method="post" action="./php/estudiante/retirar.php"> 
  <div class="row">
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
  </div>
  <div class="row">
  <div class="form-group col-sm-6">
    <label for="fecha_cierre">Fecha Retiro <span style='color: red'>*</span></label>
    <input type="date" value="<?=$today?>" class="form-control" name="fecha_retiro" required>
  </div>
  <div class="form-group col-sm-6">
    <label for="estadistica_id">Mes de Estadistica <span style='color: red'>*</span></label>
    <select class="form-control" name="estadistica_id" required>
      <?php 
        echo "<option value='' >Seleccione</option>";
        while ($r=$query6->fetch_array()):
          echo "<option value='".$r['emid']."' >".$r['description']."</option>";
        endwhile;
      ?>
    </select>
  </div>
  </div>
  <div class="row">
  <div class="form-group col-sm-12">
    <label for="descripcion_motivo_retiro">Descripción motivo retiro</label>
    <textarea class="form-control" name="descripcion_motivo_retiro" rows="3" required="required"></textarea>
  </div>
  </div>
  <div class="row">
  
  <div class="form-group col-sm-12">
    <label for="observaciones_retiro">Observaciones</label>
    <textarea class="form-control" name="observaciones_retiro" rows="3"></textarea>
  </div>
  </div>
  <input type="hidden" name="id" id="estudio_id" > 
  <input type="hidden" name="persona_id" value="<?php echo $persona->id; ?>">
  <input type="hidden" name="fecha_registro_retiro" value="<?=$today?>">
  <input type="hidden" name="source" value="<?php echo $source; ?>">
  <input type="hidden" name="opcion" value="<?php echo $opcio; ?>" >

  <button type="submit" class="btn btn-primary">Agregar</button>
</form>