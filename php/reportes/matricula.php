<?php 
  session_start();
  ini_set('display_errors',1);
  include "../funciones.php";
  if(isset($_SESSION['session']) && $_SESSION['session'] == 'true') { ?>
<html>
	<head>
		<title>.: SIGEP :.</title>
		<link rel="stylesheet" type="text/css" href="../../bootstrap/css/bootstrap.min.css">
		<script src="../../js/jquery.min.js"></script>
    <script src="../../js/utilidades.js"></script>
    <script type="text/javascript">
     
        $("#table_facultades").css("display" , "");
        $("#table_postgrados").css("display" , "none");
        $("#table_programas").css("display" , "none");
    </script>
	</head>
	<body>
	<?php include "../navbar.php"; ?>

<div class="container">
<div class="row">
<div class="col-md-12">
		<h3>REPORTES</h3>
<!-- Button trigger modal -->
  <!--a data-toggle="modal" href="#myModal" class="btn btn-default">Agregar</a-->
<br><br>
  <!-- Modal -->
  <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Agregar</h4>
        </div>
        <div class="modal-body">
            <?php include "php/personas/form.php";?>
        </div>

      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->


  <div class="container" style="padding: 10px 0px">
    <div class="row">
      <div class="row">
      <div class="col-sm-4 col-sm-offset-1">
        <a href="php/reportes/matricula.php">
          <div style="border: 1px solid #D4E0EF; background-color: #e3e3e3; border-radius: 4px; padding: 15px; text-align: center  ">
            <span style="top: 0px;" class="glyphicon glyphicon-user"></span>
            <br />
            MATRÍCULA
          </div>
        </a>
      </div>


      <div class="col-sm-4 col-sm-offset-1">
        <a href="php/reportes/reporte_posgrados.php">
          <div style="border: 1px solid #D4E0EF; background-color: #e3e3e3; border-radius: 4px; padding: 15px; text-align: center  ">
            <span style="top: 0px;" class="glyphicon glyphicon-user"></span>
            <br />
            ESTUDIANTES
          </div>
        </a>
      </div>
  </div>
</div>
<hr>
<div class="container">
  <div class="row">
    <div class="col-sm-5">
      <div class="col-sm-4" style="display: inline-block; ">Facultad</div>
      <div class="col-sm-7" style="display: inline-block; ">
        <form class="form-group">
          <select class="form-control" id="select_facultades" onchange="javascript:buscar_postgrados()">
            <option value="-1">Todas</option>
            <?php
            $elementos = consultar_facultades(); 
            foreach ($elementos as $valor) {
            ?>
              <option value="<?php echo $valor->id;?>"><?php echo $valor->nombre; ?></option>
            <?php } ?>
          </select>
        </form>
      </div>
    </div> 

    <div class="col-sm-5">
      <div class="col-sm-4" style="display: inline-block;">Postgrado</div>
      <div class="col-sm-7" style="display: inline-block;">
        <form class="form-group">
          <select class="form-control" id="select_postgrados" onchange="javascript:buscar_programas()">
            <option value="-1">Todos</option>
            <?php
            
            $elementos = consultar_postgrados(); 
            foreach ($elementos as $valor) {
            ?>
              <option value="<?php echo $valor->id; ?>"><?php echo $valor->nombre; ?></option>
            <?php } ?>
          </select>
        </form>
      </div>
    </div>

    <!--div class="col-sm-4">
      <div class="col-sm-4" style="display: inline-block; ">Programa</div>
      <div class="col-sm-7" style="display: inline-block; ">
        <form class="form-group">
          <select class="form-control" id="select_programas">
            <option value="-1">Todos</option>
              <?php
              $elementos = consultar_programas(); 
              foreach ($elementos as $valor) {
              ?>
                <option value="<?php echo $valor->id; ?>"><?php echo $valor->nombre; ?></option>
              <?php } ?>
          </select>
        </form>
      </div>
    </div-->
  </div>
  <hr>
  <hr>
  <div class="row" id="table_matricula">
    <table class="table table-bordered table-hover" id="table_facultades">
      <thead>
        <th>N.</th>
        <th>Nombre</th>
        <th style="text-align: center">Cantidad Programas</th>
        <th style="text-align: center">Cantidad Matricula Activa</th>
      </thead>
      <?php $elementos = consultar_facultades();
            $num = 0;
             ?>
      <tbody>
        <?php foreach ($elementos as $elemento) {
            $num++;
            ?>
          <tr>
            <td><?php echo $num; ?></td>
            <td><?php echo strtoupper($elemento->nombre); ?></td>
            <td style="text-align: center"><?php echo $cantidad = get_cantidad_programas($elemento->id,'facultades') ?></td>
            <td style="text-align: center"><?php echo $cantidad = get_cantidad_matricula($elemento->id,'facultades',1) ?></td>
          </tr>
        <?php
        }
        ?>

      </tbody>
    </table>

    <table class="table table-bordered table-hover" style="display: none" id="table_postgrados">
      <thead>
        <th>N.</th>
        <th>Nombre</th>
        <th style="text-align: center">Cantidad Programas</th>
        <th style="text-align: center">Cantidad Matricula</th>
      </thead>
      <?php $elementos = consultar_postgrados();
            $num = 0;
             ?>
      <tbody>
        <?php foreach ($elementos as $elemento) {
            $num++;
            ?>
          <tr class="postgrados facultad_<?php echo $elemento->facultad_nucleo_id; ?>" style="display: none">
            <td><?php echo $num; ?></td>
            <td><?php echo strtoupper($elemento->nombre); ?></td>
            <td style="text-align: center"><?php echo $cantidad = get_cantidad_programas($elemento->id,'postgrados') ?></td>
            <td style="text-align: center"><?php echo $cantidad = get_cantidad_matricula($elemento->id,'postgrados',1) ?></td>
          </tr>
        <?php
        }
        ?>

      </tbody>
    </table>

     <table class="table table-bordered table-hover" style="display: none" id="table_programas">
      <thead>
        <tr>
          <th rowspan="3">N.</th>
          <th rowspan="3">Nombre</th>
          <th colspan="5" style="text-align: center">Matricula</th>
        </tr>
        <tr>
          <th colspan="3" style="text-align: center">Cantidad de Expedientes</th>
          <th rowspan="2" style="vertical-align: middle;text-align: center;">Retirados</th>
          <th rowspan="2" style="vertical-align: middle;text-align: center;">Egresados</th>
        </tr>
        <tr>
          <th>Activos</th>
          <th>Inactivos</th>
          <th>Pasivos</th>
          
          <!--th>Desincorporados</th-->
          <!--th>Extension de Plazo</th-->
        </tr>
      </thead>
      <?php $elementos = consultar_programas();
            $num = 0;
             ?>
      <tbody>
        <?php foreach ($elementos as $elemento) {
            $num++;
            ?>
          <tr class="programas postgrado_<?php echo $elemento->postgrado_id; ?>" style="display: none">
            <td><?php echo $num; ?></td>
            <td><?php echo strtoupper($elemento->nombre); ?></td>
            <td style="text-align: center"><?php $cantidad = get_cantidad_matricula($elemento->id,'programas',1); if($cantidad > 0) echo "<a style='cursor: pointer' onclick='javascript:ver_matricula(".$elemento->id.",1)'>".$cantidad."</a>"; else echo $cantidad; ?></td>
            <td style="text-align: center"><?php $cantidad = get_cantidad_matricula($elemento->id,'programas',3); if($cantidad > 0) echo "<a style='cursor: pointer' onclick='javascript:ver_matricula(".$elemento->id.",3)'>".$cantidad."</a>"; else echo $cantidad; ?></td>
            <td style="text-align: center"><?php $cantidad = get_cantidad_matricula($elemento->id,'programas',106); if($cantidad > 0) echo "<a style='cursor: pointer' onclick='javascript:ver_matricula(".$elemento->id.",106)'>".$cantidad."</a>"; else echo $cantidad; ?></td>
            <td style="text-align: center"><?php $cantidad = get_cantidad_matricula($elemento->id,'programas',5); if($cantidad > 0) echo "<a style='cursor: pointer' onclick='javascript:ver_matricula(".$elemento->id.",5)'>".$cantidad."</a>"; else echo $cantidad; ?></td>
            <td style="text-align: center"><?php $cantidad = get_cantidad_matricula($elemento->id,'programas',2); if($cantidad > 0) echo "<a style='cursor: pointer' onclick='javascript:ver_matricula(".$elemento->id.",2)'>".$cantidad."</a>"; else echo $cantidad; ?></td>
            <!--td style="text-align: center"><?php $cantidad = get_cantidad_matricula($elemento->id,'programas',6); if($cantidad > 0) echo "<a style='cursor: pointer' onclick='javascript:ver_matricula(".$elemento->id.",6)'>".$cantidad."</a>"; else echo $cantidad; ?></td-->
           
            <!--td style="text-align: center"><?php $cantidad = get_prorrogas($elemento->id,'cantidad'); if($cantidad > 0) echo "<a style='cursor: pointer' onclick='javascript:ver_matricula(".$elemento->id.",999)'>".$cantidad."</a>"; else echo $cantidad; ?></td-->
          </tr>
        <?php
        }
        ?>
      </tbody>
    </table>

  </div>
</div>

</div>
</div>

<script src="../../bootstrap/js/bootstrap.min.js"></script>
	</body>
</html>
<?php } 
  else 
    print "<script>alert('Debe iniciar sesion.'); window.location='index.php';</script>";
?>