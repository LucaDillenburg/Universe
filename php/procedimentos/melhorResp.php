<?php session_start();
if(!isSet($_GET['codResp']))
	header("Location:../index.php");
else
if(!isSet($_SESSION['usuario']))
{
	$_SESSION['usuario'] = "";

	$codResp = $_GET['codResp'];

	include("../classes/resposta.php");
	$resposta = new Resposta();

	$resposta->ehMelhorResp($codResp);

	echo "<script>window.location = window.history.back();</script>";
}
?>