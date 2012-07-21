<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ProjetoControllerTest
 *
 * @author acarlos
 */
class ProjetoControllerTest extends ControllerTestCase {
    
    
    private $projeto;
    
    function setUp(){
        parent::setUp();
        $front = Zend_Controller_Front::getInstance();
        $front->setParam('noErrorHandler', true);
        $this->projeto = new Projetos();
        
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


    function testCanGoToProjetosPage(){
        
        $this->login();
        //$this->resetRequest(); 
        //$this->resetResponse();
        
        $this->dispatch("/projetos/");
        $this->assertController("projetos");
        $this->assertAction("index");
    }
    
    function testCanGoToProjetosNovosPage(){
        $this->login();
       $this->resetRequest(); 
       $this->resetResponse();
        
        $this->dispatch("/projetos/novo");
        $this->assertController("projetos");
        $this->assertAction("novo");
        
    }
    
    function testDefaultPageProjetosListar(){
        $this->resetResponse();
        $this->dispatch("/projetos/listar");
        $this->assertController("projetos");
        $this->assertAction("listar");
        $this->assertRedirectTo('/login/listar');
        $this->resetResponse();
        $this->login();
        $this->resetRequest();
        $this->resetResponse();
        $this->dispatch("/projetos/listar");
        $this->assertNotRedirectTo('/login/listar');
        
    }
    
    function testCanGoToListarTarefas(){
        $this->dispatch("/projetos/listar-tarefas");
        $this->assertController("projetos");
        $this->assertAction("listar-tarefas");  
    }
    
   public function testNovoProjeto(){
        $this->login();
        $this->resetRequest();
        $this->resetResponse();
        
        $this->dispatch("/projetos/novo");
       $this->assertQuery('form');
        
        $data = array(
            'nome' => 'testProj'.rand(),
            'dataInicio' => '12/04/2012',
            'dataPrevFim' => '15/06/2013',
            'descricao' => 'Teste de novo projeto 1',
            'repositorio' => 'www.repositorioteste1.com',
            'gerente' => '3'
            
        );
        $this->_request->setMethod('POST')->setPost($data);
        $this->dispatch("/projetos/novo");
        $this->assertQuery('p');
   }
   
   function testRemover(){
       $this->login();

        $this->resetRequest();
        $this->resetResponse();
        
        $projs = $this->projeto->fetchRow(
                 $this->projeto->select()->where('nome LIKE ? ', 'testProj%')
                );
        
        $this->dispatch('/projetos/detalhar-projeto/idprojeto/'.$projs->idprojeto);
        $this->dispatch('/projetos/remover/id/'.$projs->idprojeto);
        $this->assertQuery('a[title="Voltar"]');
   }


   function testEditarProjetos(){
     $this->login();
     $this->resetRequest(); 
     $this->resetResponse();
     
     $this->dispatch('/projetos/editar/idprojeto/1');
     $this->assertController("projetos");
     $this->assertAction("editar");
 }


 function testNovaTarefa(){
        
       $this->login();
       $this->resetRequest(); 
       $this->resetResponse();
        
       $this->dispatch("/projetos/nova-tarefa/idprojeto/1");
       $this->assertQuery('form');
       
        $data = array(
            'idprojeto' => '1',
            'nome' => 'AA_Teste',
            'dataInicio' => '2012-07-19',
            'dataPrevFim' => '2012-07-29',
            'prioridade' => 'Maxima',
            'descricao' => 'tarefa de teste',
            'responsavel' => '3'
        );
        $this->_request->setMethod("POST")->setPost($data);
        $this->dispatch('projetos/nova-tarefa/idprojeto/1');
        $this->assertQuery('a[title="Voltar"]');
        
        
    }
    
    function testNovaSubTarefa(){
       $this->login();
       $this->resetRequest(); 
       $this->resetResponse();
        
       $this->dispatch("/projetos/nova-sub-tarefa/idprojeto/2/idtarefa/44");
       $this->assertQuery('form');
       
       $data = array(
         'idtarefa'    => '44',
         'idprojeto'   => '2',
         'nome'        => 'Tarefa teste 1',
         'descricao'   => 'testando',
         'dataInicio'  => '2012-07-04',
         'dataPrevFim' => '2012-07-06',
         'prioridade'  => 'Maxima',
         'responsavel' => '3'    
       );
       $this->_request->setMethod('post')->setPost($data);
       $this->dispatch("/projetos/nova-sub-tarefa/idprojeto/2/idtarefa/44");
       $this->assertQuery('a[title="Voltar"]');
    }
    
    function testAdicionarTempo(){
        $this->login();
       $this->resetRequest(); 
       $this->resetResponse();
        
       $this->dispatch("/projetos/adicionar-tempo/idprojeto/2/idtarefa/44");
       $this->assertQuery('form');
       
       $data = array(
         'idtarefa'  => '44',
         'idprojeto' => '2',
         'tempo'     => '10 dias'
       );
       $this->_request->setMethod('POST')->setPost($data);
       $this->dispatch("/projetos/adicionar-tempo");
       $this->assertAction('adicionar-tempo');
       
    }
    
    function testAlocarColaborador(){
       $this->login();
       $this->resetRequest(); 
       $this->resetResponse();
       
       $this->dispatch('/projetos/alocar-colaborador/idprojeto/2');
       $this->assertQuery('form');
       
       $data = array(
           'idprojeto' => '2',
           'idusuario' => '4',
           'papel'     => 'colaborador'
       );
       $this->_request->setMethod("POST")->setPost($data);
       $this->dispatch('projetos/alocar-colaborador/idprojeto/2');
       $this->assertRedirectTo('/projetos/listar/idprojeto/2/');
    }

    function testDesalocarColaborador(){
        $this->login();
       $this->resetRequest(); 
       $this->resetResponse();
       
       $this->dispatch('/projetos/desalocar-colaborador/idprojeto/2');
       $this->assertQuery('form');
       
       $data = array(
           'idprojeto' => '2',
           'usuario' => '4'
       );
       $this->_request->setMethod("POST")->setPost($data);
       $this->dispatch('/projetos/desalocar-colaborador/idprojeto/2');
       
       $this->assertRedirectTo('/projetos/listar/idprojeto/2/');
    }

    public function testAlocarUsuarioTarefa(){
       $this->login();
       $this->resetRequest(); 
       $this->resetResponse();
       
       $this->dispatch('/projetos/alocar-usuario-tarefa/idprojeto/2/idtarefa/30');
       $this->assertQuery('form');
       
       $data = array(
           'idprojeto' => '2',
           'idtarefa' => '30',
           'usuario' => '2'
       );
       $this->_request->setMethod("POST")->setPost($data);
       $this->dispatch('/projetos/alocar-usuario-tarefa/idprojeto/2/idtarefa/30');
       $this->assertRedirectTo('/projetos/listar-tarefas/idprojeto/2/');
    }
    
    public function testDesalocarUsuarioTarefa(){
        $this->login();
       $this->resetRequest(); 
       $this->resetResponse();
       
       $this->dispatch('/projetos/desalocar-usuario-tarefa/idprojeto/2/idtarefa/30');
       $this->assertQuery('form');
       
       $data = array(
           'idprojeto' => '2',
           'idtarefa' => '30',
           'usuario' => '2'
       );
       $this->_request->setMethod("POST")->setPost($data);
       $this->dispatch('/projetos/desalocar-usuario-tarefa/idprojeto/2/idtarefa/30');
       $this->assertRedirectTo('/projetos/listar-tarefas/idprojeto/2/');
    }

    
    public function testFecharTarefa(){
        $this->login();
       $this->resetRequest(); 
       $this->resetResponse();
       
       $this->dispatch('/projetos/fechar-tarefa/idprojeto/1/idtarefa/20');
       $this->assertAction('fechar-tarefa');
       $this->assertQuery('a[title="Voltar"]');
    }

     
}

?>
