
-- Cria o banco de dados
--CREATE DATABASE darthscm OWNER sithsolutions TEMPLATE template1 ENCODING 'UTF8';

-- Cria dominios
CREATE DOMAIN d_sexo CHAR CHECK (UPPER(VALUE) IN ('M', 'F') );
CREATE DOMAIN d_pri_grav VARCHAR(6) CHECK (UPPER(VALUE) IN ('MAXIMA', 'ALTA', 'NORMAL', 'BAIXA', 'MINIMA') );
CREATE DOMAIN d_papel VARCHAR(11) CHECK (UPPER(VALUE) IN ('COLABORADOR', 'GERENTE') );
CREATE DOMAIN d_estado_sol VARCHAR(10) CHECK (UPPER(VALUE) IN ('APROVADO', 'RECUSADO', 'SOLICITADO') );
CREATE DOMAIN d_estado_aud VARCHAR(8) CHECK (UPPER(VALUE) IN ('APROVADO', 'RECUSADO') );
CREATE DOMAIN d_estado_br VARCHAR(2) CHECK (UPPER(VALUE) IN ('BA', 'AC', 'AL', 'AP', 'AM', 'CE', 'DF', 'ES', 'GO', 'MA', 'MT', 'MS', 'MG', 'PA', 'PB', 'PR', 'PE', 'PI', 'RJ', 'RN', 'RS', 'RO', 'RR', 'SC', 'SP', 'SE', 'TO') );

-- -----------------------------------------------------
-- Tabela Enderecos
-- -----------------------------------------------------
CREATE TABLE Enderecos (
  idEndereco SERIAL ,
  rua VARCHAR(100) NOT NULL ,
  num INT NOT NULL ,
  bairro VARCHAR(100) NOT NULL ,
  cidade VARCHAR(100) NOT NULL ,
  estado d_estado_br NOT NULL ,
  complemento VARCHAR(100),
  PRIMARY KEY (idEndereco) )
;

-- -----------------------------------------------------
-- Tabela Usuarios
-- -----------------------------------------------------
CREATE TABLE Usuarios (
  idUsuario SERIAL ,
  nome VARCHAR(200) NOT NULL ,
  email VARCHAR(100) NOT NULL ,
  cpf VARCHAR(11) NOT NULL ,
  dataNasc DATE NOT NULL ,
  telefone VARCHAR(10) NOT NULL ,
  endereco INT NOT NULL ,
  admin BOOLEAN NOT NULL DEFAULT FALSE,
  sexo d_sexo NOT NULL ,
  PRIMARY KEY (idUsuario),
  UNIQUE (cpf),
  UNIQUE (email),
  CONSTRAINT fk_usuarios_enderecos
    FOREIGN KEY (endereco)
    REFERENCES Enderecos (idEndereco )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
;

-- -----------------------------------------------------
-- Tabela RedefinirSenha
-- -----------------------------------------------------
CREATE  TABLE RedefinirSenha (
  hash VARCHAR(45) NOT NULL,
  idUsuario INT NOT NULL,
  expirado BOOLEAN NOT NULL DEFAULT FALSE,
  PRIMARY KEY (hash),
  CONSTRAINT fk_redefinir_senha_usuarios
    FOREIGN KEY (idUsuario)
    REFERENCES Usuarios (idusuario)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
);


-- -----------------------------------------------------
-- Tabela Repositorios
-- -----------------------------------------------------
CREATE  TABLE Repositorios (
  idRepositorio SERIAL ,
  endereco VARCHAR(300) NOT NULL ,
  nome VARCHAR(100) NOT NULL ,
  conta VARCHAR(45) NOT NULL ,
  PRIMARY KEY (idRepositorio) )
;


-- -----------------------------------------------------
-- Tabela Projetos
-- -----------------------------------------------------
CREATE  TABLE Projetos (
  idProjeto SERIAL ,
  nome VARCHAR(45) NOT NULL ,
  descricao VARCHAR(500),
  dataInicio DATE NOT NULL ,
  dataPrevFim DATE NOT NULL ,
  dataFim DATE,
  idRepositorio INT NOT NULL ,
  PRIMARY KEY (idProjeto) ,
  UNIQUE (nome) ,
  CONSTRAINT fk_projetos_repositorio_github1
    FOREIGN KEY (idRepositorio)
    REFERENCES Repositorios (idRepositorio)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
;

-- -----------------------------------------------------
-- Tabela UsuarioTrabalhaEmProjeto
-- -----------------------------------------------------
CREATE  TABLE UsuarioTrabalhaEmProjeto (
  idUsuario INT NOT NULL,
  idProjeto INT NOT NULL,
  papel d_papel NOT NULL ,
  dataInicio TIMESTAMP NOT NULL ,
  dataFim TIMESTAMP ,
  PRIMARY KEY (idUsuario, idprojeto) ,
  CONSTRAINT fk_usuarios_has_projetos_usuarios
    FOREIGN KEY (idUsuario )
    REFERENCES Usuarios (idUsuario )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT fk_usuarios_has_projetos_projetos1
    FOREIGN KEY (idProjeto )
    REFERENCES Projetos (idprojeto )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION )
;


-- -----------------------------------------------------
-- Tabela Mensagens
-- -----------------------------------------------------
CREATE  TABLE Mensagens (
  idMensagem SERIAL ,
  remetente INT NOT NULL ,
  assunto VARCHAR(200) DEFAULT '(sem assunto)' ,
  conteudo VARCHAR(500) NOT NULL ,
  dataHora TIMESTAMP NOT NULL ,
  lixeira BOOLEAN NOT NULL DEFAULT FALSE,
  excluida BOOLEAN NOT NULL DEFAULT FALSE,
  PRIMARY KEY (idMensagem, remetente) ,
  CONSTRAINT fk_mensagens_usuarios1
    FOREIGN KEY (remetente )
    REFERENCES Usuarios (idUsuario )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
;


-- -----------------------------------------------------
-- Tabela destinatarios
-- -----------------------------------------------------
CREATE  TABLE destinatarios (
  idMensagem INT NOT NULL ,
  remetente INT NOT NULL ,
  destinatario INT NOT NULL ,
  msglida BOOLEAN NOT NULL DEFAULT FALSE ,
  lixeira BOOLEAN NOT NULL DEFAULT FALSE,
  excluida BOOLEAN NOT NULL DEFAULT FALSE,
  PRIMARY KEY (idMensagem, remetente, destinatario) ,
  CONSTRAINT fk_mensagens_has_usuarios_mensagens1
    FOREIGN KEY (idMensagem , remetente )
    REFERENCES mensagens (idMensagem , remetente )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT fk_mensagens_has_usuarios_usuarios1
    FOREIGN KEY (destinatario )
    REFERENCES Usuarios (idUsuario )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
;


-- -----------------------------------------------------
-- Tabela login
-- -----------------------------------------------------
CREATE  TABLE Login (
  idLogin SERIAL,
  idUsuario INT NOT NULL ,
  login VARCHAR(45) NOT NULL ,
  senha VARCHAR(40) NOT NULL ,
  PRIMARY KEY (idLogin, idUsuario) ,
  UNIQUE (login) ,
  CONSTRAINT fk_login_usuarios1
    FOREIGN KEY (idUsuario )
    REFERENCES Usuarios (idUsuario )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
;


-- -----------------------------------------------------
-- Tabela github
-- -----------------------------------------------------
CREATE  TABLE ContaGitHub (
  idContaGitHub SERIAL ,
  idUsuario INT NOT NULL ,
  username VARCHAR(45) NOT NULL ,
  senha VARCHAR(10) NOT NULL ,
  PRIMARY KEY (idContaGitHub, idUsuario) ,
  UNIQUE (username ) ,
  CONSTRAINT fk_github_usuarios1
    FOREIGN KEY (idUsuario )
    REFERENCES Usuarios (idUsuario )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
;


-- -----------------------------------------------------
-- Tabela Tarefas
-- -----------------------------------------------------
CREATE  TABLE Tarefas (
  idTarefa SERIAL ,
  idProjeto INT NOT NULL ,
  nome VARCHAR(100) NOT NULL ,
  descricao VARCHAR(500) ,
  dataInicio DATE NOT NULL ,
  dataPrevFim DATE NOT NULL ,
  dataFim DATE ,
  prioridade d_pri_grav NOT NULL DEFAULT 'NORMAL' ,
  idSuperTarefa INT ,
  idProjetoSuperTarefa INT ,
  PRIMARY KEY (idTarefa, idProjeto) ,
  CONSTRAINT fk_tarefas_projetos1
    FOREIGN KEY (idProjeto )
    REFERENCES Projetos (idProjeto )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT fk_tarefas_tarefas1
    FOREIGN KEY (idSuperTarefa, idProjetoSuperTarefa )
    REFERENCES Tarefas (idTarefa, idProjeto )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
;


-- -----------------------------------------------------
-- Tabela UsuarioRealizaTarefa
-- -----------------------------------------------------
CREATE  TABLE usuarioRealizaTarefa (
  idTarefa INT NOT NULL ,
  idProjeto INT NOT NULL ,
  idUsuario INT NOT NULL ,
  tempo INTERVAL NOT NULL ,
  dataInicio DATE NOT NULL ,
  dataFim DATE ,
  PRIMARY KEY (idTarefa, idProjeto, idUsuario) ,
  CONSTRAINT fk_tarefas_has_usuarios_tarefas1
    FOREIGN KEY (idTarefa , idProjeto )
    REFERENCES Tarefas (idTarefa , idProjeto )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT fk_tarefas_has_usuarios_usuarios1
    FOREIGN KEY (idUsuario )
    REFERENCES Usuarios (idUsuario )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
;


-- -----------------------------------------------------
-- Tabela Bugs
-- -----------------------------------------------------
CREATE  TABLE Bugs (
  idBug SERIAL ,
  idTarefa INT ,
  idProjeto INT ,
  descricao VARCHAR(500) NOT NULL ,
  dataDeteccao TIMESTAMP NOT NULL ,
  dataSolucao TIMESTAMP ,
  gravidade d_pri_grav NOT NULL ,
  usuarioDetecta INT NOT NULL ,
  usuarioSoluciona INT ,
  tree VARCHAR(200) NOT NULL,
  sha1 VARCHAR(200) NOT NULL,
  idrepositorio INT NOT NULL,
  PRIMARY KEY (idbug ) ,
  CONSTRAINT fk_bugs_tarefas1
    FOREIGN KEY (idTarefa , idProjeto )
    REFERENCES Tarefas (idTarefa , idProjeto )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT fk_bugs_usuarios1
    FOREIGN KEY (usuarioDetecta )
    REFERENCES Usuarios (idUsuario )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT fk_bugs_usuarios2
    FOREIGN KEY (usuarioSoluciona )
    REFERENCES usuarios (idUsuario )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT fk_bugs_repositorio1
    FOREIGN KEY (idRepositorio )
    REFERENCES Repositorios (idRepositorio )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
;

-- -----------------------------------------------------
-- Tabela LogsLogin
-- -----------------------------------------------------
CREATE  TABLE logsLogin (
  idLogLogin SERIAL ,
  dataHoraIni TIMESTAMP NOT NULL ,
  dataHoraFim TIMESTAMP,
  idLogin INT NOT NULL ,
  idUsuario INT NOT NULL ,
  PRIMARY KEY (idLogLogin) ,
  CONSTRAINT fk_logs_login_login1
    FOREIGN KEY (idLogin , idUsuario )
    REFERENCES Login (idLogin , idUsuario )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
;


-- -----------------------------------------------------
-- Tabela Baselines
-- -----------------------------------------------------
CREATE  TABLE baselines (
  idBaseline SERIAL ,
  tree VARCHAR(200) NOT NULL ,
  sha1 VARCHAR(200) NOT NULL ,
  dataHora TIMESTAMP NOT NULL ,
  idRepositorio INT NOT NULL ,
  PRIMARY KEY (idBaseline) ,
  CONSTRAINT fk_baselines_repositorio_github1
    FOREIGN KEY (idRepositorio )
    REFERENCES Repositorios (idRepositorio )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
;


-- -----------------------------------------------------
-- Tabela SolicitacoesMudanca
-- -----------------------------------------------------
CREATE  TABLE solicitacoesMudanca (
  idSolicitacaoMudanca SERIAL ,
  justificativa VARCHAR(1000) NOT NULL ,
  dtSolicitacao TIMESTAMP NOT NULL ,
  estado d_estado_sol NOT NULL DEFAULT FALSE ,
  idSolicitante INT NOT NULL ,
  idProjetoSolicitante INT NOT NULL ,
  idAvaliador INT ,
  idProjetoAvaliador INT ,
  idBaseline INT NOT NULL ,
  PRIMARY KEY (idsolicitacaoMudanca) ,
  CONSTRAINT fk_solicita_mudanca_usuario_trabalhaem_projeto1
    FOREIGN KEY (idSolicitante , idprojetoSolicitante )
    REFERENCES usuarioTrabalhaEmProjeto (idUsuario, idProjeto)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT fk_solicita_mudanca_usuario_trabalhaem_projeto2
    FOREIGN KEY (idAvaliador , idProjetoAvaliador )
    REFERENCES usuarioTrabalhaEmProjeto (idUsuario, idProjeto )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT fk_solicita_mudanca_baselines1
    FOREIGN KEY (idBaseline )
    REFERENCES Baselines (idBaseline )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
;


-- -----------------------------------------------------
-- Tabela mudancas
-- -----------------------------------------------------
CREATE  TABLE mudancas (
  idMudanca SERIAL,
  tree VARCHAR(200) NOT NULL ,
  sha1 VARCHAR(200) NOT NULL ,
  dataHora TIMESTAMP NOT NULL ,
  idSolicitacaoMudanca INT NOT NULL ,
  idRepositorio INT NOT NULL,
  PRIMARY KEY (idMudanca) ,
  CONSTRAINT fk_mudancas_solicita_mudanca1
    FOREIGN KEY (idSolicitacaoMudanca )
    REFERENCES solicitacoesMudanca (idSolicitacaoMudanca )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT fk_bugs_repositorio3
    FOREIGN KEY (idRepositorio )
    REFERENCES Repositorios (idRepositorio )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
;


-- -----------------------------------------------------
-- Tabela auditoriasMudancas
-- -----------------------------------------------------
CREATE  TABLE AuditoriasMudancas (
  idAuditoriaMudanca SERIAL,
  idMudanca INT NOT NULL ,
  auditor INT NOT NULL ,
  estado d_estado_aud NOT NULL ,
  dataHora TIMESTAMP NOT NULL ,
  PRIMARY KEY (idAuditoriaMudanca) ,
  CONSTRAINT fk_auditoria_mudancas1
    FOREIGN KEY (idMudanca )
    REFERENCES Mudancas (idMudanca )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT fk_auditoria_usuarios1
    FOREIGN KEY (auditor )
    REFERENCES Usuarios (idUsuario )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
;


-- -----------------------------------------------------
-- Tabela auditoriabugs
-- -----------------------------------------------------
CREATE  TABLE auditoriaBugs (
  idAuditoriaBug SERIAL ,
  estado d_estado_sol NOT NULL ,
  dataHora TIMESTAMP NOT NULL ,
  tree VARCHAR(200) NOT NULL ,
  sha1 VARCHAR(200),
  auditor INT ,
  idbug INT ,
  idRepositorio INT NOT NULL,
  PRIMARY KEY (idAuditoriaBug) ,
  CONSTRAINT fk_auditoriabugs_bugs
    FOREIGN KEY (idbug )
    REFERENCES Bugs (idBug )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT fk_auditoriabugs_usuarios
    FOREIGN KEY (auditor )
    REFERENCES Usuarios (idUsuario )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT fk_bugs_repositorio2
    FOREIGN KEY (idRepositorio )
    REFERENCES Repositorios (idRepositorio )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
;
