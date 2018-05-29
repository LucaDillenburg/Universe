<?php
include_once("conexao.php");

class Usuario extends Conexao
{
	public function usuarioValido($nomeUsuario)
	{
		if($nomeUsuario=="")
			return false;
		
		$nomesUs = $this->select("SELECT nomeUsuario from usuario");

		if(!$nomesUs)
			return true;
		
		$nomeUsuario = strtoupper(preg_replace(array("/(á|à|ã|â|ä)/","/(Á|À|Ã|Â|Ä)/","/(é|è|ê|ë)/","/(É|È|Ê|Ë)/","/(í|ì|î|ï)/","/(Í|Ì|Î|Ï)/","/(ó|ò|õ|ô|ö)/","/(Ó|Ò|Õ|Ô|Ö)/","/(ú|ù|û|ü)/","/(Ú|Ù|Û|Ü)/","/(ñ)/","/(Ñ)/"),explode(" ","a A e E i I o O u U n N"), $nomeUsuario));

		foreach ($nomesUs as $nomeAtual) 
		{
			$nome = strtoupper(preg_replace(array("/(á|à|ã|â|ä)/","/(Á|À|Ã|Â|Ä)/","/(é|è|ê|ë)/","/(É|È|Ê|Ë)/","/(í|ì|î|ï)/","/(Í|Ì|Î|Ï)/","/(ó|ò|õ|ô|ö)/","/(Ó|Ò|Õ|Ô|Ö)/","/(ú|ù|û|ü)/","/(Ú|Ù|Û|Ü)/","/(ñ)/","/(Ñ)/"),explode(" ","a A e E i I o O u U n N"), $nomeAtual['nomeUsuario']));
			if($nomeUsuario==$nome)
				return false;
		}

		return true;
	}

	public function usuarioExiste($nomeUsuario)
	{
		if($this->select("SELECT * from usuario where nomeUsuario='$nomeUsuario'")==false)
			return false;
		else
			return true;
	}

	public function senhaCorreta($senha, $usuario)
	{
		$dados = $this->select("SELECT senha FROM usuario WHERE nomeUsuario='$usuario'");
		$senhaCrip = $dados[0]['senha'];

		return password_verify($senha, $senhaCrip); 
	}	

	public function email($nomeUsuario)
	{
		$dados = $this->select("SELECT email from usuario where nomeUsuario='$nomeUsuario'");
		if($dados==false)
			return false;
		return $dados[0]['email'];
	}

	public function logar($nomeUsuario)
	{
		$_SESSION['usuario'] = strtoupper($nomeUsuario);
	}


	public function senhaForte($senha)
	{
		return preg_match("/^.*(?=.{8,})(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).*$/", $senha);
	}

	public function cadastrar($nomeUsuario, $primeiroNome, $sobrenome, $email, $senha1)
	{
		// deixa minuscula e sem acento
		$nomeUsuario = strtoupper(preg_replace(array("/(á|à|ã|â|ä)/","/(Á|À|Ã|Â|Ä)/","/(é|è|ê|ë)/","/(É|È|Ê|Ë)/","/(í|ì|î|ï)/","/(Í|Ì|Î|Ï)/","/(ó|ò|õ|ô|ö)/","/(Ó|Ò|Õ|Ô|Ö)/","/(ú|ù|û|ü)/","/(Ú|Ù|Û|Ü)/","/(ñ)/","/(Ñ)/"),explode(" ","a A e E i I o O u U n N"), $nomeUsuario));
		$email = strtoupper($email);
		$senhaCrip = password_hash($senha1, 1);

		$primeiroNome = ucwords($primeiroNome);
		$sobrenome = ucwords($sobrenome);
		return $this->sql("INSERT INTO usuario VALUES ('$nomeUsuario', '$primeiroNome', '$sobrenome', '$email', '$senhaCrip')");
	}

	public function novasRespostas($usuario)
	{
		$dados = $this->select("SELECT sum(quantasRespostas) as soma FROM pergunta WHERE nomeUsuario='$usuario'");

		return $dados[0]['soma'];
	}

	public function pesquisa($texto)
	{
		// tira acentos
		$texto = Trim(preg_replace(array("/(á|à|ã|â|ä)/","/(Á|À|Ã|Â|Ä)/","/(é|è|ê|ë)/","/(É|È|Ê|Ë)/","/(í|ì|î|ï)/","/(Í|Ì|Î|Ï)/","/(ó|ò|õ|ô|ö)/","/(Ó|Ò|Õ|Ô|Ö)/","/(ú|ù|û|ü)/","/(Ú|Ù|Û|Ü)/","/(ñ)/","/(Ñ)/"),explode(" ","a A e E i I o O u U n N"),$texto));
		$texto = str_replace(" ", "%", $texto);
		return $this->select("SELECT nomeUsuario, email from usuario where nomeUsuario like '%$texto%'");
	}


	public function feed($usuario)
	{
		$feed = $this->select("SELECT codPergunta, nomeUsuario, assunto, explicacao, codMateria, data, receberSempre,
		 quantasRespostas from pergunta where (codMateria in(select codMateria from seguirMateria where 
		 	nomeUsuario='$usuario')  or nomeUsuario in(select nomeOutroUsuario from seguirUsuario where 
		 	nomeUsuario='$usuario')) and nomeUsuario<>'$usuario' order by data desc");

		if(!$feed)
			return false;

		foreach($feed as $i => $vetor) 
		{
			$feed[$i]['motivoMat'] = $this->segueMateria($_SESSION['usuario'], $vetor['codMateria']);
			$feed[$i]['motivoUs']  = $this->segueUsuario($_SESSION['usuario'], $vetor['nomeUsuario']);
		}

		return $feed;
	}


	public function segueUsuario($usuario1,$usuario2)
	{
		$status = $this->select("SELECT * FROM seguirUsuario WHERE nomeUsuario =  '$usuario1' and nomeOutroUsuario = '$usuario2'");

		if(!$status)
			return false;
		else
			return true;
	}

	public function segueMateria($usuario, $codMateria)
	{
		$status = $this->select("SELECT * FROM seguirMateria WHERE nomeUsuario = '$usuario' and codMateria=$codMateria");

		if(!$status)
			return false;
		else
			return true;
	}

	public function seguirUsuario($usuario1, $usuario2)
	{
		return $this->sql("INSERT INTO seguirUsuario values('$usuario1','$usuario2')");
	}

	public function desseguirUsuario($usuario1, $usuario2)
	{
		return $this->sql("DELETE FROM seguirUsuario where nomeUsuario='$usuario1' and nomeOutroUsuario='$usuario2'");
	}

	public function seguirMateria($usuario, $codMateria)
	{
		return $this->sql("INSERT INTO seguirMateria values('$usuario',$codMateria)");
	}

	public function desseguirMateria($usuario, $codMateria)
	{
		return $this->sql("DELETE FROM seguirMateria where nomeUsuario='$usuario' and codMateria=$codMateria");
	}

	public function nomeCompleto($usuario)
	{
		$status = $this->select("SELECT primeiroNome, sobrenome from usuario where nomeUsuario='$usuario'");

		if(!$status)
			return false;

		$primeiroNome = $status[0]['primeiroNome'];
		$sobrenome    = $status[0]['sobrenome']; 
		return $primeiroNome." ".$sobrenome;
	}

	public function banir($nomeUsuario)
	{
		return $this->sql("DELETE from usuario where nomeUsuario='$nomeUsuario'");
	}
}
?>


<!-- public function feed($usuario)
	{
		$feedMateria = $this->select("SELECT codPergunta, nomeUsuario, assunto, explicacao, codMateria, data, receberSempre, quantasRespostas from pergunta where codMateria in(select codMateria from seguirMateria where nomeUsuario='$usuario') order by data desc");
		$feedUsuario = $this->select("SELECT codPergunta, nomeUsuario, assunto, explicacao, codMateria, data, receberSempre, quantasRespostas from pergunta where nomeUsuario in(select nomeOutroUsuario from seguirUsuario where nomeUsuario='$usuario') order by data desc");

		$iMat = 0;
		$iUs  = 0;

		$vetor[][]= null;
		$i = 0;

		echo "materia: <br>";
		print_r($feedMateria);
		echo "<br> SizeOf: ".sizeof($feedMateria)."<br><br>";
		echo "Usuario: <br>";
		print_r($feedUsuario);
		echo "<br> SizeOf: ".sizeof($feedUsuario)."<br><br><br>";

		if($feedMateria && $feedUsuario)
		{
			while($iMat<=sizeof($feedMateria)-1 && $iUs<=sizeof($feedUsuario)-1)
			{
				echo "i: $iMat     <=   ultimo: ".(sizeof($feedMateria)-1)."<br>";
				echo "i: $iUs     <=   ultimo: ".(sizeof($feedUsuario)-1)."<br>";

				$dataMat = $feedMateria[$iMat]['data'];
				// $dataMat = strtotime('d F Y H\h', $feedMateria[$iMat]['data']);
				$dataUs  = $feedUsuario[$iUs]['data'];
				// $dataUs  = strtotime('d F Y H\h', $feedUsuario[$iUs]['data']);

				$hey = $dataMat->format('Y-m-d H:i:s');
				$ola = $dataUs->format('Y-m-d H:i:s');
				

				if($dataMat<$dataUs)
				{
					echo "$hey < $ola <br><br>";
					$vetor[$i]['motivoMat'] = true;
					$vetor[$i]['motivoUs']  = false;
					$vetor[$i] = $feedMateria[$iMat];
					$iMat++;
				}
				else
					if($dataMat>$dataUs)
					{
						echo "$hey > $ola <br><br>";
						$vetor[$i]['motivoMat'] = false;
						$vetor[$i]['motivoUs']  = true;
						$vetor[$i] = $feedUsuario[$iUs];
						$iUs++;
					}else
					{
						echo "$hey == $ola <br><br>";
						if($feedMateria[$iMat]['codPergunta']== $feedUsuario[$iUs]['codPergunta'])
						{
							$vetor[$i]['motivoMat'] = true;
							$vetor[$i]['motivoUS']  = true;
							$vetor[$i] = $feedUsuario[$iUs];
							$iUs++;
							$iMat++;
						}else
						{
							$vetor[$i] = $feedUsuario[$iUs];
							$vetor[$i]['motivoUS']  = true;
							$vetor[$i]['motivoMat'] = false;
							$iUs++;
							$i++;

							$vetor[$i] = $feedMateria[$iMat];
							$vetor[$i]['motivoMat'] = true;
							$vetor[$i]['motivoUs']  = false;
							$iMat++;
						}					
					}
				$i++;
			}

			if($iMat<=sizeof($feedMateria)-1)
			{
				for($indice=$iMat; $indice<=sizeof($feedMateria)-1; $indice++)
				{
					$vetor[$i] = $feedMateria[$indice];
					$vetor[$i]['motivoMat'] = true;
					$vetor[$i]['motivoUs']  = false;
					$i++;
				}
			}else if($iUs<=sizeof($feedUsuario)-1)
			{
				for($indice=$iUs; $indice<=sizeof($feedUsuario)-1; $indice++)
				{
					$vetor[$i] = $feedUsuario[$indice];
					$vetor[$i]['motivoMat'] = false;
					$vetor[$i]['motivoUs']  = true;
					$i++;
				}
			}

			print_r($vetor);
			return $vetor;
		}

		if($feedMateria)
		{
			foreach($feedMateria as $vetor) 
			{
				$vetor['motivoMat'] = true;
				$vetor['motivoUs']  = false;
			}
			return $feedMateria;
		}

		if($feedUsuario)
		{
			foreach($feedUsuario as $vetor) 
			{
				$vetor['motivoMat'] = false;
				$vetor['motivoUs']  = true;
			}
			return $feedUsuario;
		}

		// os dois sao nulos
		return false;
	} -->