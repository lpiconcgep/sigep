<?php 
  include "./php/conexion.php";

  $tabla = 'personas';
  $folder = 'personas';

  $user_id=null;
  
  $sql_f= "select * from facultad_nucleo";
  $query_f = $con->query($sql_f);

  $sql0= "select * from postgrado";
  $query0 = $con->query($sql0);

  $sql1= "select * from programa";
  $query = $con->query($sql1);

  $sql2= "select * from condicion_estudiante";
  $query2 = $con->query($sql2);

  $sql3= "select * from estatus_estudiante";
  $query3 = $con->query($sql3);

  $sql4= "select * from estatus_matriculacion";
  $query4 = $con->query($sql4);

?>

<form role="form" method="post" action="./php/estudiante/agregar.php">
  <div class="form-group col-sm-12">
    <label for="email">Facultad <span style='color: red'>*</span></label>
    <select class="form-control" name="facultad_id" id="select_facultades" onchange="javascript:buscar_postgrados()" required>
      <?php 
        echo "<option value='-1' >Todos</option>";
        while ($r_f=$query_f->fetch_array()):
          echo "<option value='".$r_f['id']."' >".$r_f['nombre']."</option>";
        endwhile;
      ?>
    </select>
  </div>
  <div class="form-group col-sm-12">
    <label for="email">Postgrado <span style='color: red'>*</span></label>
    <select class="form-control" name="postgrado_id" id="select_postgrados" onchange="javascript:buscar_programas()" required>
      <?php 
        echo "<option value='-1' >Todos</option>";
        while ($r0=$query0->fetch_array()):
          echo "<option value='".$r0['id']."' >".$r0['nombre']."</option>";
        endwhile;
      ?>
    </select>
  </div>
  <div class="form-group col-sm-12">
    <label for="email">Programa <span style='color: red'>*</span></label>
    <select class="form-control" name="programa_id"  id="select_programas" required>
      <?php 
        while ($r=$query->fetch_array()):
          echo "<option value='".$r['id']."' >".$r['nombre']."</option>";
        endwhile;
      ?>
    </select>
  </div>
  <div class="form-group col-sm-6">
    <label for="email">Condici&oacute;n Estudiante <span style='color: red'>*</span></label>
    <select class="form-control" name="condicion_estudiante_id" required>
      <?php 
        while ($r=$query2->fetch_array()):
          echo "<option value='".$r['id']."' >".$r['nombre']."</option>";
        endwhile;
      ?>
    </select>
  </div>
  <div class="form-group col-sm-6">
    <label for="email">Estatus Estudiante <span style='color: red'>*</span></label>
    <select class="form-control" name="estatus_estudiante_id" required>
      <?php 
        while ($r=$query3->fetch_array()):
          echo "<option value='".$r['id']."' >".$r['nombre']."</option>";
        endwhile;
      ?>
    </select>
  </div>
  <div class="form-group col-sm-6">
    <label for="name">Fecha Ingreso <span style='color: red'>*</span></label>
    <input type="date" class="form-control" name="fecha_ingreso" required>
  </div>
   <div class="form-group col-sm-6">
    <label for="name">A&ntilde;o Cohorte </label>
    <input type="text" class="form-control" name="anio_cohorte" >
  </div>
  <div class="form-group col-sm-6">
    <label for="name">Fecha Egreso </label>
    <input type="date" class="form-control" name="fecha_egreso" >
  </div>
  <div class="form-group col-sm-6">
    <label for="name">Fecha Grado </label>
    <input type="date" class="form-control" name="fecha_grado" >
  </div>
    <div class="form-group col-sm-6">
    <label for="name">Fecha de Retiro </label>
    <input type="date" class="form-control" name="fecha_retiro" >
  </div>
  <div class="form-group col-sm-6">
    <label for="name">Fecha de Desincorporaci&oacute;n </label>
    <input type="date" class="form-control" name="fecha_desincorporacion">
  </div>
  <!--div class="form-group col-sm-6">
    <label for="name">Fecha de Matriculaci&oacute;n </label>
    <input type="date" class="form-control" name="fecha_matriculacion" >
  </div>
  <div class="form-group col-sm-6">
    <label for="name">Estatus de Matriculaci&oacute;n </label>
    <select class="form-control" name="estatus_matriculacion_id" required>
      <?php 
        while ($r=$query4->fetch_array()):
          echo "<option value='".$r['id']."' >".$r['nombre']."</option>";
        endwhile;
      ?>
    </select>
  </div-->

  <div class="form-group col-sm-11">
    <label for="observaciones">Observaciones</label>
    <textarea class="form-control" name="observaciones" rows="3"></textarea>
  </div>

  <input type="hidden" name="id" value="<?php echo $person->id; ?>">
  <!--input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>"-->      

  <button type="submit" class="btn btn-primary">Agregar</button>
</form>