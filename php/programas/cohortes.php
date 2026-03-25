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
		<h4>VER COHORTES DE <?php echo strtoupper($programa->nombre); ?></h4>

<!-- Button trigger modal -->
  <a data-toggle="modal" href="#myModal" class="btn btn-primary">Agregar Cohorte</a>
  <br>
   <!-- Modal -->
  <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Agregar Cohorte</h4>
        </div>
        <div class="modal-body">
            <?php include "cohorte_form.php";?>
        </div>

      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->

     <!-- Modal -->
  
<br>

<?php include "../programas/cohortes_listar.php"; ?>
</div>
</div>
</div>

<script src="../../bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript">
  $(".btn_add_periodo").click(alert('hola'););
</script>
	</body>
</html>