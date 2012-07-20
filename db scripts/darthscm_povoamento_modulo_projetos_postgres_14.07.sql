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
-- povoamento da tabela Tarefas
-- (id, idprojeto, nome, descricao, dataini, dataprevfim, datarealfim, prioridade, idsupertarefa, idsuperprojeto)
-- --------------------------------------------------------
INSERT INTO Tarefas VALUES (DEFAULT, 1, 'Proposta detalhada e orçamento ao cliente', 'Fazer a proposta para o cliente seguindo o modelo darthscm_proposta.', '2012/04/13', '2012/04/23', '2012/04/23',  'normal', NULL, NULL);
INSERT INTO Tarefas VALUES (DEFAULT, 1, 'Estudo de viabilidade', 'Análise detalhada pretendendo determinar a possibilidade de se implementar o software.', '2012/04/03', '2012/04/17', '2012/04/17',  'baixa', NULL, NULL);
INSERT INTO Tarefas VALUES (DEFAULT, 1, 'Documento de visão', 'Coletar as necessidade do sistema.', '2012/03/28', '2012/04/17', '2012/04/17',  'normal', NULL, NULL);
INSERT INTO Tarefas VALUES (DEFAULT, 1, 'Análise de risco', 'Permite antecipar e minimizar o efeito de eventos que possa causar impactos negativos no projeto.', '2012/03/28', '2012/04/17', '2012/04/17',  'normal', NULL, NULL);
INSERT INTO Tarefas VALUES (DEFAULT, 1, 'Análise de custo', 'Análise detalha que oferece gestão da organização das informações relaticas ao custo da empresa com o projeto.', '2012/03/28', '2012/04/17', '2012/04/17',  'alta', NULL, NULL);
INSERT INTO Tarefas VALUES (DEFAULT, 1, 'Estimativa de tempo e custo', 'Mensurar o custo e tempo total do projeto.', '2012/03/28', '2012/04/17', '2012/04/17',  'alta', NULL, NULL);
INSERT INTO Tarefas VALUES (DEFAULT, 1, 'Cronograma de atividades', 'Prazos determinados para as diversas tarefas do projeto.', '2012/04/14', '2012/04/24', '2012/04/24',  'normal', NULL, NULL);
INSERT INTO Tarefas VALUES (DEFAULT, 1, 'Metas de qualidade e qualidade so software', 'Definir o processo de garantia de qualidade de software.', '2012/03/28', '2012/04/17', '2012/04/17',  'normal', NULL, NULL);
INSERT INTO Tarefas VALUES (DEFAULT, 1, 'Papéis da equipe de desenvolvimento', 'Definir os papéis de cada membro da equipe em cada fase.', '2012/03/28', '2012/04/17', '2012/04/17',  'normal', NULL, NULL);
INSERT INTO Tarefas VALUES (DEFAULT, 1, 'Revisao da documentação', 'Correção e sugestões a respeito da documentação gerada na primeira fase.', '2012/04/17', '2012/04/23', '2012/04/23',  'normal', NULL, NULL);
INSERT INTO Tarefas VALUES (DEFAULT, 1, 'Compilação dos documentos', 'Junção de todas as partes e formatação da documentação.', '2012/06/08', '2012/06/11', NULL, 'normal', NULL, NULL);
INSERT INTO Tarefas VALUES (DEFAULT, 1, 'Banco de dados', NULL, '2012/04/30', '2012/06/03', NULL, 'normal', NULL, NULL);
INSERT INTO Tarefas VALUES (DEFAULT, 1, 'Modelagem banco', 'Modelo relacional no MySql workbench', '2012/04/30', '2012/05/10', '2012/05/10', 'normal', 12, 1);
INSERT INTO Tarefas VALUES (DEFAULT, 1, 'Modelo lógico', 'Implementação do modelo relacional', '2012/05/10', '2012/05/17', '2012/05/17', 'normal', 12, 1);
INSERT INTO Tarefas VALUES (DEFAULT, 1, 'Visões e povoamento', NULL, '2012/05/17', '2012/05/29', '2012/05/29', 'normal', 12, 1);
INSERT INTO Tarefas VALUES (DEFAULT, 1, 'Gatilhos, funções e permissões', NULL, '2012/05/29', '2012/06/08', NULL, 'normal', 12, 1);
INSERT INTO Tarefas VALUES (DEFAULT, 1, 'Diagrama de comportamento', NULL, '2012/05/29', '2012/06/03', NULL, 'normal', NULL, NULL);
INSERT INTO Tarefas VALUES (DEFAULT, 1, 'Diagrama de sequencia', NULL, '2012/05/29', '2012/08/03', NULL, 'normal', NULL, NULL);
INSERT INTO Tarefas VALUES (DEFAULT, 1, 'Protótipo horizontal e vertical', NULL, '2012/04/01', '2012/05/29', NULL, 'normal', NULL, NULL);
INSERT INTO Tarefas VALUES (DEFAULT, 1, 'Plano de teste', 'Plano a respeitos dos testes que serão executados para o projeto.', '2012/04/01', '2012/05/29', NULL, 'normal', NULL, NULL);
INSERT INTO Tarefas VALUES (DEFAULT, 1, 'Gestão de projetos', 'Plano para gerência do desenvolvimento de projetos.', '2012/04/01', '2012/05/29', NULL, 'normal', NULL, NULL);
INSERT INTO Tarefas VALUES (DEFAULT, 1, 'Arquitetura de software', 'Mostrar detalhadamente a arquitetura em várias visões.', '2012/04/01', '2012/08/29', NULL, 'normal', NULL, NULL);
INSERT INTO Tarefas VALUES (DEFAULT, 1, 'Gerência de configuração de software', NULL, '2012/04/01', '2012/05/29', NULL, 'normal', NULL, NULL);
INSERT INTO Tarefas VALUES (DEFAULT, 1, 'Diagrama de classes', NULL, '2012/03/29', '2012/05/18', '2012/05/23', 'normal', NULL, NULL);
INSERT INTO Tarefas VALUES (DEFAULT, 2, 'Documentação dos requisitos', NULL, '2012/03/29', '2012/05/18', '2012/05/23', 'normal', NULL, NULL);
INSERT INTO Tarefas VALUES (DEFAULT, 2, 'Proposta ao cliente', 'Fazer a proposta para o cliente seguindo o modelo proj_doc.', '2012/03/29', '2012/05/08', '2012/05/08', 'normal', NULL, NULL);
INSERT INTO Tarefas VALUES (DEFAULT, 2, 'Revisao documentação', 'Correção de erros no documento.', '2012/05/08', '2012/05/28', '2012/05/28', 'normal', NULL, NULL);
INSERT INTO Tarefas VALUES (DEFAULT, 1, 'Correção do bug no documento de requisitos', NULL, '2012/05/08', '2012/05/28', '2012/05/28', 'normal', NULL, NULL);
INSERT INTO Tarefas VALUES (DEFAULT, 1, 'Correção do bug no documento de visao', NULL, '2012/05/08', '2012/05/28', NULL, 'normal', NULL, NULL);
INSERT INTO Tarefas VALUES (DEFAULT, 2, 'Correção do bug na proposta ao cliente', 'orçamento errado', '2012/05/30', '2012/06/10', NULL, 'normal', NULL, NULL);
INSERT INTO Tarefas VALUES (DEFAULT, 2, 'Correção do bug no código fonte - função soma', 'retorna na linha 7', '2012/05/30', '2012/08/10', NULL, 'normal', NULL, NULL);
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


