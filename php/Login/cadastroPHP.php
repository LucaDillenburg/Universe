<?php session_start(); 
	if(!(isSet($_POST['usuario']) && isSet($_POST['senha1']) && isSet($_POST['senha2'])))
		header("Location:cadastro.php");
	else
	{
		include_once("../classes/usuario.php");
		$usuario = new Usuario();

		$nomeUsuario  = htmlspecialchars($_POST['usuario']);
		$email        = htmlspecialchars($_POST['email']);
		$primeiroNome = htmlspecialchars($_POST['primeiroNome']);
		$sobrenome    = htmlspecialchars($_POST['sobrenome']);
		$senha1       = htmlspecialchars($_POST['senha1']);
		$senha2       = htmlspecialchars($_POST['senha2']);

		$_SESSION['nomeUsuarioExistente']  = $nomeUsuario;
		$_SESSION['emailExistente']        = $email;
		$_SESSION['primeiroNomeExistente'] = $primeiroNome;
		$_SESSION['sobrenomeExistente']    = $sobrenome;
		$_SESSION['senha1Existente']       = $senha1;
		$_SESSION['senha2Existente']       = $senha2;

		if($usuario->usuarioValido($nomeUsuario)==false)
			header('Location:cadastro.php?usuario=NOK');
		// dar as opções de nomes parecidos com numeros ou pontos que ainda não existem
		else
		{
			// verificar: senha (validar senha)

			if($senha1!=$senha2)
				header('Location:cadastro.php?senha=NOK');
			else
			{
				if(!$usuario->senhaForte($senha1))
					header("Location:cadastro.php?senhaFraca=S");
				else
				{
					$status = $usuario->cadastrar($nomeUsuario, $primeiroNome, $sobrenome, $email, $senha1); 
				
					if($status==false)
						header("Location:cadastro.php?deuRuim=OK");
					else
					{
						$usuario->logar($nomeUsuario);
						header("Location:../index.php");
					}	
				}
			}			
		}
	}
?>

<!-- 
function usuarioValido($usuario)
{
	$sql = "SELECT * from usuario where nomeUsuario='$usuario'";
	$status = sqlsrv_query($conexao, $sql);

	if($dados = sqlsrv_fetch_array($status))
		return false;
	else
		return true;
}

function emailValido($email)
{
	if($email=="")
		return true;

	for($i=0; $i<$email.length; $i++)
		try
		{
			if($email[$i]=="@") 
			{
				for($cont=$i;; $cont++)
					if(($email[$i]==".") && ($email[$i+1]=="c") && ($email[$i+2]=="o") && ($email[$i+3]=="m")) 
						return true;
			}	
		}catch(Exception $e)
		{}	

	return false;
}  -->