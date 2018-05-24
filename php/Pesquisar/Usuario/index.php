<?php session_start(); 
if(!isSet($_SESSION['usuario']))
	$_SESSION['usuario']="";

	$usuarioAtual = $_SESSION['usuario'];
?>
<html>
<head>
	<title>Pesquisar por Usuários</title>
	<link rel="stylesheet" type="text/css" href="../../../estilo/responder.css">
	<link rel="stylesheet" type="text/css" href="../../../estilo/menuVertical.css">
		<link rel="shortcut icon" href="../../../imagens/logo.png">
</head>
<body>
	<div class="divDoForm">

<?php
	echo "<form action='auxPHP.php' method='POST'>";
	echo "<h2 id='titulo'>Pesquisa de Usuários </h2><hr><br><br>";

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
		echo "<li id ='main' class='last'><a href='../Usuario/feedUsuario.php?nomeUsuario=$usuarioAtual'><span>Minha Página</span></a></li>";
		
		echo "<li id = 'main' class='last'><a href='../../Feed/index.php'><span>Feed</span></a></li>";

		echo "<li id = 'main' class='last'><a href='../../perguntar/index.php'><span>Nova Pergunta</span></a></li>";
  	 	//echo "<div id='cssvmenu'><ul>";
		echo "<li id='main' class='last'><a href='../../login/login.php'><span>SAIR</span></a></li>"; 

		echo "</ul><br><br>";
	}else
	{?>
   	</div></ul><br><br>
   	<div id='cssvmenu'><ul>
   	<li id="main" class='last'><a  class="first" href='../../login/login.php'><span>Login</span></a></li>
	<?php
	}
	echo "</ul></div></div>";


	$texto = "";
	if(isSet($_SESSION['pesquisaExistenteUs']))
	{
		echo "<label><b>Nome do Usuário</b></label><br>";
		$texto = $_SESSION['pesquisaExistenteUs'];
		echo "<input type='text' name='pesquisa' value='$texto'>"; //like %texto% na explicacao
	}
	else
	{
		echo "<label><b>Nome do Usuário</b></label><br>";
		echo "<input type='text' name='pesquisa'>";
	}
	echo "<input type='submit' name='submit' class='btnEnviar' value='Pesquisar'><br>";

	if(isSet($_SESSION['pesquisaExistenteUs']))
	{
		include_once("../../classes/usuario.php");
		$usuario   = new Usuario();
		$textoPesq = $_SESSION['pesquisaExistenteUs'];

		$usuarios = $usuario->pesquisa($texto);

		if($usuarios==false)
			echo "<br><label class='erro'>NÃO HÁ NENHUM USUÁRIO COM ESSE NOME!!</label>";
		else
		{
			echo "<ul>";
			foreach($usuarios as $i => $vetor)
			{
				$nomeUs = $vetor['nomeUsuario'];
				// $email  = $vetor['email'];

				echo "<li><img src='../../../imagens/logo.png'><a class='nomeUser' href='feedUsuario.php?nomeUsuario=$nomeUs'> $nomeUs </a></img><br>";

				if($_SESSION['usuario']!="" && $_SESSION['usuario']!=$nomeUs)
				{
					if(!$usuario->segueUsuario($_SESSION['usuario'],$nomeUs))
						echo "<a class = 'follow' href='../../procedimentos/seguirUsuario.php?outroUsuario=$nomeUs&seguir=true'>Follow</a>";
					else
						echo "<a class = 'unfollow' href='../../procedimentos/seguirUsuario.php?outroUsuario=$nomeUs&seguir=false'>Unfollow</a>";

					if($_SESSION['usuario']=="HOMAO")
						echo "<br><a href='../../procedimentos/banir.php?usuario=$nomeUs'> BANIR </a>";
				}

				echo "</li><br>";
			}
			echo "</ul>";
		}
	}
?>
	</form>
	</div>
</body>
</html>