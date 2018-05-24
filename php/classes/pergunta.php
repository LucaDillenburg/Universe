<?php
include_once("conexao.php");

class Pergunta extends Conexao
{
	public function adicionarPergunta($nomeUsuario, $assunto, $explicacao, $codMateria, $data, $receberEmailSempre)
	{
		$assunto = Trim(ucfirst($assunto));
		$explicacao = Trim(ucfirst($explicacao));
		return $this->sql("INSERT INTO pergunta VALUES('$nomeUsuario', '$assunto', '$explicacao', $codMateria, '$data', $receberEmailSempre, 0)");
	}

	public function apagar($codPerg)
	{
		// apagar respostas
		$apagarResp = $this->sql("DELETE FROM resposta WHERE codPergunta=$codPerg");

		if(!$apagarResp)
			return false;

		return $this->sql("DELETE FROM pergunta WHERE codPergunta=$codPerg");
	}

	public function usuarioViu($codPergunta)
	{
		return $this->sql("UPDATE pergunta SET quantasRespostas=0 WHERE codPergunta=$codPergunta");
	}


// informacoes respostas
	public function selCods($materia, $todasPerguntas, $texto, $nomeUs)
	{
		$texto = Trim(preg_replace(array("/(á|à|ã|â|ä)/","/(Á|À|Ã|Â|Ä)/","/(é|è|ê|ë)/","/(É|È|Ê|Ë)/","/(í|ì|î|ï)/","/(Í|Ì|Î|Ï)/","/(ó|ò|õ|ô|ö)/","/(Ó|Ò|Õ|Ô|Ö)/","/(ú|ù|û|ü)/","/(Ú|Ù|Û|Ü)/","/(ñ)/","/(Ñ)/"),explode(" ","a A e E i I o O u U n N"),$texto));

		$qual = 0;
		if($materia==0) //todas as materias
		{
			if($todasPerguntas)
				$qual=1;
			else
				$qual=2;
		}else
			if($todasPerguntas)
				$qual=3;
			else
				$where=4;

		if($todasPerguntas)
			$todasPerguntas='true';
		else
			$todasPerguntas='false';


		$pergMaisCurtida = $this->select("
			selecionarPergs1_sp '$materia', $todasPerguntas, '$texto', '$nomeUs', $qual");

		// VERIFICAR
		$codMaisCurt = -1;
		if($pergMaisCurtida)
		{
			$codMaisCurt = $pergMaisCurtida[0]['codPergunta'];
			$vetor[0] = $codMaisCurt;
		}

		$segPergMaisCurtidas = $this->select("
			selecionarPergs2_sp '$materia', $todasPerguntas, '$texto', '$nomeUs', $qual, $codMaisCurt");

		// VERIFICAR
		$codSegCurt = -1;
		if($segPergMaisCurtidas)
		{
			$codSegCurt = $segPergMaisCurtidas[0]['codPergunta'];
			$vetor[1] = $codSegCurt;
		}

		$resto = $this->select("
			selecionarPergs3_sp '$materia', $todasPerguntas, '$texto', '$nomeUs', $qual, $codMaisCurt, $codSegCurt");

		if(!$resto)
		{
			if($codMaisCurt==-1)
				return false;
			$vetor[0] = $codMaisCurt;

			if($codSegCurt==-1)
				return $vetor;
			$vetor[1] = $codSegCurt;
			return $vetor;
		}

		foreach ($resto as $i => $info) 
			$vetor[$i+2] = $info['codPergunta'];

		return $vetor;
	}

	public function selPergPorCod($codPergunta)
	{
		$status = $this->select("SELECT nomeUsuario, assunto, explicacao, data, codMateria FROM pergunta WHERE codPergunta=$codPergunta");

		if($status==false)
			return false;

		return $status[0];
	}


// curtidas
	public function curtir($codPerg, $nomeUsuario)
	{
		$status = $this->select("SELECT * from curtida where nomeCurtiu=$nomeUsuario and codPergunta=$codPerg");

		if($status)
			return false;
		
		return $this->sql("INSERT into curtida values('$nomeUsuario', $codPerg)");
	}

	public function descurtir($codPerg, $nomeUsuario)
	{
		$status = $this->select("SELECT * from curtida where nomeCurtiu='$nomeUsuario' and codPergunta=$codPerg");

		if(!$status)
			return false;
		
		return $this->sql("DELETE FROM curtida where nomeCurtiu='$nomeUsuario' and codPergunta=$codPerg");
	}

	public function curtidas($cod)
	{
		$status = $this->select("SELECT count(codCurtida) as curtidas from curtida where codPergunta=$cod");

		if(!$status)
			return 0;
		return $status[0]['curtidas'];
	}

	public function usuarioCurtiu($cod, $nomeUsuario)
	{
		$status = $this->select("SELECT * from curtida where codPergunta=$cod and nomeCurtiu='$nomeUsuario'");
		if(!$status)
			return false;
		return true;
	}


// materia
	public function materia($codPergunta)
	{
		$status = $this->select("SELECT nomeMateria FROM materia WHERE codMateria in(
			SELECT codMateria FROM pergunta WHERE codPergunta=$codPergunta)");

		if($status==false)
			return false;

		return $status[0]['nomeMateria'];
	}


// respostas
	public function qtsResp($codPergunta)
	{
		$status = $this->select("SELECT quantasRespostas FROM pergunta WHERE codPergunta=$codPergunta");

		if($status==false)
			return false;

		return $status[0]['quantasRespostas'];
	}

	public function selPergRespUsuario($nomeUsuario)
	{
		return $this->select("SELECT distinct(codPergunta), data FROM pergunta WHERE codPergunta in(SELECT codPergunta FROM resposta WHERE nomeRespondeu='$nomeUsuario')order by data desc");
	}

	public function enviarEmailSempre($codPerg)
	{
		return $this->select("SELECT receberSempre from pergunta where codPergunta=$codPerg");
	}

	public function banir($codPerg)
	{
		return $this->sql("DELETE from pergunta where codPergunta=$codPerg");
	}
}
?>