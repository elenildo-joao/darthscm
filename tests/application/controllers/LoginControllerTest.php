<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ControllerLoginTest
 *
 * @author acarlos
 */
class LoginControllerTest extends ControllerTestCase{
    
    function setUp() {
        parent::setUp();
        Zend_Auth::getInstance()->clearIdentity();
        $front = Zend_Controller_Front::getInstance();
        $front->setParam('noErrorHandler', true);
        
    }
    
    function testLogin(){
        
        $data = array(
            'login' => 'elenildo',
            'senha' => '123'
        );
        
        $this->_request->setMethod('POST')->setPost($data);
        $this->dispatch('/login');

        $this->assertController('login');
        $this->assertTrue(Zend_Auth::getInstance()->hasIdentity());
        
        Zend_Auth::getInstance()->clearIdentity();
        $this->resetResponse(); 
        $data = array(
            'login' => 'intruso',
            'senha' => '321'
        );
        
        $this->_request->setMethod('POST')->setPost($data);
        $this->dispatch('login');
        
        $this->assertController('login');
        $this->assertFalse(Zend_Auth::getInstance()->hasIdentity());
        
        Zend_Auth::getInstance()->clearIdentity();
        $this->resetResponse(); 
        $data = array(
            'login' => '',
            'senha' => ''
        );
        $this->_request->setMethod('POST')->setPost($data);
        $this->dispatch('login');
        $this->assertController('login');
        $this->assertFalse(Zend_Auth::getInstance()->hasIdentity());
    }
    
    function testLogout(){
        $this->dispatch('/login/logout');
        $this->assertAction('logout');
        $this->assertController('login');

        $this->assertFalse(Zend_Auth::getInstance()->hasIdentity());
        
    }
    
    /*
     * Necessita internet
     * envia um email de verdade
     * 
     * Estava funcionando mas acredtito que o envio sucessivo de emails
     * tornou ele um spammer.
     * 
     */
    function testSolicitar(){
        $data = array(
            'email' => 'clicia@gmail.com'
        );
        
        $this->_request->setMethod('POST')->setPost($data);
        $this->dispatch('login/solicitar');
        $this->assertAction('solicitar');
        //$this->assertQueryCount('p', 2);
        
        $data = array(
            'email' => 'intruso@gmail.com'
        );
        
        $this->_request->setMethod('POST')->setPost($data);
        $this->dispatch('login/solicitar');
        $this->assertAction('solicitar');  

    }
    
    function testRedefinir(){
        $this->dispatch('login/redefinir');
        $this->assertAction('redefinir');
        
        $this->_request->setMethod('post')->setPost(array());
        $this->dispatch('login/redefinir');
        $this->assertAction('redefinir');
        $this->assertNotRedirect();
        
        
        $data = array(
            'senhaNova' => '555',
            'senhaNova2' => '444'
        );
        
        $this->_request->setMethod('post')->setPost($data);
        $this->dispatch('login/redefinir');
        $this->assertAction('redefinir');
        $this->assertNotRedirect();
        
    }
    
    function tearDown(){
        Zend_Auth::getInstance()->clearIdentity();
    }
}

?>
