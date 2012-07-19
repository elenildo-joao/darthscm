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
    
    
    function setUp(){
        parent::setUp();
        $front = Zend_Controller_Front::getInstance();
        $front->setParam('noErrorHandler', true);
    }


    function testCanGoToProjetosPage(){
        
        $this->dispatch("/projetos");
        $this->assertController("projetos");
        $this->assertAction("index");
    }
    
    function testCanGoToProjetosNovosPage(){
        
        $this->dispatch("/projetos/novo");
        $this->assertController("projetos");
        $this->assertAction("novo");
        
    }
    
    function testDefaultPageProjetosListar(){
        
        $this->dispatch("/projetos/listar");
        $this->assertController("projetos");
        $this->assertAction("listar");
        
    }
    
    function testCanGoToListarTarefas(){
        $this->dispatch("/projetos/listar-tarefas");
        $this->assertController("projetos");
        $this->assertAction("listar-tarefas");  
    }
 /*   
   public function testNovoProjeto(){
        $front = Zend_Controller_Front::getInstance();
        $front->setParam('noErrorHandler', true);
        
        $data = array(
            'nome' => 'Projeto Teste 3',
            'dataInicio' => '2012-07-12',
            'dataPrevFim' => '2012-08-22',
            'descricao' => 'Teste de novo projeto 3',
            'repositorio' => 'www.repositorioteste3.com',
            'gerente' => '4'
            
        );
        $this->_request->setMethod('POST')->setPost($data);
        $this->dispatch("/projetos/novo");
        $this->assertResponseCode('200');
   }
    
 function testEditarProjetos(){
     $this->dispatch('/projetos/editar');
     $this->assertController("projetos");
     $this->assertAction("editar");
 }


 function testNovaTarefa(){
        
        //$front = Zend_Controller_Front::getInstance();
        //$front->setParam('noErrorHandler', true);
       
        $this->dispatch("/projetos/nova-tarefa");
        $this->assertController("projetos");
        $this->assertAction("nova-tarefa");
        
        $data = array(
            'nome' => 'AA_Teste',
            'dataInicio' => '2012-07-12',
            'dataPrevFim' => '2012-07-17',
            'prioridade' => 'Maxima',
            'descricao' => 'tarefa de teste',
            'responsavel' => '1'
        );
        $this->_request->setMethod("POST")->setPost($data);
        $this->dispatch('projetos/nova-tarefa/idprojeto/2/');
        
        
    }
    
    function testRemoverTarefa(){
        
        $data = array(
            'idtarefa' => '38',
            'idProjeto' => '2'
        );
        
        $this->_request->setQuery($data);
        $this->dispatch('projetos/remover-tarefa');
        
    }
    */
    
    
    
    
}

?>
