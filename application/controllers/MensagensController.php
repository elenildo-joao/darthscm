<?php

class MensagensController extends Zend_Controller_Action 
{

    private $mensagem;
    private $usuario;
    private $usuarioLogado;
    private $destinatario;
    private $db;
    private $msg;
    private $vMsgRecebida;
    private $vMsgEnviada;
    private $vDestinatarios;
    
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
        $this->vMsgRecebida = new VMsgRecebida();
        $this->vMsgEnviada = new VMsgEnviada();
        $this->vDestinatarios = new VMsgEnviada();

        $this->destinatario = new Destinatarios();


        $this->db = Zend_Db_Table::getDefaultAdapter();

        $this->usuarioLogado = Zend_Auth::getInstance()->getIdentity();
        
        $this->view->usuarioLogado = $this->usuario->find(
                $this->usuarioLogado->idusuario
                )->current();
//
    }

    public function indexAction() {

        $this->_forward('listar');
    }

    //Caixa de Entrada
    public function listarAction() {
        
        $paginator = Zend_Paginator::factory(
                        $this->vMsgRecebida
                                ->fetchAll(
                                        $this->vMsgRecebida->select()->where('destinatario = ?', $this->usuarioLogado->idusuario)
                                ));


        $paginator->setItemCountPerPage(10);
        $this->view->paginator = $paginator;
        $paginator->setCurrentPageNumber($this->_getParam('page'));
        
/*        $this->view->seimon = $this->mensagem
                ->fetchAll(
                        $this->mensagem->select()->order('idmensagem')
                        );*/
        
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
    
    public function removerAction() {
        $idMensagem = (int) $this->_getParam('id');

        $dadosRemove = array('excluida' => 't');

        $whereRemove = $this->destinatario->getAdapter()
               ->quoteInto('idmensagem = ?', (int) $idMensagem);
           
        $this->destinatario->update($dadosRemove, $whereRemove);

//        $this->_redirect('/usuarios/listar');
    }

    public function caixaSaidaAction(){
        $paginator = Zend_Paginator::factory(
                        $this->mensagem
                                ->fetchAll(
                                        $this->mensagem->select()->where('remetente = ?', $this->usuarioLogado->idusuario)->where('lixeira = ?', 'f')->where('excluida = ?', 'f')
                                ));

        $paginator->setItemCountPerPage(10);
        $this->view->paginator = $paginator;
        $paginator->setCurrentPageNumber($this->_getParam('page'));

        $this->view->vDestinatarios = $this->vMsgEnviada
                 ->fetchAll(
                     $this->vMsgEnviada->select()->where('idremetente = ?', $this->usuarioLogado->idusuario)
                  );
    }
}

?>
