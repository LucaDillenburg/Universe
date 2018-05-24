<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
  <title>Login</title>
  <meta charset="utf-8">
  <link rel="stylesheet" type="text/css" href="../../estilo/login.css">
  <link rel="shortcut icon" href="../../imagens/logo.png">
</head>
<body>

<form action="loginPHP.php" method="post">
  
  <h2 id="forum"> UNIVERSE</h2>
  <div class="imgcontainer">
     <img src="../../imagens/logo.png" height="30%" width="30%" id="imagemPerfil">
  </div>

  <div class="container">
    <label><b>Usuário</b></label>
    <br>
    <?php
    if(isSet($_SESSION['nomeUsuarioExistente']))
      echo "<input type='text' name='usuario' id='txtNome' maxlength='50' value='".$_SESSION['nomeUsuarioExistente']."' required>";
    else
    {
    ?>
      <input type="text" name="usuario" id="txtNome" maxlength="50" required>
    <?php
    }
    ?>

    <br><br>

    <label><b>Senha</b></label>
    <br>
    <?php
    if(isSet($_SESSION['senhaExistente']))
      echo "<input type='password' name='senha' id='txtSenha' maxlength='30' value='".$_SESSION['senhaExistente']."' required>";
    else
    {
    ?>
    <input type="password" name="senha" id="txtSenha" maxlength="30" required>
    <?php
    }
    ?>

    <button type="submit" class="btnCerto">Login</button>

    <h4 class="esqSenha">Esqueceu <a href="preEsqSenha.php">sua senha?</a></h4>
    <h4 class="semLogin">Não tem uma conta? <a href="cadastro.php">Clique aqui</a> e faça logo a sua!</h4>
    <h4 class="esqSenha">Ir para a <a href="../index.php">home</a>.</h4>
  </div>

  <?php   
      if(isSet($_SESSION['usuario']))
          unset($_SESSION['usuario']);

      if (isset($_GET['usuariologin']) && $_GET['usuariologin']=="NOK")
              echo "<label id='erro'>Esse nome de usuário não existe.</label>";
      else
          if (isset($_GET['senhalogin']) && $_GET['senhalogin']=="NOK")
              echo "<label id='erro'>Senha errada! </label><br>";
  ?>
</body>
</html>