<?php 
  session_start();
  ini_set('display_errors',0);
  include "../../php/conexion.php";

  $sql1= "select * from programa where id = ".$_GET["programa_id"];
  $query = $con->query($sql1);
  $person = null;

  if($query->num_rows>0){
  while ($r=$query->fetch_object()){
    $programa=$r;
    break;
    }
  }

  $sql4 = "SELECT * FROM tipo_cargo";
  $query4 = $con->query($sql4);

?>
<html>
	<head>
		<title>.: SIGEP :.</title>
		<link rel="stylesheet" type="text/css" href="../../bootstrap/css/bootstrap.min.css">
		<script src="../../js/jquery.min.js"></script>
	</head>
	<body>
	<?php include "../../php/navbar.php"; ?>
<div class="container">
<div class="row">
<div class="col-sm-1 col-sm-offset-11">
  <a href="../postgrados/programas.php?postgrado_id=<?php echo $programa->postgrado_id;?>" class="btn btn-danger">Ir atr&aacute;s</a>
  <!--a href="../../postgrados.php" class="btn btn-danger">Ir atr&aacute;s</a-->
</div>
<br><br>
<div class="col-md-12">
		<h4>DATOS DE CONTACTO DE <?php echo strtoupper($programa->nombre); ?></h4>

<!-- Button trigger modal -->
  <a data-toggle="modal" href="#myModalPersonal" class="btn btn-primary">Agregar Personal</a>
  <br>
   <!-- Modal -->
  <div class="modal fade" id="myModalPersonal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Agregar Personal</h4>
        </div>
        <div class="modal-body">
          <div class="row">
            <form role="form" method="post" action="agregar_personal.php">
              <div class="row">
                <div class="col-sm-11">
                  <div class="form-group col-sm-6">
                    <label for="nombre">Apellidos <span style='color: red'>*</span></label>
                    <input type="text" class="form-control" autofocus name="apellidos" required>
                  </div>
                  <div class="form-group col-sm-6">
                    <label for="nombre">Nombres <span style='color: red'>*</span></label>
                    <input type="text" class="form-control" name="nombres" required>
                  </div>
                </div>
              </div>
              <div class="col-sm-12">
                <div class="form-group">
                  <label for="email">Tipo de Cargo <span style='color: red'>*</span></label>
                  <select class="form-control" name="tipo_cargo_id" >
                    <?php 
                      while ($r=$query4->fetch_array()):
                        echo "<option value='".$r['id']."' >".$r['nombre']."</option>";
                      endwhile;
                    ?>
                  </select>
                </div>
                <div class="row col-sm-12">
                  <div class="form-group col-sm-6">
                    <label for="name">Fecha Inicio Cargo </label>
                    <input type="date" class="form-control" name="fecha_inicio_cargo" >
                  </div>
                  <div class="form-group col-sm-5">
                    <label for="name">Fecha Fin Cargo</label>
                    <input type="date" class="form-control" name="fecha_fin_cargo" >
                  </div>
                </div>
              </div>
              <div class="col-sm-11">
                <input type="hidden" name="programa_id" value="<?php echo $_GET["programa_id"]; ?>">
                <button type="submit" class="btn btn-primary">Agregar</button>
              </div>
            </form>
          </div>
        </div>

      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->

     <!-- Modal -->
  
<br>

<?php include "../programas/contactos_listar.php"; ?>
</div>
</div>
</div>

<script src="../../bootstrap/js/bootstrap.min.js"></script>

	</body>
</html>