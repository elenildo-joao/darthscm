<?php

/**
 * 
 * Classe responsável pela abstração da tabela tarefas do banco de dados, 
 * representando as sub-tarefas.
 *
 * @package DarthSCM
 * @subpackage models
 * @author Jacqueline Midlej
 * @version 0.1
 * @access public
 *
 */

class SubTarefas extends Zend_Db_Table_Abstract
{

    protected $_name = 'tarefas';
    protected $_primary = array('idtarefa', 'idprojeto');
    
}
?>