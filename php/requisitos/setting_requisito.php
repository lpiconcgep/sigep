<div class="row">
  
<form role="form" method="post" action="agregar_personal.php">
  <div class="col-sm-12">
    <div class="form-group col-sm-12">
      <label for="grado_acad_id">Grado académico <span style='color: red'>*</span></label>
      <select class="form-control" name="grado_acad_id[]" multiple >
        <?php 
          while ($r=$query2->fetch_array()):
            echo "<option value='".$r['id']."' >".$r['nombre']." (".$r['abreviatura'].")</option>";
          endwhile;
        ?>
      </select>
    </div>
  </div>
  <hr>
  <div class="col-sm-12">
    <div class="form-group col-sm-12">
      <label for="facultad_nucleo_id">Facultad <span style='color: red'>*</span></label>
      <select class="form-control" name="facultad_nucleo_id[]" multiple >
        <?php 
          while ($r=$query3->fetch_array()):
            echo "<option value='".$r['id']."' >".$r['nombre']."</option>";
          endwhile;
        ?>
      </select>
    </div>
  </div>
  <div class="col-sm-12">
    <div class="form-group col-sm-12">
        <label for="postgrado_id">Postgrado <span style='color: red'>*</span></label>
        <select class="form-control" name="postgrado_id[]" multiple >
            <?php 
            // Asumiendo que $query_postgrados contiene los resultados de la consulta a la base de datos
            while ($postgrado = $query4->fetch_array()):
                echo "<option value='" . $postgrado['id'] . "'>" . $postgrado['nombre'] . "</option>";
            endwhile;
            ?>
        </select>
    </div>
</div>
  <hr>
  <div class="row">
    <div class="col-sm-12">
      
     <?php /*
    
      <!--input type="hidden" name="postgrado_id" value="<?php echo $r["postgrado_id"]; ?>" -->  
  */ ?>
      <button type="submit" class="btn btn-primary">Agregar</button>
    </div>  
  </div>
</form>
</div>