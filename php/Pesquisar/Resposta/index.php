<?php session_start(); 
if(!isSet($_SESSION['usuario']))
	$_SESSION['usuario']="";
else if(!isSet($_GET['codPergunta'])) 
		header("Location:../../index.php");
else
{
	$nomeUsuario = $_SESSION['usuario'];
?>
<!DOCTYPE html>
<html>
<head>
	<title>Pesquisar Resposta</title>
	<link rel="stylesheet" type="text/css" href="../../../estilo/responder.css">
	<link rel="shortcut icon" href="../../../imagens/logo.png">
	<link rel="stylesheet" type="text/css" href="../../classes/visual.css">
	<link rel="stylesheet" type="text/css" href="../../../estilo/menuVertical.css">
</head>
<body>
<?php
	include_once("../../classes/pergunta.php");
	$pergunta = new Pergunta();

	echo "<div class='divDoForm'>";
	echo "<form action='auxPHP.php' method='POST'>";


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
         <li id = "sub" class='last'><a href='../Usuario/index.php'><span>Usuários</span></a>
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
   	<li id="main" class='last'><a href='../../login/login.php'><span>Login</span></a></li>
	<?php
	}
	echo "</ul></div></div>";


	$codPergunta = $_GET['codPergunta']; //passa como parâmetro
	$_SESSION['codPergunta'] = $codPergunta;

	$valores = $pergunta->selPergPorCod($codPergunta);
	$materia = $pergunta->materia($codPergunta);

	$usuario    = $valores['nomeUsuario'];
	$assunto    = $valores['assunto'];
	$explicacao = $valores['explicacao'];
	$codMateria = $valores['codMateria'];
	$data       = $valores['data']->format('d F Y H\h');

	echo "<label id='titulo'><b> $assunto </b></label>";
	echo " - <label style='font-size: 30px'><a href='../../Pesquisar/Materia/feedMateria.php?codMateria=$codMateria'>$materia</a> </label> (<u><a class='nome' href='../../Pesquisar/Usuario/feedUsuario.php?nomeUsuario=$usuario'>$usuario</u></a>,  $data)<br>";
	echo "<hr>";
	echo "<label>$explicacao</label><br>";

	if($_SESSION['usuario']==$usuario)
		echo "<a href='apagarPergunta.php?codPergunta=$codPergunta&site=feed.php' class='unfollow'> Apagar Pergunta </a><br>";

	echo "<br>";
	if($_SESSION['usuario']!="")
	{
		if($_SESSION['usuario']==$usuario)
			echo "<textArea name='resposta' placeholder='Comente a sua pergunta...' resize='none'></textArea><br>";
		else
			echo "<textArea name='resposta' placeholder='Digite sua resposta...' resize='none'></textArea><br>";

		if($usuario==$_SESSION['usuario'])
			echo "<input type='submit' name='submit' class='btnEnviar' value='Comentar Novamente'><br><br><br>";
		else
			echo "<input type='submit' name='submit' class='btnEnviar' value='Responder'><br><br><br>";

		if(isSet($_SESSION['resposta']))
		{
			echo "<br><label class='sucesso'>Resposta enviada com sucesso!</label><br>";
			unset($_SESSION['resposta']);
		}
	}

	include_once("../../classes/resposta.php");
	$resposta  = new Resposta();
	$respostas = $resposta->selResp($codPergunta);

	if($respostas==false)
		echo "<label>NÃO HÁ NENHUMA RESPOSTAS!!</label>";
	else
	{
		include_once("../../classes/visual.php");
		$visual = new Visual();

		foreach($respostas as $i => $respostaAtual) 
		{
			$codResp       = $respostaAtual['codResposta'];
			$resposta      = $respostaAtual['resposta'];
			$nomeRespondeu = $respostaAtual['nomeRespondeu'];
			$data          = $respostaAtual['dataResposta']->format('d F Y H\h');

			$site = "Pesquisar/Resposta/index.php?codPergunta=$codPergunta";
			$siteHome = "../../";

			$visual->tabelaRespTudo($codResp, $resposta, $data, $nomeRespondeu, $codMateria, $materia, $usuario, $site, $siteHome);
			
			if($_SESSION['usuario']=="HOMAO")
				echo "<a href='../../procedimentos/banir.php?resposta=$codResp'> BANIR </a>";
			
			echo "<hr>";
		}

		if($usuario==$_SESSION['usuario']) 
		//se quem fez a pergunta é o próprio usuário
			$pergunta->usuarioViu($codPergunta);
	}
}
?>
</form>
</div>
</body>
</html>