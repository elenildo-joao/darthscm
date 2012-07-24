<?php

/**
 * Classe responsável pelas informações de suporte do DarthSCM.
 *
 * @package DarthSCM
 * @subpackage controllers
 * @author Jacqueline Midlej
 * @version 0.1
 * @access public
 *
 */

class SuporteController extends Zend_Controller_Action
{
    
    /**
     * Função responsável pela inicialização das propriedades da classe, a serem
     * usuadas por todas as outras funções e actions. Realiza a verificação de 
     * autentiicação de usuário. Caso não exista, redireciona para a página de 
     * login.
     *
     * @author Jacqueline Midlej
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
        
        $this->view->usuarioLogado = $this->usuario->find(
                $this->usuarioLogado->idusuario
                )->current();
    }
    
    /**
     * Redireciona para a action contato.
     *
     * @author Jacqueline Midlej
     * @access public
     * @return void
     *
     */

    public function indexAction(){
        $this->_forward('contatos');
    }

    /**
     * Action que exibe informações de contato.
     *
     * @author Jacqueline Midlej
     * @access public
     * @return void
     *
     */
    
    public function contatosAction(){

    }
}