<?php

/**
 * 
 * Classe responsável pela abstração da tabela usuariorealizatarefa do banco de 
 * dados.
 *
 * @package DarthSCM
 * @subpackage models
 * @author Jacqueline Midlej
 * @version 0.1
 * @access public
 *
 */

class Realiza extends Zend_Db_Table_Abstract
{

    protected $_name = 'usuariorealizatarefa';
    protected $_primary = array('idtarefa', 'idprojeto', 'idusuario');
    protected $_referenceMap = array(
        'usuarios' => array(
            'columns'       => 'idusuario',
            'refTableClass' => 'Usuarios',
            'refColumns'    => 'idusuario'
        ),
        'tarefas' => array(
            'columns'       => array('idtarefa','idprojeto'),
            'refTableClass' => 'Tarefas',
            'refColumns'    => array('idtarefa','idprojeto')
        )
    );
}
?>
