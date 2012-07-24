<?php

/**
 * 
 * Classe helper responsável pela formatação do valor do CPF para exibição.
 *
 * @package DarthSCM
 * @subpackage helpers
 * @author Elenildo João
 * @version 0.1
 * @access public
 *
 */

class Zend_View_Helper_FormataCPF extends Zend_View_Helper_Abstract
{
    /**
     * Função que formata o cpf para exibição
     * @param string $value Valor para Formatação
     * @return string Valor Formatado
     */
    public function formataCPF($value)
    {
        $valor =
	substr($value, 0,3) . '.' .
	substr($value, 3,3) . '.' .
	substr($value, 6,3) . '-' .
	substr($value, 9,2);
	return $valor;
    }
}
