<?php

/**
 * 
 * Classe responsável pela abstração da tabela redefinirsenha do banco de dados.
 *
 * @package DarthSCM
 * @subpackage models
 * @author Elenildo João
 * @version 0.1
 * @access public
 *
 */

class RedefinirSenha extends Zend_Db_Table_Abstract
{
    /** 
     * Nome da tabela no banco de dados.
     * 
     * @access protected 
     * @name $_name 
     */ 
    protected $_name = 'redefinirsenha';
    
    /** 
      * Chave primária da tabela.
      * 
      * @access protected 
      * @name $_primary 
      */
    protected $_primary = 'hash';
    
}

