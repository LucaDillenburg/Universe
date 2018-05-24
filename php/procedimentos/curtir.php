<?php session_start();
if(!isSet($_GET['codPerg']) || !isSet($_GET['nomeUsuario']) || !isSet($_GET['curtir']))
	header("Location:../index.php");
else
if(!isSet($_SESSION['usuario']))
	$_SESSION['usuario'] = "";

	$codPerg = $_GET['codPerg'];
	$nomeUsuario = $_GET['nomeUsuario'];
	$curtir = $_GET['curtir']; 

	include("../classes/pergunta.php");
	$pergunta = new Pergunta();

	if($curtir)
		$pergunta->curtir($codPerg, $nomeUsuario);
	else
		$pergunta->descurtir($codPerg, $nomeUsuario);

	echo "<script>window.location = window.history.back();</script>";
?>