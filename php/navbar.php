<?php
//session_start();
 ini_set('display_errors',0); ?>
<nav class="navbar navbar-default" role="navigation">
<div class="container">
  <!-- Brand and toggle get grouped for better mobile display -->
  <div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
      <span class="sr-only">Toggle navigation</span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </button>
    <a class="navbar-brand" href="/sigep_prototipo/inicio.php"><b>SIGEP</b></a>
  </div>

  <!-- Collect the nav links, forms, and other content for toggling -->
  <div class="collapse navbar-collapse navbar-ex1-collapse">
    <ul class="nav navbar-nav">
      <li><a href="/sigep_prototipo/personas.php">PERSONAS</a></li>
      <li><a href="/sigep_prototipo/postgrados.php">POSTGRADOS</a></li>
      <li><a href="/sigep_prototipo/index.php">REGISTRO NUEVO INGRESO</a></li>
      <li><a href="/sigep_prototipo/reportes.php">REPORTES</a></li>
    </ul>
    <form class="navbar-form navbar-left" role="search" action="./buscar.php">
      <div class="form-group">
        <input type="text" name="s" class="form-control" placeholder="Buscar">
      </div>
      <button type="submit" class="btn btn-default">&nbsp;<i class="glyphicon glyphicon-search"></i>&nbsp;</button>
    </form>
    <div class="pull-right name-user" style="margin-top: 15px;"><i class="glyphicon glyphicon-user"></i> <?php echo $_SESSION['name']; ?> | <a href="/sigep_prototipo/php/logout.php" onclick="return confirm('Est&aacute; seguro que desea cerrar sesi&oacute;n?');">Cerrar Sesi&oacute;n <i class="glyphicon glyphicon-log-out"></i></a>
    </div>
  </div><!-- /.navbar-collapse -->
</div>
</nav>