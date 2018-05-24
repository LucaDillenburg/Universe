<?php session_start(); 
if(!isSet($_POST['pesquisa']))
	header("Location:index.php");
else
{
	if($_POST['submit']=='Pesquisar')
	{
		if(isSet($_POST['pesquisa']))
			$_SESSION['pesquisaExistenteMat'] = htmlspecialchars($_POST['pesquisa']);
		$_SESSION['pesquisar'] = true;
		header("Location:index.php");
	}else
	{
		if(isSet($_POST['pesquisa']) && $_POST['pesquisa']!="")
			$_SESSION['pesquisaExistenteMat'] = htmlspecialchars($_POST['pesquisa']);
		$_SESSION['pesquisar'] = false;
		$novaMateria = htmlspecialchars($_POST['novaMateria']);
		header("Location:../../procedimentos/adicionarMateria.php?site=Pesquisar/Materia/index.php&novaMateria=$novaMateria");
	}
}