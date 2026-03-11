<?php 
session_start();
  if(isset($_SESSION['session']) && $_SESSION['session'] == 'true') { ?>
<html>
  <head>
    <title>.: SIGEP :.</title>
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
    <script src="js/jquery.min.js"></script>
  </head>
  <body>
  <?php include "php/navbar.php"; ?>
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
        <a href="php/reportes/estudiantes.php">
          <div style="border: 1px solid #D4E0EF; background-color: #e3e3e3; border-radius: 4px; padding: 15px; text-align: center  ">
            <span style="top: 0px;" class="glyphicon glyphicon-user"></span>
            <br />
            ESTUDIANTES
          </div>
        </a>
      </div>


      <!--div class="col-sm-2 col-sm-offset-1">
        <a href="php/reportes/estadisticas.php">
          <div style="border: 1px solid #E6E6E9; background-color: #e3e3e3; border-radius: 4px; padding: 15px; text-align: center ">
            <span style="top: 0px;" class="glyphicon glyphicon-signal"></span>
            <br />
            ESTADISTICAS
          </div>
        </a>

      </div-->

  </div>
</div>

</div>
</div>

<script src="bootstrap/js/bootstrap.min.js"></script>

  </body>
</html>
<?php } 
  else 
    print "<script>alert('Debe iniciar sesion.'); window.location='index.php';</script>";
?>