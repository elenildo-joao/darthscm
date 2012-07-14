<?php

class IndexController extends Zend_Controller_Action
{
    
    private $usuarioLogado;
    private $usuario;
<<<<<<< HEAD
    private $usuarioProjeto;
    
=======
    private $vUsuarioProjeto;
    private $vTarefaUsuario;

>>>>>>> 9a867abc547e1b314cce20766350f6d9786e43e2
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
        
<<<<<<< HEAD

        
        }
=======
        $this->vUsuarioProjeto = new VUsuarioProjeto();
        $this->vTarefaUsuario = new VTarefaUsuario();
    }

    public function indexAction()
    {
        $selectProjetos = $this->vUsuarioProjeto->select()
                ->where('idusuario = ?', $this->usuarioLogado->idusuario)
                ->limit(4);
        $selecttarefas = $this->vTarefaUsuario->select()
                ->where('idusuario = ?', $this->usuarioLogado->idusuario)
                ->limit(3);
        
        $this->view->projetos = $this->vUsuarioProjeto->fetchAll($selectProjetos);
        $this->view->tarefas = $this->vTarefaUsuario->fetchAll($selecttarefas);
    }
>>>>>>> 9a867abc547e1b314cce20766350f6d9786e43e2

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

