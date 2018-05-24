<?php session_start(); 
if(!isSet($_SESSION['usuario']) || !isSet($_GET['codResp']))
	header("Location:../index.php");
else
{
	// apagar uma resposta
	$codPergunta   = $_SESSION['codPergunta'];
	unset($_SESSION['codPergunta']);

	include_once("../classes/resposta.php");
	$resposta = new Resposta();

	$codResp = $_GET['codResp'];
	$resposta->apagar($codResp);

	echo "<script>window.location = window.history.back();</script>";
}
?>