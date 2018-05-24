<?php session_start(); 
if(!isSet($_POST['pesquisa']) || !isSet($_SESSION['usuario']))
	header("Location:index.php");
else
{
	$_SESSION['pesquisaExistenteUs'] = htmlspecialchars($_POST['pesquisa']);
	header('Location:index.php');
}
?>