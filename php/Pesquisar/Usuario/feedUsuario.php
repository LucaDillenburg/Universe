<?php session_start(); 
if(!isSet($_GET['nomeUsuario'])) 
	header("Location:index.php");
else
	if(!isSet($_SESSION['usuario']))
		$_SESSION['usuario']=""; 
	
	$usuarioAtual = $_SESSION['usuario'];
?>
<!DOCTYPE html>
<html>
<head>
	<title> Perfil </title>
	<link rel="stylesheet" type="text/css" href="../../../estilo/responder.css">
	<link rel="stylesheet" type="text/css" href="../../../estilo/menuVertical.css">
	<link rel="shortcut icon" href="../../../imagens/logo.png">
	<link rel="stylesheet" type="text/css" href="../../classes/visual.css">
</head>
<body>
	<div class="divDoForm">
<?php
	include_once("../../classes/usuario.php");
	$usuario = new Usuario();

	echo "<form action='../Resposta/index.php' method='POST'>";

	$nomeUsuario = $_GET['nomeUsuario']; //passa como parâmetro
	$_SESSION['nomeUsuario'] = $nomeUsuario;
	
	$nomeCompleto = $usuario->nomeCompleto($nomeUsuario);
	echo "<br><h1 id='titulo' style='font-size: 60px'>$nomeUsuario <label style='font-size: 35px'>- $nomeCompleto</label> </h1> <hr><br>";
?>

<div class="menu">
	<div id='cssvmenu'>
	<ul>
	<li id="main" class='active has-sub'><a class="first"><span>Pesquisar</span></a>
      <ul>
         <li id = "sub" class='last'><a href='../Pergunta/index.php'><span>Perguntas</span></a>
         </li>
         <li id = "sub" class='last'><a href='../Materia/index.php'><span>Matérias</span></a>
         </li>
         <li id = "sub" class='last'><a href='index.php'><span>Usuários</span></a>
         </li>
      </ul>
   </li>
   <?php
	if($_SESSION['usuario']!="")
	{
		echo "<li id ='main' class='last'><a href='../Usuario/feedUsuario.php?nomeUsuario=$nomeUsuario'><span>Minha Página</span></a></li>";
		
		echo "<li id = 'main' class='last'><a href='../../Feed/index.php'><span>Feed</span></a></li>";

		echo "<li id = 'main' class='last'><a href='../../perguntar/index.php'><span>Nova Pergunta</span></a></li>";
  	 	//echo "<div id='cssvmenu'><ul>";
		echo "<li id='main' class='last'><a href='../../login/login.php'><span>SAIR</span></a></li>"; 

		echo "</ul><br><br>";
	}else
	{?>
   	</div></ul><br><br>
   	<div id='cssvmenu'><ul>
   	<li id="main" class='last'><a class="first" href='../../login/login.php'><span>Login</span></a></li>
	<?php
	}
	echo "</ul></div></div>";


	if($_SESSION['usuario']!=$nomeUsuario && $_SESSION['usuario']!="")
	{
		if(!($usuario->segueUsuario($_SESSION['usuario'],$nomeUsuario)))
			echo "<a class = 'follow' href='../../procedimentos/seguirUsuario.php?outroUsuario=$nomeUsuario&seguir=true'>Follow</a><br>";
		else
			echo "<a class= 'unfollow' href='../../procedimentos/seguirUsuario.php?outroUsuario=$nomeUsuario&seguir=false'>Unfollow</a><br>";
	}

	if(!isSet($_GET['Respostas']))
	{

		echo "</br><a class='verRespostas' href='feedUsuario.php?Respostas=true&nomeUsuario=$nomeUsuario'>VER RESPOSTAS</a><br>";

		include_once('../../classes/pergunta.php');
		$pergunta = new Pergunta;
		$cods = $pergunta->selCods(0, false, '', $nomeUsuario);

		if($cods==false)
			echo "<br><label id = 'erro'>NÃO HÁ NENHUMA PERGUNTA!!</label>";
		else
		{
			include_once("../../classes/visual.php");
			$visual = new Visual();

			echo "<br>";
			foreach($cods as $i => $cod)
			{
				if($i==2)
					echo "<hr>";

				$vetor = $pergunta->selPergPorCod($cod);

				$codMateria = $vetor['codMateria'];
				$assunto    = $vetor['assunto'];
				$data       = $vetor['data']->format('d F Y H\h');
				$materia    = $pergunta->materia($cod);
				$explicacao = $vetor['explicacao'];

				$site = "Pesquisar/Usuario/feedUsuario.php?nomeUsuario=$nomeUsuario";
				$siteHome = "../../";

				$nCurtidas = $pergunta->curtidas($cod);
				$curtiu    = $pergunta->usuarioCurtiu($cod, $_SESSION['usuario']);

				$visual->tabelaPergTudo($assunto, $explicacao, $codMateria, $materia, $data, $cod, $nomeUsuario, $site, $siteHome, $i<2, $nCurtidas, $curtiu, false, false);
			}
		}
	}else
	{
		echo "<br><a class='verRespostas' href='feedUsuario.php?nomeUsuario=$nomeUsuario'>VER PERGUNTAS</a><br>";

		include_once('../../classes/pergunta.php');
		$pergunta = new Pergunta;

		$todasPerg = $pergunta->selPergRespUsuario($nomeUsuario);

		if($todasPerg==false)
			echo "<br><label id='erro'>NÃO HÁ NENHUMA RESPOSTA!!</label>";
		else
		{
			include_once('../../classes/resposta.php');
			$resposta = new Resposta();

			include_once("../../classes/visual.php");
			$visual = new Visual();

			foreach ($todasPerg as $codeData) 
			{
				$cod  = $codeData['codPergunta'];
				$data = $codeData['data']->format('d F Y H\h');

				$vetor = $pergunta->selPergPorCod($cod); 

				$materia  = $pergunta->materia($cod);
				$site     = "Pesquisar/Usuario/feedUsuario.php?nomeUsuario=$nomeUsuario";
				$siteHome = "../../";

				$curtidas = $pergunta->curtidas($cod);
				$curtiu   = $pergunta->usuarioCurtiu($cod, $vetor['nomeUsuario']);
				
				$visual->tabelaPergTudo($vetor['assunto'], $vetor['explicacao'], $vetor['codMateria'], $materia, $data, $cod, $vetor['nomeUsuario'], $site, $siteHome, false, $curtidas, $curtiu, false, true);

				$resps = $resposta->selRespPorUsuario($cod, $nomeUsuario);

				foreach ($resps as $resp)
				{
					$data = $resp['dataResposta']->format('d F Y H\h');
					$site = "Pesquisar/Usuario/feedUsuario.php?nomeUsuario=$nomeUsuario";
					$siteHome = "../../";

					$visual->tabelaRespTudo($resp['codResposta'], $resp['resposta'], $data, $nomeUsuario, $vetor['codMateria'], $materia, $vetor['nomeUsuario'], $site, $siteHome);
				}
			}
		}
	}
?>
</form>
</div>
</body>
</html>