<?php session_start(); 
if(!isSet($_SESSION['usuario']))
	header("Location:../index.php");
else
{
	$nomeUsuario = $_SESSION['usuario'];
?>
<html>
<head>
	<title>Perguntar</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="../../../estilo/responder.css">
	<link rel="stylesheet" type="text/css" href="../../estilo/perguntar.css">
	<link rel="shortcut icon" href="../../imagens/logo.png">
	<link rel="stylesheet" type="text/css" href="../../estilo/menuVertical.css">
	<link rel="stylesheet" type="text/css" href="../../estilo/showModal.css">
</head>
<body>
<?php
	include_once("../classes/usuario.php");
	$usuario = new Usuario();
	include_once("../classes/materia.php");
	$materia = new Materia();

	echo "<form action='auxPHP.php' method='POST'>";
	echo "<h2 id='titulo'>Pergunte algo!</h2>";
	echo "<hr><br><br>";
	
	?>
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




	if(isSet($_SESSION['assuntoExistente']) && $_SESSION['assuntoExistente']!="")
	{
		$assuntoExistente = $_SESSION['assuntoExistente'];
		echo "<label><b>Título da pergunta<b></label><br> <input type='text' name='assunto' value=$assuntoExistente> <br>";
	}
	else
		echo "<label><b>Título da pergunta<b></label><br> <input type='text' name='assunto' placeholder='Digite o título da pergunta'> <br>";

	echo "<br>";

	if(isSet($_SESSION['explicacaoExistente']) && $_SESSION['explicacaoExistente']!="")
	{
		$explicacaoExistente = $_SESSION['explicacaoExistente'];
		echo "<label><b>Pergunta</b></label><br><textarea name='explicacao'>$explicacaoExistente</textarea>";
	}
	else
		echo "<label><b>Pergunta</b></label><br><textarea name='explicacao' placeholder='Digite a pergunta desejada...'></TEXTAREA><br>";


	$materias = $materia->todasMaterias();

	if($materias==false)
	{
		echo "<input type='hidden' name='rgMateria' value='-1'>";
		echo "<label id='semMateria'>NÃO HÁ NENHUMA MATÉRIA: crie uma para continuar!</label><br>";
	}
	else
	{
		$rgMatSelected = -2;
		if(isSet($_SESSION['rgMatExistente']))
			$rgMatSelected = $_SESSION['rgMatExistente'];

		echo "<br><label><b>Matéria: </b></label><select name='rgMateria' style='font-size:17px' id='selecionador'>";
		foreach ($materias as $vetor)
		{
			$nomeMateria = $vetor['nomeMateria'];
			$cod         = $vetor['codMateria'];

			if($rgMatSelected==$i)
				echo "<option name='rgMateria' value='$cod' selected> $nomeMateria </option>";
			else
				echo "<option name='rgMateria' value='$cod'> $nomeMateria </option>";
		}
		echo "</select> <br>";
	}

	echo "<br><br><input type='submit' name='submit' class='incluir' value='Adicionar Matéria' style='width: 200px'>";
	echo "<input type='text' name='novaMateria' id='assuntoNovo' maxlength='30' placeholder='Digite uma nova matéria...'><br><br>";
	?>

	<br><br>
	<label><b>Frequência de emails</b></label>
    <br><br>
    <input type="radio" name="rgEmail" value=0><label class="rgb">Não receber nunca</label><br>
    <input type="radio" name="rgEmail" value=1 checked><label class="rgb">Receber a cada resposta</label><br><br>

<?php
	if($materias)
	echo "<input type='submit' class='btnEnviar' name='submit' value='Perguntar'>";
	echo "<br>";

	if(isSet($_GET['novaMateria']))
	{
		if($_GET['novaMateria']=='OK')
			echo "<br><label class='sucesso'>Matéria adicionada com sucesso! </label><br>";
		else
			if($_GET['novaMateria']=='escreva')
				echo "<br><label class='sucesso'>Digite uma matéria! </label><br>";
			else
				echo "<br><label class='erro'>ERRO: matéria não adicionada! <label><br>";
	}

	if(isSet($_GET['pergunta']))
	{
		if($_GET['pergunta']=='OK')
			echo "<br><label class='sucesso'>Pergunta enviada com sucesso!<br>";
		else
			echo "<br><label class='erro'>Algum dos campos não foi preenchido corretamente!<br>";
	}

	if(isSet($_GET['matJahExiste']))
		echo "<br><label class='erro'>A matéria já existe! <br>";

	echo "<br><br></form>";

	if(isSet($_SESSION['assuntoExistente']))
		unset($_SESSION['assuntoExistente']);
	if(isSet($_SESSION['explicacaoExistente']))
		unset($_SESSION['explicacaoExistente']);
	if(isSet($_SESSION['rgMatExistente']))
		unset($_SESSION['rgMatExistente']);
	if(isSet($_SESSION['rgEmailExistente']))
		unset($_SESSION['rgEmailExistente']);
}
?>
</body>
</html>