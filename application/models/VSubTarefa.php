<?php

/**
 * 
 * Classe responsável pela abstração da visão vsubtarefas do banco de 
 * dados.
 *
 * @package DarthSCM
 * @subpackage models
 * @author Jacqueline Midlej
 * @version 0.1
 * @access public
 *
 */

class VSubTarefa extends Zend_Db_Table_Abstract
{

    protected $_name = 'vsubtarefas';
    protected $_depedentTables = array('usuariorealizatarefa');
    protected $_primary = array('idtarefa', 'idprojeto');
 }