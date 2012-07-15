-- Criando as visões

-- ------------------------------------------------------------------------
-- Visao que permite visualizar todas as tarefas e subtarefas quem são 
-- os responsáveis pelo desenvolvimento da tarefa
-- ------------------------------------------------------------------------
 CREATE OR REPLACE VIEW vTarefaUsuario (idusuario, nomeusuario, datainiciousuario, datafimusuario, tempo, idtarefa, nometarefa, descricao, prioridadetarefa, datafimTarefa, idSupertarefa, nomesupertarefa, datafimsuper, idprojeto, nomeprojeto) AS
 SELECT DISTINCT u.idUsuario, u.nome, ur.datainicio, ur.datafim, ur.tempo, t.idTarefa, t.nome, t.descricao, t.prioridade, t.dataFim, s.idTarefa, s.nome, s.dataFim, t.idProjeto, p.nome
 FROM (Usuarios AS u JOIN UsuarioRealizaTarefa AS ur ON u.idUsuario=ur.idUsuario 
	JOIN Tarefas AS t ON ur.idTarefa=t.idTarefa AND ur.idProjeto=t.idProjeto 
		JOIN Projetos AS p ON t.idProjeto=p.idProjeto) 
			LEFT OUTER JOIN Tarefas AS s ON t.idSuperTarefa=s.idTarefa AND t.idProjetoSuperTarefa=s.idProjeto
 ORDER BY t.idProjeto , s.idTarefa DESC;

-- ------------------------------------------------------------------------
-- Visao que permite visualizar as tarefas abertas e quem são responsaveis 
-- pelo desenvolvimento da mesma
-- ------------------------------------------------------------------------
CREATE OR REPLACE VIEW vTarefaUsuarioAberta (idusuario, nomeusuario, idtarefa, nometarefa, prioridadetarefa, idprojeto, nomeprojeto) AS
SELECT DISTINCT u.idusuario, u.nome, t.idTarefa, t.nome, t.prioridade, t.idProjeto, p.nome
FROM Usuarios AS u JOIN UsuarioRealizaTarefa AS ur ON ur.idusuario=u.idUsuario 
	JOIN tarefas AS t ON ur.idTarefa=t.idTarefa AND ur.idProjeto=t.idProjeto 
		JOIN Projetos AS p ON t.idProjeto=p.idProjeto
WHERE idSuperTarefa=NULL
ORDER BY t.idprojeto;


-- ------------------------------------------------------------------------
-- Visao que permite visualizar as tarefas e subtarefas atrasadas e quem são 
-- os responsáveis pelo desenvolvimento da tarefa
-- ------------------------------------------------------------------------
CREATE OR REPLACE VIEW vTarefaUsuarioAtrasada (idusuario, nomeusuario, idtarefa, nometarefa, idSupertarefa, nomesupertarefa, prioridadetarefa, idprojeto, nomeprojeto) AS
SELECT DISTINCT u.idUsuario, u.nome, t.idTarefa, t.nome, s.idTarefa, s.nome, t.prioridade, t.idProjeto, p.nome
FROM (Usuarios AS u JOIN UsuarioRealizaTarefa AS ur ON u.idUsuario=ur.idUsuario 
	JOIN Tarefas AS t ON ur.idTarefa=t.idTarefa AND ur.idProjeto=t.idProjeto 
		JOIN Projetos AS p ON t.idProjeto=p.idProjeto) 
			LEFT OUTER JOIN Tarefas AS s ON t.idSuperTarefa=s.idTarefa AND t.idprojetoSuperTarefa=s.idProjeto
WHERE t.dataPrevFim < CURRENT_DATE OR s.dataPrevFim < CURRENT_DATE
ORDER BY t.idProjeto, s.idTarefa DESC;


-- ------------------------------------------------------------------------
-- Visao que permite visualizar as tarefas fechadas e quem são responsaveis 
-- pelo desenvolvimento da mesma
-- ------------------------------------------------------------------------
CREATE OR REPLACE VIEW vTarefaUsuarioFechada (idusuario, nomeusuario, idtarefa, nometarefa, prioridadetarefa, idprojeto, nomeprojeto) AS
SELECT DISTINCT u.idUsuario, u.nome, t.idTarefa, t.nome, t.prioridade, t.idProjeto, p.nome
FROM Usuarios AS u JOIN UsuarioRealizaTarefa AS ur ON u.idUsuario=ur.idUsuario 
	JOIN Tarefas AS t ON ur.idTarefa=t.idTarefa AND ur.idProjeto=t.idProjeto 
		JOIN Projetos AS p ON t.idProjeto=p.idProjeto
WHERE t.dataFim <> NULL AND idSuperTarefa=NULL
ORDER BY t.idProjeto;

-- ------------------------------------------------------------------------
-- Usuarios alocados no projeto e seu papel
-- ------------------------------------------------------------------------
CREATE OR REPLACE VIEW vUsuarioProjeto AS
SELECT u.idusuario, u.nome AS nomeusuario, p.idprojeto, p.nome AS nomeprojeto, p.descricao, p.datainicio AS datainicioprojeto, p.dataprevfim, p.datafim, t.papel, t.datainicio AS datainiciousuario, t.datafim AS datafimusuario, p.idrepositorio
FROM usuarios u
JOIN usuariotrabalhaemprojeto t ON u.idusuario = t.idusuario
JOIN projetos p ON p.idprojeto = t.idprojeto;

-- ------------------------------------------------------------------------
-- Visualizar relatorio de produtividade dos projetos 
-- ------------------------------------------------------------------------
CREATE OR REPLACE VIEW vRelatorioProdProj (idprojeto, nomeprojeto, tempodedicado) AS
SELECT p.idProjeto, p.nome, SUM (r.tempo)
FROM projetos AS p JOIN Tarefas AS t ON p.idProjeto=t.idProjeto 
	JOIN usuarioRealizaTarefa AS r ON r.idTarefa=t.idTarefa AND t.idProjeto=r.idProjeto
GROUP BY p.idProjeto, p.nome;


-- ------------------------------------------------------------------------
-- Visualizar relatorio de produtividade dos colaboradores em cada projeto (detalhado)
-- ------------------------------------------------------------------------
CREATE OR REPLACE VIEW vRelatorioProdCol (idusuario, nomeusuario, idprojeto, nomeprojeto, tempodedicado) AS
SELECT u.idUsuario, u.nome, p.idProjeto, p.nome, SUM (r.tempo)
FROM Projetos AS p JOIN Tarefas AS t ON p.idProjeto=t.idProjeto 
	JOIN   usuarioRealizaTarefa AS r ON r.idTarefa=t.idTarefa AND t.idProjeto=r.idProjeto
		JOIN Usuarios AS u ON u.idUsuario=r.idUsuario
GROUP BY p.idProjeto, p.nome, u.idUsuario, u.nome;


-- ------------------------------------------------------------------------
-- Visualizar bugs detectados e quem etectou, solucionou se houver solução 
-- e tarefa ppara solucao do erro, se houver
-- ------------------------------------------------------------------------
CREATE OR REPLACE VIEW vBugs (idbug, descricao, tree, sha1, repositorio, gravidade, datadeteccao, idusuariodetecta, nomeusuariodetecta, idusuariosoluciona, nomeusuariosoluciona, datasolucao, idtarefasolucao) AS
SELECT b.idBug, b.descricao, b.tree, b.sha1, b.idRepositorio, b.gravidade, b.dataDeteccao, b.usuarioDetecta, ud.nome, b.usuarioSoluciona, us.nome, b.dataSolucao, b.idTarefa, b.idProjeto
FROM (Bugs AS b JOIN Usuarios AS ud ON ud.idUsuario=b.usuarioDetecta)
	JOIN Usuarios AS us ON us.idUsuario=b.usuarioSoluciona
;


-- ------------------------------------------------------------------------
-- Visualizar bugs detectados e auditoria das soluções dos bugs
---------------------------------------------------------------------------
CREATE OR REPLACE VIEW vBugsAuditorias (idbug, descricao, tree, sha1, repositorio, gravidade, datadeteccao, idusuariodetecta, nomeusuariodetecta, idusuariosoluciona, nomeusuariosoluciona, datasolucao, idtarefasolucao, idaudotoria, estadoauditoria, dataHoraauditoria, treeauditoria, sha1auditoria, repositorioauditoria, idusuarioauditor, nomeauditor) AS
SELECT b.idbug, b.descricao, b.tree, b.sha1, b.repositorio, b.gravidade, b.datadeteccao, b.idusuariodetecta, b.nomeusuariodetecta, b.idusuariosoluciona, B.nomeusuariosoluciona, b.datasolucao, b.idtarefasolucao, a.idauditoriabug, a.estado, a.dataHora, a.tree, a.sha1, a.idrepositorio, a.auditor, ua.nome
FROM vBugs AS b JOIN auditoriaBugs AS a ON b.idbug=a.idbug JOIN Usuarios AS ua ON a.auditor=ua.idUsuario
;


-- ------------------------------------------------------------------------
-- Visualizar tarefas relacionada à solução de um erro
-- ------------------------------------------------------------------------
CREATE OR REPLACE VIEW  vtarefasBugs (idtarefas, idprojetos, nome, descricao, datainicio, dataprevfim, datarealfim, prioridade, idbugs, descricaob, datadeteccaob, datasolucaob, gravidade, usuariodetectab, usuariosolucionab) AS
SELECT t.idtarefa, t.idprojeto, t.nome, t.descricao, t.datainicio, t.dataprevfim, t.datafim, t.prioridade, b.idbug, b.descricao, b.datadeteccao, b.datasolucao, b.gravidade, b.usuariodetecta, b.usuariosoluciona
FROM tarefas AS t JOIN bugs AS b ON b.idtarefa=t.idtarefa AND b.idprojeto=t.idprojeto
;


-- ------------------------------------------------------------------------
-- Visualizar base-lines e mudanças aprovadas para ela
-- ------------------------------------------------------------------------
CREATE OR REPLACE VIEW vBaselineMudancas (idbaseline, treeb, sha1b, datahorab, usuariomudanca, usuarioauditor, idrepositorio, idmudanca, treem, sha1m, datahoram) AS
SELECT b.idbaseline, b.tree, b.sha1, b.datahora, s.idsolicitante, a.auditor, b.idrepositorio, m.idmudanca, m.tree, m.sha1, m.datahora
FROM baselines AS b JOIN solicitacoesmudanca AS s ON b.idbaseline=s.idbaseline 
	JOIN mudancas AS m ON m.idsolicitacaomudanca=s.idsolicitacaomudanca
		JOIN auditoriasMudancas AS a ON a.idmudanca=m.idmudanca
WHERE UPPER(a.estado)='APROVADO' AND UPPER(s.estado)='APROVADO'
;

-- ------------------------------------------------------------------------
-- Visualizar historico de mensagens enviadas
-- ------------------------------------------------------------------------
CREATE OR REPLACE VIEW vMensagensEnviadas (idmensagem, idremetente, assunto, conteudo, datahora, lida, destinatario) AS
SELECT m.idmensagem, m.remetente, m.assunto, m.conteudo, m.datahora, d.msglida, d.destinatario
FROM mensagens AS m JOIN destinatarios AS d ON m.idmensagem=d.idmensagem AND m.remetente=d.remetente
WHERE m.lixeira=false AND m.excluida=false
ORDER BY m.remetente, m.datahora
;

-- ------------------------------------------------------------------------
-- Visualizar historico de mensagens na lixeira
-- ------------------------------------------------------------------------
CREATE OR REPLACE VIEW vMensagensLixeira (idmensagem, idremetente, assunto, conteudo, datahora, lida, destinatario) AS
SELECT m.idmensagem, m.remetente,  m.assunto, m.conteudo, m.datahora, d.msglida, d.destinatario
FROM mensagens AS m JOIN destinatarios AS d ON m.idmensagem=d.idmensagem AND m.remetente=d.remetente
WHERE d.lixeira=true AND d.excluida=false
ORDER BY m.datahora
;

-- ------------------------------------------------------------------------
-- Visualizar historico de mensagens recebidas
-- ------------------------------------------------------------------------
CREATE OR REPLACE VIEW vMensagensRecebidas (idmensagem, idremetente, assunto, conteudo, datahora, lida, destinatario) AS
SELECT m.idmensagem, m.remetente,  m.assunto, m.conteudo, m.datahora, d.msglida, d.destinatario
FROM mensagens AS m JOIN destinatarios AS d ON m.idmensagem=d.idmensagem AND m.remetente=d.remetente
WHERE d.lixeira=false AND d.excluida=false
ORDER BY d.destinatario, m.datahora
;


-- ------------------------------------------------------------------------
-- Visualizar solicitações de autororias de erro em aberto
-- ------------------------------------------------------------------------
CREATE OR REPLACE VIEW vsolicitacao_auditoria_bugs AS
SELECT *
FROM auditoriabugs
WHERE UPPER(estado)='SOLICITADO';

------------------------------------------------------------------------
-- Visualizar usuarios que realizam tarefas e nao foram desalocados na tarefa
-- ------------------------------------------------------------------------
CREATE OR REPLACE VIEW vrealiza AS 
 SELECT usuariorealizatarefa.idtarefa, usuariorealizatarefa.idprojeto, usuariorealizatarefa.idusuario, usuariorealizatarefa.tempo, usuariorealizatarefa.datainicio, usuariorealizatarefa.datafim, usuarios.nome
   FROM usuariorealizatarefa JOIN usuarios ON usuarios.idusuario=usuariorealizatarefa.idusuario
  WHERE usuariorealizatarefa.datafim IS NULL OR usuariorealizatarefa.datafim>CURRENT_DATE;

------------------------------------------------------------------------
-- Visualizar subtarefas em aberto
-- ------------------------------------------------------------------------
CREATE OR REPLACE VIEW vsubtarefas AS
SELECT *
FROM tarefas
WHERE idsupertarefa IS NOT NULL AND (datafim IS NULL OR datafim>CURRENT_DATE);
