<?php 
  include "./php/conexion.php";

  $tabla = 'personas';
  $folder = 'personas';

  

  $sql5= "select * from grados where status = 'active' or status = 'closed'";
  $query5 = $con->query($sql5);

  $today = date("Y-m-d");
?>
<h4>REGISTRO DE EGRESADO</h4>
<form role="form" method="post" action="./php/estudiante/egresar.php"> 
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