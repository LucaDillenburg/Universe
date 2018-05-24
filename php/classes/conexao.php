<?php
class Conexao
{
	protected $conexao;
	protected $servidor = "regulus.cotuca.unicamp.br";
	protected $username = "BDPPI17191";
	protected $senha = "projetoppitudojuntominusculo";
	protected $base = "BDPPI17191";

	public function __construct()
	{
		$InfConexao = array("Database"=>$this->base,"PWD"=>$this->senha,"UID"=>$this->username);

		$aux = 1;
		if($this->conexao = sqlsrv_connect($this->servidor, $InfConexao))
			$aux = 2;
		else
			exit("Falha na conexão");
	}

	public function __destruct()
	{
		sqlsrv_close($this->conexao);
	}

	public function select($sql)
	{
	  	$status = sqlsrv_query($this->conexao,$sql);

	  	if(!$status)
	  		return false;

	  	$dados = false;
   		while ($linha = sqlsrv_fetch_array($status, SQLSRV_FETCH_ASSOC)) 
		{
			$dados[] = $linha;
		}
		return $dados; 
		// $dados[numeroRegistro][numeroCampo]
	}

	public function mostrarTudo($tabela)
	{
		$dados = $this->select("SELECT * FROM $tabela");
		foreach ($dados as $i => $x) 
		{
			echo "$x, ";
		}
	}

	public function sql($sql)
	{
		// Executar a instrução SQL
		return $this->status = sqlsrv_query($this->conexao, $sql);
	}
}