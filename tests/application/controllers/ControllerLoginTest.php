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
class ControllerLoginTest extends ControllerTestCase{
    
    function testIndexAction(){
        $data = array(
            'login' => 'anderson',
            'senha' => '123'
        );
        
        $this->_request->setMethod('POST')->setPost($data);
        $this->dispatch('/');
        $this->assertController('index');
    }
}

?>
