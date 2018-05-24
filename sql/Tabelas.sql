create table usuario(
nomeUsuario varchar(50) primary key,
primeiroNome varchar(20) not null,
sobrenome varchar(35) not null,
email varchar(50) not null,
senha varchar(256) not null
)

create table materia(
codMateria int identity(1,1) primary key,
nomeMateria varchar(30) not null
)

create table pergunta(
codPergunta int identity(1,1) primary key,
nomeUsuario varchar(50) not null,
assunto varchar(75) not null,
explicacao ntext not null,
codMateria int not null,
data datetime not null,
receberSempre bit not null,
quantasRespostas int not null,

constraint fkUsuario foreign key (nomeUsuario) references usuario(nomeUsuario),
constraint fkMateria foreign key (codMateria)  references materia(codMateria)
)

create table resposta(
codResposta int identity(1,1) primary key,
codPergunta int not null,
nomeRespondeu varchar(50) not null,
resposta ntext not null,
dataResposta datetime not null,
melhorResposta bit not null

constraint fkPergunta foreign key (codPergunta) references pergunta(codPergunta),
constraint fkUsuario2 foreign key (nomeRespondeu) references usuario(nomeUsuario)
)

create table seguirPessoa(
codSeguirPessoas int identity(1,1) primary key,
nomeUsuario varchar(50) not null,
nomeOutroUsuario varchar(50) not null
CONSTRAINT fkUsuario3 FOREIGN KEY (nomeUsuario) REFERENCES usuario(nomeUsuario),
CONSTRAINT fkOutroUs FOREIGN KEY (nomeOutroUsuario) REFERENCES usuario(nomeUsuario)
)

create table seguirMateria(
codSeguirPessoas int identity(1,1) primary key,
nomeUsuario varchar(50) not null,
codMateria int not null
CONSTRAINT fkUsuario4 FOREIGN KEY (nomeUsuario) REFERENCES usuario(nomeUsuario),
CONSTRAINT fkMateria2 FOREIGN KEY (codMateria) REFERENCES materia(codMateria)
)

create table curtida(
codCurtida int identity(1,1) primary key,
nomeCurtiu varchar(50) not null,
codPergunta int not null
constraint fkNomeCurtiu foreign key(nomeCurtiu) references usuario(nomeUsuario),
constraint fkCodPerg foreign key(codPergunta) references pergunta(codPergunta)
)