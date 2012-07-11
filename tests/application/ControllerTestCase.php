<?php

//require_once 'Zend/Application.php';
require_once 'Zend/Test/PHPUnit/ControllerTestCase.php';
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ControllerTestCase
 *
 * @author silas
 */
class ControllerTestCase extends Zend_Test_PHPUnit_ControllerTestCase{
    //put your code here
    
    
    
    protected $application;

    
    public function setUp(){
        
        $this->bootstrap = array($this, 'appBootstrap');
        parent::setUp();
    }
    
    public function appBootstrap(){
        
        $this->application = 
                new Zend_Application(APPLICATION_ENV, APPLICATION_PATH . '/configs/application.ini');

        $this->application->bootstrap();
    }
}

?>
