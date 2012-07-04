<?php

class UsuariosController extends Zend_Controller_Action
{
    private $usuario;
    private $endereco;
    private $login;
    private $db;

    public function init()
    {
        $this->usuario = new Usuarios();
        $this->endereco = new Enderecos();
        $this->login = new Login();
        $this->db = Zend_Db_Table::getDefaultAdapter();
    }

    public function indexAction()
    {
        $this->_forward('listar');
    }
    
    public function listarAction()
    {
        $this->view->usuarios = $this->usuario->fetchAll();
    }
    
    public function novoAction()
    {
        if ( $this->_request->isPost() )
        {
            $dadosUsuario = array(
                'nome'     => $this->_request->getPost('nome'),
                'email'    => $this->_request->getPost('email'),
                'cpf'      => $this->_request->getPost('cpf'),
                'datanasc' => $this->_request->getPost('dataNasc'),
                'telefone' => $this->_request->getPost('telefone'),
                'sexo'     => $this->_request->getPost('sexo')
            );
            
            $dadosEndereco = array(
                'rua'         => $this->_request->getPost('rua'),
                'num'         => $this->_request->getPost('num'),
                'bairro'      => $this->_request->getPost('bairro'),
                'cidade'      => $this->_request->getPost('cidade'),
                'estado'      => $this->_request->getPost('estado'),
                'complemento' => $this->_request->getPost('complemento')
            );
            
            $dadosLogin = array(
                'login' => $this->_request->getPost('login'),
                'senha' => sha1('123')
            );
            
            $this->endereco->insert($dadosEndereco);

            $dadosUsuario['endereco'] = $this->db->lastInsertId('enderecos', 'idendereco');
            
            $this->usuario->insert($dadosUsuario);
            
            $dadosLogin['idusuario'] = $this->db->lastInsertId('usuarios', 'idusuario');
            
            $this->login->insert($dadosLogin);
        
            $this->_redirect('/usuarios/listar');
        }
    }
    
    public function editarAction()
    {     
        if ( !$this->_request->isPost() )
        {           
            $idUsuario = (int) $this->_getParam('id'); 
            
            $usuario = $this->usuario->find($idUsuario)->current();
 
            $this->view->usuario  = $usuario;
            $this->view->endereco  = $usuario->findParentEnderecos();
            $this->view->login = $usuario->findParentLogin();
        }
        else
        {
            $dadosUsuario = array(
                'nome'     => $this->_request->getPost('nome'),
                'email'    => $this->_request->getPost('email'),
                'cpf'      => $this->_request->getPost('cpf'),
                'datanasc' => $this->_request->getPost('dataNasc'),
                'telefone' => $this->_request->getPost('telefone'),
                'sexo'     => $this->_request->getPost('sexo')                
            );
            
            $dadosEndereco = array(
                'rua'         => $this->_request->getPost('rua'),
                'num'         => $this->_request->getPost('num'),
                'bairro'      => $this->_request->getPost('bairro'),
                'cidade'      => $this->_request->getPost('cidade'),
                'estado'      => $this->_request->getPost('estado'),
                'complemento' => $this->_request->getPost('complemento')
            );
            
            $dadosLogin = array(
                'login' => $this->_request->getPost('login')
            );
            
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
    
    public function removerAction()
    {
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