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
    
    
    function testCanGoToProjetosPage(){
        
        $this->dispatch("/projetos");
        $this->assertController("projetos");
        $this->assertAction("listar");
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
    
   /* public function testNovoProjeto(){
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
        //$this->assertRedirectTo('/projetos/listar');
    }*/
    
    function testNovaTarefa(){
        
        //$front = Zend_Controller_Front::getInstance();
        //$front->setParam('noErrorHandler', true);
       
        $this->dispatch("/projetos/nova-tarefa");
        $this->assertController("projetos");
        $this->assertAction("nova-tarefa");
        
        $data = array(
            'nomeproj' => '2',
            'nome' => 'AA_Teste',
            'dataInicio' => '2012-07-12',
            'dataPrevFim' => '2012-07-17',
            'prioridade' => 'maxima',
            'descricao' => 'tarefa de teste',
            'responsavel' => '1'
        );
        $this->_request->setMethod("POST")->setPost($data);
        $this->dispatch('projetos/nova-tarefa');
        
    }
    
    function testRemoverTarefa(){
        
        $data = array(
            'idtarefa' => '36',
            'idProjeto' => '2'
        );
        
        $this->_request->setQuery($data);
        $this->dispatch('projetos/remover-tarefa');
        
    }
    
    function testSomaInterval(){
        
        $proj = new ProjetosController (new Zend_Controller_Request_Http(), 
                                        new Zend_Controller_Response_Http()
                                        );
        $date_inicial = new DateInterval('P0D');
        $date_adicionada = new DateInterval('PT1H');
        $result_esperado = new DateInterval('P0DT1H');
        $result = $proj->SomaInterval($date_inicial, $date_adicionada);
        $this->assertEquals($result, $result_esperado);
        
        $date_inicial = new DateInterval('P0DT23H59M');
        $date_adicionada = new DateInterval('PT1M');
        $result_esperado = new DateInterval('P1DT0H0M');
        $result = $proj->SomaInterval($date_inicial, $date_adicionada);
        $this->assertEquals($result, $result_esperado);
        
        $date_inicial = new DateInterval('P0DT23H59M');
        $date_adicionada = new DateInterval('P0DT23H59M');
        $result_esperado = new DateInterval('P1DT23H58M');
        $result = $proj->SomaInterval($date_inicial, $date_adicionada);
        $this->assertEquals($result, $result_esperado);
        
        $date_inicial = new DateInterval('P1DT1H1M');
        $date_adicionada = new DateInterval('P0DT0H0M');
        $result_esperado = new DateInterval('P1DT1H1M');
        $result = $proj->SomaInterval($date_inicial, $date_adicionada);
        $this->assertEquals($result, $result_esperado);
        
    }
    
    
}

?>
