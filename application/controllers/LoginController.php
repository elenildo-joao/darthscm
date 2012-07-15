<?php

class LoginController extends Zend_Controller_Action
{
    
    private $usuario;
    private $login;
    private $db;

    public function init()
    {
        $this->usuario = new Usuarios();
        $this->login = new Login();
        $this->db = Zend_Db_Table::getDefaultAdapter();
        
        
    }

    public function indexAction()
    {
        $this->_helper->layout->setLayout('login');
        
        if ( $this->_request->isPost() )
        {
            $dadosLogin = array(
                'login' => $this->_request->getPost('login'),
                'senha' => sha1($this->_request->getPost('senha'))
            );
            
            if ( empty($dadosLogin['login']) || empty($dadosLogin['senha']) )
            {
                $this->view->mensagemErro = "Preencha o formulário corretamente";
                return false;
            }
            else
            {
                $authAdapter = new Zend_Auth_Adapter_DbTable($this->db);
                
                $authAdapter->setTableName('login')
                            ->setIdentityColumn('login')
                            ->setCredentialColumn('senha');
                
                $authAdapter->setIdentity($dadosLogin['login'])
                            ->setCredential($dadosLogin['senha']);
                
                $auth = Zend_Auth::getInstance();
                $resultado = $auth->authenticate($authAdapter);
                
                if ( $resultado->isValid() )
                {
                    $infoUsuario = $authAdapter->getResultRowObject(array('idusuario'));

                    $storage = $auth->getStorage();
                    $storage->write($infoUsuario);
                    
                    return $this->_helper->redirector->goToRoute(array('controller' => 'index'));
                }
                else
                {
                    $this->view->mensagemErro = "Dados inválidos";
                }
            }
        }
    }
    
    public function logoutAction()
    {
        $this->_helper->layout->setLayout('login');
        Zend_Auth::getInstance()->clearIdentity();
        return $this->_helper->redirector->goToRoute( 
                    array('controller' => 'login', 'action' => 'index') 
                    );
    }
    
    public function redefinirAction(){
        $this->_helper->layout->setLayout('login-red');
        
    }
    
    public function novaSenhaAction(){
        $this->_helper->layout->setLayout('login-red');
    }
}

