<?php
include "../conexion.php";

$user_id=null;
$sql1= "select * from persona where id = ".$_GET["id"];
$query = $con->query($sql1);
$person = null;

$sql2= "select * from pais";
$query2 = $con->query($sql2);

$sql3= "select * from etnia";
$query3 = $con->query($sql3);

if($query->num_rows>0){
while ($r=$query->fetch_object()){
  $person=$r;
  break;
}

  }
?>

<?php if($person!=null):?>
  <form role="form" method="post" action="actualizar.php">

    <div class="form-group col-sm-12">
      <label for="name">Tipo Documento Identidad <span style='color: red'>*</span></label>
      <select class="form-control" name="tipo_documento_identidad">
        <?php 
          $sel['0'] = '';
          $sel['1'] = '';
          $sel['2'] = '';
          if( $person->tipo_documento_identidad == 0 )
            $sel['0'] = 'selected = selected';
          else if($person->tipo_documento_identidad == 1)
            $sel['1'] = 'selected = selected';
          else
            $sel['2'] = 'selected = selected';
        ?>
        <option <?php echo $sel['0']; ?> value="0">Cedula Venezolana</option>
        <option <?php echo $sel['1']; ?> value="1">Cedula Venezolana Extranjero</option>
        <option <?php echo $sel['2']; ?> value="2">Cedula del Pais origen</option>
      </select>
    </div>

    <div class="form-group col-sm-6">
      <label for="name">N. Documento Identidad <span style='color: red'>*</span></label>
      <input type="text" class="form-control" name="documento_identidad" value="<?php echo $person->documento_identidad; ?>" required>
    </div>
    <div class="form-group col-sm-6">
      <label for="name">Fecha Vencimiento Doc. Identidad </label>
      <input type="date" class="form-control" value="<?php echo $person->fecha_vencimiento_doc_identidad; ?>"  name="fecha_vencimiento_doc_identidad">
    </div>
    <div class="form-group col-sm-6">
      <label for="lastname">Primer Apellido <span style='color: red'>*</span></label>
      <input type="text" class="form-control" name="primer_apellido" value="<?php echo strtoupper($person->primer_apellido); ?>" required>
    </div>
    <div class="form-group col-sm-6">
      <label for="lastname">Segundo Apellido</label>
      <input type="text" class="form-control" name="segundo_apellido" value="<?php echo strtoupper($person->segundo_apellido); ?>">
    </div>
    <div class="form-group col-sm-6">
      <label for="name">Primer Nombre <span style='color: red'>*</span></label>
      <input type="text" class="form-control" name="primer_nombre" value="<?php echo strtoupper($person->primer_nombre); ?>" required>
    </div>
    <div class="form-group col-sm-6 ">
      <label for="name">Segundo Nombre</label>
      <input type="text" class="form-control" name="segundo_nombre"  value="<?php echo strtoupper($person->segundo_nombre); ?>"  >
    </div>
    <div class="form-group col-sm-6">
      <label for="lastname">Sexo <span style='color: red'>*</span></label>
      <select class="form-control" name="sexo" required value="<?php echo $person->sexo; ?>">
        <?php 
          $sel['0'] = '';
          $sel['1'] = '';
          if( $person->sexo == 'F' )
            $sel['0'] = 'selected = selected';
          else if($person->sexo == 'M')
            $sel['1'] = 'selected = selected';
        ?>

        <option <?php echo $sel['0']; ?> value="F">Femenino</option>
        <option <?php echo $sel['1']; ?> value="M">Masculino</option>
      </select>
    </div>
    <div class="form-group col-sm-6">
      <label for="phone">Estado Civil</label>
      <select class="form-control" name="estado_civil" value="<?php echo $person->estado_civil; ?>">
        <?php 
          $sel['0'] = '';
          $sel['1'] = '';
          $sel['2'] = '';
          $sel['3'] = '';
          $sel['4'] = '';

          if( $person->estado_civil == 'S' )
            $sel['0'] = 'selected = selected';
          else if($person->estado_civil == 'C')
            $sel['1'] = 'selected = selected';
          else if($person->estado_civil == 'D')
            $sel['2'] = 'selected = selected';
          else if($person->estado_civil == 'V')
            $sel['3'] = 'selected = selected';
          else if($person->estado_civil == 'O')
            $sel['4'] = 'selected = selected';
        ?>

        <option <?php echo $sel['0']; ?> value="S">Soltero</option>
        <option <?php echo $sel['1']; ?> value="C">Casado</option>
        <option <?php echo $sel['2']; ?> value="D">Divorciado</option>
        <option <?php echo $sel['3']; ?> value="V">Viudo</option>
        <option <?php echo $sel['4']; ?> value="O">Union Libre o Concubinato</option>
      </select>
    </div>
    <div class="form-group col-sm-6">
      <label for="name">Fecha Nacimiento</label>
      <input type="date" class="form-control" name="fecha_nacimiento" value="<?php echo $person->fecha_nacimiento; ?>">
    </div>
    <div class="form-group col-sm-6">
      <label for="name">Pasaporte N.</label>
      <input type="text" class="form-control" name="pasaporte" value="<?php echo $person->pasaporte; ?>" >
    </div>
    <div class="form-group col-sm-6">
      <label for="address">Nacionalidad <span style='color: red'>*</span></label>
       <select class="form-control" name="nacionalidad" value="<?php echo $person->nacionalidad; ?>" required>
        <?php
          $selected_v = '';
          $selected_e = '';
          if($person->nacionalidad == 'V')
          {
            $selected_v = 'selected="selected"';
            $selected_e = '';
          }
          else
          {
            $selected_v = '';
            $selected_e = 'selected="selected"';
          }
        ?>
        <option value="V" <?php echo $selected_v ?> >Venezolano</option>
        <option value="E" <?php echo $selected_e ?> >Extranjero</option>
      </select>
    </div>

    <div class="form-group col-sm-6">
      <label for="email">Pais de Nacimiento <span style='color: red'>*</span></label>
      <?php if($query2->num_rows>0):?>
      <select class="form-control" name="pais_origen_id" value="<?php echo $person->pais_origen_id; ?>" required>
        <?php 
          while ($r=$query2->fetch_array()):
            $selected = '';
            if($r['id'] == $person->pais_origen_id)
              $selected = 'selected="selected"';
            echo "<option ".$selected." value='".$r['id']."' >".$r['nombre']."</option>";
          endwhile;
        ?>
      </select>
      <?php else:?>
        <input type="text" class="form-control" name="pais_origen_id" value="<?php echo $person->pais_origen_id; ?>" >
      <?php endif;?>
    </div>
    
    <div class="form-group col-sm-6">
      <label for="phone">Etnia <span style='color: red'>*</span></label>
       <?php if($query3->num_rows>0):?>
      <select class="form-control" name="etnia_id" value="<?php echo $person->etnia_id; ?>" required>
        <?php 

          while ($r=$query3->fetch_array()):
            $selected = '';
            if($r['id'] == $person->etnia_id)
              $selected = 'selected="selected"';
            echo "<option ".$selected." value='".$r['id']."' >".$r['nombre']."</option>";
          endwhile;
        ?>
      </select>
      <?php else:?>
        <input type="text" class="form-control" value="<?php echo $person->etnia_id; ?>" name="etnia_id" >
      <?php endif;?>
    </div>
    <div class="form-group col-sm-6">
      <label for="phone">Ciudad de Residencia</label>
      <input type="text" class="form-control" value="<?php echo $person->ciudad_id; ?>" name="ciudad_id" >
    </div>
    <?php 
      if($person->regimen == true)
      {
        $regimen_si = 'checked="checked"';
        $regimen_no = '';
      }
      else
      {
        $regimen_si = '';
        $regimen_no = 'checked="checked"';
      }

      if($person->discapacidad == true)
      {
        $disc_si = 'checked="checked"';
        $disc_no = '';
      }
      else
      {
        $disc_si = '';
        $disc_no = 'checked="checked"';
      }
        
    ?>
    <div class="form-group col-sm-6">
      <label for="name">Regimen Penitenciario</label>
      <div class="radio">
        <label><input type="radio" <?php echo $regimen_si; ?> value="1" name="regimen">Si</label>
      </div>
      <div class="radio">
        <label><input type="radio" <?php echo $regimen_no; ?> value="0" name="regimen">No</label>
      </div>
    </div>
    <div class="form-group col-sm-6">
      <label for="name">Posee Discapacidad</label>
      <div class="radio">
        <label><input type="radio" <?php echo $disc_si; ?>  value="1" name="discapacidad">Si</label>
      </div>
      <div class="radio">
        <label><input type="radio"  <?php echo $disc_no; ?> value="0" name="discapacidad">No</label>
      </div>
    </div>

    <input type="hidden" name="id" value="<?php echo $person->id; ?>">
    

    <?php

      if(isset($_GET['origen']))
      {
        if($_GET['origen'] == 'matricula')
        { ?>
          <input type="hidden" name="link" value="<?php echo $_GET['origen']; ?>">
          <input type="hidden" name="programa_id" value="<?php echo $_GET['programa_id']; ?>">
        <?php
        }
        else
        {
          $link = 'personas';
          ?>
          <input type="hidden" name="link" value="<?php echo $link; ?>">
          <?php
        }
      }

    ?>
   
    <button type="submit" class="btn btn-primary">Actualizar</button>
    <?php  
      if(isset($_GET['origen']))
      {
        if($_GET['origen'] == 'matricula')
        { ?>
          <a href="../../matricula.php?programa_id=<?php echo $_GET['programa_id'];?>" class="btn btn-danger">Cancelar</a>
  <?php } 
      }?>
    <br><br><br>
  </form>
<?php else:?>
  <p class="alert alert-danger">404 No se encuentra</p>
<?php endif;?>