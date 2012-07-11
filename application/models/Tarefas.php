<?php
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
