<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
  <title>Cadastro</title>
  <meta charset="utf-8">
  <link rel="stylesheet" type="text/css" href="../../estilo/cadastro.css">
    <link rel="shortcut icon" href="../../imagens/logo.png">
</head>
<body>


<form action="cadastroPHP.php" method="post">
  
    <h2 id="forum">UNIVERSE</h2>
      <div class="imgcontainer">
     <img src="../../imagens/logo.png" height="30%" width="30%" id="imagemPerfil">

  </div>
  <div class="container">
  <label><b>Primeiro Nome</b></label>
  <br>
    <?php 
    if(isSet($_SESSION['primeiroNomeExistente']))
    {
      echo "<input type='text' name='primeiroNome' id='txtSenha' value='".$_SESSION['primeiroNomeExistente']."' required>";
    }
    else
    {
    ?> <input type='text' name='primeiroNome' id='txtSenha' maxlength="20" required>
    <?php } ?>

    <br><br>

    <label><b>Sobrenome</b></label>
    <br>

    <?php 
    if(isSet($_SESSION['sobrenomeExistente']))
    {
      echo "<input type='text' name='sobrenome' id='txtSenha' value='".$_SESSION['sobrenomeExistente']."' required>";
    }
    else
    {
    ?> <input type='text' name='sobrenome' id='txtSenha' maxlength="35" required>
    <?php } ?>

    <br><br>


    <label><b>Usuário</b></label>
    <br>
    <?php 
    if(isSet($_SESSION['nomeUsuarioExistente']))
    {
      echo "<input type='text' name='usuario' id='txtNome' value='".$_SESSION['nomeUsuarioExistente']."' required>";
    }
    else
    {
     ?> <input type='text' name='usuario' id='txtNome' required>
    <?php } ?>
    
    <br>
    <br>

  	<label><b>Email</b></label>
    <br>

    <?php 
    if(isSet($_SESSION['emailExistente']))
    {
      echo "<input type='email' name='email' id='txtSenha' maxlength='50' value='".$_SESSION['emailExistente']."' required>";
    }
    else
    {
     ?> <input type='email' name='email' id='txtSenha' maxlength="50" required>
    <?php } ?>

    <br><br>

    <label><b>Senha</b></label>
    <br>

    <?php 
    if(isSet($_SESSION['senha1Existente']))
    {
      echo "<input type='password' name='senha1' id='txtSenha' maxelngth='20' value='".$_SESSION['senha1Existente']."' required>";
    }
    else
    {
     ?> <input type='password' name='senha1' id='txtSenha' maxlength="20" required>
    <?php } ?>
    <br><br>

    <label><b>Confirmar senha</b></label>
    <br>

    <?php 
    if(isSet($_SESSION['senha2Existente']))
    {
      echo "<input type='password' name='senha2' id='txtSenha' maxlength='20' value='".$_SESSION['senha2Existente']."' required>";
    }
    else
    {
     ?> <input type='password' name='senha2' id='txtSenha' maxlength="20" required>
    <?php } ?>

    <br>
    <br>

    <button type="submit" class="btnCerto">Cadastrar</button>

  </div>

	<?php
		if(isSet($_SESSION['usuario']))   
			unset($_SESSION['usuario']); 

    if (isset($_GET['usuario']) && $_GET['usuario']=="NOK")
            echo "<label id='erro'>* Esse nome de usuário já existe, escolha outro nome.</label>";

    if(isSet($_GET['senhaFraca']))
    	echo "<label id='erro'>* A senha que você digitou é fraca!! \n Tem que ter 8 caracteres, maiúscula e minúscula e números</label>";

    if (isset($_GET['senha']) && $_GET['senha']=="NOK")
            echo "<label id='erro'>* As senhas que você digitou não se correspondem.</label>";

    if (isset($_GET['deuRuim']) && $_GET['deuRuim']=="OK")
            echo "<label id='erro'>** Deu ruim!!</label>";
  ?>
</body>
</html>