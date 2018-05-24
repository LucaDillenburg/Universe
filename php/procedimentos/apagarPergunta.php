<?php session_start(); 
if(!isSet($_SESSION['usuario']) || !isSet($_GET['codPergunta']))
	header("Location:../index.php");
else
{
	include_once("../classes/pergunta.php");
	$pergunta = new Pergunta();

	$codPergunta = $_GET['codPergunta'];
	$pergunta->apagar($codPergunta);

	echo "<script>window.location = window.history.back();</script>"; 
}