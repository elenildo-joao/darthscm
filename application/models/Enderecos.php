<?php

/**
 * 
 * Classe responsável pela abstração da tabela enderecos do banco de dados.
 *
 * @package DarthSCM
 * @subpackage models
 * @author Elenildo João
 * @version 0.1
 * @access public
 *
 */

class Enderecos extends Zend_Db_Table_Abstract
{

    protected $_name = 'enderecos';
    protected $_sequence = 'enderecos_idendereco_seq';
    protected $_depedentTables = array('usuarios');
    
}

