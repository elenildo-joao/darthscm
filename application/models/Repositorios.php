<?php

/**
 * 
 * Classe responsável pela abstração da tabela repositorios do banco de dados.
 *
 * @package DarthSCM
 * @subpackage models
 * @author Elenildo João
 * @version 0.1
 * @access public
 *
 */

class Repositorios extends Zend_Db_Table_Abstract
{

    protected $_name = 'repositorios';
    protected $_sequence = 'repositorios_idrepositorio_seq';
    protected $_depedentTables = array('projetos', 'vusuarioprojeto');
}

