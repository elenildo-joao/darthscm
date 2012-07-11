<?php



/**
 * Description of ModelUserTest
 *
 * @author acarlos
 */
class ModelUserTest extends PHPUnit_Framework_TestCase{
    
    function emailJaExisteTest(){
        $user = new Usuarios();
        $this->assertType("Usuarios", $user);
    }
}

?>
