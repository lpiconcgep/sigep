<form role="form" method="post" action="./php/requisitos/agregar_requisito.php">
  <div class="form-group col-sm-12">
    <label for="nombre">Nombre <span style='color: red'>*</span></label>
    <input type="text" class="form-control" name="nombre" required>
  </div>
  <div class="form-group col-sm-6">
    <label for="posicion">Posici&oacute;n <span style='color: red'>*</span></label>
    <input type="number" min="1" max="999" step="1" class="form-control" name="posicion" required 
    style="position: sticky; z-index: 999;" >
  </div>
  <div class="form-group col-sm-6">
    <label for="obligatorio">Obligatorio:</label>
    <div class="form-check">
        <input class="form-check-input" type="radio" name="obligatorio" id="obligatorio_si" value="si" <?php echo (isset($obligatorio) && $obligatorio == 'si') ? 'checked' : ''; ?> required style="position: sticky; z-index: 999;" >
        <label class="form-check-label" for="obligatorio_si">Sí</label>
    </div>
    <div class="form-check">
        <input class="form-check-input" type="radio" name="obligatorio" id="obligatorio_no" value="no" <?php echo (isset($obligatorio) && $obligatorio == 'no') ? 'checked' : ''; ?> style="position: sticky; z-index: 999;" >
        <label class="form-check-label" for="obligatorio_no">No</label>
    </div>
  </div>
  <div class="form-group col-sm-12">
    <label for="tipo">Tipo:</label>
    <select class="form-control" name="tipo" id="tipo" required>
        <option value="">-- Seleccione el tipo --</option>
        <option value="Cumplimiento" <?php echo (isset($tipo) && $tipo == 'Cumplimiento') ? 'selected' : ''; ?>>Cumplimiento</option>
        <option value="Documento" <?php echo (isset($tipo) && $tipo == 'Documento') ? 'selected' : ''; ?>>Documento</option>
    </select>
  </div>

  <button type="submit" class="btn btn-primary">Agregar</button>
</form>