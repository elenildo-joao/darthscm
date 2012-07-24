<?php

/** 
 * Classe responsável pelo gerenciamento de mensagens enviadas entre os usuários 
 * do DarthSCM.
 * 
 * @package DarthSCM
 * @subpackage controllers
 * @author Caique Pires
 * @author Jacqueline Midlej
 * @version 0.1
 * @access public
 *
 */

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
    
    /**
     * Função responsável pela inicialização das propriedades da classe, a serem
     * usuadas por todas as outras funções e actions. Realiza a verificação de 
     * autentiicação de usuário. Caso não exista, redireciona para a página de 
     * login.
     *
     * @author Caique Pires
     * @access public
     * @return void
     *
     */
    
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

    }
    
    /**
     * Redireciona para a action listar.
     *
     * @author Caique Pires
     * @access public
     * @return void
     *
     */
    
    public function indexAction() 
    {
        $this->_forward('listar');
    }

    /**
     * Action responsável pela caixa de entrada.
     *
     * @author Caique Pires
     * @access public
     * @return void
     *
     */
    
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
    
    /**
     * Action responsável pelo envio de uma nova mensagem.
     *
     * @author Caique Pires
     * @access public
     * @return void
     *
     */
    
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
    
    /**
     * Action responsável por enviar uma mensagem para a lixeira.
     *
     * @author Jacqueline Midlej
     * @access public
     * @return void
     *
     */
    
    public function removerAction() {
        $idMensagem = (int) $this->_getParam('id');

        $dadosRemove = array('excluida' => 't', 'lixeira' => 'f' );

        $whereRemove = $this->destinatario->getAdapter()->quoteInto('idmensagem = ?', (int) $idMensagem).
                       $this->destinatario->getAdapter()->quoteInto('AND destinatario = ?', $this->usuarioLogado->idusuario);
           
        $this->destinatario->update($dadosRemove, $whereRemove);
        $this->view->mensagemErro='Mensagem Removida com Sucesso!';
//        $this->_redirect('/usuarios/listar');
    }
    
    /**
     * Action responsável por remover a mensagem da caixa de saída.
     *
     * @author Jacqueline Midlej
     * @access public
     * @return void
     *
     */

    public function removerSaidaAction() {
        $idMensagem = (int) $this->_getParam('id');

        $dadosRemove = array('excluida' => 't', 'lixeira' => 'f');

        $whereRemove = $this->mensagem->getAdapter()->quoteInto('idmensagem = ?', (int) $idMensagem).
                       $this->mensagem->getAdapter()->quoteInto('AND remetente = ?', (int) $this->usuarioLogado->idusuario);
        $this->mensagem->update($dadosRemove, $whereRemove);
        $this->view->mensagemErro='Mensagem Removida com Sucesso!';
//        $this->_redirect('/usuarios/listar');
    }
    
    /**
     * Action responsável pela vizualização de uma mensagem.
     *
     * @author Jacqueline Midlej
     * @access public
     * @return void
     *
     */
    
    public function visualizarAction() {
        $idMensagem = (int) $this->_getParam('id');
        $this->view->mensagem=$this->mensagem
                ->fetchAll(
                        $this->mensagem->select()->where('idmensagem = ?', $idMensagem)
                );
        $this->view->usuario=$this->usuario
                ->fetchAll(
                        $this->usuario->select()
                );
        $this->view->vDestinatarios = $this->vMsgEnviada
                 ->fetchAll(
                     $this->vMsgEnviada->select()->where('idmensagem = ?', $idMensagem)
                  );
        $a=(boolean)false;
        $dadosVisualiza = array('msglida' => 't');

//        $whereVisualiza = $this->destinatario->getAdapter()->quoteInto('idmensagem = '.$idMensagem.' AND destinatario='.$this->usuarioLogado->idusuario, 0);
        $whereVisualiza = $this->destinatario->getAdapter()->quoteInto('idmensagem = ?', $idMensagem).
                          $this->destinatario->getAdapter()->quoteInto('AND destinatario = ? ', $this->usuarioLogado->idusuario);
            $this->destinatario->update($dadosVisualiza, $whereVisualiza);   

    }
    
    /**
     * Action responsável pela visualização de uma mensagem da caixa de saída.
     *
     * @author Jacqueline Midlej
     * @access public
     * @return void
     *
     */
    
    public function visualizarSaidaAction() {
        $idMensagem = (int) $this->_getParam('id');
        $this->view->mensagem=$this->mensagem
                ->fetchAll(
                        $this->mensagem->select()->where('idmensagem = ?', $idMensagem)
                );
        $this->view->usuario=$this->usuario
                ->fetchAll(
                        $this->usuario->select()
                );
        $this->view->vDestinatarios = $this->vMsgEnviada
                 ->fetchAll(
                     $this->vMsgEnviada->select()->where('idmensagem = ?', $idMensagem)
                  );
    }
    
    /**
     * Action responsável pela caixa de saída.
     *
     * @author Jacqueline Midlej
     * @access public
     * @return void
     *
     */
       
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