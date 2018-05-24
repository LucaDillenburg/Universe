<?php session_start(); 
if(!isSet($_SESSION['usuario']))
	header("Location:../index.php");
else
{
	$nomeUsuario = $_SESSION['usuario'];
?>
<html>
<head></head>
	<link rel="shortcut icon" href="../../imagens/logo.png">
	<link rel="stylesheet" type="text/css" href="../../estilo/responder.css">
	<link rel="stylesheet" type="text/css" href="../classes/visual.css">
	<link rel="stylesheet" type="text/css" href="../../estilo/menuVertical.css">
<body>

		<div class='divDoForm'>
		<h2 id="titulo">FEED</h2>
		<hr>
		<br><br>

		<div class="menu">
	<div id='cssvmenu'>
	<ul>
	<li id="main" class='active has-sub'><a class="first"><span>Pesquisar</span></a>
      <ul>
         <li id = "sub" class='last'><a href='../Pesquisar/Pergunta/index.php'><span>Perguntas</span></a>
         </li>
         <li id = "sub" class='last'><a href='../Pesquisar/Materia/index.php'><span>Matérias</span></a>
         </li>
         <li id = "sub" class='last'><a href='../Pesquisar/Usuario/index.php'><span>Usuários</span></a>
         </li>
      </ul>
   </li>
   <?php
	if($_SESSION['usuario']!="")
	{
		echo "<li id ='main' class='last'><a href='../Pesquisar/Usuario/feedUsuario.php?nomeUsuario=$nomeUsuario'><span>Minha Página</span></a></li>";
		
		echo "<li id = 'main' class='last'><a href='../Feed/index.php'><span>Feed</span></a></li>";

		echo "<li id = 'main' class='last'><a href='index.php'><span>Nova Pergunta</span></a></li>";
  	 	//echo "<div id='cssvmenu'><ul>";
		echo "<li id='main' class='last'><a href='../login/login.php'><span>SAIR</span></a></li>"; 

		echo "</ul><br><br>";
	}else
	{?>
   	</div></ul><br><br>
   	<div id='cssvmenu'><ul>
   	<li id="main" class='last'><a href='../login/login.php'><span>Login</span></a></li>
	<?php
	}
	echo "</ul></div></div>";

	include("../classes/usuario.php");
	$usuario = new Usuario();
	include("../classes/visual.php");
	$visual = new Visual();
	include_once("../classes/pergunta.php");
	$pergunta = new Pergunta();

	$feed = $usuario->feed($_SESSION['usuario']);

	if(!$feed)
	{
		echo "<label><b>NÃO HÁ PERGUNTAS NO SEU FEED! Siga novas matérias e usuários!</b></label>";
	}else
	{
		foreach ($feed as $feedAtual)
		{
			$cod         = $feedAtual['codPergunta'];
			$nomeUsuario = $feedAtual['nomeUsuario'];
			$codMateria  = $feedAtual['codMateria'];
			$assunto     = $feedAtual['assunto'];
			$data        = $feedAtual['data']->format('d F Y H\h');
			$materia     = $pergunta->materia($cod);
			$explicacao  = $feedAtual['explicacao'];

			$site        = "Feed/index.php";
			$siteHome    = "../";

			$curtidas    = $pergunta->curtidas($cod);
			$curtiu      = $pergunta->usuarioCurtiu($cod, $_SESSION['usuario']);

			$maisCurtida = false;
			$motivoMat   = $feedAtual['motivoMat'];
			$motivoUs    = $feedAtual['motivoUs'];

			$visual->tabelaPergTudo($assunto, $explicacao, $codMateria, $materia, $data, $cod, $nomeUsuario, $site, $siteHome, $maisCurtida, $curtidas, $curtiu, $motivoMat, $motivoUs);
		}
	}
}
?>
</body>
</html>