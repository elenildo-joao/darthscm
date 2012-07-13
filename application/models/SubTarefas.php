<?php
class SubTarefas extends Zend_Db_Table_Abstract
{

    protected $_name = 'tarefas';
    protected $_primary = array('idtarefa', 'idprojeto');
    
}
?>