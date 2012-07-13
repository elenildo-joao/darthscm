<?php

class IndexController extends Zend_Controller_Action
{
    
    private $usuarioLogado;
    private $usuario;

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
        
        $this->view->usuarioLogado = $this->usuario->find(
                $this->usuarioLogado->idusuario
                )->current();
    }

    public function indexAction()
    {
    }


}

