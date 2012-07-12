<?php

class Zend_View_Helper_FormataCPF extends Zend_View_Helper_Abstract
{
    /**
     * Método Principal
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
