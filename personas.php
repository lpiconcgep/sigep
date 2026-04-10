<?php 
session_start();
  if(isset($_SESSION['session']) && $_SESSION['session'] == 'true') { ?>
<html>
	<head>
		<title>.: SIGEP :.</title>
        <<link rel="stylesheet" type="text/css" href="css/styles_tables.css">
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="libs/DataTables/datatables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>  
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
	</head>
	<body>
	<?php include "php/navbar.php"; ?>
<div class="container">
<div class="row">
<div class="col-md-12">
		<h2>VER PERSONAS</h2>
<!-- Button trigger modal -->
  <a data-toggle="modal" href="#myModal" class="btn btn-default">Agregar</a>
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
            <?php
            $source = "personas";
            include "php/personas/form.php";?>
        </div>

      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->


<?php include "php/personas/listar.php"; ?>
</div>
</div>
</div>

<script src="bootstrap/js/bootstrap.min.js"></script>
<script>
    $(document).ready(function() {
        $('#table_personas').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json'
                }
            });
    });
</script>
	</body>
</html>

<?php }
else 
  print "<script>window.location='index.php';</script>";
?>