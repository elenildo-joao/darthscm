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
    
    private $user;
    
    function setUp(){
        parent::setUp();
        $front = Zend_Controller_Front::getInstance();
        $front->setParam('noErrorHandler', true);      
        $this->user = new Usuarios();
    }
  
    /* * Created on 16/Dez/2005 
     * * 
     * * funções para geração automática 
     * * e randômica de CPFs e CNPJs 
     * * créditos: damico@dcon.com.br 
     */
    function mod($dividendo,$divisor)
    {
        return round($dividendo - (floor($dividendo/$divisor)*$divisor));
    }

    function cpf($compontos)
    {
        $n1 = rand(0,9);
        $n2 = rand(0,9);
        $n3 = rand(0,9);
        $n4 = rand(0,9);
        $n5 = rand(0,9);
        $n6 = rand(0,9);
        $n7 = rand(0,9);
        $n8 = rand(0,9);
        $n9 = rand(0,9);
        $d1 = $n9*2+$n8*3+$n7*4+$n6*5+$n5*6+$n4*7+$n3*8+$n2*9+$n1*10;
        $d1 = 11 - ( $this->mod($d1,11) );
        if ( $d1 >= 10 )
        { 
            $d1 = 0 ;
        }
        $d2 = $d1*2+$n9*3+$n8*4+$n7*5+$n6*6+$n5*7+$n4*8+$n3*9+$n2*10+$n1*11;
        $d2 = 11 - ( $this->mod($d2,11) );
        if ($d2>=10) { $d2 = 0 ;}
        $retorno = '';
        if ($compontos==1) {$retorno = ''.$n1.$n2.$n3.".".$n4.$n5.$n6.".".$n7.$n8.$n9."-".$d1.$d2;}
        else {$retorno = ''.$n1.$n2.$n3.$n4.$n5.$n6.$n7.$n8.$n9.$d1.$d2;}
        return $retorno;
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
    
    function testCanGoToUsuariosPage(){
        $this->dispatch("/usuarios/listar");
        $this->assertResponseCode(302);
        $this->resetResponse();
        
        $this->login();
        $this->resetResponse();
        $this->dispatch("/usuarios/listar");
        $this->assertController("usuarios");
        $this->assertAction("listar");
        $this->assertResponseCode(200);
        
        $this->resetResponse();
        $this->resetRequest();
        $this->dispatch("/usuarios");
        $this->assertController("usuarios");
        $this->assertAction("listar");
        $this->assertResponseCode(200);
    }
    
    function testCanGoToUsuariosNovosPage(){
        $this->login();
        $this->dispatch("/usuarios/novo");
        $this->assertController("usuarios");
        $this->assertAction("novo");
        
    }
    
    function testDefaultPageUsuariosListar(){
        $this->login();
        $this->dispatch("/usuarios/");
        $this->assertController("usuarios");
        $this->assertAction("index");
        
    }
    
    
    public function testNovo(){
        
        $this->login();

        $this->resetRequest();
        $this->resetResponse();
        $this->dispatch('/usuarios/novo');
        $this->assertQuery('form');
        
        $data = array(
                'nome'     => 'Ueslei Lima',
                'email'    => 'email'.rand().'@mail'.rand().'.com',
                'cpf'      => $this->cpf(0),
                'dataNasc' => '02/01/1990',
                'telefone' => '7399010007',
                'sexo'     => 'M',
                'rua'      => 'rua',
                'num'      => '1',
                'bairro'   => 'bairro',
                'cidade'   => 'cidade',
                'estado'   => 'BA',
                'complemento' => 'complemento',
                'login' => 'login'.rand()
         );
         $this->_request->setMethod('POST')->setPost($data);
         $this->dispatch("/usuarios/novo");
         $this->assertQuery('a[title="Voltar"]');
         $this->id_novo += 1;
         
        $data['email'] = 'mail';
         $this->_request->setMethod('POST')->setPost($data);
         $this->dispatch("/usuarios/novo");
         $this->assertQuery('a[title="Voltar"]');
         
         $data['email'] = 'andersoncarlos@gmail.com';
         $this->_request->setMethod('POST')->setPost($data);
         $this->dispatch("/usuarios/novo");
         $this->assertQuery('a[title="Voltar"]');
         
         $data['email'] = 'email'.rand().'@mail'.rand().'.com';
         $data['cpf'] = '00700700707';
         $this->_request->setMethod('POST')->setPost($data);
         $this->dispatch("/usuarios/novo");
         $this->assertQuery('a[title="Voltar"]');
         
         $data['cpf'] = '';
         $this->_request->setMethod('POST')->setPost($data);
         $this->dispatch("/usuarios/novo");
         $this->assertQuery('a[title="Voltar"]');
    }
    
    function testEditar(){
        $this->login();

        $this->resetRequest();
        $this->resetResponse();
        $this->dispatch('/usuarios/editar/id/6');
        $this->assertQuery('form');
        
        $data = array(
                'idLogin'     => '6',
                'idEndereco'  => '6',
                'idUsuario'   => '6',
                'nome'        => 'Marcelo Santos',
                'email'       => 'marcelosantos@gmail.com',
                'cpf'         => '00500500505',
                'dataNasc'    => '1990-01-05',
                'telefone'    => '7399010005',
                'sexo'        => 'M',
                'rua'         => 'Rua Local G',
                'num'         => '11',
                'bairro'      => 'Nelson Costa',
                'cidade'      => 'Ilhéus',
                'estado'      => 'BA',
                'complemento' => 'casa',
                'login'       => 'marcelinho'
         );
         $this->_request->setMethod('POST')->setPost($data);
         $this->dispatch("/usuarios/editar/id/6");
         $this->assertQuery('a[title="Voltar"]');
         
         $data['sexo'] = '';
         $this->_request->setMethod('POST')->setPost($data);
         $this->dispatch("/usuarios/editar/id/6");
         $this->assertQuery('a[title="Voltar"]');
    }
    
    function testRemover(){
        $this->login();

        $this->resetRequest();
        $this->resetResponse();
        $users = $this->user->fetchRow(
                $this->user->select()->where('nome= ? ', 'Ueslei Lima')
                );
        $this->dispatch('/usuarios/remover/id/'.$users->idusuario);
        $this->assertQuery('a[title="Voltar"]');
    }
    
    function testVisualisar(){
        
        
        $this->login();

        //$this->resetRequest();
        $this->resetResponse();
        
        $this->dispatch('/usuarios/visualizar/id/2');
        //print_r($this->getResponse());
        //die();
        $this->assertResponseCode(200);
        $this->assertQuery('#detUsuarios');
    }
}

?>
