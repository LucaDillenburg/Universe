<?php session_start(); 
	if(!isSet($_SESSION['usuario']))
		header("Location:../index.php");
	else
	{
		if($_POST['submit']=='Perguntar')
		{
			include_once("../classes/pergunta.php");
			$pergunta = new Pergunta();

			$nomeUsuario        = $_SESSION['usuario'];
			$assunto            = htmlspecialchars($_POST['assunto']);
			$explicacao         = htmlspecialchars($_POST['explicacao']);
			$codMateria         = htmlspecialchars($_POST['rgMateria']);
			$data               = date('d-m-y H:i:s');
			$receberEmailSempre = htmlspecialchars($_POST['rgEmail']);

			/*echo "Usuario: $nomeUsuario <br>";
			echo "Assunto: $assunto <br>";
			echo "Explicação: $explicacao <br>";
			echo "CodMatéria: $codMateria <br>";
			echo "Data: $data <br>";
			echo "CodReceberEmail: $receberEmailSempre <br>";*/

			if($assunto=='' || $explicacao=='' || $codMateria=='' || !isSet($codMateria))
			{
				header('Location:index.php?pergunta=NOK');
			}else
			{		
				$status = $pergunta->adicionarPergunta($nomeUsuario, $assunto, $explicacao, $codMateria, $data, $receberEmailSempre);

				if($status==false)
					header('Location:index.php?deuRuim=OK');
				else
					header('Location:index.php?pergunta=OK');
			}
		}else
		{
			// adiciona conteudos existentes no formulário no array session
			if(isSet($_POST['assunto']))
				$_SESSION['assuntoExistente']    = htmlspecialchars($_POST['assunto']);
			if(isSet($_POST['explicacao']))
				$_SESSION['explicacaoExistente'] = htmlspecialchars($_POST['explicacao']);
			if(isSet($_POST['rgMateria']))
				$_SESSION['rgMatExistente']      = htmlspecialchars($_POST['rgMateria']);
			if(isSet($_POST['rgEmail']))
				$_SESSION['rgEmailExistente']    = htmlspecialchars($_POST['rgEmail']);

			$novaMat = htmlspecialchars($_POST['novaMateria']);
			header("Location:../procedimentos/adicionarMateria.php?site=Perguntar/index.php&novaMateria=$novaMat");
		}
	}
?>