<?php session_start();
if($_SESSION['usuario']!="HOMAO")
	header("Location:../index.php?PARA_DE_SER_OTÁRIO=true");
else
{
	if(isSet($_GET['usuario']))
	{
		include("../classes/usuario.php");
		$usuario = new Usuario();

		$usuario->banir($_GET['usuario']);
	}else
		if(isSet($_GET['materia']))
		{
			include("../classes/materia.php");
			$materia = new Materia();

			$materia->banir($_GET['materia']);
		}else
			if(isSet($_GET['pergunta']))
			{
				include("../classes/pergunta.php");
				$pergunta = new Pergunta();

				$pergunta->banir($_GET['pergunta']);
			}else
				if(isSet($_GET['resposta']))
				{
					include("../classes/resposta.php");
					$resposta = new Resposta();

					$resposta->banir($_GET['resposta']);
				}

	echo "<script>window.location = window.history.back();</script>";
}
?>