<?php

/**
 * 
 * Classe responsável pela abstração da tabela login do banco de dados.
 *
 * @package DarthSCM
 * @subpackage models
 * @author Elenildo João
 * @version 0.1
 * @access public
 *
 */

class Login extends Zend_Db_Table_Abstract 
{
    
    /** 
     * Nome da tabela no banco de dados.
     * 
     * @access protected 
     * @name $_name 
     */ 
    protected $_name = 'login';
    
    /** 
      * Sequência da tabela.
      * 
      * @access protected 
      * @name $_sequence 
      */      
    protected $_sequence = 'login_idlogin_seq';
    
    /** 
      * Tabelas referenciadas.
      * 
      * @access protected 
      * @name $_depedentTables
      */
    protected $_depedentTables = array('usuarios');
    
}


