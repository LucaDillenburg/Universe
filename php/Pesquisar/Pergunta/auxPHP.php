<?php session_start(); 
	if(!isSet($_SESSION['usuario']))
		$_SESSION['usuario']="";

	$_SESSION['pesquisaExistentePerg'] = htmlspecialchars($_POST['pesquisa']);
	$_SESSION['rgQualExistentePerg']   = $_POST['rgQual'];
	$_SESSION['rgMatExistentePerg']    = $_POST['rgMateria'];

	header("Location:index.php");	
?>