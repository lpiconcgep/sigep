
<?php 
  include "./php/conexion.php";
  ini_set('display_errors',0);


  $sql1= "select * from pais";
  $query = $con->query($sql1);

  $sql2= "select * from etnia";
  $query2 = $con->query($sql2);
  

  if(isset($_POST['s']) && ($_POST['s'] != ''))
  {
    $cedula = $_POST['s'];
  }
  else
  {
    $cedula = '';
  }
?>

<form role="form" method="post" action="./php/personas/agregar.php">
  <div class="form-group col-sm-12">
    <label for="name">Tipo Documento Identidad <span style='color: red'>*</span></label>
    <select class="form-control" name="tipo_documento_identidad">
      <option value="0">Cedula Venezolana</option>
      <option value="1">Cedula Venezolana Extranjera</option>
      <option value="2">Cedula del Pais origen</option>
      <option value="3">Pasaporte</option>

    </select>
  </div>

  <div class="form-group col-sm-6">
    <label for="name">Num. Documento Identidad <span style='color: red'>*</span></label>
    <input type="text" class="form-control" name="documento_identidad" value="<?php echo $cedula; ?>" <?php if($cedula != '') { ?> readonly="readonly" <?php } ?> required>
  </div>
  <div class="form-group col-sm-6">
    <label for="name">Fecha Vencimiento Doc. Identidad </label>
    <input type="date" class="form-control" name="fecha_vencimiento_doc_identidad">
  </div>
  <div class="form-group col-sm-6">
    <label for="lastname">Primer Apellido <span style='color: red'>*</span></label>
    <input type="text" class="form-control" name="primer_apellido" required>
  </div>
  <div class="form-group col-sm-6">
    <label for="lastname">Segundo Apellido</label>
    <input type="text" class="form-control" name="segundo_apellido" >
  </div>
  <div class="form-group col-sm-6">
    <label for="name">Primer Nombre <span style='color: red'>*</span></label>
    <input type="text" class="form-control" name="primer_nombre" required>
  </div>
  <div class="form-group col-sm-6 ">
    <label for="name">Segundo Nombre</label>
    <input type="text" class="form-control" name="segundo_nombre" >
  </div>
  <div class="form-group col-sm-6">
    <label for="lastname">Sexo <span style='color: red'>*</span></label>
    <select class="form-control" name="sexo" required>
      <option value="F">Femenino</option>
      <option value="M">Masculino</option>
    </select>
  </div>
  <div class="form-group col-sm-6">
    <label for="phone">Estado Civil</label>
    <select class="form-control" name="estado_civil">
      <option value="S">Soltero</option>
      <option value="C">Casado</option>
      <option value="D">Divorciado</option>
      <option value="V">Viudo</option>
      <option value="O">Union Libre o Concubinato</option>
    </select>
  </div>
  <div class="form-group col-sm-6">
    <label for="name">Fecha Nacimiento</label>
    <input type="date" class="form-control" name="fecha_nacimiento">
  </div>
  <div class="form-group col-sm-6">
    <label for="name">Pasaporte Num.</label>
    <input type="text" class="form-control" name="pasaporte" >
  </div>
  <div class="form-group col-sm-6">
    <label for="email">Pais de Nacimiento <span style='color: red'>*</span></label>
    <select class="form-control" name="pais_origen_id" required>
      <?php 
        while ($r=$query->fetch_array()):
          if($r['id'] == 141)
            $select = "selected='selected'";
          else
            $select = '';
          echo "<option ".$select." value='".$r['id']."' >".$r['nombre']."</option>";
        endwhile;
      ?>
    </select>
  </div>
  <div class="form-group col-sm-6">
    <label for="address">Nacionalidad <span style='color: red'>*</span></label>
     <select class="form-control" name="nacionalidad" required>
      <option value="V">Venezolano</option>
      <option value="E">Extranjero</option>
    </select>
  </div>
  <div class="form-group col-sm-6">
    <label for="address">Si posee otra nacionalidad </label>
    <input type="text" class="form-control" name="nacionalidad_otra" placeholder="Escriba otra nacionalidad">
  </div>
 
  <div class="form-group col-sm-6">
    <label for="phone">Etnia <span style='color: red'>*</span></label>
    <select class="form-control" name="etnia_id" required>
      <?php 
        while ($r=$query2->fetch_array()):
          echo "<option value='".$r['id']."' >".$r['nombre']."</option>";
        endwhile;
      ?>
    </select>
  </div>
  <div class="form-group col-sm-11">
    <label for="phone">Ciudad de Residencia</label>
    <input type="text" class="form-control" name="ciudad_id" >
  </div>
  <div class="form-group col-sm-6">
    <label for="name">Regimen Penitenciario</label>
    <div class="radio">
      <label><input type="radio" value="1" name="regimen">Si</label>
    </div>
    <div class="radio">
      <label><input type="radio" value="0" name="regimen">No</label>
    </div>
  </div>

  <div class="form-group col-sm-6">
    <label for="name">Posee Discapacidad</label>
    <div class="radio">
      <label><input type="radio" value="1" name="discapacidad">Si</label>
    </div>
    <div class="radio">
      <label><input type="radio" value="0" name="discapacidad">No</label>
    </div>
  </div>
  
  <input type="hidden" name="source" value="<?php echo $source; ?>">
  <input type="hidden" name="opcion" value="<?php echo $_POST['opcion']; ?>" >
  <button type="submit" class="btn btn-primary">Agregar</button>

</form>
