<?php session_start(); 
if (!isSet($_GET['codMateria'])) 
	header("Location:index.php");
else if(!isSet($_SESSION['usuario']))
	$_SESSION['usuario'] = "";
else
{
	$nomeUsuario = $_SESSION['usuario'];
?>
<!DOCTYPE html>
<html>
<head>
	<title>Matéria</title>
	<link rel="stylesheet" type="text/css" href="../../../estilo/responder.css">
	<link rel="shortcut icon" href="../../../imagens/logo.png">
	<link rel="stylesheet" type="text/css" href="../../classes/visual.css">
	<link rel="stylesheet" type="text/css" href="../../../estilo/menuVertical.css">
</head>
<body>
<?php
	include_once("../../classes/materia.php");
	$materia = new Materia();
	include_once("../../classes/usuario.php");
	$usuario = new Usuario();

	echo "<div class='divDoForm'>";
	echo "<form action='../Resposta/index.php' method='POST'>";

	$codMateria = $_GET['codMateria']; //passa como parâmetro
	$_SESSION['codMateria'] = $codMateria;

	$nomeMateria = $materia->nome($codMateria);

	echo "<h2 id='titulo'><b> $nomeMateria </b></h2>";
	echo "<hr>";

?>
	<div class="menu">
	<div id='cssvmenu'>
	<ul>
	<li id="main" class='active has-sub'><a class="first"><span>Pesquisar</span></a>
      <ul>
         <li id = "sub" class='last'><a href='../Pergunta/index.php'><span>Perguntas</span></a>
         </li>
         <li id = "sub" class='last'><a href='index.php'><span>Matérias</span></a>
         </li>
         <li id = "sub" class='last'><a href='../Usuario/index.php'><span>Usuários</span></a>
         </li>
      </ul>
   </li>
   <?php
	if($_SESSION['usuario']!="")
	{
		echo "<li id ='main' class='last'><a href='../Usuario/feedUsuario.php?nomeUsuario=$nomeUsuario'><span>Minha Página</span></a></li>";
		
		echo "<li id = 'main' class='last'><a href='../../Feed/index.php'><span>Feed</span></a></li>";

		echo "<li id = 'main' class='last'><a href='../../perguntar/index.php'><span>Nova<br>Pergunta</span></a></li>";
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




	if($_SESSION['usuario']!= "")
		if(!$usuario->segueMateria($_SESSION['usuario'],$codMateria))
			echo "<a href='../../procedimentos/seguirMateria.php?codMateria=$codMateria&seguir=true' class='follow'>Follow</a>";
		else
			echo "<a href='../../procedimentos/seguirMateria.php?codMateria=$codMateria&seguir=false' class='unfollow'>Unfollow</a>";

	echo "<br><br>";
	include_once('../../classes/pergunta.php');
	$pergunta = new Pergunta;
	$cods = $pergunta->selCods($codMateria, true, '', '');

	if($cods==false)
		echo "<br><label>NÃO HÁ NENHUMA PERGUNTA!!</label>";
	else
	{
		include_once("../../classes/visual.php");
		$visual = new Visual();

		foreach($cods as $i => $cod)
		{
			$vetor = $pergunta->selPergPorCod($cod);

			$assunto    = $vetor['assunto'];
			$usuario    = $vetor['nomeUsuario'];
			$data       = $vetor['data']->format('d F Y H\h');
			$materia    = $pergunta->materia($cod);
			$explicacao = $vetor['explicacao'];

			$site = "Pesquisar/Materia/feedMateria.php?codMateria=$codMateria";
			$siteHome = "../../";

			$nCurtidas = $pergunta->curtidas($cod);
			$curtiu    = $pergunta->usuarioCurtiu($cod, $_SESSION['usuario']);

			$visual->tabelaPergTudo($assunto, $explicacao, $codMateria, $materia, $data, $cod, $usuario, $site, $siteHome, $i<2, $nCurtidas, $curtiu,false,false);
		}
	}
}
?>
</form>
</div>
</body>
</html>