<?php

class MensagensController extends Zend_Controller_Action 
{

    private $mensagem;
    private $usuario;
    private $usuarioLogado;
    private $destinatario;
    private $db;
    private $msg;

    public function init() {
        
        if ( !Zend_Auth::getInstance()->hasIdentity() ) 
        {
            $this->_helper->layout->setLayout('informacao');
            return $this->_helper->redirector->goToRoute( 
                    array('controller' => 'login') 
                    );
        }
        
        $this->mensagem = new Mensagens();
        $this->usuario = new Usuarios();
        $this->usuarioLogado = new Usuarios();
        $this->msg = new Mensagens();

        $this->destinatario = new Destinatarios();


        $this->db = Zend_Db_Table::getDefaultAdapter();

        $this->usuarioLogado = Zend_Auth::getInstance()->getIdentity();
        
        $this->view->usuarioLogado = $this->usuario->find(
                $this->usuarioLogado->idusuario
                )->current();

    }

    public function indexAction() {

        $this->_forward('listar');
    }

    //Caixa de Entrada
    public function listarAction() {
        
        $paginator = Zend_Paginator::factory(
                        $this->destinatario
                                ->fetchAll(
                                        $this->destinatario->select()->where('destinatario = ?', $this->usuarioLogado->idusuario)
                                ));


        $paginator->setItemCountPerPage(10);
        $this->view->paginator = $paginator;
        $paginator->setCurrentPageNumber($this->_getParam('page'));
        
        $this->view->seimon = $this->mensagem
                ->fetchAll(
                        $this->mensagem->select()->order('idmensagem')
                        );
        
    }

    
    public function novoAction() {
        if (!$this->_request->isPost()){
            $this->view->usuarios = $this->usuario->fetchAll();}
        else {
            $idsDestinatarios = $this->_request->getPost('destinatarios');

            foreach ($idsDestinatarios as $idsDestinatario):
                
                $dadosMensagem = array(
                    'remetente' => $this->usuarioLogado->idusuario,
                    'assunto' => $this->_request->getPost('assunto'),
                    'conteudo' => $this->_request->getPost('conteudo')
                );
                
                $dadosDestinatario = array(
                    'remetente' => $this->usuarioLogado->idusuario,
                    'destinatario' => $idsDestinatario
                );
                           
            


            if ( empty($dadosMensagem['assunto'])         ||
                 empty($dadosMensagem['conteudo'])        ||
                 empty($dadosDestinatario['destinatario']))          
                 
            {
                $this->view->mensagemErro = "Preencha todos os campos do formulário.";
                return false;
            }   
            
            $this->mensagem->insert($dadosMensagem);

            $dadosDestinatario['idmensagem'] = $this->db->lastInsertId('mensagens', 'idmensagem');
            
            $this->destinatario->insert($dadosDestinatario);           
            $this->view->mensagemErro='Mensagem Enviada com Sucesso!';

        
        endforeach;
        }       
    
    }
    
    public function editarAction() {
        if (!$this->_request->isPost()) {
            $idUsuario = (int) $this->_getParam('id');

            $usuario = $this->usuario->find($idUsuario)->current();

            $this->view->usuario = $usuario;
            $this->view->endereco = $usuario->findParentEnderecos();
            $this->view->login = $usuario->findParentLogin();
        } else {
            $dadosUsuario = array(
                'nome' => $this->_request->getPost('nome'),
                'email' => $this->_request->getPost('email'),
                'cpf' => $this->_request->getPost('cpf'),
                'datanasc' => $this->_request->getPost('dataNasc'),
                'telefone' => $this->_request->getPost('telefone'),
                'sexo' => $this->_request->getPost('sexo')
            );

            $dadosEndereco = array(
                'rua' => $this->_request->getPost('rua'),
                'num' => $this->_request->getPost('num'),
                'bairro' => $this->_request->getPost('bairro'),
                'cidade' => $this->_request->getPost('cidade'),
                'estado' => $this->_request->getPost('estado'),
                'complemento' => $this->_request->getPost('complemento')
            );

            $dadosLogin = array(
                'login' => $this->_request->getPost('login')
            );

            if (empty($dadosUsuario['nome']) ||
                    empty($dadosUsuario['email']) ||
                    empty($dadosUsuario['cpf']) ||
                    empty($dadosUsuario['datanasc']) ||
                    empty($dadosUsuario['telefone']) ||
                    empty($dadosUsuario['sexo']) ||
                    empty($dadosEndereco['rua']) ||
                    empty($dadosEndereco['num']) ||
                    empty($dadosEndereco['bairro']) ||
                    empty($dadosEndereco['cidade']) ||
                    empty($dadosEndereco['estado']) ||
                    empty($dadosEndereco['complemento']) ||
                    empty($dadosLogin['login'])) {
                $this->view->mensagemErro = "Preencha todos os campos do formulário.";
                return false;
            }

            if ($this->validator->isValid($dadosUsuario['email'])) {
                $this->view->mensagemErro = "E-mail inválido.";
                return false;
            }

            if ($this->usuario->emailJaExiste($dadosUsuario['email'])) {
                $this->view->mensagemErro = "E-mail já cadastrado.";
                return false;
            }

            if ($this->usuario->cpfJaExiste($dadosUsuario['cpf'])) {
                $this->view->mensagemErro = "CPF já cadastrado.";
                return false;
            }

            $idUsuario = $this->_request->getPost('idUsuario');
            $idEndereco = $this->_request->getPost('idEndereco');
            $idLogin = $this->_request->getPost('idLogin');

            $whereEndereco = $this->endereco->getAdapter()->quoteInto('idendereco = ?', (int) $idEndereco);
            $whereUsuario = $this->usuario->getAdapter()->quoteInto('idusuario = ?', (int) $idUsuario);
            $whereLogin = $this->login->getAdapter()->quoteInto('idlogin = ?', (int) $idLogin);

            $this->endereco->update($dadosEndereco, $whereEndereco);
            $this->usuario->update($dadosUsuario, $whereUsuario);
            $this->login->update($dadosLogin, $whereLogin);

            $this->_redirect('/usuarios/listar');
        }
    }

    public function removerAction() {
        $idUsuario = (int) $this->_getParam('id');
        $usuario = $this->usuario->find($idUsuario)->current();

        $whereEndereco = $this->endereco->getAdapter()->quoteInto('idendereco = ?', (int) $usuario->endereco);
        $whereLogin = $this->login->getAdapter()->quoteInto('idusuario = ?', (int) $idUsuario);
        $whereUsuario = $this->usuario->getAdapter()->quoteInto('idusuario = ?', (int) $idUsuario);

        $this->login->delete($whereLogin);
        $this->usuario->delete($whereUsuario);
        $this->endereco->delete($whereEndereco);

        $this->_redirect('/usuarios/listar');
    }

}

?>
