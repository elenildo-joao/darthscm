<?php

class ProjetosController extends Zend_Controller_Action
{

    private $projeto;
    private $repositorio;
    private $trabalhaEm;
    private $usuario;
    private $vUsuarioProjeto;
    private $db;

    public function init()
    {
        $this->projeto = new Projetos();
        $this->repositorio = new Repositorios();
        $this->trabalhaEm = new TrabalhaEm();
        $this->usuario = new Usuarios();
        $this->vUsuarioProjeto = new VUsuarioProjeto();
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


}

