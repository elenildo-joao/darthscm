<?php

class ProjetosController extends Zend_Controller_Action
{

    private $projeto;
    private $repositorio;
    private $trabalhaEm;
    private $usuario;
    private $tarefa = null;
    private $realiza = null;
    private $vUsuarioProjeto;
    private $vTarefaUsuario = null;
    private $vRealiza = null;
    private $db;

    public function init()
    {
        $this->projeto = new Projetos();
        $this->repositorio = new Repositorios();
        $this->trabalhaEm = new TrabalhaEm();
        $this->usuario = new Usuarios();
        $this->tarefa = new Tarefas();
        $this->realiza = new Realiza();
        $this->vUsuarioProjeto = new VUsuarioProjeto();
        $this->vTarefaUsuario = new VTarefaUsuario();
        $this->vRealiza = new VRealiza();
        $this->db = Zend_Db_Table::getDefaultAdapter();
    }

    public function indexAction()
    {
        $this->_forward('listar');
    }
    
    public function listarAction()
    {
        $this->view->projetos = $this->vUsuarioProjeto
                ->fetchAll(
                        $this->vUsuarioProjeto->select()->where('papel = ?', 'gerente')
                        ->order('datainicioprojeto DESC')
                        );
    }
    
    public function novoAction()
    {
        if ( !$this->_request->isPost() )
            $this->view->usuarios = $this->usuario->fetchAll();
        else
        {
            $dadosRepositorio = array(
                'endereco' => $this->_request->getPost('endereco'),
                'nome'     => 'default',
                'conta'    => 'default'
            );
            
            $dadosProjeto = array(
                'nome'        => $this->_request->getPost('nome'),
                'descricao'   => $this->_request->getPost('descricao'),
                'datainicio'  => $this->_request->getPost('dataInicio'),
                'dataprevfim' => $this->_request->getPost('dataPrevFim')
            );
            
            $dadosTrabalhaEm = array(
                'idusuario'  => $this->_request->getPost('gerente'),
                'papel'      => 'GERENTE',
                'datainicio' => $dadosProjeto['datainicio']
            );
            
            $this->repositorio->insert($dadosRepositorio);
            
            $dadosProjeto['repositorio'] = $this->db->lastInsertId('repositorios', 'idrepositorio');
            
            $this->projeto->insert($dadosProjeto);
            
            $dadosTrabalhaEm['idprojeto'] = $this->db->lastInsertId('projetos', 'idprojeto');
            
            $this->trabalhaEm->insert($dadosTrabalhaEm);
        
            $this->_redirect('/projetos/listar');
        }
    }
    
    public function editarAction()
    {     
        if ( !$this->_request->isPost() )
        {           
            $idProjeto = (int) $this->_getParam('id'); 
            
            $projeto = $this->projeto->find($idProjeto)->current();
            
            $selectGerente = $this->trabalhaEm->select()
                                       ->where('idprojeto = ?', $projeto->idprojeto)
                                       ->where('papel = ?', 'GERENTE');
            
            $idGerente = $this->trabalhaEm->fetchRow($selectGerente)->idusuario;
            
            $this->view->gerente = $this->usuario->find($idGerente)->current();            
            $this->view->projeto  = $projeto;
            $this->view->repositorio  = $projeto->findParentRepositorios();
        }
        else
        {
            $dadosProjetos = array(
                'nome'        => $this->_request->getPost('nome'),
                'descricao'   => $this->_request->getPost('descricao'),
                'datainic'    => $this->_request->getPost('dataInic'),
                'dataprevfim' => $this->_request->getPost('dataPrevFim')
            );
                        
            $dadosRepositorio = array(
                'endereco' => $this->_request->getPost('endereco')
            );
            
            $idProjeto = $this->_request->getPost('idProjeto');
            $idRepositorio = $this->_request->getPost('idRepositorio');
            
            $whereProjeto = $this->projeto->getAdapter()->quoteInto('idprojeto = ?', (int) $idProjeto);
            $whereRepositorio = $this->repositorio->getAdapter()->quoteInto('idrepositorio = ?', (int) $idRepositorio);
            
            $this->projeto->update($dadosProjetos, $whereProjeto);
            $this->repositorio->update($dadosRepositorio, $whereRepositorio); 
        
            $this->_redirect('/projetos/listar');
        }
    }
    
    public function removerAction()
    {
        $idUsuario = (int) $this->_getParam('id'); 
        $usuario = $this->usuario->find($idUsuario)->current();
        
        $whereEndereco = $this->endereco->getAdapter()->quoteInto('idendereco = ?', (int) $usuario->endereco);
        $whereLogin = $this->login->getAdapter()->quoteInto('idusuario = ?', (int) $idUsuario);
        $whereUsuario = $this->usuario->getAdapter()->quoteInto('idusuario = ?', (int) $idUsuario);
        
        $this->login->delete($whereLogin);
        $this->usuario->delete($whereUsuario);
        $this->endereco->delete($whereEndereco);
        
        $this->_redirect('/usuarios/listar');
    }

    public function listarTarefasAction()
    {
        $this->view->tarefas = $this->vTarefaUsuario
                ->fetchAll(
                        $this->vTarefaUsuario->select()->order('idtarefa')
                        );
    }      
    public function novaTarefaAction()
    {
        if ( !$this->_request->isPost() ){
            $this->view->usuarios = $this->usuario->fetchAll();
            $this->view->projetos = $this->projeto->fetchAll();
        } 
        else
        {   
            $dadosTarefa = array(
                'idprojeto' => $this->_request->getPost('nomeproj'),
                'nome' => $this->_request->getPost('nome'),
                'descricao'   => $this->_request->getPost('descricao'),
                'datainicio'  => $this->_request->getPost('dataInicio'),
                'dataprevfim' => $this->_request->getPost('dataPrevFim'),
                'prioridade' => $this->_request->getPost('prioridade')
            );
            
            $dadosRealiza = array(
                'idprojeto'  => $this->_request->getPost('nomeproj'),
                'idusuario'  => $this->_request->getPost('responsavel'),
                'tempo'      => '00:00:00',
            );
                        
            $this->tarefa->insert($dadosTarefa);
            
            $dadosRealiza['idtarefa'] = $this->db->lastInsertId('tarefas', 'idtarefa');

            $this->realiza->insert($dadosRealiza);
        
            $this->_redirect('/projetos/listar-tarefas');
        }
    }

    public function editarTarefaAction(){
        if ( !$this->_request->isPost() )
        {
            $idTarefa = (int) $this->_getParam('idtarefa'); 
            $idProjeto = (int) $this->_getParam('idprojeto'); 
            $tarefa = $this->tarefa->find($idTarefa, $idProjeto)->current();
            $this->view->tarefa  = $tarefa;
        }
        else
        {
            $dadosTarefas = array(
                'nome'     => $this->_request->getPost('nome'),
                'descricao'    => $this->_request->getPost('descricao'),
                'datainicio'      => $this->_request->getPost('dataInicio'),
                'dataprevfim' => $this->_request->getPost('dataPrevFim'),
                'prioridade' => $this->_request->getPost('prioridade')
            );
            
            $idTarefa = $this->_request->getPost('idtarefa');
            
            $whereTarefa = $this->tarefa->getAdapter()->quoteInto('idtarefa = ?', (int) $idTarefa);
            
            $this->tarefa->update($dadosTarefas, $whereTarefa);
        
            $this->_redirect('/projetos/listar-tarefas');
        }
    }

    public function removerTarefaAction(){
        $idTarefa = (int) $this->_getParam('idtarefa');
        $idProjeto = (int) $this->_getParam('idprojeto'); 
        $tarefa = $this->tarefa->find($idTarefa, $idProjeto)->current();

        $whereRealiza = $this->realiza->getAdapter()->quoteInto('idtarefa = ?', (int) $idTarefa);
        $whereTarefa = $this->tarefa->getAdapter()->quoteInto('idtarefa = ?', (int) $idTarefa);

        $this->realiza->delete($whereRealiza);
        $this->tarefa->delete($whereTarefa);
        
        $this->_redirect('/projetos/listar-tarefas');
    }

    public function fecharTarefaAction(){
        $dados = array(
            'datafim' => date("Y-m-d")
        );

        $idTarefa = $this->_request->getParam('idtarefa');
        $usuariosTarefas = $this->vRealiza->fetchAll($this->vRealiza->select()->where('idtarefa = ?', $idTarefa));
        foreach ( $usuariosTarefas as $usuarioTarefa ){
            $whereRealiza = $this->realiza->getAdapter()->quoteInto('idtarefa = ?', (int) $usuarioTarefa->idtarefa);
            $this->realiza->update($dados, $whereRealiza);
        }
        $whereTarefa = $this->tarefa->getAdapter()->quoteInto('idtarefa = ?', (int) $idTarefa);
        
        $this->tarefa->update($dados, $whereTarefa);
        $this->_redirect('/projetos/listar-tarefas');
    }

    public function alocarUsuarioTarefaAction(){
        if ( !$this->_request->isPost() )
        {
            $idProjeto = (int) $this->_getParam('idprojeto');
            $idTarefa = (int) $this->_getParam('idtarefa'); 
            $usuarioProjeto = $this->vUsuarioProjeto->find($idProjeto);
            $tarefa = $this->tarefa->find($idTarefa, $idProjeto)->current();
            $this->view->vUsuarioProjeto  = $usuarioProjeto;
            $this->view->tarefa  = $tarefa;        
        }
        else
        {
            $dadosRealiza = array(
                'idtarefa'     => $this->_request->getPost('idtarefa'),
                'idprojeto'     => $this->_request->getPost('idprojeto'),
                'idusuario'    => $this->_request->getPost('usuario'),
                'datainicio'      => date("Y-m-d"),
                'tempo' => '00:00:00'
            );
            
            $this->realiza->insert($dadosRealiza);
        
            $this->_redirect('/projetos/listar-tarefas');
        }
    }
}

