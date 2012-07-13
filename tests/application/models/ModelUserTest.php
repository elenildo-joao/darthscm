<?php

/**
 * Description of ModelUserTest
 *
 * @author acarlos
 */
class ModelUserTest extends PHPUnit_Framework_TestCase{
    
    private $user;
    
    public function setUp()
    {
        $this->user = new Usuarios();
       
    }


    function testEmailJaExiste(){
        $this->assertTrue($this->user->emailJaExiste('andersoncarlos@gmail.com'));
        $this->assertFalse($this->user->emailJaExiste('naoexiste@gmail.com'));
        $this->assertTrue($this->user->emailJaExiste('rafaelasouza@gmail.com'));
        $this->assertFalse($this->user->emailJaExiste('rafaelasouza@gmail.com.br'));
        $this->assertTrue($this->user->emailJaExiste('jacquelinemidlej@gmail.com'));
        $this->assertFalse($this->user->emailJaExiste('0'));
    }
    
    function testCpfJaExiste(){
        $this->assertTrue($this->user->cpfJaExiste('00000000000'));
        $this->assertTrue($this->user->cpfJaExiste('00100100101'));
        $this->assertTrue($this->user->cpfJaExiste('00700700707'));
        $this->assertTrue($this->user->cpfJaExiste('00600600606'));
        $this->assertFalse($this->user->cpfJaExiste('cpf'));
        $this->assertFalse($this->user->cpfJaExiste('000000000000'));
        
    }
}

?>