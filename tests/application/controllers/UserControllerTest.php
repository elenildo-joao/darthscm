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
        $this->assertAction("index");
        
    }
    
    function testDefaultPageUsuariosRemover(){
        
        $this->dispatch("/usuarios/");
        $this->assertController("usuarios");
        $this->assertAction("index");
        
    }
    
    /*public function testQtForm(){
                
        $data = array(
                'nome'     => 'Ueslei Lima',
                'email'    => 'email',
                'cpf'      => '00800800808',
                'datanasc' => '1990-01-02',
                'telefone' => '7399010007',
                'sexo'     => 'M',
                'rua'      => 'rua',
                'num'      => '1',
                'bairro'   => 'bairro',
                'cidade'   => 'cidade',
                'estado'   => 'BA',
                'complemento' => 'complemento',
                'login' => 'login'
         );
        // $request = $this->getRequest();
         $this->_request->setMethod('POST')->setPost($data);
         $this->dispatch("/usuarios/novo");
        // $this->assertRedirect();
         //$this->assertRedirectTo('/usuarios/listar');
          //$this->assertAction('listar');
         
    }*/
}

?>
