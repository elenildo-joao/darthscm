<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of IndexControllerTest
 *
 * @author acarlos
 */
class IndexControllerTest extends ControllerTestCase{
    
    function setUp(){
        parent::setUp();
        $front = Zend_Controller_Front::getInstance();
        $front->setParam('noErrorHandler', true);
         
    }

    function testIndex(){
        
        
        $this->_request
         ->setMethod('POST')
         ->setPost(array(
             'login' => 'elenildo',
             'senha' => '123'
         ));
        $this->dispatch('/login');        
        $this->assertTrue(Zend_Auth::getInstance()->hasIdentity());
        
        $this->resetRequest();
        $this->resetResponse();
        
        $this->dispatch('/index');
        
        $this->assertResponseCode(200);
       
        $this->assertController('index');
        $this->assertAction('index');
        
        
        
        Zend_Auth::getInstance()->clearIdentity();
        $this->dispatch('/index');      
        $this->assertRedirectTo('/login');
        
        //$this->assertQuery('div#tarefas');
        
        /*
        print_r($this->getResponse()); 
        die();
        $this->assertQuery('div#tarefas');
        $this->assertQuery('div#mensagens');
        $this->assertQuery('div#projetos');*/
    }
}

?>
