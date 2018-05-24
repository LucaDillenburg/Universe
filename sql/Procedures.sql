alter proc selecionarPergs1_sp
@nomeMateria varchar(30),
@todasPerguntas bit,
@texto varchar(200),
@nomeUsuario varchar(50),
@qual tinyint
as
	if(@qual=1)
	begin
		SELECT count(c.codPergunta), p.codPergunta from 
		curtida c,
		pergunta p
		where
		c.codPergunta = p.codPergunta and
		p.codPergunta in (select codPergunta from pergunta
		where (assunto like '%'+@texto+'%' or explicacao like '%'+@texto+'%'))
		group by p.codPergunta
		order by count(c.codCurtida) desc
	end
	else if(@qual=2)
	begin
		SELECT count(c.codPergunta), p.codPergunta from 
		curtida c,
		pergunta p
		where
		c.codPergunta = p.codPergunta and
		p.codPergunta in (select codPergunta from pergunta
		where nomeUsuario=@nomeUsuario and 
		(assunto like '%'+@texto+'%' or explicacao like '%'+@texto+'%'))
		group by p.codPergunta
		order by count(c.codCurtida) desc
	end
	else if(@qual=3)
	begin
		SELECT count(c.codPergunta), p.codPergunta from 
		curtida c,
		pergunta p
		where
		c.codPergunta = p.codPergunta and
		p.codPergunta in (select codPergunta from pergunta
		where codMateria=@nomeMateria and 
		(assunto like '%'+@texto+'%' or explicacao like '%'+@texto+'%'))
		group by p.codPergunta
		order by count(c.codCurtida) desc
	end
	else
	begin
		SELECT count(c.codPergunta), p.codPergunta from 
		curtida c,
		pergunta p
		where
		c.codPergunta = p.codPergunta and
		p.codPergunta in (select codPergunta from pergunta
		where codMateria=@nomeMateria and nomeUsuario=@nomeUsuario
		and (assunto like '%'+@texto+'%' or explicacao like '%'+@texto+'%'))
		group by p.codPergunta
		order by count(c.codCurtida) desc
	end;

alter proc selecionarPergs2_sp
@nomeMateria varchar(30),
@todasPerguntas bit,
@texto varchar(200),
@nomeUsuario varchar(50),
@qual tinyint,
@codMaisCurt int
as
	if(@qual=1)
	begin
		SELECT count(c.codPergunta), p.codPergunta from 
		curtida c,
		pergunta p
		where
		c.codPergunta = p.codPergunta and
		p.codPergunta in (select codPergunta from pergunta
		where (assunto like '%'+@texto+'%' or explicacao like '%'+@texto+'%')
		and codPergunta<>@codMaisCurt)
		group by p.codPergunta
		order by count(c.codCurtida) desc
	end
	else if(@qual=2)
	begin
		SELECT count(c.codPergunta), p.codPergunta from 
		curtida c,
		pergunta p
		where
		c.codPergunta = p.codPergunta and
		p.codPergunta in (select codPergunta from pergunta
		where nomeUsuario=@nomeUsuario and 
		(assunto like '%'+@texto+'%' or explicacao like '%'+@texto+'%') and
		codPergunta<>@codMaisCurt)
		group by p.codPergunta
		order by count(c.codCurtida) desc
	end
	else if(@qual=3)
	begin
		SELECT count(c.codPergunta), p.codPergunta from 
		curtida c,
		pergunta p
		where
		c.codPergunta = p.codPergunta and
		p.codPergunta in (select codPergunta from pergunta
		where codMateria=@nomeMateria and 
		(assunto like '%'+@texto+'%' or explicacao like '%'+@texto+'%')
		and codPergunta<>@codMaisCurt)
		group by p.codPergunta
		order by count(c.codCurtida) desc
	end
	else
	begin
		SELECT count(c.codPergunta), p.codPergunta from 
		curtida c,
		pergunta p
		where
		c.codPergunta = p.codPergunta and
		p.codPergunta in (select codPergunta from pergunta
		where codMateria=@nomeMateria and nomeUsuario=@nomeUsuario
		and (assunto like '%'+@texto+'%' or explicacao like '%'+@texto+'%')
		and codPergunta<>@codMaisCurt)
		group by p.codPergunta
		order by count(c.codCurtida) desc
	end;


alter proc selecionarPergs3_sp
@nomeMateria varchar(30),
@todasPerguntas bit,
@texto varchar(200),
@nomeUsuario varchar(50),
@qual tinyint,
@codMaisCurt int,
@codSegMaisCurt int
as
	if(@qual=1)
	begin
		SELECT codPergunta, data FROM pergunta WHERE 
		(assunto like '%'+@texto+'%' or explicacao like '%'+@texto+'%') and 
		codPergunta<>@codMaisCurt and codPergunta<>@codSegMaisCurt
		order by data desc
	end
	else if(@qual=2)
	begin
		SELECT codPergunta, data FROM pergunta WHERE 
		nomeUsuario=@nomeUsuario and 
		(assunto like '%'+@texto+'%' or explicacao like '%'+@texto+'%') and 
		codPergunta<>@codMaisCurt and codPergunta<>@codSegMaisCurt
		order by data desc
	end
	else if(@qual=3)
	begin
		SELECT codPergunta, data FROM pergunta WHERE 
		codMateria=@nomeMateria and 
		(assunto like '%'+@texto+'%' or explicacao like '%'+@texto+'%') and 
		codPergunta<>@codMaisCurt and codPergunta<>@codSegMaisCurt
		order by data desc
	end
	else
	begin
		SELECT codPergunta, data FROM pergunta WHERE 
		codMateria=@nomeMateria and nomeUsuario=@nomeUsuario
		and (assunto like '%'+@texto+'%' or explicacao like '%'+@texto+'%') and 
		codPergunta<>@codMaisCurt and codPergunta<>@codSegMaisCurt
		order by data desc
	end;



















alter proc inserirMateria_sp 
@nomeMateria varchar(30)
as
INSERT into materia values(@nomeMateria)

create proc inserirPergunta_sp 
@nomeUsuario varchar(50), 
@assunto     varchar(75), 
@explicacao  ntext, 
@codMateria  int, 
@data        datetime, 
@receberEmailSempre tinyint
as
INSERT INTO pergunta VALUES(@nomeUsuario, @assunto, @explicacao, @codMateria, 
@data, @receberEmailSempre, 0)






create proc inserirResposta_sp 
@codPergunta int,
@nomeRespondeu varchar(50),
@resposta ntext,
@dataResposta datetime
as
INSERT INTO resposta VALUES(@codPergunta, @nomeRespondeu, @resposta, @dataResposta, 0)


create proc usuarioExiste_sp 
@nomeUsuario varchar(50)
as
SELECT * from usuario where nomeUsuario=@nomeUsuario

create proc senhaDeUsuario_sp
@nomeUsuario varchar(50)
as
SELECT senha FROM usuario WHERE nomeUsuario=@nomeUsuario

alter proc cadastrar_sp 
@nomeUsuario varchar(50), 
@primeiroNome varchar(15), 
@sobrenome varchar(35), 
@email varchar(50), 
@senhaCrip varchar(256)
as
INSERT INTO usuario VALUES (@nomeUsuario, @primeiroNome, @sobrenome, @email, @senhaCrip)


create proc pesquisarUsuario_sp
@texto varchar(200)
as
SELECT nomeUsuario, email from usuario where nomeUsuario like '%'+@texto+'%'


create proc pesquisarMat_sp 
@texto varchar(50)
as
SELECT codMateria, nomeMateria from materia where nomeMateria like '%'+@texto+'%'