<?php

/** 
 * Classe responsável pela página inicial do DarthSCM.
 * 
 * @package DarthSCM
 * @subpackage controllers
 * @author Elenildo João <elenildo.joao@gmail.com> 
 * @author Jacqueline Midlej
 * @version 0.1
 * @access public
 *
 */

class IndexController extends Zend_Controller_Action
{
    
    private $usuarioLogado;
    private $usuario;

    private $usuarioProjeto;
    
    private $vUsuarioProjeto;
    private $vTarefaUsuario;
//  private $mensagem;
//  private $destinatario;
    private $vMsgRecebida;

    /**
     * Função responsável pela inicialização das propriedades da classe, a serem
     * usuadas por todas as outras funções e actions. Realiza a verificação de 
     * autentiicação de usuário. Caso não exista, redireciona para a página de 
     * login.
     *
     * @author Elenildo João <elenildo.joao@gmail.com>
     * @access public
     * @return void
     *
     */
    
    public function init()
    {
        if ( !Zend_Auth::getInstance()->hasIdentity() ) 
        {
            return $this->_helper->redirector->goToRoute( 
                    array('controller' => 'login') 
                    );
        }
        
        $this->usuarioLogado = Zend_Auth::getInstance()->getIdentity();
        
        $this->usuario = new Usuarios();
        $this->usuarioProjeto = new VUsuarioProjeto();
        $this->usuarioTarefa = new VTarefaUsuario();
        //$this->mensagem = new Mensagens();
        //$this->destinatario = new Destinatarios();
        $this->vMsgRecebida = new VMsgRecebida();
        
        $this->view->usuarioLogado = $this->usuario->find(
                $this->usuarioLogado->idusuario
                )->current();
        
        $this->vUsuarioProjeto = new VUsuarioProjeto();
        $this->vTarefaUsuario = new VTarefaUsuario();
    }
    
    /**
     * Action responsável pela página inicial do DarthSCM. Exibe informação dos
     * últimos projetos, tarefas e um contador com o número de mensagens não 
     * lidas. 
     *
     * @author Jacqueline Midlej
     * @access public
     * @return void
     *
     */
    
    public function indexAction(){
        $paginator = Zend_Paginator::factory(
        $this->usuarioProjeto
            ->fetchAll(
                $this->usuarioProjeto->select()->where('idusuario = ?', $this->usuarioLogado->idusuario)->order('datainiciousuario')->order('datafimusuario')
                ));

        $paginator->setItemCountPerPage(4);
        $this->view->paginator = $paginator;
        $paginator->setCurrentPageNumber($this->_getParam('page'));

        $paginator2 = Zend_Paginator::factory(
        $this->usuarioTarefa
            ->fetchAll(
                $this->usuarioTarefa->select()->where('idusuario = ?', $this->usuarioLogado->idusuario)->order('datafimtarefa')
                ));

        $paginator2->setItemCountPerPage(4);
        $this->view->paginator2 = $paginator2;
        $paginator2->setCurrentPageNumber($this->_getParam('page2'));

        $this->view->vMsgRecebida=$this->vMsgRecebida
            ->fetchAll(
                $this->vMsgRecebida->select()->where('destinatario = ?', $this->usuarioLogado->idusuario)->where('lida = ?', 'f')
                );
    }
}