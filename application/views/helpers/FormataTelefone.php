<?php

/**
 * 
 * Classe helper responsável pela formatação do valor do telefone para exibição.
 *
 * @package DarthSCM
 * @subpackage helpers
 * @author Elenildo João
 * @version 0.1
 * @access public
 *
 */

class Zend_View_Helper_FormataTelefone extends Zend_View_Helper_Abstract
{
    private $telefone;
    
    /**
     * Função que formata o valor de telefone para exibição.
     * @param string $telefone Valor para Formatação
     * @return string Valor Formatado
     */
    
    public function formataTelefone($telefone)
    {
        $this->telefone = '(' . substr($telefone, 0, 2) . ') ';
        $this->telefone .= substr($telefone, 2, 4) . '-';
        $this->telefone .= substr($telefone, 6, 8);
        return $this->telefone;
    }
}
?>
