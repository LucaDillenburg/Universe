<?php session_start(); 
	if(!(isSet($_POST['usuario']) && isSet($_POST['senha'])))
		header("Location:cadastro.php");
	else
	{
		include_once("../classes/usuario.php");
		$usuario = new Usuario();

		$nomeUsuario = htmlspecialchars(strtoupper($_POST['usuario']));
		$senha       = htmlspecialchars($_POST['senha']);

		$_SESSION['nomeUsuarioExistente'] = htmlspecialchars($_POST['usuario']);
		$_SESSION['senhaExistente']       = $senha;

		if(!$usuario->usuarioExiste($nomeUsuario))
			header("Location:login.php?usuariologin=NOK");
		else
		{
			if(!$usuario->senhaCorreta($senha, $nomeUsuario))
				header("Location:login.php?senhalogin=NOK");
			else
			{
				$usuario->logar($nomeUsuario);
				header("Location:../index.php");
			}
		}	
	}
?>