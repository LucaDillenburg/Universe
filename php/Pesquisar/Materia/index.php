<?php session_start(); 
if(!isSet($_SESSION['usuario']))
	$_SESSION['usuario'] = "";
$nomeUsuario = $_SESSION['usuario'];
?>
<html>
<head>
	<title>Responder Perguntas</title>
	<link rel="stylesheet" type="text/css" href="../../../estilo/responder.css">
	<link rel="stylesheet" type="text/css" href="../../../estilo/showModal.css">
	<link rel="stylesheet" type="text/css" href="../../../estilo/menuVertical.css">
	<link rel="shortcut icon" href="../../../imagens/logo.png">
</head>
<body>

<div class="divDoForm">
<form action="auxPHP.php" name="formulario" method="post">
	<h2 id="titulo">Pesquisar Matéria</h2>
	<hr>
	<br><br>
<?php
	echo "<form action='auxPHP.php' method='post'>";

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



	if(isSet($_SESSION['pesquisaExistenteMat']))
	{
		echo "<br><label>Nome da matéria</label><br>";
		$texto = $_SESSION['pesquisaExistenteMat'];
		echo "<input type='text' name='pesquisa' value='$texto'>"; //like %texto% na explicacao
	}
	else
	{
		echo "<label>Nome da matéria</label><br>";
		echo "<input type='text' name='pesquisa'>";
	}

	echo "<input type='submit' name='submit' class='incluir' value='Pesquisar'><br>";

	if($_SESSION['usuario']!="")
	{
		echo "<br><br><input type='submit' name='submit' class='incluir' value='Adicionar Matéria' style='width: 200px'>";
		echo "<input type='text' name='novaMateria' id='assuntoNovo' maxlength='30' placeholder='Digite uma nova matéria...'><br><br>";
	}else
		echo "<label id='erro'> Você precisa se logar para adicionar uma matéria.</label>";


	if(isSet($_GET['novaMateria']))
	{
		if($_GET['novaMateria']=='OK')
			echo "<br><label id='sucesso'>Matéria adicionada com sucesso! </label><br>";
		else
			echo "<br><br><label id='erro'>ERRO: matéria não adicionada!</label> <br>";
	}

	if(isSet($_GET['matJahExiste']))
		echo "<br><label id='erro'>A matéria já existe!</label> <br>";

	if(isSet($_SESSION['pesquisar']) && $_SESSION['pesquisar'] && isSet($_SESSION['pesquisaExistenteMat']))
	{
		include_once("../../classes/materia.php");
		$materia   = new Materia();
		include_once("../../classes/usuario.php");
		$usuario   = new Usuario();
		$textoPesq = $_SESSION['pesquisaExistenteMat'];

		// $_SESSION['pesquisar'] = false;		

		$materias = $materia->pesquisa($texto);

		if($materias==false)
			echo "<br><label id='erro'>NÃO HÁ NENHUMA MATÉRIA!!</label>";
		else
		{
			echo "<ul>";
			foreach($materias as $i => $vetor)
			{
				$codMateria = $vetor['codMateria'];
				$nomeMat    = $vetor['nomeMateria'];

				echo "<li> <img src='../../../imagens/logo.png'><a class='nomeUser' href='feedMateria.php?codMateria=$codMateria'> $nomeMat</img> </a><br>";

				if($_SESSION['usuario']!= "")
				{
					if(!$usuario->segueMateria($_SESSION['usuario'],$codMateria))
						echo "<a href='../../procedimentos/seguirMateria.php?codMateria=$codMateria&seguir=true' class='follow'>Follow</a>";
					else
						echo "<a href='../../procedimentos/seguirMateria.php?codMateria=$codMateria&seguir=false' class='unfollow'>Unfollow</a>";

					if($_SESSION['usuario']=="HOMAO")
						echo "<a href='../../procedimentos/banir.php?materia=$codMateria'> BANIR </a>";
				}

				echo"</li><br><br>";
				/*if(!$materia->temQuestoes($codMateria))
					echo "<a href='excluirMat.php?codMateria=$codMateria'> APAGAR MATÉRIA </a>";*/
			}
			echo "</ul>";
		}
	}
?>
	</div>
	</form>
</body>
</html>