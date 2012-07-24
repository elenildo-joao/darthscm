<?php

/**
 * 
 * Classe responsável pela abstração da tabela logslogin do banco de dados.
 *
 * @package DarthSCM
 * @subpackage models
 * @author Elenildo João
 * @version 0.1
 * @access public
 *
 */

class LogsLogin extends Zend_Db_Table_Abstract 
{
    /** 
     * Nome da tabela no banco de dados.
     * 
     * @access protected 
     * @name $_name 
     */            
    protected $_name = 'logslogin';
    
    /** 
      * Sequência da tabela.
      * 
      * @access protected 
      * @name $_sequence 
      */ 
    protected $_sequence = 'logslogin_idloglogin_seq';
    
}
