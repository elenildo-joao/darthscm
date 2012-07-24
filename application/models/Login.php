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
    
    protected $_name = 'login';
    protected $_sequence = 'login_idlogin_seq';
    protected $_depedentTables = array('usuarios');
    
}


