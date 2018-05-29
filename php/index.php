<?php session_start(); 
if(!isSet($_SESSION['usuario']))
	$_SESSION['usuario']="";

	if(isSet($_SESSION['rgMatExistente']))
		unset($_SESSION['rgMatExistente']);
	if(isSet($_SESSION['rgQualExistente']))
		unset($_SESSION['rgQualExistente']);
	if(isSet($_SESSION['pesquisaExistente']))
		unset($_SESSION['pesquisaExistente']);
	if(isSet($_SESSION['senhaExistente']))
		unSet($_SESSION['senhaExistente']);

	$nomeUsuario = $_SESSION['usuario'];
?>
<!DOCTYPE html>
<html>
<head>
	<title>Página Inicial</title>
	<link rel="stylesheet" type="text/css" href="../estilo/menuVertical.css">
	<link rel="stylesheet" type="text/css" href="../estilo/indexStyle.css">

	<link rel="shortcut icon" href="../imagens/logo.png">
</head>
<body>
<div id="principal">
<center>
	<br>
	<h2 id="titulo">Seja bem-vindo a <u><b>UNIVERSE!</b></u></h2>
	<br>

	<div id='cssvmenuind' class="esq">
	<ul>
	<li id="main" class='active has-sub'><a class="first"><span>Pesquisar</span></a>
      <ul>
         <li id = "sub" class='last'><a href='Pesquisar/Pergunta/index.php'><span>Perguntas</span></a>
         </li>
         <li id = "sub" class='last'><a href='Pesquisar/Materia/index.php'><span>Matérias</span></a>
         </li>
         <li id = "sub" class='last'><a href='Pesquisar/Usuario/index.php'><span>Usuários</span></a>
         </li>
      </ul>
   </li>
   </ul></div>
   <?php
	if($_SESSION['usuario']!="")
	{
		echo "<div id='cssvmenuind' class='direita'><ul>";
		echo "<li id ='main' class='last'><a class='first' href='Pesquisar/Usuario/feedUsuario.php?nomeUsuario=$nomeUsuario'><span>Minha Página</span></a></li></ul></div>";
		
		echo "<div id='cssvmenuind' class='esq'><ul><li id = 'main' class='last'><a class='first' href='Feed/index.php'><span>Feed</span></a></li></ul></div>";

		echo "<div id='cssvmenuind' class='direita'><ul><li id = 'main' class='last'><a class='first' href='Perguntar/index.php'><span>Nova Pergunta</span></a></li></ul></div>";
		
		echo "<br><br><div class='meio' id='cssvmenuind'><ul>";
		echo "<li id='main' class='last'><a class='first' href='login/login.php'><span>SAIR</span></a></li>"; 
		echo "</ul></div>";

	}else
	{?>
	<br><div class='meio' id='cssvmenuind'><ul>
   	<li id="main" class='last'><a class="first" href='login/login.php'><span>Login</span></a></li></ul></div>
	<?php
	}
	echo "</ul></div>";
	?>
	</div>
</center>
</div>
</body>
</html>