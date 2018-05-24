<link rel="stylesheet" type="text/css" href="visual.css">
<?php
class Visual
{
	protected $pergunta;

	public function __construct()
	{
		include_once("Pergunta.php");
		$this->pergunta = new Pergunta();
	}

	public function tabelaPergTudo($assunto, $explicacao, $codMateria, $materia, $data, $cod, $usuario, $site, $siteHome, $maisCurtida, $curtidas, $curtiu, $motivoMat, $motivoUs)
	{
		echo "<hr>";
		$nomeUsuario = $_SESSION['usuario'];
		if(strtoupper($usuario)==strtoupper($nomeUsuario))
		{
			if($maisCurtida)
				echo "<table border='5px' style='color:blue'>";
			else
				echo "<table border='1px' style='color:blue'>";
			$qts = $this->pergunta->qtsResp($cod);
			echo "<tr class='deCima'><th class='assunto' colspan=9> $assunto </th>  <th colspan=1 style='color: blue'> $qts </th></tr>";
		}else
		{
			if($maisCurtida)
				echo "<table border='5px'>";
			else
				echo "<table border='1px'>";
			echo "<tr><th colspan=10> $assunto </th></tr>";
		}
		echo "<tr><td colspan=3> <a class='nome' href='".$siteHome."Pesquisar/Usuario/feedUsuario.php?nomeUsuario=$usuario'> ";
		if($motivoUs)
			echo "<b>$usuario</b>";
		else
			echo "$usuario";
		echo " </a> </td>";
		
		echo "<td colspan=7 rowspan=2> $explicacao </td></tr>";

		echo "<tr><td colspan=3> <a class='nome' href='".$siteHome."Pesquisar/Materia/feedMateria.php?codMateria=$codMateria'> ";
		if($motivoMat)
			echo "<b>$materia</b>";
		else
			echo "$materia"; 
		echo " </a>, $data </td></tr>";

		echo "</table>";

		echo "<label class='curtida'>Curtidas: $curtidas </label>";

		if($nomeUsuario!="")
		{
			if(!$curtiu)
				echo "<a class='follow' href='".$siteHome."procedimentos/curtir.php?codPerg=$cod&nomeUsuario=$nomeUsuario&site=$site&curtir=1'> Curtir </a>";
			else
				echo "<a class='unfollow' href='".$siteHome."procedimentos/curtir.php?codPerg=$cod&nomeUsuario=$nomeUsuario&site=$site&curtir=0'> Descurtir </a>";
		}

		echo "<a class='verResp' href='".$siteHome."Pesquisar/Resposta/index.php?codPergunta=$cod'> Ver respostas </a>";

				echo "<br>";

		if(strtoupper($usuario)==strtoupper($_SESSION['usuario']))
			echo "<br><a class='unfollow' href='".$siteHome."procedimentos/apagarPergunta.php?codPergunta=$cod&site=$site'> APAGAR PERGUNTA </a>";

		echo "<br>";
	}

	//																								  usuario que fez a pergunta
	public function tabelaRespTudo($codResp, $resposta, $data, $nomeRespondeu, $codMateria, $materia, $usuario, $site, $siteHome)
	{
		if($nomeRespondeu==$usuario)
			echo "<table border='1px' style='color:blue'>";
		else
			if($nomeRespondeu==$_SESSION['usuario'])
				echo "<table border='1px' style='color: blue'>";
			else
				echo "<table border='1px'>";

		echo "<tr><td colspan=10 rowspan=2 class='aResposta'> $resposta </td><td colspan=3 class='data'> $data </td> </tr>";
		echo "<tr><td colspan=3 id='nome' class='nome'> <a class='nome' href='".$siteHome."Pesquisar/Usuario/feedUsuario.php?nomeUsuario=$nomeRespondeu'> $nomeRespondeu  </a> </td></tr>"; 
		echo "</table>";

		// usuário é quem perguntou
		if($_SESSION['usuario']==$usuario)
		{
			// comentario do usuário
			if($_SESSION['usuario']==$nomeRespondeu)
				echo "<a class='unfollow' href='".$siteHome."procedimentos/apagarResp.php?codResp=$codResp&site=$site'> Apagar Seu Comentário </a>";
			else
			{
				echo "<a class='unfollow' href='".$siteHome."procedimentos/apagarResp.php?codResp=$codResp&site=$site'> Apagar Resposta </a><br>";

				include_once("resposta.php");
				$resposta = new Resposta();

				if(!$resposta->ehMelhorResp($codResp) && $usuario!=$nomeRespondeu)
					echo "<a class='verResp' href='".$siteHome."procedimentos/melhorResp.php?codResp=$codResp&site=$site'> Melhor Resposta </a>";
			}
		}/*else
			// usuário respondeu e quer apagar a resposta
			if($_SESSION['usuario']==$nomeRespondeu)
				echo "<a href='".$siteHome."procedimentos/apagarResp.php?codResp=$codResp&site=$site'> Apagar Sua Resposta </a><hr>";*/
		echo "<br>";
	}
}
?>