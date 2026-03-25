
<form role="form" method="post" action="agregar_personal.php">
  <div class="col-sm-12">
    <div class="form-group col-sm-6">
      <label for="nombre">Apellidos <span style='color: red'>*</span></label>
      <input type="text" class="form-control" autofocus name="apellidos" required>
    </div>
    <div class="form-group col-sm-6">
      <label for="nombre">Nombres <span style='color: red'>*</span></label>
      <input type="text" class="form-control" name="nombres" required>
    </div>
  </div>
  <div class="col-sm-12">
    <div class="form-group col-sm-4">
      <label for="email">Tipo de Cargo <span style='color: red'>*</span></label>
      <select class="form-control" name="tipo_cargo_id" >
        <?php 
          while ($r=$query4->fetch_array()):
            echo "<option value='".$r['id']."' >".$r['nombre']."</option>";
          endwhile;
        ?>
      </select>
    </div>
    <div class="form-group col-sm-4">
      <label for="name">Fecha Inicio Cargo <span style='color: red'>*</span></label>
      <input type="date" class="form-control" name="fecha_inicio_cargo" required>
    </div>
    <div class="form-group col-sm-4">
      <label for="name">Fecha Fin Cargo</label>
      <input type="date" class="form-control" name="fecha_fin_cargo" >
    </div>
  </div>
  <div class="col-sm-12">
    <input type="hidden" name="programa_id" value="<?php echo $_GET["programa_id"]; ?>">
    <input type="hidden" name="postgrado_id" value="<?php echo $r['postgrado_id']; ?>">
   <?php /*
  
    <!--input type="hidden" name="postgrado_id" value="<?php echo $r["postgrado_id"]; ?>" -->  
*/ ?>
    <button type="submit" class="btn btn-primary">Agregar</button>
  </div>
</form>
