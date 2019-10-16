
<?php 
  include "../../php/conexion.php";

  $sql= "select * from estudiante_programa where id = ".$_GET["estudiante_id"];
  $query = $con->query($sql);

  $sql1= "select * from programa";
  $query1 = $con->query($sql1);

  $sql2= "select * from condicion_estudiante";
  $query2 = $con->query($sql2);

  $sql3= "select * from estatus_estudiante";
  $query3 = $con->query($sql3);

  $sql4= "select * from estatus_matriculacion";
  $query4 = $con->query($sql4);

  if($query->num_rows>0){
  while ($r=$query->fetch_object()){
    $person=$r;
    break;
  }
  }


?>
<form role="form" method="post" action="actualizar.php">
  <div class="form-group col-sm-12">
    <label for="email">Programa <span style='color: red'>*</span></label>
    <select class="form-control" name="programa_id" required>
      <?php 
        
        while ($r=$query1->fetch_array()):
          $selected = '';
          if($r['id'] == $person->programa_id)
            $selected = 'selected="selected"';
          echo "<option ".$selected." value='".$r['id']."' >".$r['nombre']."</option>";
        endwhile;
      ?>
    </select>
  </div>
  <div class="form-group col-sm-6">
    <label for="email">Condici&oacute;n Estudiante <span style='color: red'>*</span></label>
    <select class="form-control" name="condicion_estudiante_id" required>
      <?php 
        while ($r=$query2->fetch_array()):
          $selected = '';
          if($r['id'] == $person->condicion_estudiante_id)
            $selected = 'selected="selected"';
          echo "<option ".$selected." value='".$r['id']."' >".$r['nombre']."</option>";
        endwhile;
      ?>
    </select>
  </div>
  <div class="form-group col-sm-6">
    <label for="email">Estatus Estudiante <span style='color: red'>*</span></label>
    <select class="form-control" name="estatus_estudiante_id" required>
      <?php 
        while ($r=$query3->fetch_array()):
          $selected = '';
          if($r['id'] == $person->estatus_estudiante_id)
            $selected = 'selected="selected"';
          echo "<option ".$selected." value='".$r['id']."' >".$r['nombre']."</option>";
        endwhile;
      ?>
    </select>
  </div>
  <div class="form-group col-sm-6">
    <label for="name">Fecha Ingreso <span style='color: red'>*</span></label>
    <input type="date" class="form-control" name="fecha_ingreso" value="<?php echo $person->fecha_ingreso; ?>" required>
  </div>
   <div class="form-group col-sm-6">
    <label for="name">A&ntilde;o Cohorte </label>
    <input type="text" class="form-control" name="anio_cohorte" value="<?php echo $person->anio_cohorte; ?>" >
  </div>
  <div class="form-group col-sm-6">
    <label for="name">Fecha Egreso </label>
    <input type="date" class="form-control" name="fecha_egreso" value="<?php echo $person->fecha_egreso; ?>" >
  </div>
  <div class="form-group col-sm-6">
    <label for="name">Fecha Grado </label>
    <input type="date" class="form-control" name="fecha_grado" value="<?php echo $person->fecha_grado; ?>" >
  </div>
  <div class="form-group col-sm-6">
    <label for="name">Fecha de Retiro </label>
    <input type="date" class="form-control" name="fecha_retiro" value="<?php echo $person->fecha_retiro; ?>">
  </div>
  <div class="form-group col-sm-6">
    <label for="name">Fecha de Desincorporaci&oacute;n </label>
    <input type="date" class="form-control" name="fecha_desincorporacion" value="<?php echo $person->fecha_desincorporacion; ?>">
  </div>
  <!--div class="form-group col-sm-6">
    <label for="name">Fecha de Matriculaci&oacute;n </label>
    <input type="date" class="form-control" name="fecha_matriculacion" value="<?php echo $person->fecha_matriculacion; ?>">
  </div>
  <div class="form-group col-sm-6">
    <label for="name">Estatus de Matriculaci&oacute;n </label>
    <select class="form-control" name="estatus_matriculacion_id" required>
      <?php 
        while ($r=$query4->fetch_array()):
          $selected = '';
          if($r['id'] == $person->estatus_matriculacion_id)
            $selected = 'selected="selected"';
          echo "<option ".$selected." value='".$r['id']."' >".$r['nombre']."</option>";
        endwhile;
      ?>
    </select>
  </div-->

  <div class="form-group col-sm-11">
    <label for="observaciones">Observaciones</label>
    <textarea class="form-control" name="observaciones" rows="3"> <?php echo $person->observaciones; ?> </textarea>
  </div>

  <input type="hidden" name="id" value="<?php echo $person->id; ?>">  
  <input type="hidden" name="persona_id" value="<?php echo $person->persona_id; ?>">
  <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>">    

  <button type="submit" class="btn btn-primary">Actualizar</button>
  <a href="../../estudios.php?id=<?php echo $person->persona_id;?>" class="btn btn-danger">Cancelar</a>
</form>