<!DOCTYPE html>
<html>
<head>
	<title>Esquecimento de senha</title>
	<link rel="stylesheet" type="text/css" href="../../estilo/preEsqSenha.css">
    <link rel="shortcut icon" href="imagens/logo.png">
	<meta charset="utf-8">
	<style type="text/css">
		.frase
		{
			font-size: 15px;
			padding-top: 0px;
			margin-top: 10px;
		    margin-bottom: 0px;
			font-family: sans-serif;
			margin-left: 15%;
			font-style: italic;
			color: black;
		}
	</style>
</head>
<body>
	<form action="preEsqSenha.php" method="post">
   <h2 id="forum">UNIVERSE</h2>
	<h4 class="frase">Por favor, confirme seu nome de usuário e email.</h4>
	<br>
	<div class="container">
		<input type="text" placeholder="Insira seu nome..." name="uname" id="txtNome" required>
		<!-- <input type="email" placeholder="Insira seu email..." name="email" id="txtSenha" required> -->
		<br>
		<button type="submit" class="btnCerto">Enviar email de recuperação de senha</button>
</div>

</body>
</html>