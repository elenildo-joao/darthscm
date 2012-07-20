<?php

class SuporteController extends Zend_Controller_Action
{
    

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

        public function indexAction(){
            $this->_forward('contatos');
        }

        public function contatosAction(){
            
        }


}

?>
