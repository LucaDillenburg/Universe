<?php session_start(); 
	if(!isSet($_SESSION['usuario']) || !isSet($_GET['site']))
		header("Location:../index.php");
	{
		$site = $_GET['site'];
		$novaMateria = $_GET['novaMateria'];
		include("../classes/materia.php");
		$materia = new Materia();

		if($materia->jahExiste($novaMateria))
			header("Location:../$site?matJahExiste=OK");
		else
		{
			if(!$materia->adicionarMateria($novaMateria))
				header("Location:../$site?novaMateria=NOK");
			else
				header("Location:../$site?novaMateria=OK");
		}
	}
?>