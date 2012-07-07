<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UserControllerTest
 *
 * @author silas
 */
class UserControllerTest extends ControllerTestCase{
    //put your code here
    
    function testCanGoToUsuariosPage(){
        
        $this->dispatch("/usuarios/listar");
        $this->assertController("usuarios");
        $this->assertAction("listar");
        //$this->assertResponseCode(200, );
    }
    
    function testCanGoToUsuariosNovosPage(){
        
        $this->dispatch("/usuarios/novo");
        $this->assertController("usuarios");
        $this->assertAction("novo");
        
    }
    
    function testDefaultPageUsuariosListar(){
        
        $this->dispatch("/usuarios/");
        $this->assertController("usuarios");
        $this->assertAction("listar");
        
    }
    
    function testDefaultPageUsuariosRemover(){
        
        $this->dispatch("/usuarios/");
        $this->assertController("usuarios");
        $this->assertAction("listar");
        
    }
}

?>
