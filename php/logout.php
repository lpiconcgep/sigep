<?php
	session_start();
	//session_unset($_SESSION['session']);
	session_unset();
	session_destroy();
	print "<script>window.location='../index.php';</script>";
?>