<?php
class Zend_View_Helper_FormataTelefone extends Zend_View_Helper_Abstract
{
    private $telefone;
    
    public function formataTelefone($telefone)
    {
        $this->telefone = '(' . substr($telefone, 0, 2) . ') ';
        $this->telefone .= substr($telefone, 2, 4) . '-';
        $this->telefone .= substr($telefone, 6, 8);
        return $this->telefone;
    }
}
?>
