<?php

/** 
 * Classe responsável pela autenticação no DarthSCM, pela gerência  da sessão de 
 * usuário, e por fornecer um meio de alteração de senha, caso o usuário tenha 
 * esquecido.
 * 
 * @package DarthSCM
 * @subpackage controllers
 * @author Elenildo João <elenildo.joao@gmail.com>
 * @version 0.1
 * @access public
 *
 */

class LoginController extends Zend_Controller_Action
{
    
    private $usuario;
    private $login;
    private $db;
    private $redefinirSenha;

    
    /**
     * Função responsável pela inicialização das propriedades da classe, a serem
     * usuadas por todas as outras funções e actions.
     *
     * @author Elenildo João <elenildo.joao@gmail.com>
     * @access public
     * @return void
     *
     */
    public function init()
    {
        $this->usuario = new Usuarios();
        $this->login = new Login();
        $this->db = Zend_Db_Table::getDefaultAdapter();
        $this->redefinirSenha = new RedefinirSenha();
        
    }
    
    /**
     * Action responsável por efetuar a autenticação do usuário no DarthSCM.
     * Recebe os dados do usuário inseridos no formulário de login via POST, 
     * realiza a validação, cria a sessão e redireciona para a página inicial do 
     * sistema.
     *
     * @author Elenildo João <elenildo.joao@gmail.com>
     * @access public
     * @return void
     *
     */
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
    
    /**
     * Action responsável por finalizar a sessão de usuário. Redireciona para a
     * página de login.
     *
     * @author Elenildo João <elenildo.joao@gmail.com>
     * @access public
     * @return void
     *
     */
    public function logoutAction()
    {
        $this->_helper->layout->setLayout('login');
        Zend_Auth::getInstance()->clearIdentity();
        return $this->_helper->redirector->goToRoute( 
                    array('controller' => 'login', 'action' => 'index') 
                    );
    }   
    
    /**
     * Action resnponsável pela solicitação de mudança de senha. Envia um e-mail
     * para o usuário com informações de como realizar a alteração.
     *
     * @author Elenildo João <elenildo.joao@gmail.com>
     * @access public
     * @return void
     *
     */
    public function solicitarAction(){
        $this->_helper->layout->setLayout('login-red');
        
        if ( $this->_request->isPost() )
        {
            $email = $this->_request->getPost('email');
            
            $usuario = $this->usuario->fetchRow(
                    $this->usuario->select()->where('email = ?', $email)
                    );
            
            $hash = sha1(date('dmYHisu'));
            
            $dados = array('hash'      => $hash,
                           'idusuario' => $usuario->idusuario
                    );
            
            $this->redefinirSenha->insert($dados);
            
            $mensagem = "Clique no link a seguir para alterar a sua senha:<br />";
            $mensagem .= "http://darthscm.local/login/redefinir/hash/" . $hash; 
            
            $assunto = 'Redefinir a senha no DarthSCM.';

            $email = new Email($mensagem, $assunto, $usuario->email, $usuario->nome);
            $email->enviar();
            
            $this->view->emailEnviado = TRUE;
        }
    }

    /**
     * Action resnponsável pela mudança de senha. Recebe pela url um hash para a
     * identificação da solicitação, e permite ao usuário realizar a mudança de 
     * senha.
     *
     * @author Elenildo João <elenildo.joao@gmail.com>
     * @access public
     * @return void
     *
     */
    public function redefinirAction(){
        $this->_helper->layout->setLayout('login-red'); 
        
        if ( !$this->_request->isPost() )
        {
            $hash = $this->_getParam('hash');

            $redefinirSenha = $this->redefinirSenha->fetchRow(
                    $this->redefinirSenha->select()->where('hash = ?', $hash)
                    );

            $this->view->idUsuario = $redefinirSenha->idusuario;
            $this->view->hash = $hash;
        } 
        else
        {
            $hash = $this->getRequest()->getPost('hash');
            
            $data = array(
                        'idusuario'  => $this->getRequest()->getPost('idusuario'),
                        'senhaNova'  => stripslashes(trim($this->getRequest()->getPost('senhaNova'))),
                        'senhaNova2' => stripslashes(trim($this->getRequest()->getPost('senhaNova2')))
                    );

            if ( empty($data['senhaNova']) || empty($data['senhaNova2']) )
            {
                $this->view->mensagem = "Preencha os dois campos.";
                return;
            }

            if ( $data['senhaNova'] != $data['senhaNova2'] ){
                $this->view->mensagem = "As duas senhas digitadas são diferentes.";
                return;
            }

            $where = $this->login->getAdapter()->quoteInto('idusuario = ?', (int) $data['idusuario']);

            $data2 = array(
                'senha' => sha1($data['senhaNova'])
            );

            $this->login->update($data2, $where);

            $where = $this->redefinirSenha->getAdapter()->quoteInto('hash = ?', $hash);

            $this->redefinirSenha->delete($where);

            $this->_redirect('login');
        }
    }
    
}