<?php session_start();
//if(!isset($_GET['codMateria'])|| !isSet($_GET['seguir']))
	//echo "<script>window.location = window.history.back();</script>";
//else
if(!isSet($_SESSION['usuario']) || $_SESSION['usuario']=="")
{
	$_SESSION['usuario']="";
	header("Location:index.php");
}
else{
	include("../classes/usuario.php");
	$usuario = new Usuario();
	$status = false;

	$seguir = $_GET['seguir']=='true';

	if(!$seguir)
		$status = $usuario->desseguirMateria($_SESSION['usuario'], $_GET['codMateria']);
	else
		$status = $usuario->seguirMateria($_SESSION['usuario'], $_GET['codMateria']);

	echo "<script>window.location = window.history.back();</script>";
}
?>

