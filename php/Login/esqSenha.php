<!DOCTYPE html>
<html>
<head>
  <title>Esquecimento de Senha</title>
  <meta charset="utf-8">
  <link rel="stylesheet" type="text/css" href="estilo/esqSenha.css">
    <link rel="shortcut icon" href="../../imagens/logo.png">
  <script type="text/javascript" src="jquery-3.2.1.js"></script>
</head>
<body>


<form action="esqSenha.php">
  
   <h2 id="forum">UNIVERSE</h2>
     <div class="imgcontainer">
     <img src="imagens/logo.png" height="30%" width="30%" id="imagemPerfil">

  </div>

  <div class="container">


    <input type="text" placeholder="Insira seu usuário..." name="uname" id="txtNome" required>

<br>
<br>

    <input type="email" placeholder="Digite o código recebido por email..." name="email" id="txtSenha" required>

    <br><br>

    <input type="password" placeholder="Insira a nova senha..." name="psw" id="txtSenha" required>
    <br><br

    <input type="password" placeholder="Confirme a nova senha..." name="psw" id="txtSenha" required>

    <br><br>

    <button type="submit" class="btnCerto">Alterar senha</button>


  </div>




</body>
</html>
