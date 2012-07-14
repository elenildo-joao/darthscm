-- --------------------------------------------------------
-- povoamento da tabela Endereco
-- (id, rua, num, bairro, cidade, estado, complemento)
-- --------------------------------------------------------
INSERT INTO Enderecos VALUES (DEFAULT, 'Av. Amélia Amado', 1, 'Centro', 'Itabuna', 'BA', 'Rua do canal');
INSERT INTO Enderecos VALUES (DEFAULT, 'Av. Princesa Isabel', 1, 'São Caetano', 'Itabuna', 'BA', NULL);
INSERT INTO Enderecos VALUES (DEFAULT, 'Rua São João', 1, 'Fátima', 'Itabuna', 'BA', 'próximo à lotérica');
INSERT INTO Enderecos VALUES (DEFAULT, 'Rua União Operária', 1, 'Pontalzinho', 'Itabuna', 'BA', NULL);
INSERT INTO Enderecos VALUES (DEFAULT, 'Av. Juracy Magalhães', 1, 'Centro', 'Itabuna', 'BA', NULL);
INSERT INTO Enderecos VALUES (DEFAULT, 'Rua Local G', 1, 'Nelson Costa', 'Ilhéus', 'BA', NULL);
INSERT INTO Enderecos VALUES (DEFAULT, 'Rua Itália', 1, 'Pontal', 'Ilhéus', 'BA', NULL);
INSERT INTO Enderecos VALUES (DEFAULT, 'Rua Macário dos Reis', 1, 'Santo Antônio', 'Itabuna', 'BA', 'próximo ao hospital');

-- --------------------------------------------------------
-- povoamento da tabela Usuarios
-- (id, nome, email, cpf, datanasc, telefone, endereco, sexo)
-- --------------------------------------------------------
INSERT INTO Usuarios VALUES (DEFAULT, 'Jacqueline Midlej', 'jacquelinemidlej@gmail.com', '00000000000', '1990/11/14', '7399010000', 1, FALSE, 'F');
INSERT INTO Usuarios VALUES (DEFAULT, 'Clícia Santos', 'clicia@gmail.com', '00100100101', '1990/01/01', '7399010001', 2, FALSE, 'F');
INSERT INTO Usuarios VALUES (DEFAULT, 'Elenildo Joao', 'elenildojoao@gmail.com', '00200200202', '1990/01/02', '7399010002', 3, TRUE, 'M');
INSERT INTO Usuarios VALUES (DEFAULT, 'Rafaela Souza', 'rafaelasouza@gmail.com', '00300300303', '1990/01/03', '7399010003', 4, FALSE, 'F');
INSERT INTO Usuarios VALUES (DEFAULT, 'Silas Ferreira', 'silasferreira@gmail.com', '00400400404', '1990/01/04', '7399010004', 5, FALSE, 'M');
INSERT INTO Usuarios VALUES (DEFAULT, 'Marcelo Santos', 'marcelosantos@gmail.com', '00500500505', '1990/01/05', '7399010005', 6, FALSE, 'M');
INSERT INTO Usuarios VALUES (DEFAULT, 'Caique Pires', 'caiquepires@gmail.com', '00600600606', '1990/01/06', '7399010006', 7, FALSE, 'M');
INSERT INTO Usuarios VALUES (DEFAULT, 'Anderson Carlos', 'andersoncarlos@gmail.com', '00700700707', '1990/01/07', '7399010007', 8, FALSE, 'M');

-- --------------------------------------------------------
-- povoamento da tabela Redefinirsenha
-- (hash, idusuario)
-- --------------------------------------------------------
INSERT INTO RedefinirSenha VALUES ('34fa345ac234fd3ec', 1, FALSE);
INSERT INTO RedefinirSenha VALUES ('54723ff246d2134cc', 4, TRUE);
INSERT INTO RedefinirSenha VALUES ('1d234dca23498abbb', 2, TRUE);

-- --------------------------------------------------------
-- povoamento da tabela Repositorios
-- (id, endereco, nome, conta)
-- --------------------------------------------------------
INSERT INTO Repositorios VALUES (DEFAULT, 'http://www.meurepositorio.com', 'repositoriodarthscm', 'admdarthscm');
INSERT INTO Repositorios VALUES (DEFAULT, 'http://www.meurepositorio.com', 'repositorioprojetoparalelo', 'admprojetoparalelo');

-- --------------------------------------------------------
-- povoamento da tabela Projetos
-- (id, nome, descricao, datainicio, dataprevfim, datafim, repositorio)
-- --------------------------------------------------------
INSERT INTO Projetos VALUES (DEFAULT, 'darthscm', 'Projeto de Engenharia de Software 2012.1 - Desenvolvimento de um Gerenciador de Configuração de Software', '2012/03/20', '2012/07/17', NULL, 1);
INSERT INTO Projetos VALUES (DEFAULT, 'projetoparalelo','', '2012/04/20', '2012/06/20', NULL, 2);

-- --------------------------------------------------------
-- povoamento da tabela UsuarioTrabalhaEmProjeto
-- (usuario, projeto, papel, datainicio, datafim)
-- --------------------------------------------------------
INSERT INTO UsuarioTrabalhaEmProjeto VALUES (1, 1, 'colaborador', '2012/03/20', NULL);
INSERT INTO UsuarioTrabalhaEmProjeto VALUES (2, 1, 'colaborador', '2012/03/20', NULL);
INSERT INTO UsuarioTrabalhaEmProjeto VALUES (3, 1, 'colaborador', '2012/03/20', NULL);
INSERT INTO UsuarioTrabalhaEmProjeto VALUES (4, 1, 'colaborador', '2012/03/20', NULL);
INSERT INTO UsuarioTrabalhaEmProjeto VALUES (5, 1, 'colaborador', '2012/03/20', NULL);
INSERT INTO UsuarioTrabalhaEmProjeto VALUES (6, 1, 'colaborador', '2012/03/20', NULL);
INSERT INTO UsuarioTrabalhaEmProjeto VALUES (7, 1, 'colaborador', '2012/03/20', NULL);
INSERT INTO UsuarioTrabalhaEmProjeto VALUES (8, 1, 'gerente', '2012/03/20', NULL);
INSERT INTO UsuarioTrabalhaEmProjeto VALUES (1, 2, 'gerente', '2012/03/20', NULL);
INSERT INTO UsuarioTrabalhaEmProjeto VALUES (2, 2, 'colaborador', '2012/03/20', NULL);
INSERT INTO UsuarioTrabalhaEmProjeto VALUES (3, 2, 'colaborador', '2012/03/20', NULL);

-- --------------------------------------------------------
-- povoamento da tabela Mensagens
-- (id, remetente, conteudo, datahora, lixeira, excluida)
-- --------------------------------------------------------
INSERT INTO Mensagens VALUES (DEFAULT, 1, 'Bem-vindos', 'Bem-vindos', '2012/03/20 08:00:00', false, false);
INSERT INTO Mensagens VALUES (DEFAULT, 2, 'Problema na tarefa', 'Estou tendo problemas com minha tarefa', '2012/03/30 10:46:52', false, false);
INSERT INTO Mensagens VALUES (DEFAULT, 2, 'Problema reslvido', 'Problema resolvido, Obrigada', '2012/03/30 12:00:00', false, false);
INSERT INTO Mensagens VALUES (DEFAULT, 3, 'Problema na tarefa (RE)', 'Trás na minha sala', '2012/03/30 11:00:24', false, false);
INSERT INTO Mensagens VALUES (DEFAULT, 1, 'Notícias', 'Como estão as atividades?', '2012/04/04 08:00:00', false, true);
INSERT INTO Mensagens VALUES (DEFAULT, 5, 'Notícias (RE)', 'Tudo bem. Estou desenvolvendo os requisitos do sistema', '2012/04/04 09:00:32', false, true);
INSERT INTO Mensagens VALUES (DEFAULT, 8, 'Sugestão', 'Eu acho que deveria haver a tabela de depreciações na estimativa de custo', '2012/03/30 15:04:08', false, false);
INSERT INTO Mensagens VALUES (DEFAULT, 1, 'Documento de visões', 'O documento de visões ficou ótimo!', '2012/04/02 14:06:54', false, true);
INSERT INTO Mensagens VALUES (DEFAULT, 4, 'Ajuda', 'Tenho pouca experiência com plano de qualidade, alguém pode me ajudar com algum material?', '2012/03/28 10:10:10', false, false);
INSERT INTO Mensagens VALUES (DEFAULT, 7, 'Ajuda (RE)', 'Ja ja encaminho!', '2012/03/28 10:20:40', false, true);

-- --------------------------------------------------------
-- povoamento da tabela Sestinatarios
-- (idmsg, idremetente, iddestinatario, lida, lixeira, excluida)
-- --------------------------------------------------------
INSERT INTO Destinatarios VALUES (1, 1, 2, TRUE, false, false);
INSERT INTO Destinatarios VALUES (1, 1, 3, TRUE, false, true);
INSERT INTO Destinatarios VALUES (1, 1, 4, TRUE, true, false);
INSERT INTO Destinatarios VALUES (1, 1, 5, TRUE, true, false);
INSERT INTO Destinatarios VALUES (1, 1, 6, TRUE, false, false);
INSERT INTO Destinatarios VALUES (1, 1, 7, TRUE, false, true);
INSERT INTO Destinatarios VALUES (1, 1, 8, TRUE, false, true);
INSERT INTO Destinatarios VALUES (2, 2, 3, TRUE, false, false);
INSERT INTO Destinatarios VALUES (3, 2, 3, TRUE, true, false);
INSERT INTO Destinatarios VALUES (4, 3, 2, TRUE, false, false);
INSERT INTO Destinatarios VALUES (5, 1, 5, TRUE, true, false);
INSERT INTO Destinatarios VALUES (6, 5, 1, TRUE, false, false);
INSERT INTO Destinatarios VALUES (7, 8, 6, TRUE, false, false);
INSERT INTO Destinatarios VALUES (8, 1, 8, TRUE, false, false);
INSERT INTO Destinatarios VALUES (9, 4, 2, TRUE, false, false);
INSERT INTO Destinatarios VALUES (9, 4, 3, FALSE, false, false);
INSERT INTO Destinatarios VALUES (9, 4, 5, FALSE, false, false);
INSERT INTO Destinatarios VALUES (9, 4, 6, TRUE, false, false);
INSERT INTO Destinatarios VALUES (9, 4, 7, TRUE, false, false);
INSERT INTO Destinatarios VALUES (9, 4, 8, TRUE, false, false);
INSERT INTO Destinatarios VALUES (10, 7, 4, TRUE, false, false);

-- --------------------------------------------------------
-- povoamento da tabela login
-- (id, usuario, login, senha)
-- --------------------------------------------------------
INSERT INTO Login VALUES (DEFAULT, 1, 'jack', '40bd001563085fc35165329ea1ff5c5ecbdbbeef');
INSERT INTO Login VALUES (DEFAULT, 2, 'clicia', '40bd001563085fc35165329ea1ff5c5ecbdbbeef');
INSERT INTO Login VALUES (DEFAULT, 3, 'elenildo', '40bd001563085fc35165329ea1ff5c5ecbdbbeef');
INSERT INTO Login VALUES (DEFAULT, 4, 'rafa', '40bd001563085fc35165329ea1ff5c5ecbdbbeef');
INSERT INTO Login VALUES (DEFAULT, 5, 'silas', '40bd001563085fc35165329ea1ff5c5ecbdbbeef');
INSERT INTO Login VALUES (DEFAULT, 6, 'marcelo', '40bd001563085fc35165329ea1ff5c5ecbdbbeef');
INSERT INTO Login VALUES (DEFAULT, 7, 'caique', '40bd001563085fc35165329ea1ff5c5ecbdbbeef');
INSERT INTO Login VALUES (DEFAULT, 8, 'anderson', '40bd001563085fc35165329ea1ff5c5ecbdbbeef');

-- --------------------------------------------------------
-- povoamento da tabela ContaGitHub
-- (id, usuario, username, senha)
-- --------------------------------------------------------
INSERT INTO ContaGitHub VALUES (DEFAULT, 1, 'jack_git', '123');
INSERT INTO ContaGitHub VALUES (DEFAULT, 2, 'clicia_git', '123');
INSERT INTO ContaGitHub VALUES (DEFAULT, 3, 'elenildo_git', '123');
INSERT INTO ContaGitHub VALUES (DEFAULT, 4, 'rafa_git', '123');
INSERT INTO ContaGitHub VALUES (DEFAULT, 5, 'silas_git', '123');
INSERT INTO ContaGitHub VALUES (DEFAULT, 6, 'marcelo_git', '123');
INSERT INTO ContaGitHub VALUES (DEFAULT, 7, 'caique_git', '123');
INSERT INTO ContaGitHub VALUES (DEFAULT, 8, 'anderson_git', '123');


-- --------------------------------------------------------
-- povoamento da tabela Tarefas
-- (id, idprojeto, nome, descricao, dataini, dataprevfim, datarealfim, prioridade, idsupertarefa, idsuperprojeto)
-- --------------------------------------------------------
INSERT INTO Tarefas VALUES (DEFAULT, 1, 'Proposta detalhada e orçamento ao cliente', NULL, '2012/04/13', '2012/04/23', '2012/04/23',  'normal', NULL, NULL);
INSERT INTO Tarefas VALUES (DEFAULT, 1, 'Estudo de viabilidade', NULL, '2012/04/03', '2012/04/17', '2012/04/17',  'baixa', NULL, NULL);
INSERT INTO Tarefas VALUES (DEFAULT, 1, 'Documento de visão', NULL, '2012/03/28', '2012/04/17', '2012/04/17',  'normal', NULL, NULL);
INSERT INTO Tarefas VALUES (DEFAULT, 1, 'Análise de risco', NULL, '2012/03/28', '2012/04/17', '2012/04/17',  'normal', NULL, NULL);
INSERT INTO Tarefas VALUES (DEFAULT, 1, 'Análise de custo', NULL, '2012/03/28', '2012/04/17', '2012/04/17',  'alta', NULL, NULL);
INSERT INTO Tarefas VALUES (DEFAULT, 1, 'Estimativa de tempo e custo', 'Total do produto', '2012/03/28', '2012/04/17', '2012/04/17',  'alta', NULL, NULL);
INSERT INTO Tarefas VALUES (DEFAULT, 1, 'Cronograma de atividades', NULL, '2012/04/14', '2012/04/24', '2012/04/24',  'normal', NULL, NULL);
INSERT INTO Tarefas VALUES (DEFAULT, 1, 'Metas de qualidade e qualidade so software', NULL, '2012/03/28', '2012/04/17', '2012/04/17',  'normal', NULL, NULL);
INSERT INTO Tarefas VALUES (DEFAULT, 1, 'Papéis da equipe de desenvolvimento', NULL, '2012/03/28', '2012/04/17', '2012/04/17',  'normal', NULL, NULL);
INSERT INTO Tarefas VALUES (DEFAULT, 1, 'Revisao da documentação', NULL, '2012/04/17', '2012/04/23', '2012/04/23',  'normal', NULL, NULL);
INSERT INTO Tarefas VALUES (DEFAULT, 1, 'Compilação dos documentos', NULL, '2012/06/08', '2012/06/11', NULL, 'normal', NULL, NULL);
INSERT INTO Tarefas VALUES (DEFAULT, 1, 'Banco de dados', NULL, '2012/04/30', '2012/06/03', NULL, 'normal', NULL, NULL);
INSERT INTO Tarefas VALUES (DEFAULT, 1, 'Modelagem banco', NULL, '2012/04/30', '2012/05/10', '2012/05/10', 'normal', 12, 1);
INSERT INTO Tarefas VALUES (DEFAULT, 1, 'Modelo lógico', NULL, '2012/05/10', '2012/05/17', '2012/05/17', 'normal', 12, 1);
INSERT INTO Tarefas VALUES (DEFAULT, 1, 'visões e povoamento', NULL, '2012/05/17', '2012/05/29', '2012/05/29', 'normal', 12, 1);
INSERT INTO Tarefas VALUES (DEFAULT, 1, 'gatilhos, funções e permissões', NULL, '2012/05/29', '2012/06/08', NULL, 'normal', 12, 1);
INSERT INTO Tarefas VALUES (DEFAULT, 1, 'diagrama de comportamento', NULL, '2012/05/29', '2012/06/03', NULL, 'normal', NULL, NULL);
INSERT INTO Tarefas VALUES (DEFAULT, 1, 'diagrama de sequencia', NULL, '2012/05/29', '2012/06/03', NULL, 'normal', NULL, NULL);
INSERT INTO Tarefas VALUES (DEFAULT, 1, 'protótipo horizontal e vertical', NULL, '2012/04/01', '2012/05/29', NULL, 'normal', NULL, NULL);
INSERT INTO Tarefas VALUES (DEFAULT, 1, 'plano de teste', NULL, '2012/04/01', '2012/05/29', NULL, 'normal', NULL, NULL);
INSERT INTO Tarefas VALUES (DEFAULT, 1, 'gestão de projetos', NULL, '2012/04/01', '2012/05/29', NULL, 'normal', NULL, NULL);
INSERT INTO Tarefas VALUES (DEFAULT, 1, 'arquitetura de software', NULL, '2012/04/01', '2012/05/29', NULL, 'normal', NULL, NULL);
INSERT INTO Tarefas VALUES (DEFAULT, 1, 'gerencia de configuração de software', NULL, '2012/04/01', '2012/05/29', NULL, 'normal', NULL, NULL);
INSERT INTO Tarefas VALUES (DEFAULT, 1, 'diagrama de classes', NULL, '2012/03/29', '2012/05/18', '2012/05/23', 'normal', NULL, NULL);
INSERT INTO Tarefas VALUES (DEFAULT, 2, 'documentação dos requisitos', NULL, '2012/03/29', '2012/05/18', '2012/05/23', 'normal', NULL, NULL);
INSERT INTO Tarefas VALUES (DEFAULT, 2, 'proposta ao cliente', NULL, '2012/03/29', '2012/05/08', '2012/05/08', 'normal', NULL, NULL);
INSERT INTO Tarefas VALUES (DEFAULT, 2, 'revisao documentação', NULL, '2012/05/08', '2012/05/28', '2012/05/28', 'normal', NULL, NULL);
INSERT INTO Tarefas VALUES (DEFAULT, 1, 'correção do bug no documento de requisitos', NULL, '2012/05/08', '2012/05/28', '2012/05/28', 'normal', NULL, NULL);
INSERT INTO Tarefas VALUES (DEFAULT, 1, 'correção do bug no documento de visao', NULL, '2012/05/08', '2012/05/28', NULL, 'normal', NULL, NULL);
INSERT INTO Tarefas VALUES (DEFAULT, 2, 'correção do bug na proposta ao cliente', 'orçamento errado', '2012/05/30', '2012/06/10', '2012/06/03', 'normal', NULL, NULL);

-- --------------------------------------------------------
-- povoamento da tabela UsuarioRealizaTarefa
-- (idtarefa, idprojeto, idusuario, tempo, datainicio, datafim)
-- ---------------------------------------------------------
INSERT INTO UsuarioRealizaTarefa VALUES (1, 1, 4, '3 23:20:10', '2012/04/13', '2012/04/23');
INSERT INTO UsuarioRealizaTarefa VALUES (2, 1, 2, '4 07:32:41', '2012/04/03', '2012/04/17');
INSERT INTO UsuarioRealizaTarefa VALUES (3, 1, 8, '4 03:20:30', '2012/03/28', '2012/04/17');
INSERT INTO UsuarioRealizaTarefa VALUES (4, 1, 7, '5 14:56:30', '2012/03/28', '2012/04/17');
INSERT INTO UsuarioRealizaTarefa VALUES (5, 1, 6, '3 12:34:10', '2012/03/28', '2012/04/17');
INSERT INTO UsuarioRealizaTarefa VALUES (6, 1, 3, '2 00:12:30', '2012/03/28', '2012/04/17');
INSERT INTO UsuarioRealizaTarefa VALUES (7, 1, 4, '5 15:00:00', '2012/04/14', '2012/04/24');
INSERT INTO UsuarioRealizaTarefa VALUES (8, 1, 1, '2 03:00:00', '2012/03/28', '2012/04/17');
INSERT INTO UsuarioRealizaTarefa VALUES (9, 1, 5, '2 15:00:00', '2012/03/28', '2012/04/17');
INSERT INTO UsuarioRealizaTarefa VALUES (10, 1, 1, '2 12:11:45', '2012/04/17', '2012/04/23');
INSERT INTO UsuarioRealizaTarefa VALUES (11, 1, 5, '2 05:12:12', '2012/06/08', NULL);
INSERT INTO UsuarioRealizaTarefa VALUES (11, 1, 4, '2 14:34:43', '2012/06/08', NULL);
INSERT INTO UsuarioRealizaTarefa VALUES (12, 1, 1, '2 23:44:22', '2012/04/30');
INSERT INTO UsuarioRealizaTarefa VALUES (13, 1, 3, '3 12:34:00', '2012/04/30', '2012/05/10');
INSERT INTO UsuarioRealizaTarefa VALUES (14, 1, 1, '5 23:54:30', '2012/05/10', '2012/05/17');
INSERT INTO UsuarioRealizaTarefa VALUES (15, 1, 1, '1 21:43:50', '2012/05/17', '2012/05/29');
INSERT INTO UsuarioRealizaTarefa VALUES (16, 1, 1, '4 00:00:00', '2012/05/29', NULL);
INSERT INTO UsuarioRealizaTarefa VALUES (16, 1, 3, '3 05:03:43', '2012/05/29', NULL);
INSERT INTO UsuarioRealizaTarefa VALUES (17, 1, 4, '2 23:02:30', '2012/05/29', NULL);
INSERT INTO UsuarioRealizaTarefa VALUES (17, 1, 5, '2 03:00:00', '2012/05/29', NULL);
INSERT INTO UsuarioRealizaTarefa VALUES (18, 1, 6, '4 20:32:30', '2012/05/29', NULL);
INSERT INTO UsuarioRealizaTarefa VALUES (18, 1, 7, '2 23:44:40', '2012/05/29', NULL);
INSERT INTO UsuarioRealizaTarefa VALUES (19, 1, 4, '2 02:12:43', '2012/04/01', NULL);
INSERT INTO UsuarioRealizaTarefa VALUES (20, 1, 7, '4 10:40:50', '2012/04/01', NULL);
INSERT INTO UsuarioRealizaTarefa VALUES (21, 1, 8, '3 02:30:40', '2012/04/01', NULL);
INSERT INTO UsuarioRealizaTarefa VALUES (22, 1, 2, '1 23:54:05', '2012/04/01', NULL);
INSERT INTO UsuarioRealizaTarefa VALUES (22, 1, 1, '23:40:20', '2012/04/01', NULL);
INSERT INTO UsuarioRealizaTarefa VALUES (23, 1, 8, '3 03:03:45', '2012/04/01', NULL);
INSERT INTO UsuarioRealizaTarefa VALUES (24, 1, 2, '5 00:00:00', '2012/03/29', '2012/05/23');
INSERT INTO UsuarioRealizaTarefa VALUES (25, 2, 3, '10 21:40:00', '2012/03/29', '2012/05/23');
INSERT INTO UsuarioRealizaTarefa VALUES (26, 2, 2, '6 04:00:00', '2012/03/29', '2012/05/08');
INSERT INTO UsuarioRealizaTarefa VALUES (27, 2, 1, '00:00:00', '2012/05/08', '2012/05/28');
INSERT INTO UsuarioRealizaTarefa VALUES (28, 1, 6, '02:30:00', '2012/05/08', '2012/05/28');
INSERT INTO UsuarioRealizaTarefa VALUES (29, 1, 7, '00:00:00', '2012/05/08', NULL);
INSERT INTO UsuarioRealizaTarefa VALUES (30, 2, 3, '00:00:00', '2012/05/30', '2012/06/03');


-- --------------------------------------------------------
-- povoamento da tabela Bugs
-- (id, idtarefas, idprojeto, descrição, datadetecção, datasolucao, gravidade, usuariodetecta, usuariosoluciona, tree, sha1, idrepositorio)
-- ---------------------------------------------------------
INSERT INTO Bugs VALUES (DEFAULT, 28, 1, 'O documento de requisitos requer mudança na numeração do documento', '2012/05/02', '2012/05/28', 'normal', 1, 6, 'requisitos_do_software', 'chave_crip', 1);
INSERT INTO Bugs VALUES (DEFAULT, 29, 1, 'O documento de visão tem tabelas incompletas', '2012/05/02', NULL, 'normal', 1, NULL, 'documento_de_visão', 'chave_crip', 1);
INSERT INTO Bugs VALUES (DEFAULT, NULL, NULL, 'O banco de dados nao detecta quais tarefas estão fechadas', '2012/05/29', NULL, 'alta', 8, NULL, 'modelagem_banco_de_dados', 'chave_crip', 1);
INSERT INTO Bugs VALUES (DEFAULT, 30, 2, 'Bug na proposta ao cliente, o orçamento informado nao vale mais para a data presente', '2012/05/29', '2012/06/03', 'alta', 2, 3, 'proposta_ao_cliente', 'chave_crip', 2);
INSERT INTO Bugs VALUES (DEFAULT, NULL, NULL, 'Erro no banco de dados, a tabela usuario tem um atributo para endereço. Deveria ser uma tabela.', '2012/05/30', NULL, 'maxima', 2, NULL, 'modelagem_banco_de_dados', 'chave_crip', 1);


-- --------------------------------------------------------
-- povoamento da tabela LogsLogin
-- (id, datahora, datahorafim, idlogin, idusuario)
-- ---------------------------------------------------------
INSERT INTO LogsLogin VALUES (DEFAULT, '2012/03/20 08:00:00', '2012/03/20 10:23:34', 1, 1);
INSERT INTO LogsLogin VALUES (DEFAULT, '2012/04/04 07:50:43', '2012/04/04 16:33:54', 1, 1);
INSERT INTO LogsLogin VALUES (DEFAULT, '2012/04/02 14:02:30', '2012/04/02 15:23:34', 1, 1);
INSERT INTO LogsLogin VALUES (DEFAULT, '2012/05/02 09:40:00', '2012/05/02 11:50:23', 1, 1);
INSERT INTO LogsLogin VALUES (DEFAULT, '2012/05/23 21:40:50', '2012/05/23 23:24:04', 1, 1);
INSERT INTO LogsLogin VALUES (DEFAULT, '2012/05/29 08:00:00', '2012/05/29 10:13:00', 1, 1);
INSERT INTO LogsLogin VALUES (DEFAULT, '2012/05/27 08:00:00', '2012/05/27 08:15:45', 1, 1);
INSERT INTO LogsLogin VALUES (DEFAULT, '2012/03/30 08:00:00', '2012/03/30 11:15:45', 2, 2);
INSERT INTO LogsLogin VALUES (DEFAULT, '2012/03/30 08:00:00', '2012/03/30 12:15:45', 2, 2);
INSERT INTO LogsLogin VALUES (DEFAULT, '2012/05/14 10:00:00', '2012/05/14 12:15:45', 2, 2);
INSERT INTO LogsLogin VALUES (DEFAULT, '2012/03/30 10:00:00', '2012/03/30 11:45:55', 3, 3);
INSERT INTO LogsLogin VALUES (DEFAULT, '2012/03/28 10:00:00', '2012/03/28 11:00:59', 3, 3);
INSERT INTO LogsLogin VALUES (DEFAULT, '2012/04/02 14:34:00', '2012/04/02 16:23:35', 4, 4);
INSERT INTO LogsLogin VALUES (DEFAULT, '2012/04/02 14:34:00', '2012/04/02 16:23:35', 4, 4);
INSERT INTO LogsLogin VALUES (DEFAULT, '2012/05/28 10:00:00', '2012/05/28 11:45:55', 4, 4);
INSERT INTO LogsLogin VALUES (DEFAULT, '2012/04/04 08:40:00', '2012/04/04 11:45:05', 5, 5);
INSERT INTO LogsLogin VALUES (DEFAULT, '2012/05/30 13:40:40', '2012/05/30 16:25:56', 5, 5);
INSERT INTO LogsLogin VALUES (DEFAULT, '2012/03/30 08:00:40', '2012/03/30 11:25:46', 6, 6);
INSERT INTO LogsLogin VALUES (DEFAULT, '2012/04/30 13:40:40', '2012/04/30 16:25:56', 6, 6);
INSERT INTO LogsLogin VALUES (DEFAULT, '2012/03/28 09:40:40', '2012/03/28 16:25:56', 7, 7);
INSERT INTO LogsLogin VALUES (DEFAULT, '2012/04/30 13:40:40', '2012/04/30 16:25:56', 7, 7);
INSERT INTO LogsLogin VALUES (DEFAULT, '2012/05/20 13:40:40', '2012/05/20 15:02:46', 7, 7);
INSERT INTO LogsLogin VALUES (DEFAULT, '2012/03/30 13:42:40', '2012/03/30 16:23:56', 8, 8);
INSERT INTO LogsLogin VALUES (DEFAULT, '2012/04/30 14:45:40', '2012/05/30 16:45:56', 8, 8);
INSERT INTO LogsLogin VALUES (DEFAULT, '2012/05/30 08:50:40', '2012/05/30 10:25:56', 8, 8);


-- --------------------------------------------------------
-- povoamento da tabela Baselines
-- (id, tree, sha1, datahora, idrepositorio)
-- ---------------------------------------------------------
INSERT INTO Baselines VALUES (DEFAULT, 'requisitos_do_software', 'chave_crip', '2012/06/03 10:10:34', 1);
INSERT INTO Baselines VALUES (DEFAULT, 'requisitos_do_software_v.2', 'chave_crip', '2012/06/10 10:10:34', 1);
INSERT INTO Baselines VALUES (DEFAULT, 'requisitos_do_software', 'chave_crip', '2012/05/28 16:10:54', 2);
INSERT INTO Baselines VALUES (DEFAULT, 'documente_de_visao', 'chave_crip', '2012/05/03 10:10:34', 1);
INSERT INTO Baselines VALUES (DEFAULT, 'analise_de_custo', 'chave_crip', '2012/05/03 10:10:34', 1);
INSERT INTO Baselines VALUES (DEFAULT, 'proposta_ao_cliente', 'chave_crip', '2012/04/30 08:10:53', 1);
INSERT INTO Baselines VALUES (DEFAULT, 'proposta_ao_cliente_v.2', 'chave_crip', '2012/05/06 08:10:53', 1);
INSERT INTO Baselines VALUES (DEFAULT, 'metas_de_qualidade', 'chave_crip', '2012/04/30 08:45:53', 1);
INSERT INTO Baselines VALUES (DEFAULT, 'cronograma', 'chave_crip', '2012/04/30 08:45:53', 1);
INSERT INTO Baselines VALUES (DEFAULT, 'papais_de_cada_membro', 'chave_crip', '2012/04/29 10:46:53', 1);
INSERT INTO Baselines VALUES (DEFAULT, 'analise_de_risco', 'chave_crip', '2012/04/29 12:25:43', 1);


-- --------------------------------------------------------
-- povoamento da tabela SolicitacaoMudanca
-- (id, justificativa, data, estado, idususol, idprojsol, idusuarioava, idprojava, idbase)
-- ---------------------------------------------------------
INSERT INTO SolicitacoesMudanca VALUES (DEFAULT, 'Quero mudar os requisitos_do_software pois o cliente fez mais exigencias, adicionou requisitos', '2012/06/10', 'aprovado', 3, 1, 8, 1, 1);
INSERT INTO SolicitacoesMudanca VALUES (DEFAULT, 'Quero mudar os requisitos_do_software pois esta uma merda', '2012/06/11', 'recusado', 5, 1, 8, 1, 2);
INSERT INTO SolicitacoesMudanca VALUES (DEFAULT, 'Quero mudar os requisitos_do_software pois esta uma merda', '2012/06/11', 'solicitado', 2, 2, NULL, NULL, 3);
INSERT INTO SolicitacoesMudanca VALUES (DEFAULT, 'Quero mudar os requisitos_do_software pois esta uma merda', '2012/06/04', 'recusado', 3, 2, 1, 2, 3);
INSERT INTO SolicitacoesMudanca VALUES (DEFAULT, 'Quero mudar a proposta do cliente, pois se faz necessário acrescentar o tópico contatos da empresa', '2012/05/04', 'aprovado', 2, 1, 8, 1, 6);
INSERT INTO SolicitacoesMudanca VALUES (DEFAULT, 'Quero mudar o documento metas de qualidade pois falta inserir a revisao tecnica formal', '2012/05/04', 'aprovado', 3, 1, 8, 1, 8);


-- --------------------------------------------------------
-- povoamento da tabela mudancas
-- (id, tree, sha1, datahora, solicitacaoMudança, idrepositorio)
-- ---------------------------------------------------------
INSERT INTO Mudancas VALUES (DEFAULT, 'requisitos_do_software_v.2', 'chave_crip', '2012/06/11 08:00:00', 1, 1);
INSERT INTO Mudancas VALUES (DEFAULT, 'proposta_ao_cliente_v.2', 'chave_crip', '2012/05/05 08:00:00', 5, 1);
INSERT INTO Mudancas VALUES (DEFAULT, 'metas_de_qualiade_v.2', 'chave_crip', '2012/05/05 08:00:00', 6, 1);


-- --------------------------------------------------------
-- povoamento da tabela auditoriasMudancas
-- (id, idmudança, idauditor, estado, datahora)
-- ---------------------------------------------------------
INSERT INTO AuditoriasMudancas VALUES (DEFAULT, 1, 8, 'aprovado', '2012/06/11 14:05:34');
INSERT INTO AuditoriasMudancas VALUES (DEFAULT, 2, 8, 'aprovado', '2012/05/05 14:34:20');
INSERT INTO AuditoriasMudancas VALUES (DEFAULT, 3, 8, 'recusado', '2012/05/05 15:50:30');

-- --------------------------------------------------------
-- povoamento da tabela auditoriabugs
-- (id, estado, datahora, tree, sha1, idauditor, idbugs, idrepositorio)
-- ---------------------------------------------------------
INSERT INTO AuditoriaBugs VALUES (DEFAULT, 'RECUSADO', '2012/05/26 09:00:00', 'requisitos_do_software_v_1.0', 'chave_crip', 8, 1, 1);
INSERT INTO AuditoriaBugs VALUES (DEFAULT, 'APROVADO', '2012/05/28 09:00:00', 'requisitos_do_software_v_1.1', 'chave_crip', 8, 1, 1);
INSERT INTO AuditoriaBugs VALUES (DEFAULT, 'RECUSADO', '2012/05/28 10:00:00', 'documente_de_visao_v_1.0', 'chave_crip', 8, 2, 1);
INSERT INTO AuditoriaBugs VALUES (DEFAULT, 'APROVADO', '2012/06/03 10:34:20', 'proposta_ao_cliente_v.1.1', 'chave_crip', 8, 4, 1);
INSERT INTO AuditoriaBugs VALUES (DEFAULT, 'SOLICITADO', '2012/06/02 12:00:00', 'modelagem_banco_de_dados_v_1.1', 'chave_crip', NULL, 3, 1);
INSERT INTO AuditoriaBugs VALUES (DEFAULT, 'RECUSADO', '2012/06/01 12:30:40', 'modelagem_banco_de_dados_v_1.2', 'chave_crip', 8, 5, 1);
INSERT INTO AuditoriaBugs VALUES (DEFAULT, 'SOLICITADO', '2012/06/06 15:45:43', 'modelagem_banco_de_dados_v_1.3', 'chave_crip', NULL, 5, 1);

