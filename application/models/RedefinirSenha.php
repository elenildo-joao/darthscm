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

    protected $_name = 'redefinirsenha';
    protected $_primary = 'hash';
    
}

