<?php session_start(); 
if(!isSet($_SESSION['usuario']) || !isSet($_POST['resposta']))
	header("Location:../index.php");
else
{
	$codPergunta   = $_SESSION['codPergunta'];
	unset($_SESSION['codPergunta']);

	include_once("../../classes/resposta.php");
	$resposta = new Resposta();

	$nomeRespondeu = $_SESSION['usuario'];
	$textoResp     = htmlspecialchars($_POST['resposta']);
	$dataResposta  = date('d-m-Y H:i:s');

	$status = $resposta->responder($codPergunta, $nomeRespondeu, $textoResp, $dataResposta);

	if($_POST['submit']=="Responder")
		$resposta->respondeu($codPergunta, $_SESSION['usuario']);

	if($status)
	{
		$_SESSION['resposta'] = 'OK';
		header("Location:index.php?codPergunta=$codPergunta");
	}
	else
		header("Location:index.php?naoFoi=1");
}
?>