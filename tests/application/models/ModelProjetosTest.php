<?php

include "../../../application/models/Projetos.php";

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ModelProjetosTest
 *
 * @author acarlos
 */
class ModelProjetosTest extends ControllerTestCase{
    
    private $projetos;
    
    function setUp(){
        parent::setUp();
        $this->projetos = new Projetos();
    }
    
    function testSomaInterval(){
               
        $proj = $this->projetos;
        
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
    
    function testTrataInterval(){
        
        
        $tempo = "3 days 23:20:10";
        $init2 = new DateInterval("P0D");
        $result_esperado = new DateInterval("P3DT23H20M");
        $this->projetos->trataInterval($tempo, &$init2);
        $this->assertEquals($result_esperado, $init2);
        
        $tempo = "2:30:00";
        $init2 = new DateInterval("P0D");
        $result_esperado = new DateInterval("PT2H30M");
        $this->projetos->trataInterval($tempo, &$init2);
        $this->assertEquals($result_esperado, $init2);
        
        $tempo = "4:56:00";
        $init2 = new DateInterval("P0D");
        $result_esperado = new DateInterval("PT4H56M");
        $this->projetos->trataInterval($tempo, &$init2);
        $this->assertEquals($result_esperado, $init2);
           
        $tempo = "6 days 00:00:00";
        $init2 = new DateInterval("P0D");
        $result_esperado = new DateInterval("P6DT0H0M");
        $this->projetos->trataInterval($tempo, &$init2);
        $this->assertEquals($result_esperado, $init2);
        
        $tempo = "4 days";
        $init2 = new DateInterval("P0D");
        $result_esperado = new DateInterval("P4D");
        $this->projetos->trataInterval($tempo, &$init2);
        $this->assertEquals($result_esperado, $init2);
        
        
        $tempo = "1 day";
        $init2 = new DateInterval("P0D");
        $result_esperado = new DateInterval("P1D");
        $this->projetos->trataInterval($tempo, &$init2);
        $this->assertEquals($result_esperado, $init2);
        
        $tempo = "6 days 00:00:00";
        $init2 = new DateInterval("P0D");
        $result_esperado = new DateInterval("P6DT2H30M");
        $this->projetos->trataInterval($tempo, &$init2);
        $this->assertNotEquals($result_esperado, $init2);
                
    }
}

?>
