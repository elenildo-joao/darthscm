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
    
    protected $_name = 'logslogin';
    protected $_sequence = 'logslogin_idloglogin_seq';
    
}
