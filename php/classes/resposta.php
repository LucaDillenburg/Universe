<?php
include_once("conexao.php");

class Resposta extends Conexao
{
	public function responder($codPergunta, $nomeRespondeu, $resposta, $dataResposta)
	{
		return $this->sql("INSERT INTO resposta VALUES($codPergunta, '$nomeRespondeu', '$resposta', '$dataResposta', 0)");
	}

	public function apagar($codResp)
	{
		return $this->sql("DELETE FROM resposta WHERE codResposta=$codResp");
	}

	public function respondeu($codPergunta, $nomeUsuario)
	{
		//mais resposta
		$aux = $this->select("SELECT quantasRespostas FROM pergunta WHERE codPergunta=$codPergunta");
		$qts = $aux[0]['quantasRespostas']+1;
		return $this->sql("UPDATE pergunta SET quantasRespostas=$qts WHERE codPergunta=$codPergunta");

		//mandar email
		include_once("pergunta.php");
		$pergunta = new Pergunta();
		if($pergunta->enviarEmailSempre($codPerg))
		{
			$this->mandarEmail(); 
		}
	}

	private function mandarEmail($nomeUsuario)
	{
		include_once("usuario.php");

		$usuario = new Usuario();
		
		$email_sender = $usuario->email($nomeUsuario);
		$assunto    = "Esquecimento de Senha UNIVERSE"; //trata a  variavel assunto
		$mensagem   ="Olá $nomeUsuario!
						Abra o link abaixo e use este código:
						NY@@RV@SD";

						//<a href=''>Ir para Alteração de Senha"; //trata a variavel mensagem


		global $email; //transforma a variavel email em variavel global 

		$quebra_linha = "\n";

		$headers  = "MIME-Version: 1.1".$quebra_linha;
		$headers .= "Content-type: text/html; charset=iso-8859-1".$quebra_linha;
		$headers .= "From: ".$email_sender.$quebra_linha;
		$headers .= "Return-Path: ".$email_sender.$quebra_linha;
		$headers .= "Reply-To: ".$email_sender.$quebra_linha;



		$envio = mail ($email, $assunto, $mensagem, $headers, $email_sender);//posta o assunto e a mensagem na caixa de mensagem da pessoa

		 //agora vamos imprimir na tela o resultado ou a resposta
		if($envio)
			echo "<label class='frase'><b>$nomeUsuario</b>, acabamos de enviar um email para que voce possa trocar de senha.</label><br>";
		else
			echo "<label class='frase'>Erro ao enviar o email.</label>";
	
	}

	public function selResp($codPergunta)
	{
		$ret = $this->select("SELECT resposta, nomeRespondeu, dataResposta, codResposta FROM resposta WHERE codPergunta=$codPergunta and melhorResp=1");
		
		if(!$ret)
			return $this->select("SELECT resposta, nomeRespondeu, dataResposta, codResposta FROM resposta WHERE codPergunta=$codPergunta order by dataResposta desc");

		$codMelhorResp = $ret[0]['codResposta'];
		$outro = $this->select("SELECT resposta, nomeRespondeu, dataResposta, codResposta FROM resposta WHERE codPergunta=$codPergunta and codResposta<>$codMelhorResp order by dataResposta desc");

		if(!$outro)
			return $ret;

		foreach ($outro as $x => $vetor)
		{
			$ret[$x+1] = $vetor;
		}

		return $ret;
	}

	public function selRespPorUsuario($codPergunta, $nomeUsuario)
	{
		return $this->select("SELECT resposta, dataResposta, codResposta FROM resposta WHERE codPergunta=$codPergunta and nomeRespondeu='$nomeUsuario' order by dataResposta desc");
	}

	public function ehMelhorResp($codResp)
	{
		$codPerg = $this->select("SELECT codPergunta from resposta where codResposta=$codResp");

		if(!$codPerg)
			return false;

		$codPerg = $codPerg[0]['codPergunta'];
		$status = $this->sql("UPDATE resposta set melhorResp=0 where codPergunta=$codPerg");
		if(!$status)
			return false;
		
		return $this->sql("UPDATE resposta set melhorResp=1 where codResposta=$codResp");
	}

	public function banir($codResp)
	{
		return $this->sql("DELETE from resposta where codResposta=$codResp");
	}
}