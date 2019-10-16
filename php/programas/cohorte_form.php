
<form role="form" method="post" action="agregar_cohorte.php">
  <div class="form-group col-sm-4">
    <label for="nombre">Nombre <span style='color: red'>*</span></label>
    <input type="text" class="form-control" name="nombre" required>
  </div>
  <div class="form-group col-sm-4">
    <label for="email">N&uacute;mero <span style='color: red'>*</span></label>
    <input type="text" class="form-control" name="numero" required>
  </div>
  <div class="form-group col-sm-4">
    <label for="email">A&ntilde;o <span style='color: red'>*</span></label>
    <input type="text" class="form-control" name="anio" required>
  </div>
  <div class="form-group col-sm-6">
    <label for="name">Fecha Inicio <span style='color: red'>*</span></label>
    <input type="date" class="form-control" name="fecha_inicio" required>
  </div>
  <div class="form-group col-sm-6">
    <label for="name">Fecha Fin <span style='color: red'>*</span></label>
    <input type="date" class="form-control" name="fecha_fin" required>
  </div>

  <input type="hidden" name="programa_id" value="<?php echo $_GET["programa_id"]; ?>">  

  <button type="submit" class="btn btn-primary">Agregar</button>
</form>