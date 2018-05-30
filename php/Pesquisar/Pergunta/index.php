<?php session_start(); 
if(!isSet($_SESSION['usuario']))
	$_SESSION['usuario']="";
else
{
	$nomeUsuario = $_SESSION['usuario'];
?>
<html>
<head>
	<title>Pesquisar Perguntas</title>
	<link rel="stylesheet" type="text/css" href="../../../estilo/responder2.css">
	<link rel="shortcut icon" href="../../../imagens/logo.png">
	<link rel="stylesheet" type="text/css" href="../../classes/visual.css">
	<link rel="stylesheet" type="text/css" href="../../../estilo/menuVertical.css">
	<meta charset="utf-8">
</head>
<body>

<?php
	include_once("../../classes/materia.php");
	$materia = new Materia();
	include_once("../../classes/pergunta.php");
	$pergunta = new Pergunta();

	echo "<form action='auxPHP.php' method='POST'>";
	echo "<h2 id='titulo'>Pesquisar Perguntas</h2>		
	<hr>
	<br><br>";

?>

<div class="menu">
	<div id='cssvmenu'>
	<ul>
	<li id="main" class='active has-sub'><a class="first"><span>Pesquisar</span></a>
      <ul>
         <li id = "sub" class='last'><a href='index.php'><span>Perguntas</span></a>
         </li>
         <li id = "sub" class='last'><a href='../Materia/index.php'><span>Matérias</span></a>
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
   	<li id="main" class='active'><a class="first" href='../../login/login.php'><span>Login</span></a></li>
	<?php
	}
	echo "</ul></div></div>";




	$materias = $materia->todasMaterias();

	if($materias==false)
		echo "<label>NÃO HÁ NENHUMA MATÉRIA! </label><br>"; 
	else
	{
		if(isSet($_SESSION['rgMatExistentePerg']))
			$matSel = $_SESSION['rgMatExistentePerg'];
		else
			$matSel = -1;

		echo "<label><b>Matéria</b></label><br><select name='rgMateria' style='margin-left: 50px;
			margin-top: 10px; width: 300px; height: 50px; font-family: verdana; font-size: 20px;
			font-style: italic; margin-bottom: 20px;'>>";
		echo "<option value='0'> Qualquer matéria </option>";
		foreach ($materias as $vetor) 
		{
			$nome = $vetor['nomeMateria'];
			$cod  = $vetor['codMateria'];
			echo $matSel==$cod?"<option value='$cod' selected> $nome </option>":"<option name='rgMateria' value='$cod'> $nome </option>";
		}
		echo "</select> ";

		if($_SESSION['usuario']!='')
		{
			$qual = 1;
			if(isSet($_SESSION['rgQualExistentePerg']))
				$qual = $_SESSION['rgQualExistentePerg'];

			echo "<br><label><b>Buscar em: </b></label><br><select name='rgQual' style='margin-left: 50px;
				margin-top: 10px; width: 300px; height: 50px; font-family: verdana; font-size: 20px; 
				font-style: italic; margin-bottom: 20px;'>>";


			echo $qual==1?"<option value='1' selected> Todas as perguntas </option>":"<option name='rgQual' value='1'> Todas as perguntas </option>";
			echo $qual==0?"<option value='0' selected> Só nas minhas perguntas </option>":"<option name='rgQual' value='0'> Só nas minhas perguntas </option>";
			echo "</select><br>";
		}else
			echo "<input type='hidden' name='rgQual' value='0'><br>";

		if(isSet($_SESSION['pesquisaExistentePerg']))
		{
			$texto = $_SESSION['pesquisaExistentePerg'];
			echo "<input type='text' name='pesquisa' value='$texto'>"; //like %texto% na explicacao
		}
		else
			echo "<input type='text' name='pesquisa'>";

		echo "<input type='submit' class='btnEnviar' value='Pesquisar'><br>";
	}


	if(isSet($_SESSION['rgMatExistentePerg']) || isSet($_SESSION['rgQualExistentePerg']) || isSet($_SESSION['pesquisaExistentePerg']))
	{
		$matSel         = 0;
		$todasPerguntas = 1; 
		$textoPesq      = "";  

		if(isSet($_SESSION['rgMatExistentePerg']))
			$matSel         = $_SESSION['rgMatExistentePerg'];
		if(isSet($_SESSION['rgQualExistentePerg']))
			$todasPerguntas = $_SESSION['rgQualExistentePerg']; 
			//true se tiver selecionado todas as perguntas
		if(isSet($_SESSION['pesquisaExistentePerg']))
			$textoPesq      = $_SESSION['pesquisaExistentePerg'];
		$nomeUsuario    = $_SESSION['usuario'];

		$cods = $pergunta->selCods($matSel, $todasPerguntas, $textoPesq, $nomeUsuario);

		if($cods==false)
			echo "<br><label>NÃO HÁ NENHUMA PERGUNTA!!</label>";
		else
		{
			include_once("../../classes/visual.php");
			$visual = new Visual();

			echo "<hr>";
			foreach($cods as $i => $cod)
			{
				if($i==2)
					echo "<hr>";
				
				$vetor = $pergunta->selPergPorCod($cod);

				$codMateria = $vetor['codMateria'];
				$assunto    = $vetor['assunto'];
				$usuario    = $vetor['nomeUsuario'];
				$data       = $vetor['data']->format('d F Y H\h');
				$materia    = $pergunta->materia($cod);
				$explicacao = $vetor['explicacao'];

				$site = "Pesquisar/Pergunta/index.php";
				$siteHome = "../../";

				$nCurtidas = $pergunta->curtidas($cod);
				$curtiu    = $pergunta->usuarioCurtiu($cod, $_SESSION['usuario']);

				$visual->tabelaPergTudo($assunto, $explicacao, $codMateria, $materia, $data, $cod, $usuario, $site, $siteHome, $i<2, $nCurtidas, $curtiu, false, false);

				if($_SESSION['usuario']=="HOMAO")
					echo "<a href='../../procedimentos/banir.php?pergunta=$cod'> BANIR </a>";

			}
		}
	}
}
?>
	</form>
</body>
</html>