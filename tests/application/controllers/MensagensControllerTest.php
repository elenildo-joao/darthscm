<?php


/**
 * Description of MensagensControllerTest
 *
 * @author acarlos
 */
class MensagensControllerTest extends ControllerTestCase {
    
    private $mensagem; 
    private $vMsg;
    
    function setUp() {
        parent::setUp();
        parent::setUp();
        $front = Zend_Controller_Front::getInstance();
        $front->setParam('noErrorHandler', true);
        
        $this->mensagem = new Mensagens();
        $this->vMsg = new VMsgRecebida();
    }
    
    function login(){
        $front = Zend_Controller_Front::getInstance();
        $front->setParam('noErrorHandler', true);
        $this->_request
         ->setMethod('POST')
         ->setPost(array(
             'login' => 'elenildo',
             'senha' => '123'
         ));
        $this->dispatch('/login');        
        $this->assertTrue(Zend_Auth::getInstance()->hasIdentity());
    }
    
    function logout(){
        Zend_Auth::getInstance()->clearIdentity();
    }
    
    function testListar(){
        $this->dispatch('mensagens');
        $this->assertResponseCode(302);
        $this->resetResponse();
        $this->login();
        $this->resetResponse();
        
        $this->dispatch('mensagens');
        $this->assertResponseCode(200);
        $this->assertQuery('#confMsg');
    }
    
    function testNovo(){
        $this->login();
        $this->resetRequest();
        $this->resetResponse();
        
        $this->dispatch('mensagens/novo');
        $this->assertResponseCode(200);
        $this->assertQuery('form');
        
        $data = array(
            'assunto' => 'teste',
            'destinatarios' => array(2,3,8),
            'conteudo' => 'esse teste e muito bom',
            
        );
        $this->resetResponse();
        $this->_request->setMethod('POST')->setPost($data);
        $this->dispatch('mensagens/novo');
        $this->assertQuery('a[title="Voltar"]');
        
        $data['assunto'] = '';
        $this->_request->setMethod('POST')->setPost($data);
        $this->dispatch('mensagens/novo');
        $this->assertQuery('a[title="Voltar"]');
    }
    
    function testRemoverSaida(){
        $this->login();

        
        $msg = $this->mensagem->fetchRow(
                $this->mensagem->select()->where('assunto= ? ', 'teste')
                );
        $this->resetRequest();
        $this->resetResponse();
        $this->dispatch('/mensagens/remover-saida/id/'.$msg->idmensagem);
        $this->assertQuery('a[title="Voltar"]');
    }
    
    function testRemover(){
        $this->_request
         ->setMethod('POST')
         ->setPost(array(
             'login' => 'anderson',
             'senha' => '123'
         ));
        $this->dispatch('/login');        
        $this->assertTrue(Zend_Auth::getInstance()->hasIdentity());

        
        $msg = $this->vMsg->fetchRow(
                $this->vMsg->select()->where('assunto= ? ', 'teste')
                                             ->where('destinatario= ?', '3')
                );
        $this->resetRequest();
        $this->resetResponse();
        $this->dispatch('/mensagens/remover/id/'.$msg->idmensagem);
        $this->assertQuery('a[title="Voltar"]');
    }
    
    function testVisualisar(){
        $this->login();
        $this->resetRequest();
        $this->resetResponse();
        
        $this->dispatch('/mensagens/visualizar/id/9');
        $this->assertResponseCode(200);
        $this->assertQuery('fieldset');
    }
    
    function testVisualisarSaida(){
        $this->login();
        $this->resetRequest();
        $this->resetResponse();
        
        $this->dispatch('mensagens/visualizar-saida/id/4');
        $this->assertResponseCode(200);
        $this->assertQuery('fieldset');
    }
    
    function testCaixaSaida(){
        $this->login();
        $this->resetRequest();
        $this->resetResponse();
        
        $this->dispatch('mensagens/caixa-saida');
        $this->assertResponseCode(200);
        $this->assertQuery('fieldset');
    }
    
}

?>
