<?php
include_once("conexao.php");

class Materia extends Conexao
{
	public function adicionarMateria($novaMateria)
	{
		// Apenas as primeiras letras de cada palavra maiúscula
		$novaMateria = ucwords(strtolower((Trim(preg_replace(array("/(á|à|ã|â|ä)/","/(Á|À|Ã|Â|Ä)/","/(é|è|ê|ë)/","/(É|È|Ê|Ë)/","/(í|ì|î|ï)/","/(Í|Ì|Î|Ï)/","/(ó|ò|õ|ô|ö)/","/(Ó|Ò|Õ|Ô|Ö)/","/(ú|ù|û|ü)/","/(Ú|Ù|Û|Ü)/","/(ñ)/","/(Ñ)/"),explode(" ","a A e E i I o O u U n N"),$novaMateria)))));
		
		if($novaMateria=="")
			return false;

		return $this->sql("INSERT into materia values('$novaMateria')");
	}

	public function todasMaterias()
	{
		return $this->select("SELECT nomeMateria, codMateria FROM materia");
	}

	public function jahExiste($novaMateria)
	{
		$dados = $this->todasMaterias();

		// tira acentos
		$matNova = Trim(preg_replace(array("/(á|à|ã|â|ä)/","/(Á|À|Ã|Â|Ä)/","/(é|è|ê|ë)/","/(É|È|Ê|Ë)/","/(í|ì|î|ï)/","/(Í|Ì|Î|Ï)/","/(ó|ò|õ|ô|ö)/","/(Ó|Ò|Õ|Ô|Ö)/","/(ú|ù|û|ü)/","/(Ú|Ù|Û|Ü)/","/(ñ)/","/(Ñ)/"),explode(" ","a A e E i I o O u U n N"),$novaMateria));
		// deixa maisculo
		$matNova = strtoupper($matNova);
		
		foreach ($dados as $i => $vetor) 
		{
			// tira acentos 
			$matAnt = Trim(preg_replace(array("/(á|à|ã|â|ä)/","/(Á|À|Ã|Â|Ä)/","/(é|è|ê|ë)/","/(É|È|Ê|Ë)/","/(í|ì|î|ï)/","/(Í|Ì|Î|Ï)/","/(ó|ò|õ|ô|ö)/","/(Ó|Ò|Õ|Ô|Ö)/","/(ú|ù|û|ü)/","/(Ú|Ù|Û|Ü)/","/(ñ)/","/(Ñ)/"),explode(" ","a A e E i I o O u U n N"),$vetor['nomeMateria']));
			// deixa maisculo
			$matAnt = strtoupper($matAnt);

			if($matAnt==$matNova)
				return true;
		}

		return false;
	}

	public function nome($codMateria)
	{
		return $this->select("SELECT nomeMateria from materia where codMateria=$codMateria")[0]['nomeMateria'];
	}

	public function pesquisa($texto)
	{
		// tira acentos
		$texto = Trim(preg_replace(array("/(á|à|ã|â|ä)/","/(Á|À|Ã|Â|Ä)/","/(é|è|ê|ë)/","/(É|È|Ê|Ë)/","/(í|ì|î|ï)/","/(Í|Ì|Î|Ï)/","/(ó|ò|õ|ô|ö)/","/(Ó|Ò|Õ|Ô|Ö)/","/(ú|ù|û|ü)/","/(Ú|Ù|Û|Ü)/","/(ñ)/","/(Ñ)/"),explode(" ","a A e E i I o O u U n N"),$texto));
		$texto = str_replace(" ", "%", $texto);
		return $this->select("SELECT codMateria, nomeMateria from materia where nomeMateria like '%$texto%'");
	}

	public function banir($codMat)
	{
		return $this->sql("DELETE from materia where codMateria=$codMat");
	}
}