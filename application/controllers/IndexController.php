<?php

class IndexController extends Zend_Controller_Action
{
    
    private $usuarioLogado;
    private $usuario;
    private $usuarioProjeto;
    
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
        
        $this->view->usuarioLogado = $this->usuario->find(
                $this->usuarioLogado->idusuario
                )->current();
        

        
        }

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
        }
}

