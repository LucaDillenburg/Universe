<?php session_start();
if(!isset($_GET['outroUsuario'])|| !isSet($_GET['seguir']))
	echo "<script>window.location = window.history.back();</script>";
else
if(!isSet($_SESSION['usuario']))
	header("Location:../index.php");
else{
	include("../classes/usuario.php");
	$usuario = new Usuario();
	$seguir = $_GET['seguir']=='true';

	if($seguir)
		$usuario->seguirUsuario($_SESSION['usuario'],$_GET['outroUsuario']);
	else
		$usuario->desseguirUsuario($_SESSION['usuario'],$_GET['outroUsuario']);

	echo "<script>window.location = window.history.back();</script>";
}
?>