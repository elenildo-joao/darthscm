<?php

/**
 * 
 * Classe responsável pela abstração da tabela tarefas do banco de dados.
 *
 * @package DarthSCM
 * @subpackage models
 * @author Jacqueline Midlej
 * @version 0.1
 * @access public
 *
 */

class Tarefas extends Zend_Db_Table_Abstract
{

    protected $_name = 'tarefas';
    protected $_sequence = 'tarefas_idtarefa_seq';
    protected $_depedentTables = array('usuariorealizatarefa');
    
    protected $_referenceMap = array(
        'projetos' => array(
            'columns'       => 'idprojeto',
            'refTableClass' => 'Projetos',
            'refColumns'    => 'idprojeto'
        ),
        'superTaferas' => array(
            'columns'       => array('idsupertarefa', 'idsuperprojeto'),
            'refTableClass' => 'Tarefas',
            'refColumns'    => array ('idtarefa', 'idprojeto')
        )
    );
}
?>
