<?php

class IndexController extends Zend_Controller_Action
{
    
    private $usuarioLogado;
    private $usuario;
    private $vUsuarioProjeto;
    private $vTarefaUsuario;

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


}

