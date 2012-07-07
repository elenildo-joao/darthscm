<?php
class Realiza extends Zend_Db_Table_Abstract
{

    protected $_name = 'usuariorealizatarefa';
    
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
