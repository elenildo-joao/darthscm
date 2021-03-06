<?php

/** 
 * Classe responsável pelo gerenciamento de projetos no DarthSCM.
 *
 * @package DarthSCM
 * @subpackage controllers
 * @author Elenildo João <elenildo.joao@gmail.com>
 * @author Jacqueline Midlej
 * @version 0.1
 * @access public
 *
 */

class ProjetosController extends Zend_Controller_Action
{

    private $projeto;
    private $repositorio;
    private $trabalhaEm;
    private $usuario;
    private $tarefa = null;
    private $realiza = null;
    private $subtarefa = null;
    private $vUsuarioProjeto;
    private $vTarefaUsuario = null;
    private $vRealiza = null;
    private $vSubTarefa;
    private $vRelatorioCol;
    private $vRelatorioProj;
    private $db;
    private $usuarioLogado;

    /**
     * Função responsável pela inicialização das propriedades da classe, a serem
     * usuadas por todas as outras funções e actions. Realiza a verificação de 
     * autentiicação de usuário. Caso não exista, redireciona para a página de 
     * login.
     *
     * @author Elenildo João
     * @access public
     * @return void
     *
     */
    
    public function init()
    {
        if ( !Zend_Auth::getInstance()->hasIdentity() ) 
        {
            $this->_helper->layout->setLayout('informacao');
                return $this->_helper->redirector->goToRoute(
                    array('controller' => 'login') 
                    );
        }
        
        $this->usuarioLogado = Zend_Auth::getInstance()->getIdentity();
        
        $this->projeto = new Projetos();
        $this->repositorio = new Repositorios();
        $this->trabalhaEm = new TrabalhaEm();
        $this->usuario = new Usuarios();
        $this->tarefa = new Tarefas();
        $this->realiza = new Realiza();
        $this->subtarefa = new SubTarefas();
        $this->vUsuarioProjeto = new VUsuarioProjeto();
        $this->vTarefaUsuario = new VTarefaUsuario();
        $this->vRealiza = new VRealiza();
        $this->vSubTarefa = new VSubTarefa();
        $this->vRelatorioCol = new VRelatorioProdCol();
        $this->vRelatorioProj = new VRelatorioProdProj();
        $this->db = Zend_Db_Table::getDefaultAdapter();
        
        $this->view->usuarioLogado = $this->usuario->find(
                $this->usuarioLogado->idusuario
                )->current();
    }

    /**
     * Redireciona para a action listar.
     *
     * @author Elenildo João
     * @access public
     * @return void
     *
     */
    
    public function indexAction()
    {
        $this->_forward('listar');
    }
    
    /**
     * Action responsável pela lista de projetos.
     *
     * @author Elenildo João
     * @access public
     * @return void
     *
     */
    
    public function listarAction()
    {
        $usuario = $this->usuario->find($this->usuarioLogado->idusuario)->current();
        if ($usuario->admin=='t')
        {

        $paginator = Zend_Paginator::factory(
           $this->projeto
                    ->fetchAll(
                            $this->projeto->select()->from('projetos', array('idprojeto'=>'idprojeto', 'nomeprojeto'=>'nome', 'descricao'=>'descricao', 'datainicioprojeto'=>'datainicio', 'dataprevfim'=>'dataprevfim', 'datafim'=>'datafim'))
                            ->order('datainicio DESC')
                            ));       
   
        $paginator->setItemCountPerPage(2);
        $this->view->paginator = $paginator;
        $paginator->setCurrentPageNumber($this->_getParam('page'));

        }
        else 
        {
        $paginator = Zend_Paginator::factory(
           $this->vUsuarioProjeto
                    ->fetchAll(
                            $this->vUsuarioProjeto->select()
                            ->where('idusuario= ? ', $this->usuarioLogado->idusuario)
                            ->order('datainicioprojeto DESC')
                            ));       
   
        $paginator->setItemCountPerPage(2);
        $this->view->paginator = $paginator;
        $paginator->setCurrentPageNumber($this->_getParam('page'));
        }
    }
    
    /**
     * Action responsável pela criação de um novo projeto.
     *
     * @author Elenildo João
     * @access public
     * @return void
     *
     */
    
    public function novoAction()
    {
        if ( !$this->_request->isPost() )
            $this->view->usuarios = $this->usuario->fetchAll();
        else
        {
            $dadosRepositorio = array(
                'endereco' => $this->_request->getPost('repositorio'),
                'nome'     => 'default',
                'conta'    => 'default'
            );
            
           $dataInicio = explode('/', $this->_request->getPost('dataInicio'));
           $dataPrevFim = explode('/', $this->_request->getPost('dataPrevFim'));
           
           $dataInicio = array($dataInicio[2], $dataInicio[1], $dataInicio[0]);
           $dataPrevFim = array($dataPrevFim[2], $dataPrevFim[1], $dataPrevFim[0]);
           
           $dataInicio = implode('-', $dataInicio);
           $dataPrevFim = implode('-', $dataPrevFim);
            
            $dadosProjeto = array(
                'nome'        => $this->_request->getPost('nome'),
                'descricao'   => $this->_request->getPost('descricao'),
                'datainicio'  => $dataInicio,
                'dataprevfim' => $dataPrevFim
            );
            
            $dadosTrabalhaEm = array(
                'idusuario'  => $this->_request->getPost('gerente'),
                'papel'      => 'gerente',
                'datainicio' => $dadosProjeto['datainicio']
            );
            
            $this->repositorio->insert($dadosRepositorio);
            
            $dadosProjeto['idrepositorio'] = $this->db->lastInsertId('repositorios', 'idrepositorio');
            
            $this->projeto->insert($dadosProjeto);
            
            $dadosTrabalhaEm['idprojeto'] = $this->db->lastInsertId('projetos', 'idprojeto');
            
            $this->trabalhaEm->insert($dadosTrabalhaEm);
            
            $this->view->mensagemErro='Projeto Cadastrado com Sucesso!';

//            $this->_redirect('/projetos/listar');
        }
    }
    
    /**
     * Action responsável pela atualização das informações de um projeto.
     *
     * @author Elenildo João
     * @access public
     * @return void
     *
     */
    
    public function editarAction()
    {     
        if ( !$this->_request->isPost() )
        {           
            $idProjeto = (int) $this->_getParam('idprojeto'); 
            
            $projeto = $this->projeto->find($idProjeto)->current();
            
            $selectGerente = $this->trabalhaEm->select()
                                       ->where('idprojeto = ?', $projeto->idprojeto)
                                       ->where('papel = ?', 'gerente')
                                       ->orWhere('papel = ?', 'GERENTE');
            
            $idGerente = $this->trabalhaEm->fetchRow($selectGerente)->idusuario;
            
            $this->view->gerente = $this->usuario->find($idGerente)->current();            
            $this->view->projeto  = $projeto;
            $this->view->repositorio  = $projeto->findParentRepositorios();
        }
        else
        {
            $dadosProjeto = array(
                'nome'        => $this->_request->getPost('nome'),
                'descricao'   => $this->_request->getPost('descricao'),
                'datainicio'    => $this->_request->getPost('dataInicio'),
                'dataprevfim' => $this->_request->getPost('dataPrevFim')
            );
                        
            $dadosRepositorio = array(
                'endereco' => $this->_request->getPost('repositorio')
            );
            
            $idProjeto = $this->_request->getPost('idProjeto');
            $idRepositorio = $this->_request->getPost('idRepositorio');
            
            $whereProjeto = $this->projeto->getAdapter()
                    ->quoteInto('idprojeto = ?', (int) $idProjeto);
            $whereRepositorio = $this->repositorio->getAdapter()
                    ->quoteInto('idrepositorio = ?', (int) $idRepositorio);
            
            $this->projeto->update($dadosProjeto, $whereProjeto);
            $this->repositorio->update($dadosRepositorio, $whereRepositorio); 
            $this->view->mensagemErro='Projeto Alterado com Sucesso!';
 //           $this->_redirect('/projetos/listar');
        }
    }
    
    /**
     * Action responsável pela remoção de um projeto.
     *
     * @author Elenildo João
     * @access public
     * @return void
     *
     */
    
    public function removerAction()
    {
        $idProjeto = (int) $this->_getParam('idprojeto'); 
        $projeto = $this->projeto->find($idProjeto)->current();
        
        $whereProjeto = $this->projeto->getAdapter()
                ->quoteInto('idprojeto = ?', (int) $idProjeto);
        $whereRepositorio = $this->repositorio->getAdapter()
                ->quoteInto('idrepositorio = ?', (int) $projeto->idrepositorio);
        $whereTrabalhaEm = $this->trabalhaEm->getAdapter()
                ->quoteInto('idprojeto = ?', (int) $idProjeto);
        $whereRealiza = $this->realiza->getAdapter()
                ->quoteInto('idprojeto = ?', (int) $idProjeto);
        $whereTarefa = $this->tarefa->getAdapter()
                ->quoteInto('idprojeto = ?', (int) $idProjeto);
        
        $this->trabalhaEm->delete($whereTrabalhaEm);
        $this->realiza->delete($whereRealiza);
        $this->tarefa->delete($whereTarefa);
        $this->projeto->delete($whereProjeto);
        $this->repositorio->delete($whereRepositorio);
        $this->view->mensagemErro='Projeto Removido com Sucesso!';       
//        $this->_redirect('/projetos/listar');
    }
    
    /**
     * Action responsável pelo fechamento de um projeto.
     *
     * @author Elenildo João
     * @access public
     * @return void
     *
     */
    
    public function fecharAction()
    {
        $idProjeto = (int) $this->_getParam('idprojeto'); 
        
        $dados = array(
            'datafim' => date('Y-m-d')
        );
        
        $whereProjeto = $this->projeto->getAdapter()
                ->quoteInto('idprojeto = ?', $idProjeto);
        $whereTrabalhaEm = $this->trabalhaEm->getAdapter()
                ->quoteInto('idprojeto = ?', $idProjeto);
        $whereTarefa = $this->tarefa->getAdapter()
                ->quoteInto('idprojeto = ?', $idProjeto);
        
        $this->tarefa->update($dados, $whereTarefa);
        $this->trabalhaEm->update($dados, $whereTrabalhaEm);
        $this->projeto->update($dados, $whereProjeto);
        $this->view->mensagemErro='Projeto Fechado com Sucesso!';               
 //       $this->_redirect('/projetos/listar');
    }
    
    /**
     * Action responsável pela alocação de um colaborador a um projeto.
     *
     * @author Elenildo João
     * @access public
     * @return void
     *
     */
    
    public function alocarColaboradorAction()
    {        
        if ( !$this->_request->isPost() )
        {
            $idProjeto = (int) $this->_getParam('idprojeto');
            $this->view->idProjeto = $idProjeto;
            $usuariosProjeto = $this->vUsuarioProjeto->fetchAll(
                    $this->vUsuarioProjeto->select()
                        ->where('idprojeto = ?', $idProjeto)
                    );
            $this->view->vUsuarioProjeto  = $usuariosProjeto;
        $this->view->idProjeto = $idProjeto;
            
            $usuariosNaoAlocados = $this->trabalhaEm->fetchAll(
                    $this->trabalhaEm->select()
//                        ->from($this->trabalhaEm, 'idusuario')
                        ->where('idprojeto = ?', $idProjeto)
                    );

            $idsUsuarios = array();

            foreach($usuariosNaoAlocados as $idUsuario)
            {
                $idsUsuarios[] = $idUsuario->idusuario;
            }

            $select = $this->usuario->select()->where('idusuario not in (?)', $idsUsuarios);
            $this->view->usuarios = $this->usuario->fetchAll($select);
        
        }
        else
        {
            $idUsuario=$this->_request->getPost('idusuario');            
            $idProjeto=$this->_request->getPost('idprojeto');
            $dados = array(
                'idprojeto'  => $idProjeto,
                'idusuario'  => $idUsuario,
                'papel'      => $this->_request->getPost('papel'),
                'datainicio' => date('Y-m-d H:i:s')
            );
            $dadosAtualizar = array(
                'papel'      => $this->_request->getPost('papel'),
                'datainicio' => date('Y-m-d H:i:s'),
                'datafim' => null
            );
            $usuTrabalhaEm = $this->trabalhaEm->find($idUsuario, $idProjeto)->current();
            
            if($usuTrabalhaEm){
                $whereAtualiza = $this->trabalhaEm->getAdapter()->quoteInto('idusuario = ?', (int) $idUsuario).
                                 $this->trabalhaEm->getAdapter()->quoteInto('AND idprojeto = ?', (int) $idProjeto);
                $this->trabalhaEm->update($dadosAtualizar, $whereAtualiza);
            } else{
            $this->trabalhaEm->insert($dados);
            }
            $this->view->mensagem = 'Usuário alocado com sucesso.';
            $this->view->idProjeto = $dados['idprojeto'];
            $this->_redirect('/projetos/listar/idprojeto/'.$idProjeto.'/');
        }
    }
    
    /**
     * Action responsável por desalocar um colaborador de um projeto.
     *
     * @author Jacqueline Midlej
     * @access public
     * @return void
     *
     */
    
    public function desalocarColaboradorAction(){
        if ( !$this->_request->isPost() )
        {
            $idProjeto = (int) $this->_getParam('idprojeto');
            $this->view->projeto = $this->projeto->find($idProjeto)->current();
            $usuariosProjeto = $this->vUsuarioProjeto->fetchAll(
                    $this->vUsuarioProjeto->select()
//                        ->from($this->trabalhaEm, 'idusuario')
                        ->where('idprojeto = ?', $idProjeto)
                    );
            $this->view->vUsuarioProjeto  = $usuariosProjeto;
        }
        else
        {
            $dadosTrabalha = array(
                'datafim'      => date("Y-m-d")
            );
            $idProjeto = $this->_request->getPost('idprojeto');
            $idUsuario = $this->_request->getPost('usuario');
            $projeto = $this->projeto->find($idProjeto)->current();

            $this->view->projeto  = $projeto;

            $tarefas = $this->vRealiza
                ->fetchAll(
                        $this->vRealiza->select()->where('idprojeto = ?', $idProjeto)->where('idusuario = ?', $idUsuario)->where('idusuario = ?', $idUsuario)
                        );
            $this->view->vRealiza  = $tarefas;

            foreach($this->vRealiza as $tarefa):
                $whereRealiza = $this->realiza->getAdapter()->quoteInto('idtarefa = ?', $tarefa->idtarefa).
                                $this->realiza->getAdapter()->quoteInto('AND idprojeto = ?', $tarefa->idprojeto).
                                $this->realiza->getAdapter()->quoteInto('AND idusuario = ?', (int) $idUsuario);
                $this->realiza->update($dadosRealiza, $whereRealiza);
            endforeach;            

            $whereTrabalha = $this->trabalhaEm->getAdapter()->quoteInto('idusuario = ?', (int) $idUsuario).
                             $this->trabalhaEm->getAdapter()->quoteInto('AND idprojeto = ?', (int) $idProjeto);
            $this->trabalhaEm->update($dadosTrabalha, $whereTrabalha);

            $this->_redirect('/projetos/listar/idprojeto/'.$idProjeto.'/');
        }
    }    
    
    /**
     * Action responsável pela lista de tarefas de um projeto.
     *
     * @author Jacqueline Midlej
     * @access public
     * @return void
     *
     */
    
    public function listarTarefasAction()
    {
        $paginator = Zend_Paginator::factory(
                         $this->tarefa
                ->fetchAll(
                        $this->tarefa->select()->where('idprojeto = ?', $this->_getParam('idprojeto'))->order('datafim DESC')
                        ));

        $paginator->setItemCountPerPage(2);
        $this->view->paginator = $paginator;
        $paginator->setCurrentPageNumber($this->_getParam('page'));
        

        $this->view->SubTarefas = $this->subtarefa
                ->fetchAll(
                        $this->subtarefa->select()->where('idprojeto = ?', $this->_getParam('idprojeto'))
                        );
        $this->view->vRealiza = $this->vRealiza
                ->fetchAll(
                        $this->vRealiza->select()->where('idprojeto = ?', $this->_getParam('idprojeto'))->order('nome')
                        );
        
        $this->view->VTarefaUsuario = $this->vTarefaUsuario
                ->fetchAll(
                        $this->vTarefaUsuario->select()->where('idprojeto = ?', $this->_getParam('idprojeto'))->order('nomeusuario')
                        );
    }      
    
    /**
     * Action responsável pela criação de uma nova tarefa.
     *
     * @author Jacqueline Midlej
     * @access public
     * @return void
     *
     */
    
    public function novaTarefaAction()
    {
        if ( !$this->_request->isPost() ){
            $this->view->usuarios = $this->usuario->fetchAll();
            $idProjeto = (int) $this->_getParam('idprojeto'); 
            $projeto = $this->projeto->find($idProjeto)->current();
            $this->view->projeto  = $projeto;
//            $this->view->projetos = $this->projeto->fetchAll();
        } 
        else
        {   
            $dadosTarefa = array(
                'idprojeto' => (int) $this->_request->getPost('idprojeto'),
                'nome' => $this->_request->getPost('nome'),
                'descricao'   => $this->_request->getPost('descricao'),
                'datainicio'  => $this->_request->getPost('dataInicio'),
                'dataprevfim' => $this->_request->getPost('dataPrevFim'),
                'prioridade' => $this->_request->getPost('prioridade')
            );
            
            $dadosRealiza = array(
                'idprojeto'  => (int) $this->_request->getPost('idprojeto'),
                'idusuario'  => $this->_request->getPost('responsavel'),
                'tempo'      => '00:00:00',
                'datainicio' => $this->_request->getPost('dataInicio')
            );
                        
            $this->tarefa->insert($dadosTarefa);
            
            $dadosRealiza['idtarefa'] = $this->db->lastInsertId('tarefas', 'idtarefa');

            $this->realiza->insert($dadosRealiza);
            
            $projeto = $this->projeto->find($this->_request->getPost('idprojeto'))->current();
            $this->view->projeto  = $projeto;
            $this->view->mensagemErro='Tarefa Cadastrada com Sucesso!';
//            $this->_redirect('/projetos/listar-tarefas');
            }
    }
    
    /**
     * Action responsável pela atualização de uma tarefa.
     *
     * @author Jacqueline Midlej
     * @access public
     * @return void
     *
     */

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
            $idProjeto = $this->_request->getPost('idprojeto');
            $whereTarefa = $this->tarefa->getAdapter()->quoteInto('idtarefa = ?', (int) $idTarefa);
            
            $this->tarefa->update($dadosTarefas, $whereTarefa);            
            
            $tarefa = $this->tarefa->find($idTarefa, $idProjeto)->current();
            $this->view->tarefa  = $tarefa;
            $this->view->mensagemErro='Tarefa Alterada com Sucesso!';
//            $this->_redirect('/projetos/editar-tarefa/idprojeto/'.$idProjeto.'/idtarefa'.$idTarefa);
        }
    }
    
    /**
     * Função responsável pela remoção de uma tarefa.
     *
     * @author Jacqueline Midlej
     * @access private
     * @param int $idTarefa
     * @param int $idProjeto
     * @return void
     *
     */
    
    private function removeTarefa($idTarefa, $idProjeto) {
        $tarefa = $this->tarefa->find($idTarefa, $idProjeto)->current();

        $whereRealiza = $this->realiza->getAdapter()->quoteInto('idtarefa = ?', (int) $idTarefa);
        $whereTarefa = $this->tarefa->getAdapter()->quoteInto('idtarefa = ?', (int) $idTarefa);

        $this->realiza->delete($whereRealiza);

        $subTarefas = $this->tarefa->fetchAll($this->tarefa->select()->where('idsupertarefa = ?', $idTarefa));
        foreach ( $subTarefas as $subTarefa ){
            $this->removeTarefa($subTarefa->idtarefa, $subTarefa->idprojeto);
        }
        $this->tarefa->delete($whereTarefa);     
    }
    
    /**
     * Action responsável pela remoção de uma tarefa.
     *
     * @author Jacqueline Midlej
     * @access public
     * @return void
     *
     */

    public function removerTarefaAction(){
        $idTarefa = (int) $this->_getParam('idtarefa');
        $idProjeto = (int) $this->_getParam('idprojeto'); 
        $tarefa = $this->tarefa->find($idTarefa, $idProjeto)->current();
        $this->view->tarefa  = $tarefa;
        $this->removeTarefa($idTarefa, $idProjeto);
        $this->view->mensagemErro='Tarefa Removida com Sucesso!';        
//        $this->_redirect('/projetos/listar-tarefas/');
    }

    /**
     * Action responsável pelo fechamento de uma tarefa.
     *
     * @author Jacqueline Midlej
     * @access public
     * @return void
     *
     */
    
    public function fecharTarefaAction(){
        $idTarefa = $this->_request->getParam('idtarefa');
        $idProjeto = $this->_request->getParam('idprojeto');        $tarefa = $this->tarefa->find($idTarefa, $idProjeto)->current();
        $this->view->tarefa  = $tarefa;
        $this->fechaTarefa($idTarefa);
        $this->view->mensagemErro='Tarefa Fechada com Sucesso!';
//        $this->_redirect('/projetos/listar-tarefas');
    }
    
    /**
     * Função responsável pelo fechamento de uma tarefa.
     *
     * @author Jacqueline Midlej
     * @access private
     * @param int $idTarefa
     * @return void
     *
     */
    
    private function fechaTarefa($idTarefa){
        $dados = array(
            'datafim' => date("Y-m-d")
        );

        $usuariosTarefas = $this->vRealiza->fetchAll($this->vRealiza->select()->where('idtarefa = ?', $idTarefa));

        foreach ( $usuariosTarefas as $usuarioTarefa ){
            $whereRealiza = $this->realiza->getAdapter()->quoteInto('idtarefa = ?', (int) $usuarioTarefa->idtarefa);
            $this->realiza->update($dados, $whereRealiza);
        }

        $subTarefas = $this->vSubTarefa->fetchAll($this->vSubTarefa->select()->where('idsupertarefa = ?', $idTarefa));
        foreach ( $subTarefas as $subTarefa ){
            $this->fechaTarefa($subTarefa->idtarefa);
        }

        $whereTarefa = $this->tarefa->getAdapter()->quoteInto('idtarefa = ?', (int) $idTarefa);
        $this->tarefa->update($dados, $whereTarefa);
    }
    
    /**
     * Action responsável pela alocação de um usuário a uma tarefa.
     *
     * @author Jacqueline Midlej
     * @access public
     * @return void
     *
     */
    
    public function alocarUsuarioTarefaAction(){
        if ( !$this->_request->isPost() )
        {
            $idProjeto = (int) $this->_getParam('idprojeto');
            $idTarefa = (int) $this->_getParam('idtarefa'); 
            $usuarioProjeto = $this->vUsuarioProjeto->find($idProjeto);
            $tarefa = $this->tarefa->find($idTarefa, $idProjeto)->current(); 
            $usuarioTarefa = $this->vRealiza->find($idTarefa, $idProjeto);
            $this->view->vUsuarioProjeto  = $usuarioProjeto;
            $this->view->vRealiza = $usuarioTarefa; 
            $this->view->tarefa  = $tarefa;
        }
        else
        {
            $idTarefa=$this->_request->getPost('idtarefa');
            $idProjeto=$this->_request->getPost('idprojeto');
            $idUsuario=$this->_request->getPost('usuario');
            $tarefa = $this->tarefa->find($idTarefa, $idProjeto)->current();
            $this->view->tarefa  = $tarefa;
            $dadosRealiza = array(
                'idtarefa'     => $idTarefa,
                'idprojeto'     => $idProjeto,
                'idusuario'    => $idUsuario,
                'datainicio'      => date("Y-m-d"),
                'tempo' => '00:00:00'
            );

            $dadosAtualiza = array('datafim' => null);
            
            $usuRealizaTar = $this->realiza->find($idTarefa, $idProjeto, $idUsuario)->current();
            
            if($usuRealizaTar){
                $whereAtualiza = $this->realiza->getAdapter()->quoteInto('idtarefa = ?', (int) $idTarefa).
                                 $this->realiza->getAdapter()->quoteInto('AND idusuario = ?', (int) $idUsuario);
                $this->realiza->update($dadosAtualiza, $whereAtualiza);
            }
            else{
                $this->realiza->insert($dadosRealiza);
            }
            
            $this->_redirect('/projetos/listar-tarefas/idprojeto/'.$idProjeto.'/');
        }
    }
    
    /**
     * Action responsável por desalocar um usuário de uma tarefa.
     *
     * @author Jacqueline Midlej
     * @access public
     * @return void
     *
     */
    
    public function desalocarUsuarioTarefaAction(){
        if ( !$this->_request->isPost() )
        {
            $idProjeto = (int) $this->_getParam('idprojeto');
            $idTarefa = (int) $this->_getParam('idtarefa'); 
            $usuariosTarefas = $this->vRealiza->find($idTarefa, $idProjeto);
            $tarefa = $this->tarefa->find($idTarefa, $idProjeto)->current();
            $this->view->vRealiza  = $usuariosTarefas;
            $this->view->tarefa  = $tarefa; 
        }
        else
        {
            $dadosRealiza = array(
                'datafim'      => date("Y-m-d")
            );
            $idProjeto = $this->_request->getPost('idprojeto');             
            $idTarefa = $this->_request->getPost('idtarefa'); 
            $idUsuario = $this->_request->getPost('usuario'); 
            $tarefa = $this->tarefa->find($idTarefa, $idProjeto)->current();
            $this->view->tarefa  = $tarefa;
            $usuariosTarefas = $this->vRealiza->fetchAll($this->vRealiza->select()->where('idtarefa = ?', $idTarefa)->where ('idusuario = ?', $idUsuario));
            
            foreach ( $usuariosTarefas as $usuarioTarefa ){
                $whereRealiza = $this->realiza->getAdapter()->quoteInto('idusuario = ?', (int) $usuarioTarefa->idusuario).
                                $this->realiza->getAdapter()->quoteInto('AND idtarefa = ?', (int) $usuarioTarefa->idtarefa).
                                $this->realiza->getAdapter()->quoteInto('AND idprojeto = ?', (int) $usuarioTarefa->idprojeto);
                $this->realiza->update($dadosRealiza, $whereRealiza);
            }

            $this->_redirect('/projetos/listar-tarefas/idprojeto/'.$idProjeto.'/');
        }
    }
    
    /**
     * Action responsável pela criação de uma nova sub-tarefa.
     *
     * @author Jacqueline Midlej
     * @access public
     * @return void
     *
     */
    
    public function novaSubTarefaAction()
    {
        if ( !$this->_request->isPost() ){
            $idProjeto = $this->_getParam('idprojeto');
            $idTarefa = $this->_getParam('idtarefa'); 
            $tarefa = $this->tarefa->find($idTarefa, $idProjeto)->current();
            $usuarioProjeto = $this->vUsuarioProjeto->find($idProjeto);
            $this->view->vUsuarioProjeto = $usuarioProjeto;
            $this->view->tarefa = $tarefa;
        } 
        else
        {
            $idProjeto = $this->_request->getPost('idprojeto');             
            $idTarefa = $this->_request->getPost('idtarefa'); 
            $dadosTarefa = array(
                'idprojeto' => $idProjeto,
                'nome' => $this->_request->getPost('nome'),
                'descricao'   => $this->_request->getPost('descricao'),
                'datainicio'  => $this->_request->getPost('dataInicio'),
                'dataprevfim' => $this->_request->getPost('dataPrevFim'),
                'prioridade' => $this->_request->getPost('prioridade'),
                'idsupertarefa' => $idTarefa,
                'idprojetosupertarefa' => $idProjeto
            );
            
            $dadosRealiza = array(
                'idprojeto'  => $idProjeto,
                'idusuario'  => $this->_request->getPost('responsavel'),
                'tempo'      => '00:00:00',                        
                'datainicio' => $this->_request->getPost('dataInicio')
            );
                        
            $this->tarefa->insert($dadosTarefa);
            
            $dadosRealiza['idtarefa'] = $this->db->lastInsertId('tarefas', 'idtarefa');

            $this->realiza->insert($dadosRealiza);
            $tarefa = $this->tarefa->find($idTarefa, $idProjeto)->current();
            $this->view->tarefa = $tarefa;
            $this->view->mensagemErro='Nova Sub-Tarefa Cadastrada com Sucesso!';        
 //           $this->_redirect('/projetos/listar-tarefas');
        }
    }
    
    /**
     * Action responsável pela adição de tempo de trabalho em uma tarefa.
     *
     * @author Jacqueline Midlej
     * @access public
     * @return void
     *
     */
            
    public function adicionarTempoAction(){        
        if ( !$this->_request->isPost() )
        {
            $idProjeto = (int) $this->_getParam('idprojeto');
            $idTarefa = (int) $this->_getParam('idtarefa'); 
            $tarefaUsuario = $this->vTarefaUsuario->find($idTarefa, $idProjeto);
            $this->view->vTarefaUsuario  = $tarefaUsuario;
            $tarefa = $this->tarefa->find($idTarefa, $idProjeto)->current();
            $this->view->tarefa  = $tarefa;
        }
        else
        {    
            $int1=new DateInterval('P0D');
            
            $idTarefa=$this->_request->getPost('idtarefa');
            $idProjeto=$this->_request->getPost('idprojeto');                        
            $idUsuario=$this->_request->getPost('usuario');
            
//            $int1->d=$this->_request->getPost('dias');
//            $int1->h=$this->_request->getPost('horas');
//            $int1->i=$this->_request->getPost('minutos');
            $tempo=$this->_request->getPost('tempo');
            $realiza = $this->realiza->find($idTarefa, $idProjeto, (int) $this->usuarioLogado->idusuario)->current();
            projetos::trataInterval (&$tempo, &$int1);             
            $tempo=$realiza->tempo;
            $int2=new DateInterval('P0D');
            $d2="";$h2="";$m2="";
            projetos::trataInterval (&$tempo, &$int2); 
            $int2=projetos::SomaInterval($int1, $int2);
            
            if ($int2->d==0){
                $dadosRealiza = array(
                    'tempo'      => $int2->h.':'.$int2->i.':00'
                );
            }
            else {
                $dadosRealiza = array(
                    'tempo'      => $int2->d.' '.$int2->h.':'.$int2->i.':00'
                );
            }  
            $whereRealiza = $this->realiza->getAdapter()->quoteInto('idusuario = ?', (int) $this->usuarioLogado->idusuario).
                            $this->realiza->getAdapter()->quoteInto('AND idtarefa = ?', (int) $idTarefa);
            $this->realiza->update($dadosRealiza, $whereRealiza);
            $tarefa = $this->tarefa->find($idTarefa, $idProjeto)->current();
            $this->view->tarefa  = $tarefa;

//            $this->view->mensagemErro='Tempo Adicionado com Sucesso!';
            $this->_redirect('/projetos/listar-tarefas/idprojeto/'.$idProjeto.'/');
        } 
    }
    
    /**
     * Action responsável pela geração do relatório de produtividade dos 
     * colaboradores.
     *
     * @author Jacqueline Midlej
     * @access public
     * @return void
     *
     */

     public function relatorioColaboradorAction (){
     
        $this->view->vRelatorioCol = $this->vRelatorioCol
                ->fetchAll(
                        $this->vRelatorioCol->select()->order('nomeprojeto')->order('nomeusuario')
                        );
     }
     
     /**
     * Action responsável pela geração do relatório de produtividade nos 
     * projetos.
     *
     * @author Jacqueline Midlej
     * @access public
     * @return void
     *
     */
     
     public function relatorioProjetoAction (){
     
     $this->view->vRelatorioProj = $this->vRelatorioProj
                ->fetchAll(
                        $this->vRelatorioProj->select()->order('nomeprojeto')
                        );
     }
     
     /**
     * Action responsável pela geração do gráfico de dedicação aos projetos.
     *
     * @author Jacqueline Midlej
     * @access public
     * @return void
     *
     */
     
     public function graficoRelProjetoAction (){
          $this->view->vRelatorioProj = $this->vRelatorioProj
                ->fetchAll(
                        $this->vRelatorioProj->select()->order('nomeprojeto')
                        );
        $this->view->vRelatorioCol = $this->vRelatorioCol
                ->fetchAll(
                        $this->vRelatorioCol->select()->order('nomeusuario')
                        );
        $this->view->visao1 = $this->vRelatorioCol
                ->fetchAll(
                        $this->vRelatorioCol->select()->order('nomeprojeto')->order('nomeusuario')
                        );
     }
     
     /**
     * Action responsável pela exibição detalhada de um projeto.
     *
     * @author Jacqueline Midlej
     * @access public
     * @return void
     *
     */
     
     public function detalharProjetoAction () {
         
                 $idProjeto = (int) $this->_getParam('idprojeto');

         $paginator = Zend_Paginator::factory(
            $this->tarefa
                   ->fetchAll(
                        $this->tarefa->select()->where('idprojeto = ?', $idProjeto)->order('nome')
                        ));
        
        $paginator->setItemCountPerPage(4);
        $this->view->paginator = $paginator;
        $paginator->setCurrentPageNumber($this->_getParam('page'));
         
         $projeto = $this->projeto->find($idProjeto)->current();
         
         $this->view->projeto = $projeto;         
         
        
         $this->view->vUsuarioProjeto = $this->vUsuarioProjeto
                   ->fetchAll(
                        $this->vUsuarioProjeto->select()->where('idprojeto = ?', $idProjeto)->order('nomeusuario')
                        );
         
     }
     
     /**
     * Action responsável pela geração do relatório geral de cada projeto.
     *
     * @author Jacqueline Midlej
     * @access public
     * @return void
     *
     */
     
     public function relatorioParticipacaoAction () {
         
         $idProjeto = (int) $this->_getParam('idprojeto');
         
         $this->view->vUsuarioProjeto = $this->vUsuarioProjeto
                   ->fetchAll(
                        $this->vUsuarioProjeto->select()->where('idprojeto = ?', $idProjeto)->order('datainiciousuario')->order('datafimusuario')
                        );
         
         $this->view->vTarefaUsuario = $this->vTarefaUsuario
                   ->fetchAll(
                        $this->vTarefaUsuario->select()->where('idprojeto = ?', $idProjeto)->order('nometarefa')
                        );         
                  
         $this->view->tarefas = $this->tarefa
                   ->fetchAll(
                        $this->tarefa->select()->where('idprojeto = ?', $idProjeto)
                        );
     }
     
     /**
     * Action responsável pela exibição detalhada de uma tarefa.
     *
     * @author Jacqueline Midlej
     * @access public
     * @return void
     *
     */
     
     public function detalharTarefaAction () {
         
                 $idProjeto = (int) $this->_getParam('idprojeto');
                 $idTarefa = (int) $this->_getParam('idtarefa');
                 
         $tarefa = $this->tarefa->find($idTarefa, $idProjeto)->current();
         
         $this->view->tarefas = $tarefa;         
/*         $this->view->tarefas = $this->tarefa
                   ->fetchAll(
                        $this->tarefa->select()->where('idprojeto = ?', $idProjeto)->where('idtarefa = ?', $idTarefa)
                        );*/
         
         $this->view->vRealiza = $this->vRealiza
                ->fetchAll(
                        $this->vRealiza->select()->where('idprojeto = ?', $idProjeto)->where('idtarefa = ?', $idTarefa)->order('nome')
                        );
        
        $this->view->vTarefaUsuario = $this->vTarefaUsuario
                ->fetchAll(
                        $this->vTarefaUsuario->select()->where('idtarefa = ?', $idTarefa)->order('nomeusuario')
                        );

        $paginator = Zend_Paginator::factory(
        $this->subtarefa
                ->fetchAll(
                        $this->subtarefa->select()->where('idsupertarefa = ?', $idTarefa)->order('nome')
                        ));         
        
        $paginator->setItemCountPerPage(4);
        $this->view->paginator = $paginator;
        $paginator->setCurrentPageNumber($this->_getParam('page'));
     }
     
}